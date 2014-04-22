<html>
  <head>
  	<title>Route List</title>
  	<style>
  	table {
  		border-collapse: collapse;
  	}
  	th, td {
  		border: 1px solid black;
  		padding: 5px 15px;
  		text-align: left;
  	}
  	td.separator {
  		padding: 5px 15px;
  	}
  	</style>
  </head>

  <body>

	<?php

	/**
	 * Populate table to list out all routes
	 */
	foreach ($models as $model => $params)
	{
		$noun = $params['noun'];
		$ctrler = $model.'Controller';

		$base_routes = empty($params['base_routes']) ? array() : $params['base_routes'];
		$custom_routes = empty($params['custom_routes']) ? array() : $params['custom_routes'];

		echo "<h2>Model: $model</h2>";

		echo "<table>";
		echo "<tr><th>Type</th><th>Method</th><th>URI</th><th>Controller Function</th><th>Route Name</th><th>Sample Link</th></tr>";

		// Base routes
		foreach ($base_routes as $route)
		{
			$link = '';
			$url = "/$noun";
			$name = $noun.'.'.$route;

			switch ($route)
			{
				case 'get_list':
					$method = "GET";
					$link = $app->urlFor($name);
					break;

				// GET (single)
				case 'get_one':
					$method = "GET";
					$url.= "/:id";
					$link = $app->urlFor($name, array('id' => 1));
					break;

				// CREATE
				case 'create':
					$method = "CREATE";
					break;

				// UPDATE
				case 'update':
					$method = "UPDATE";
					$url.= "/:id";
					break;

				// DELETE
				case 'delete':
					$method = "DELETE";
					$url.= "/:id";
					break;
			}

			// display route info
			$link = empty($link) ? '-' : "<a href='$link'>Link</a>";
			echo "<tr><td>Base</td><td>$method</td><td>$url</td><td>$ctrler:$route</td><td>$name</td><td>$link</td></tr>";
		}

		// separator
		echo "<tr><td colspan='6' class='separator'></td></tr>";

		// Custom routes
		foreach ($custom_routes as $action => $routes)
		{
			switch ($action)
			{
				// GET
				case 'get':
					foreach ($routes as $route)
					{
						$method = "GET";
						$url = "/$noun/:id/".$route;
						$route = 'get_'.$route;
						$name = $noun.'.'.$route;

						// display route info
						$link = $app->urlFor($name, array('id' => 1));
						$link = "<a href='$link'>Link</a>";
						echo "<tr><td>Custom</td><td>$method</td><td>$url</td><td>$ctrler:$route</td><td>$name</td><td>$link</td></tr>";
					}
					break;

				// CREATE
				case 'create':
					foreach ($routes as $route)
					{
						$method = "POST";
						$url = "/$noun/:id/".$route;
						$route = 'create_'.$route;
						$name = $noun.'.'.$route;

						// display route info
						echo "<tr><td>Custom</td><td>$method</td><td>$url</td><td>$ctrler:$route</td><td>$name</td><td>-</td></tr>";
					}
					break;

				// UPDATE
				case 'update':
					foreach ($routes as $route)
					{
						$method = "PUT";
						$url = "/$noun/:id/".$route;
						$route = 'update_'.$route;
						$name = $noun.'.'.$route;

						// display route info
						echo "<tr><td>Custom</td><td>$method</td><td>$url</td><td>$ctrler:$route</td><td>$name</td><td>-</td></tr>";
					}
					break;

				// DELETE
				case 'delete':
					foreach ($routes as $route)
					{
						$method = "DELETE";
						$url = "/$noun/:id/".$route;
						$route = 'delete_'.$route;
						$name = $noun.'.'.$route;

						// display route info
						echo "<tr><td>Custom</td><td>$method</td><td>$url</td><td>$ctrler:$route</td><td>$name</td><td>-</td></tr>";
					}
					break;
			}
		}

		echo "</table>";
	}
	?>

  </body>
</html>