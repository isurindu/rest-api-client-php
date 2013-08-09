SMSGlobal Class Library for PHP
===============================

This is a wrapper for the [SMSGlobal](http://www.smsglobal.com/) REST API. Get an API key from SMSGlobal by signing up and viewing the API key page in the MXT platform.

View the [REST API documentation](http://www.smsglobal.com/rest-api/) for a list of available resources.

Quick Start
-----------
This wrapper is requires PHP 5.3 or greater, and either the cURL library or the HTTP stream wrapper to be installed and enabled.

To install, add the dependency to your `composer.json` file:

```json
{
    "require": {
        "smsglobal/class-library": "*"
    }
}
```

And install with Composer.

```bash
$ cd path/to/SMSGlobal/class/library
$ composer install
```

Not using Composer?
-------------------
You can install the library by downloading it from Github. Just use a PSR-0 compliant autoloader to load in the classes.

To run unit tests or generate documentation, you'll need PHPUnit and phpDocumentor.

Running Unit Tests
------------------
```bash
$ cd path/to/SMSGlobal/class/library
$ composer install --dev
$ phpunit
```

Get documentation
-----------------
```bash
$ cd path/to/SMSGlobal/class/library
$ composer install --dev
$ vendor/phpdocumentor/phpdocumentor/bin/phpdoc.php -c phpdoc.xml
```

Using the library
-----------------
Running Unit Tests
```php
// Include the Composer autoloader or use your own PSR-0 autoloader
require 'vendor/autoload.php';

use Smsglobal\ClassLibrary\ApiKey;
use Smsglobal\ClassLibrary\Resource\Sms;
use Smsglobal\ClassLibrary\ResourceManager;

// Get an API key from SMSGlobal and insert the key and secret
$apiKey = new ApiKey('your-api-key', 'your-api-secret');

// All requests are done via a 'resource manager.' This abstracts away the REST
// API so you can deal with it like you would an ORM
$manager = new ResourceManager($apiKey);

// Now you can get objects
$contact = $manager->get('contact', 1); // Contact resource with ID = 1
// Edit them
$contact->setMsisdn('61447100250');
// And save them
$manager->save($contact);
// Or delete them
$manager->delete($contact);

// You can also instantiate new resources
$sms = new Sms();
$sms->setDestination('61447100250');
    ->setOrigin('Test');
    ->setMessage('Hello World');
// And save them
$manager->save($sms);
// When a new object is saved, the ID gets populated (it was null before)
echo $sms->getId(); // integer

// You can get a list of available resources
$list = $manager->getList('sms');

foreach ($list->objects as $resource) {
    // ...
}

// Pagination data is included
echo $list->meta->getTotalPages(); // integer

// Lists can be filtered
// e.g. contacts belonging to group ID 1
$manager->getList('contact', 0, 20, array('group' => 1));
```

Notes
-----
1. Requesting the same object twice in one session will return the same instance (even in the resource lists)
2. Exceptions are thrown if you attempt to save an object with invalid data