Wolfpack Assessment of Toan Luu
------------
This github assessment contains a RESTful API made with a basic Yii2 framework.
Given that I have never worked with Yii2 before, this repository shows mostly what I already know in working with the Laravel.
Due to the nature of this assessment and time free time, I have not added test cases and more error handling.
Also there is no real documentation of the API within the code, so I will do it here.

The relevant files I edited are as follows

        config/
            web.php
        controllers/        
            PackController.php
            WolfController.php
        migrations/
            m200825_191012_wolf.php
            m200830_143532_pack.php
            m200830_150826_create_wolfPack_table.php
        models/             
            Pack.php
            Wolf.php

Models and Tables
------------
I decided to create two models: Wolf and Pack, with their tables respectively. For the relation between those two models, I decided to use a linking table, since it was not specified if a wolf can only be in one or more packs. So there is a many-to-many relation between Wolf and Pack. For the location of a Wolf, I decided to use latitude and longitude, since that is the most logical way to keep track of wolves' locations in the wild, instead of using a address. As for gender, I decided to use a string, since the current definition of gender is a bit controversial.

API Requests
------------
Given that you have a working database with the migrations correctly, the following API calls should work. Otherwise you would get an error that the tables do not exists or something in a similar fashion.
Some remarks: 
Most of the specific actions, such as updating locations and changing wolves in a pack, are done when updating the whole model itself with the PUT request.
The ? before means that the parameter is optional.

### WolfController

    GET /wolves : Returns a list of all wolves with their attributes

    GET /wolves/{wolf_id} : Returns a specific wolf with its attributes

    POST /wolves : Creates a new wolf
        Content-Type: application/x-www-form-urlencoded
        Body:
            name=(String) => Wolf
            ?gender=(String) => Male
            ?birthdate=(Date "yyyy-MM-dd") => 2020-12-01
            ?latitude=(Number ##.###### in range(-90,90)) => 67.041324
            ?longitude=(Number ###.###### in range(-180,180)) => -172.234233

    PUT /wolves/{wolf_id} : Updates a exisiting wolf
        Content-Type: application/x-www-form-urlencoded
        Body:
            ?name=(String)
            ?gender=(String)
            ?birthdate=(Date "yyyy-MM-dd")
            ?latitude=(Number ##.###### in range(-90,90))
            ?longitude=(Number ###.###### in range(-180,180))

    DELETE /wolves/{wolf_id} : Deletes a specific wolf, given that it is not the only wolf in a pack

### PackController

    GET /packs : Returns a list of all packs with their attributes, including wolves

    GET /packs/{pack_id} : Returns a specific pack with its attributes, including wolves

    POST /packs : Creates new pack with one or more wolves
        Content-Type: application/x-www-form-urlencoded
        Body:
            name=(String)
            wolves=(String of wolf_ids separated by ',') => 2,63,23

    PUT /packs/{pack_id} : Updates existing pack
        Content-Type: application/x-www-form-urlencoded
        Body:
            ?name=(String)
            ?wolves= (String of wolf_ids separated by ',')

    DELETE /packs/{pack_id} : Deletes a specific wolf, given that it is not the only wolf in a pack


------------
The following part of the readme is the default Yii2 basic template readme


<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 Basic Project Template</h1>
    <br>
</p>

Yii 2 Basic Project Template is a skeleton [Yii 2](http://www.yiiframework.com/) application best for
rapidly creating small projects.

The template contains the basic features including user login/logout and a contact page.
It includes all commonly used configurations that would allow you to focus on adding new
features to your application.

[![Latest Stable Version](https://img.shields.io/packagist/v/yiisoft/yii2-app-basic.svg)](https://packagist.org/packages/yiisoft/yii2-app-basic)
[![Total Downloads](https://img.shields.io/packagist/dt/yiisoft/yii2-app-basic.svg)](https://packagist.org/packages/yiisoft/yii2-app-basic)
[![Build Status](https://travis-ci.com/yiisoft/yii2-app-basic.svg?branch=master)](https://travis-ci.com/yiisoft/yii2-app-basic)

DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources



REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 5.6.0.


INSTALLATION
------------

### Install via Composer

If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

You can then install this project template using the following command:

~~~
composer create-project --prefer-dist yiisoft/yii2-app-basic basic
~~~

Now you should be able to access the application through the following URL, assuming `basic` is the directory
directly under the Web root.

~~~
http://localhost/basic/web/
~~~

### Install from an Archive File

Extract the archive file downloaded from [yiiframework.com](http://www.yiiframework.com/download/) to
a directory named `basic` that is directly under the Web root.

Set cookie validation key in `config/web.php` file to some random secret string:

```php
'request' => [
    // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
    'cookieValidationKey' => '<secret random string goes here>',
],
```

You can then access the application through the following URL:

~~~
http://localhost/basic/web/
~~~


### Install with Docker

Update your vendor packages

    docker-compose run --rm php composer update --prefer-dist
    
Run the installation triggers (creating cookie validation code)

    docker-compose run --rm php composer install    
    
Start the container

    docker-compose up -d
    
You can then access the application through the following URL:

    http://127.0.0.1:8000

**NOTES:** 
- Minimum required Docker engine version `17.04` for development (see [Performance tuning for volume mounts](https://docs.docker.com/docker-for-mac/osxfs-caching/))
- The default configuration uses a host-volume in your home directory `.docker-composer` for composer caches


CONFIGURATION
-------------

### Database

Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```

**NOTES:**
- Yii won't create the database for you, this has to be done manually before you can access it.
- Check and edit the other files in the `config/` directory to customize your application as required.
- Refer to the README in the `tests` directory for information specific to basic application tests.


TESTING
-------

Tests are located in `tests` directory. They are developed with [Codeception PHP Testing Framework](http://codeception.com/).
By default there are 3 test suites:

- `unit`
- `functional`
- `acceptance`

Tests can be executed by running

```
vendor/bin/codecept run
```

The command above will execute unit and functional tests. Unit tests are testing the system components, while functional
tests are for testing user interaction. Acceptance tests are disabled by default as they require additional setup since
they perform testing in real browser. 


### Running  acceptance tests

To execute acceptance tests do the following:  

1. Rename `tests/acceptance.suite.yml.example` to `tests/acceptance.suite.yml` to enable suite configuration

2. Replace `codeception/base` package in `composer.json` with `codeception/codeception` to install full featured
   version of Codeception

3. Update dependencies with Composer 

    ```
    composer update  
    ```

4. Download [Selenium Server](http://www.seleniumhq.org/download/) and launch it:

    ```
    java -jar ~/selenium-server-standalone-x.xx.x.jar
    ```

    In case of using Selenium Server 3.0 with Firefox browser since v48 or Google Chrome since v53 you must download [GeckoDriver](https://github.com/mozilla/geckodriver/releases) or [ChromeDriver](https://sites.google.com/a/chromium.org/chromedriver/downloads) and launch Selenium with it:

    ```
    # for Firefox
    java -jar -Dwebdriver.gecko.driver=~/geckodriver ~/selenium-server-standalone-3.xx.x.jar
    
    # for Google Chrome
    java -jar -Dwebdriver.chrome.driver=~/chromedriver ~/selenium-server-standalone-3.xx.x.jar
    ``` 
    
    As an alternative way you can use already configured Docker container with older versions of Selenium and Firefox:
    
    ```
    docker run --net=host selenium/standalone-firefox:2.53.0
    ```

5. (Optional) Create `yii2_basic_tests` database and update it by applying migrations if you have them.

   ```
   tests/bin/yii migrate
   ```

   The database configuration can be found at `config/test_db.php`.


6. Start web server:

    ```
    tests/bin/yii serve
    ```

7. Now you can run all available tests

   ```
   # run all available tests
   vendor/bin/codecept run

   # run acceptance tests
   vendor/bin/codecept run acceptance

   # run only unit and functional tests
   vendor/bin/codecept run unit,functional
   ```

### Code coverage support

By default, code coverage is disabled in `codeception.yml` configuration file, you should uncomment needed rows to be able
to collect code coverage. You can run your tests and collect coverage with the following command:

```
#collect coverage for all tests
vendor/bin/codecept run -- --coverage-html --coverage-xml

#collect coverage only for unit tests
vendor/bin/codecept run unit -- --coverage-html --coverage-xml

#collect coverage for unit and functional tests
vendor/bin/codecept run functional,unit -- --coverage-html --coverage-xml
```

You can see code coverage output under the `tests/_output` directory.
