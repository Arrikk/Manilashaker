<?php

/**
 * Index Page
 * 
 * Created By Bruiz(@~codeHart~) 2022
 * 
 * PHP Version 7.4.
 */

use Router\Route;

/**
 * Autoload
 */
require 'vendor/autoload.php';
/**
 * Add route to the Routing Table
 */  


/**
 * Twig
 */
// Twig_Autoloader::register();

ini_set('max_execution_time', 200);
date_default_timezone_set('Africa/Lagos');
define('SIGN', '₱');

/**
 * Error
 */

error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

define('URL', $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/');

/**
 * Session
 */
session_start();

Route::Route();

// header('content-type: application/json');
// echo json_encode($_SERVER);
