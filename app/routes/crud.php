<?php


// prepare models
$models = array(
	'UserModel' => array(
		'noun'		=> 'users',
		'routes'	=> array('get_list', 'get_one', 'create', 'update')
	)
	
	// Examples:
	/*
	'ProductModel' => array(
		'noun'		=> 'products',
		'routes'	=> array('get_list', 'get_one', 'create', 'update', 'delete')
	)
	*/
);


// setup CRUD routes
foreach ($models as $model => $params)
{
	$noun = $params['noun'];
	$routes = $params['routes'];

	foreach ($routes as $route)
	{
		switch ($route)
		{
			// GET (multiple)
			case 'get_list':
				$url = "/$noun";
				$app->get($url, function () use ($app, $model) {
					$factory = new $model($app);
					echo $factory->get_list();
				});
				break;

			// GET (single)
			case 'get_one':
				$url = "/$noun/:id";
				$app->get($url, function ($id) use ($app, $model) {
					$factory = new $model($app);
					echo $factory->get_one($id);
				});
				break;

			// CREATE
			case 'create':
				$url = "/$noun";
				$app->post($url, function () use ($app, $model) {
					$factory = new $model($app);
					echo $factory->create();
				});
				break;

			// UPDATE
			case 'update':
				$url = "/$noun/:id";
				$app->put($url, function ($id) use ($app, $model) {
					$factory = new $model($app);
					echo $factory->update($id);
				});
				break;

			// DELETE
			case 'delete':
				$url = "/$noun/:id";
				$app->delete($url, function ($id) use ($app, $model) {
					$factory = new $model($app);
					echo $factory->delete($id);
				});
				break;
		}
	}
}
