<?php

// path constants
define('BASE_DIR', str_replace('public', '', __DIR__) );
define('APP_DIR', BASE_DIR.'app/');

// packages via composer
require '../vendor/autoload.php';

// config
require APP_DIR.'config/app.php';
require APP_DIR.'config/db.php';

// autoloader for classes
require APP_DIR.'autoload.php';

// init app
$app = new \Slim\Slim($app_config);
$app->setName(APP_NAME);

// routes
require APP_DIR.'routes.php';

// start app
$app->run();