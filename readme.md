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

## How to Use It



## Screenshots

![homestead.yaml](https://raw.githubusercontent.com/carlosadames/url-shortener-api/master/src/views/screenshots/homestead.yaml.png)

![migrations](https://raw.githubusercontent.com/carlosadames/url-shortener-api/master/src/views/screenshots/migrations.png)

![create-api-endpoint](https://raw.githubusercontent.com/carlosadames/url-shortener-api/master/src/views/screenshots/create-api-endpoint.png)

![get-top-urls](https://raw.githubusercontent.com/carlosadames/url-shortener-api/master/src/views/screenshots/get-top-urls.png)



## Table Schemas

Data is stored in the urls table.  


## Installation

#### Clone the project:

    git clone https://github.com/carlosadames/url-shortener-api.git


#### Install dependencies:

    composer install


#### Create .env file:

    mv .env.example .env


```php
php artisan migrate
``` 

## License

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
