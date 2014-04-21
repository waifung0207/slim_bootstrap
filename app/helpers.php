<?php

/**
 * String transformation:
 * 	- http://laravel.com/api/source-class-Illuminate.Support.Str.html (Laravel Str Helper)
 * 	- http://stackoverflow.com/questions/834303/startswith-and-endswith-functions-in-php
 */

function snake_case($value, $delimiter = '_')
{
	$replace = '$1'.$delimiter.'$2';
	return ctype_lower($value) ? $value : strtolower(preg_replace('/(.)([A-Z])/', $replace, $value));
}

function starts_with($haystack, $needle)
{
    return $needle === "" || strpos($haystack, $needle) === 0;
}

function ends_with($haystack, $needle)
{
    return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
}