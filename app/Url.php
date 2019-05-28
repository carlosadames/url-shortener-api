<?php namespace App;
 
use DB;
use Illuminate\Database\Eloquent\Model;
 
class Url extends Model
{ 

   protected $table = "urls";

   protected $fillable = ['long_url', 'short_url', 'visits', 'created_at', 'updated_at']; 
   
   /**
    * Creates a new resource url in the database
    *
    * @param array $data contains the data to be inserted
    * @param string $shortUrl the given short url
    *
    * @return array|null
    */   
   public function insertInDatabase($data = null, $shortUrl){
      
      return Url::create(array_merge($data, ['short_url' => $shortUrl]));

   }


   /**
    * Finds a long url in the database
    *
    * @param string $longUrl the long url
    *
    * @return array|null
    */
   public function findByLongUrl($longUrl = null){

      return Url::where('long_url','=', $longUrl)->first();

   }

   /**
    * Update visits in the database
    *
    * @param string $longUrl the long url
    * @param int $visits the given visits for this url
    *
    * @return array|null
    */
   public function UpdateVisits($longUrl = null, $visits){

      return Url::where('long_url','=', $longUrl)->update(['visits' => $visits]);

   }

   public function getUrlTotalVisits($longUrl = null){

      $total = Url::where('long_url','=', $longUrl)->first();

      return $total->visits;

   }

   /**
    * Find an url by its short url
    *
    * @param string $shortUrl a given short url
    * 
    * @return array|null
    */
   public function findShortUrl($shortUrl = null){
      
      return Url::where('short_url','=', $shortUrl)->first();

   }

   /**
    * Gets the top most visited urls
    *
    * @param int $qantity the total of urls
    * @return void
    */
   public function getTopUrls($quantity = null){

     return DB::table('urls')
                ->limit($quantity)
                ->orderBy('visits','Desc')
                ->get();

   }


   /**
    * Get total count of url's records in the database
    *
    * @return int
    */
   public function getTotalCount(){

     return Url::all()->count();

   }

}
