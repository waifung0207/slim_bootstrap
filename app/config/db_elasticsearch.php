<?php

/**
 * Configuration specific for ElasticSearch
 */

define('ES_AUTH_TYPE',		'Basic');
define('ES_DEFAULT_INDEX',	DB_NAME);

define('ES_LOG_ENABLED',	FALSE);
define('ES_LOG_PATH',		APP_DIR.'logs/elasticsearch.log');

require_once APP_DIR.'lib/elastic_client.php';