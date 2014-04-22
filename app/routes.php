<?php

/**
 * List out functions to models
 */
$models = array(
	'User' => array(
		'noun'			=> 'users',
		'base_routes'	=> array('get_list', 'get_one', 'create', 'update', 'delete'),
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
		'base_routes'	=> array('get_list', 'get_one'),
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

	$base_routes = empty($params['base_routes']) ? array() : $params['base_routes'];
	$custom_routes = empty($params['custom_routes']) ? array() : $params['custom_routes'];

	/**
	 * Base routes, 5 basic methods which are defined in BaseController and BaseModel:
	 * 	- get_list: obtain multiple items
	 * 	- get_one: obtain single item
	 * 	- create: create single item
	 * 	- update: update single item
	 * 	- delete: delete single item
	 */
	foreach ($base_routes as $route)
	{
		switch ($route)
		{
			// GET (multiple)
			case 'get_list':
				$url = "/$noun";
				$name = $noun.'.'.$route;
				$app->get($url, $ctrler.':'.$route)->name($name);
				break;

			// GET (single)
			case 'get_one':
				$url = "/$noun/:id";
				$name = $noun.'.'.$route;
				$app->get($url, $ctrler.':'.$route)->name($name);
				break;

			// CREATE
			case 'create':
				$url = "/$noun";
				$name = $noun.'.'.$route;
				$app->post($url, $ctrler.':'.$route)->name($name);
				break;

			// UPDATE
			case 'update':
				$url = "/$noun/:id";
				$name = $noun.'.'.$route;
				$app->put($url, $ctrler.':'.$route)->name($name);
				break;

			// DELETE
			case 'delete':
				$url = "/$noun/:id";
				$name = $noun.'.'.$route;
				$app->delete($url, $ctrler.':'.$route)->name($name);
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
					$route = 'get_'.$route;
					$name = $noun.'.'.$route;
					$app->get($url, $ctrler.':'.$route)->name($name);
				}
				break;

			// CREATE
			case 'post':
				foreach ($routes as $route)
				{
					$url = "/$noun/:id/".$route;
					$route = 'create_'.$route;
					$name = $noun.'.'.$route;
					$app->post($url, $ctrler.':'.$route)->name($name);
				}
				break;

			// UPDATE
			case 'put':
				foreach ($routes as $route)
				{
					$url = "/$noun/:id/".$route;
					$route = 'update_'.$route;
					$name = $noun.'.'.$route;
					$app->put($url, $ctrler.':'.$route)->name($name);
				}
				break;

			// DELETE
			case 'delete':
				foreach ($routes as $route)
				{
					$url = "/$noun/:id/".$route;
					$route = 'delete_'.$route;
					$name = $noun.'.'.$route;
					$app->delete($url, $ctrler.':'.$route)->name($name);
				}
				break;
		}
	}
}


/**
 * For debug only
 */
if (APP_DEBUG)
{
	$app->get('/util/routes', function() use($app, $models) {
		$view_data = array('app' => $app, 'models' => $models);
		$app->render('list_routes.php', $view_data);
		exit();
	});
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