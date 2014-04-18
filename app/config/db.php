<?php

// general database config
define('DB_ENGINE',		'elasticsearch');
define('DB_HOST',		'localhost');
define('DB_PORT',		'9200');
define('DB_NAME',		'slim_bootstrap');
define('DB_USERNAME',	'');
define('DB_PASSWORD',	'');

// currently only supports 'elasticsearch'
require APP_DIR.'config/db_'.DB_ENGINE.'.php';