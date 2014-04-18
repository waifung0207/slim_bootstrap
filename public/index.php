<?php

define('APP_DIR', '../app/');


// packages via composer
require '../vendor/autoload.php';


// config file
require APP_DIR.'config/app.php';
require APP_DIR.'config/db.php';

// init framework
$app = new \Slim\Slim($app_config);
$app->setName(APP_NAME);


// libraries
require APP_DIR.'lib/api_output.php';


// models with CRUD operations
require APP_DIR.'models/crud.php';
$models = glob(APP_DIR.'models/*_model.php');
foreach ($models as $model)
{
    require $model;
}

// routes
$routes = glob(APP_DIR.'routes/*.php');
foreach ($routes as $route)
{
    require $route;
}


// start app
$app->run();