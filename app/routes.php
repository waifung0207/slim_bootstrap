<?php

/**
 * List out functions to models
 */
$models = array(
	'User' => array(
		'noun'			=> 'users',
		'rest_routes'	=> array('get_list', 'get_one', 'create', 'update', 'delete'),
		'custom_routes'	=> array(
			'get'			=> array('followers', 'posts'),
			'post'			=> array('post'),
			'put'			=> array('password')
		)
	),

	/**
	 * Another example
	 */
	/*
	'Post' => array(
		'noun'			=> 'posts',
		'rest_routes'	=> array('get_list', 'get_one'),
		'custom_routes'	=> array(
			'get'			=> array('comments'),
		)
	)
	*/
);

/**
 * Setup routes for models
 */
foreach ($models as $model => $params)
{
	$noun = $params['noun'];
	$ctrler = $model.'Controller';

	$rest_routes = empty($params['rest_routes']) ? array() : $params['rest_routes'];
	$custom_routes = empty($params['custom_routes']) ? array() : $params['custom_routes'];

	/**
	 * RESTful routes, 5 basic actions are defined in BaseController and BaseModel:
	 * 	- get_list: obtain multiple items
	 * 	- get_one: obtain single item
	 * 	- create: create single item
	 * 	- update: update single item
	 * 	- delete: delete single item
	 */
	foreach ($rest_routes as $route)
	{
		switch ($route)
		{
			// GET (multiple)
			case 'get_list':
				$url = "/$noun";
				$app->get($url, $ctrler.':'.$route);
				break;

			// GET (single)
			case 'get_one':
				$url = "/$noun/:id";
				$app->get($url, $ctrler.':'.$route);
				break;

			// CREATE
			case 'create':
				$url = "/$noun";
				$app->post($url, $ctrler.':'.$route);
				break;

			// UPDATE
			case 'update':
				$url = "/$noun/:id";
				$app->put($url, $ctrler.':'.$route);
				break;

			// DELETE
			case 'delete':
				$url = "/$noun/:id";
				$app->delete($url, $ctrler.':'.$route);
				break;
		}
	}

	/**
	 * Custom routes for different actions, e.g.:
	 *  - GET 		/users/2/followers		=> UserController@get_followers
	 *  - POST 		/posts/5/comment 		=> PostController@create_comment
	 * 	- PUT 		/users/1/password 		=> UserController@update_password
	 *  - DELETE 	/posts/6/comment 		=> PostController@delete_comment
	 */
	foreach ($custom_routes as $action => $routes)
	{
		switch ($action)
		{
			// GET
			case 'get':
				foreach ($routes as $route)
				{
					$url = "/$noun/:id/".$route;
					$app->get($url, $ctrler.':get_'.$route);
				}
				break;

			// CREATE
			case 'post':
				foreach ($routes as $route)
				{
					$url = "/$noun/:id/".$route;
					$app->post($url, $ctrler.':create_'.$route);
				}
				break;

			// UPDATE
			case 'put':
				foreach ($routes as $route)
				{
					$url = "/$noun/:id/".$route;
					$app->put($url, $ctrler.':update_'.$route);
				}
				break;

			// DELETE
			case 'delete':
				foreach ($routes as $route)
				{
					$url = "/$noun/:id/".$route;
					$app->delete($url, $ctrler.':delete'.$route);
				}
				break;
		}
	}
}


/**
 * Error handling
 */

$app->notFound(function () use ($app) {
	$app->render('404.php', array(), 404);
});

$app->error(function (\Exception $e) use ($app) {
	$view_data = array('msg' => $e->getMessage());
	$app->render('error.php', $view_data);
});