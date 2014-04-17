<?php

$app->get('/hello/:name', function ($name) {
	echo "Hello, $name";
});