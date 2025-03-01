<?php

use Illuminate\Http\Request;


if (!file_exists('../.env')) {
    $GLOBALS["error_type"] = "env-missing";
    include('error_install.php');
    exit(1);
}

if (version_compare(PHP_VERSION, '8.2.0') < 0) {
    $GLOBALS["error_type"] = "php-version";
    include('error_install.php');
    exit(1);
}

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__ . '/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__ . '/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
(require_once __DIR__ . '/../bootstrap/app.php')
    ->handleRequest(Request::capture());
