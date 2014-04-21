<?php

require_once('helpers.php');


/**
 * Autoloading Reference: 
 * https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md
 */

spl_autoload_register("autoload");

function autoload($className)
{
	if ( ends_with($className, 'Controller') )
	{
		$fileName  = "controllers/".snake_case($className).'.php';
		require_once(APP_DIR.$fileName);
	}
	else if ( ends_with($className, 'Model') )
	{
		$fileName  = "models/".snake_case($className).'.php';
		require_once(APP_DIR.$fileName);
	}
	else if ( ends_with($className, 'Middleware') )
	{
		$fileName  = "middleware/".snake_case($className).'.php';
		require_once(APP_DIR.$fileName);
	}
}