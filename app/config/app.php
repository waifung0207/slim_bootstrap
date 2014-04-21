<?php

define('APP_DEBUG',		TRUE);
define('APP_MODE',		'development');

define('APP_NAME',		'Slim Bootstrap');
define('APP_VERSION',	'0.1');


// display debug messages
if (APP_DEBUG && APP_MODE != 'production')
{
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
}

// app config values
$app_config = array(
	'debug'				=> APP_DEBUG,
    'mode'				=> APP_MODE,
    'http.version'		=> APP_VERSION,
    'templates.path'	=> APP_DIR.'views'
);