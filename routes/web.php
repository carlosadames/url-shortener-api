<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/


$router->get('/{urlUniqueCode}','UrlShortenerController@getShortUrl');

$router->group(['prefix' => 'api/v1'], function($router)
{
    
  $router->post('url/create','UrlShortenerController@createLink');
  $router->get('url/get/top','UrlShortenerController@getTopVisitedUrls');

});