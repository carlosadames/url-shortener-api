# Lumen URL Shortener API

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://poser.pugx.org/laravel/lumen-framework/d/total.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/lumen-framework/v/stable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/lumen-framework/v/unstable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://poser.pugx.org/laravel/lumen-framework/license.svg)](https://packagist.org/packages/laravel/lumen-framework)


## Index
- [Description](#description)
- [Why?](#why)
- [How To Use It](#usage)
- [Screenshots](#screenshots)
- [Table Schema](#how-data-is-stored)
- [System Requirements](#requirements)
- [Installing](#installing)
- [Contributing](#contributing)


## Description 

A simple URL Shortener application in Laravel Lumen. The official documentation for the framework can be found on the [Lumen website](https://lumen.laravel.com/docs).

## Why

There are several reasons to use URL shortening. Often regular unshortened links may be aesthetically unpleasing. Many web developers pass descriptive attributes in the URL to represent data hierarchies, command structures, transaction paths or session information. This can result in URLs that are hundreds of characters long and that contain complex character patterns. Such URLs are difficult to memorize, type-out or distribute. As a result, long URLs must be copied-and-pasted for reliability. Thus, short URLs may be more convenient for websites or hard copy publications (e.g. a printed magazine or a book), the latter often requiring that very long strings be broken into multiple lines (as is the case with some e-mail software or internet 
forums) or truncated.


## Usage

How it works and how to use it? This Simple application consist on an API with the following two end points:


     POST http://localhost/api/v1/url/create?long_url={LONG_URL}
    
     GET  http://localhost/api/v1/get/top

The first end point creates a new shorten link and the second gets the top 100 most visited URLS.


## Screenshots

![homestead.yaml](https://github.com/carlosadames/url-shortener-api/blob/master/homestead.yaml.png)

![migrations](https://github.com/carlosadames/url-shortener-api/blob/master/migrations.png)

![url_validation](https://github.com/carlosadames/url-shortener-api/blob/master/url_validation.png)

![create-api-endpoint](https://github.com/carlosadames/url-shortener-api/blob/master/%20create-api-endpoint.png)

![get-top-urls](https://github.com/carlosadames/url-shortener-api/blob/master/get-top-urls.png)



## Table Schemas

Data is stored in the urls table. See migration file below for reference.


## Installation

#### Clone the project:

    git clone https://github.com/carlosadames/url-shortener-api.git


#### Install dependencies:

    composer install


#### Create .env file:

    mv .env.example .env
    

#### Create migration file:

As shown in previously in the screenshots

```php
    public function up()
    {
        Schema::create('urls', function (Blueprint $table) {
            $table->bigIncrements('id')->index();
            $table->string('long_url')->unique()->index();
            $table->string('short_url')->unique()->nullable()->index();
            $table->integer('visits')->default('0');
            $table->timestamps();
        });
    }
```


#### Run migrations:

    php artisan migrate
    

## License

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
