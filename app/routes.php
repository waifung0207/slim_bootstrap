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
			'create'		=> array('post'),
			'update'		=> array('password')
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
	 * Define route group
	 */
	$app->group('/'.$noun, function () use ($app, $noun, $ctrler, $base_routes, $custom_routes)
	{
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
			$target = $ctrler.':'.$route;
			$name = $noun.'.'.$route;

			switch ($route)
			{
				// GET (multiple)
				case 'get_list':
					$app->get('', $target)->name($name);
					break;

				// GET (single)
				case 'get_one':
					$app->get('/:id', $target)->name($name);
					break;

				// CREATE
				case 'create':
					$app->post('', $target)->name($name);
					break;

				// UPDATE
				case 'update':
					$app->put('/:id', $target)->name($name);
					break;

				// DELETE
				case 'delete':
					$app->delete('/:id', $target)->name($name);
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
		foreach ($custom_routes as $method => $routes)
		{
			$target_prefix = $ctrler.':'.$method.'_';
			$name_prefix = $noun.'.'.$method.'_';

			switch ($method)
			{
				// GET
				case 'get':
					foreach ($routes as $route)
					{
						$url = "/:id/".$route;
						$app->get($url, $target_prefix.$route)->name($name_prefix.$route);
					}
					break;

				// CREATE
				case 'create':
					foreach ($routes as $route)
					{
						$url = "/:id/".$route;
						$app->post($url, $target_prefix.$route)->name($name_prefix.$route);
					}
					break;

				// UPDATE
				case 'update':
					foreach ($routes as $route)
					{
						$url = "/:id/".$route;
						$app->put($url, $target_prefix.$route)->name($name_prefix.$route);
					}
					break;

				// DELETE
				case 'delete':
					foreach ($routes as $route)
					{
						$url = "/:id/".$route;
						$app->delete($url, $target_prefix.$route)->name($name_prefix.$route);
					}
					break;
			}
		}
	});
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