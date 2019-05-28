<?php

namespace App\Http\Controllers;

use App\Url;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\URL as UrlFacade;

/**
 * UrlShortenerController class handles logic for the Url Shortener API
 * 
 * @author Carlos Adames
 * @version $Revision: 1.0 $
 * @access public
 * 
 */
class UrlShortenerController extends Controller
{

    /**
     * Represents the url database record
     *
     * @var array
     */
    public $url = array();

    /**
     * The long URL 
     *
     * @var array
     */
    public $longUrl;

    /**
     *  The short Url
     * 
     * @var string
     */
    public $shortUrl;

    /**
     * A Url Model Instance
     *
     * @var object
     */
    public $urlModel;

    /**
     * Contains additional information about the opearation
     *
     * @var string
     */
    public $message;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
    * Contains the database transaction result
    *
    * @var mixed
    */
    public $result;

    /**
    * Contains the transaction error message code
    *
    * @var string
    */
    public $errorCode;

    /**
    * Number of times the url is been visit
    *
    * @var int
    */
    public $visits;

    /**
    * The app base url
    *
    * @var string
    */
    public $appUrl;


    public function __construct()
    {
        $this->urlModel = new Url();
    }

    /**
     * Redirects to the original long url if exists
     *
     * @param string $shortUrl
     * @return void
     */
    public function getShortUrl($shortUrl){

        $this->url = $this->urlModel->findShortUrl($shortUrl);

        if(!isset($this->url)){

            $this->message = "Shorten Url not found";

            return response()->json(array('message' => $this->message),404);

        }

        $this->shortUrl =  $this->generateShortenUrl();
        $this->message = "Shorten Url found";
        return redirect()->to($this->url->long_url);

    }
    

    /**
     * Return the most visited urls or top urls
     *
     * @param integer $default
     * 
     * @return array
     */
    public function getTopVisitedUrls($defaultQuantity = 100){
 
        $topVisitedUrls  = $this->urlModel->getTopUrls($defaultQuantity);

        $topVisitedUrls = $this->mapShortUrl($topVisitedUrls);    

        return response()->json(array('results' => $topVisitedUrls, 'records_displayed' => $topVisitedUrls->count(), 'total_records' => $this->getTotalUrlsCount()),200);
   
    }

    /**
     * Updates short url for each given url
     *
     * @param collection $shortUrl a collection of urls
     * 
     * @return collection
     */
    public function mapShortUrl($shortUrl){

        $shortUrl = $shortUrl->map(function ($urls, $key) {
            $this->url = $urls;
            $urls->short_url = $this->generateShortenUrl();
            return $urls;
        });  
        
        return $shortUrl;
    } 


    /**
     * Get total url records in the database
     *
     * @return int
     */
    public function getTotalUrlsCount(){

        return $this->urlModel->getTotalCount();
    }


    /**
     * Creates a new url in the database
     *
     * @param Illuminate\Http\Request $request 
     * 
     * @return json
     */
    public function createLink(Request $request){

        $this->longUrl = $request->get('long_url');

        if(!$this->isValidUrl($request)){
            return response()->json(array('results' => $this->result, 'status_code' => 422),422);
        }

        if($this->urlExists($this->longUrl)){
            $this->updateUrlVisits();
            $this->message = "Resource found in database";
            return response()->json(array('results' => $this->url,'message' => $this->message, 'status_code' => 200),200);
        }

        $this->shortUrl = $this->createShortUrl();
        $this->url = $this->urlModel->insertInDatabase($request->all(), $this->shortUrl);

        if(!$this->url){
            $this->message = "Could not create resource";
            return response()->json(array('message' => $this->message, 'status_code' => 404),404);
        }
        
        $this->url->short_url = $this->generateShortenUrl();
        $this->message = "resource succesfully created";      
        return response()->json(array('results' => array('urls' => $this->url),'message' => $this->message, 'status_code' => 201),201);
    }


    /**
     * Validates an url is valid
     *
     * @param  Illuminate\Http\Request $request
     * @return boolean
     */
    public function isValidUrl($request){

        $validator = \Validator::make($request->all(),
         [
            'long_url' => 'required|url|max:2048',
         ]);

        if ($validator->fails()) {

            $this->result = [
                'error' => [
                    'message' => $validator->errors()
                ]
            ];

            return false;

        }      
        
        return true;
        
    }


    /**
     * Determines if an url exist in the database
     *
     * @param string $longUrl the long url
     * 
     * @return boolean
     */
    public function urlExists($longUrl){

        $this->url = $this->urlModel->findByLongUrl($longUrl);

        if(!isset($this->url)){
            return false;   
        }
        return true;

    }


    /**
     * Generates a new short url
     *
     * @return string
     */
    public function createShortUrl(){

        $this->shortUrl = str_random(6);

        if(!$this->shortUrlExists($this->shortUrl)){
            return $this->shortUrl;
        }

        return $this->createShortUrl();

    }


    /**
     * Determines if the given short url exist in the database
     *
     * @param string $shortUrl
     * 
     * @return boolean
     */
    public function shortUrlExists($shortUrl){
        
        if(!$this->urlModel->findShortUrl($shortUrl)){
            return false;
        }
        return true;

    }
   

    /**
     * Increments the number of visits for an url
     * 
     * @return boolean
     */
    public function updateUrlVisits(){
        
        try{
            $this->urlModel->UpdateVisits($this->longUrl, $this->getUrlVisits() + 1);
            $this->urlModel->refresh();
            return true;
        }
        catch(\Illuminate\Database\QueryException $e)
        { 
            $this->errorCode = $e->errorInfo[1];
            return false;
        }     
        
    }


    /**
     * Gets the total visits for a given url
     *
     * @return int
     */
    public function getUrlVisits(){

        $this->visits = $this->urlModel->getUrlTotalVisits($this->longUrl);

        return $this->visits;

    }

   /**
    * Gets the application base URL 
    *
    * @return void
    */  
    public function getAppBaseUrl(){
        
        return UrlFacade::to('/').'/';
    }

    /**
     * Generates the shorten url
     *
     * @return string
     */
    public function generateShortenUrl(){

       return $this->getAppBaseUrl().$this->url->short_url;

    }


}
