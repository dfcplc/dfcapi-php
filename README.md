# DFCAPI for PHP [![Build Status](https://api.travis-ci.org/dfcplc/dfcapi-php.png)](https://travis-ci.org/dfcplc/dfcapi-php)

The DFC API is a Restful API which has been built to facilitate the ability to Setup/Ammend/Cancel & View Direct Debits with Debit Finance Collections Plc

### Install with Composer
If you're using [Composer](https://github.com/composer/composer) to manage
dependencies, you can the DFC API Client Library with it.

```javascript
{
  "require" : {
    "dfcplc/dfcapi-php" : "dev-master"
  },
  "autoload": {
    "psr-0": {"Dfcapi": "lib/"}
  }
}
```

### Install source from GitHub
The DFCAPI-PHP Client Library requires PHP `v5.3+`. Download the PHP library from Github, and require in your script like so:

To install the source code:

```bash
$ git clone git@github.com:dfcplc/dfcapi-php.git 
```

And include it in your scripts:

```bash
require_once '/path/to/dfcapi-php/lib/Dfcapi.php';
```

## Checking API Credentials

So you're probably wondering how using Unirest makes creating requests in PHP easier, let's look at a working example:

```php
$dfcapi = new Dfcapi();
$response = $dfcapi->checkApiKey('TEST-TEST-TEST-TEST','a94a8fe5ccb19ba61c4c0873d391e987982fbbd3');

var_dump($response); // API Credential Check Response (true or false)
```

### Extra Details
When calling the API, additional details can be retrieved using the below methods:

```php
$dfcapi = new Dfcapi();

$dfcapi->getErrors(); //Array of returned errors from the API Call

$dfcapi->getResponseCode(); //HTTP Response Code (200 = OK)

$dfcapi->getResponseBody(); //HTTP Response Body (Object)

$dfcapi->getResponseBodyRaw(); //HTTP Response Body (Raw)

$dfcapi->getResponseHeaders(); //HTTP Response Headers (Array)
```

<hr>
### Thanks
Thanks go out to:
* [thefosk](https://github.com/thefosk) @ [mashape.com](https://mashape.com) - Unirest Restful Library