Melody Datetime
=================

[![Build Status](https://secure.travis-ci.org/leviferreira/melody-datetime.png)](http://travis-ci.org/leviferreira/melody-datetime)


Installation
------------

The recommended way to install Melody Validation is [through
composer](http://getcomposer.org). Just create a `composer.json` file and
run the `php composer.phar install` command to install it:

    {
        "require": {
            "leviferreira/melody-datetime": "dev-master"
        }
    }

Introduction
------------

Importing Validator namespace:
```php
use Melody\DateTime\DateTime;
```

Basic Usage
-----------
### Adding bussiness days to a date
```php
    // Sets the datetime, will consider the 'now' date
    // for example: 2013-12-01 00:00:00
    $datetime = new DateTime();
    
    // add two business days to a date
    $datetime->addBusinessDays(2);

    // Output: 2013-12-03 00:00:00
    echo $datetime->format('Y-m-d H:i:s');
```

### Adding bussiness days to a date, considering holydays
```php
    // Sets the datetime, will consider the 'now' date
    // for example: 2013-12-01 00:00:00
    $datetime = new DateTime();
    
    // Set a list of holydays that will be considered
    $datetime->setHolydays(array('2013-12-02'));

    // Add two business days to a date, considering holydays as non-business days
    $datetime->addBusinessDaysWithHolydays(2);

    // Output: 2013-12-04 00:00:00
    echo $datetime->format('Y-m-d H:i:s');
```