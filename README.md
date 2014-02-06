Melody Datetime
=================

[![Build Status](https://travis-ci.org/project-melody/datetime.png?branch=develop)](https://travis-ci.org/project-melody/datetime)


Installation
------------

The recommended way to install Melody DateTime is [through
composer](http://getcomposer.org). Just create a `composer.json` file and
run the `php composer.phar install` command to install it:
```json
    {
        "require": {
            "project-melody/datetime": "dev-master"
        }
    }
```

Introduction
------------

Importing DateTime namespace:
```php
use Melody\DateTime\DateTime;
```

Basic Usage
-----------
### Adding business days to a date
```php
    // Sets the datetime, will consider the 'now' date
    // for example: 2013-12-01 00:00:00
    $datetime = new DateTime();
    
    // add two business days to a date
    $datetime->addBusinessDays(2);

    // Output: 2013-12-03 00:00:00
    echo $datetime->format('Y-m-d H:i:s');
```

### Adding business days to a date, considering holidays
```php
    // Sets the datetime, will consider the 'now' date
    // for example: 2013-12-01 00:00:00
    $datetime = new DateTime();
    
    // Set a list of holidays that will be considered
    $datetime->setHolidays(array('2013-12-02'));

    // Add two business days to a date, considering holidays as non-business days
    $datetime->addBusinessDaysWithHolidays(2);

    // Output: 2013-12-04 00:00:00
    echo $datetime->format('Y-m-d H:i:s');
```
