<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/test_for_auto_drive/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__ . '/test_for_auto_drive/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
(require_once __DIR__ . '/test_for_auto_drive/bootstrap/app.php')
    ->handleRequest(Request::capture());
