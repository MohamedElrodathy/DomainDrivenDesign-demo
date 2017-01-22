<?php

use Symfony\Component\Debug\Debug;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;

/** @var \Composer\Autoload\ClassLoader $loader */
$loader = require __DIR__.'/../app/autoload.php';

// If SYMFONY_ENV is not defined, then we are in development/testing/staging environment.
// Production environment MUST NOT use the .env file
if (false === getenv('SYMFONY_ENV')) {
    (new Dotenv())->load(__DIR__.'/../.env');
}

$debug = false;
if ('1' === getenv('SYMFONY_DEBUG')) {
    Debug::enable();
    $debug = true;
}

$kernel = new AppKernel(getenv('SYMFONY_ENV'), $debug);
//$kernel = new AppCache($kernel);

// When using the HttpCache, you need to call the method in your front controller instead of relying on the configuration parameter
//Request::enableHttpMethodParameterOverride();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
