<?php

use App\Url;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ApiTest extends TestCase
{
    /**
     * Test a user can create a shorten url.
     *
     * @return void
     */
    public function testUserCanCreateShortenUrl()
    {
        $parameters = [
            'long_url' => 'http://www.google.com',
        ];
        $this->post("/api/v1/url/create", $parameters, []);
        $this->seeStatusCode(201);
        $this->seeJsonStructure(
            ['results' =>
                [
                    'id',
                    'long_url',
                    'short_url',
                    'created_at',
                    'updated_at'
                ],
              'message' => [],  
              'status_code' => [],
            ]    
        );


    }



   /**
     * Test a user can get top most visited urls.
     *
     * @return void
     */
    public function testUserCanGetTopUrls()
    {

        $this->get("/api/v1/url/get/top");
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            ['results' =>
                [[
                    'long_url',
                    'short_url',
                    'created_at',
                    'updated_at',
                    'id'
                ]],
               'records_displayed',
               'total_records',
            ]    
        );



    }    


 /**
     * Test a user can not input invalid url.
     *
     * @return void
     */
    public function testUserCanNotInputInvalidUrl()
    {
 
        $parameters = [
            'long_url' => 'htp://www.google.com',
        ];
        $this->post("/api/v1/url/create", $parameters, []);
        $this->seeStatusCode(422);
        $this->seeJsonStructure(
            ['results' =>
                ['error' => 
                    ['message' =>
                    
                        ['long_url'],
                    ]
             ],
              'status_code'
            ]
            
        );


    }  
    
    
    /**
     * Test a user is redirected to long url when accesses browser with shorten url.
     *
     * @return void
     */
    public function testUserIsRedirectedToCreateShortenUrl()
    {
        $url = Url::find(1);

        $parameters = [
            'short_url' => $url->short_url,
        ];
        $this->get($url->short_url, $parameters, []);
        $this->seeStatusCode(302);

    }



    
 
}
