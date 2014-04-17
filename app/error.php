<?php

$app->notFound(function () use ($app) {
	$view_data = array('home_url' => $app->urlFor('home'));
    $app->render('404.php', $view_data, 404);
});