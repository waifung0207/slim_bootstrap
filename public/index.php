<?php

define('APP_DIR',	'../app/');


// packages via composer
require APP_DIR.'vendor/autoload.php';


// config file
require APP_DIR.'config.php';

// init framework
$config = array(
	'debug'				=> APP_DEBUG,
    'mode'				=> APP_MODE,
    'http.version'		=> APP_VERSION,
    'templates.path'	=> APP_DIR.'templates'
);
$app = new \Slim\Slim($config);
$app->setName(APP_NAME);


// routes
require APP_DIR.'routes/home.php';
require APP_DIR.'routes/hello.php';

// error pages
require APP_DIR.'error.php';


// start app
$app->run();