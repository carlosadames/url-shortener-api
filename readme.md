# Lumen URL Shortener API

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://poser.pugx.org/laravel/lumen-framework/d/total.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/lumen-framework/v/stable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/lumen-framework/v/unstable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://poser.pugx.org/laravel/lumen-framework/license.svg)](https://packagist.org/packages/laravel/lumen-framework)


## Index
- [Description](#description)
- [Why?](#why)
- [Screenshots](#screenshots)
- [Table Schema](#how-data-is-stored)
- [Installing](#installation)
- [How To Use It](#usage)
- [Contributing](#contributing)
- [License](#license)


## Description 

A simple URL Shortener application in Laravel Lumen. The official documentation for the framework can be found on the [Lumen website](https://lumen.laravel.com/docs).

## Why

There are several reasons to use URL shortening. Often regular unshortened links may be aesthetically unpleasing. Many web developers pass descriptive attributes in the URL to represent data hierarchies, command structures, transaction paths or session information. This can result in URLs that are hundreds of characters long and that contain complex character patterns. Such URLs are difficult to memorize, type-out or distribute. As a result, long URLs must be copied-and-pasted for reliability. Thus, short URLs may be more convenient for websites or hard copy publications (e.g. a printed magazine or a book), the latter often requiring that very long strings be broken into multiple lines (as is the case with some e-mail software or internet 
forums) or truncated.


## Screenshots

![homestead.yaml](https://github.com/carlosadames/url-shortener-api/blob/master/homestead.yaml.png)

![migrations](https://github.com/carlosadames/url-shortener-api/blob/master/migrations.png)

![url_validation](https://github.com/carlosadames/url-shortener-api/blob/master/url_validation.png)

![create-api-endpoint](https://github.com/carlosadames/url-shortener-api/blob/master/%20create-api-endpoint.png)

![get-top-urls](https://github.com/carlosadames/url-shortener-api/blob/master/get-top-urls.png)



## How data is stored

Data is stored in the urls table. See migration file below for reference.


## Installation

If using Homestead, please check the installation details at https://lumen.laravel.com/docs/5.8/installation. Once you have 
properly install and configure Homestead, proceed. Check Homestead.yaml configuation example in the [Screenshots](#screenshots) section.


#### Provisioning the current VM

Inside your Homestead folder in order to set up your environment run: 

    vagrant provision --reaload


#### Configuring the guest machine

In order to configure the guest machines according to your Vagrantfile run:

    vagrant up


#### Configuring the guest machine

Run this command in order to SSH into the running Vagrant machine and get access to a shell:

    vagrant ssh


#### Clone the project:

Once you are into your project folder as specified in your Vagrant file clone the repository:

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


#### Seeding the database:  

This will seed the database with fake data for testing purposes.

    php artisan db:seed


## Usage

How it works and how to use it? This Simple application consist on an API with the following two end points:


     POST http://192.168.10.10/api/v1/url/create?long_url={LONG_URL}
    
     GET  http://192.168.10.10/api/v1/get/top

The first end point creates a new shorten link and the second gets the top 100 most visited URLS. If you access through 
the web browser to the shorten link it should redirect you to the intended URL.


## Contributing

    Pull requests and issues are more than welcome.


## License

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
