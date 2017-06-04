<?php

require 'autoload.php';

use Controller\HomeController;
use Controller\StudentController;

/** @todo: put DEBUG value into config data */
const DEBUG = true;

$routes = [
	['GET',  '/',                 HomeController::class,    'index'],
	['GET',  '/student',          StudentController::class, 'index'],
	['GET',  '/student/([0-9]+)', StudentController::class, 'show' ],
	['POST', '/student/([0-9]+)', StudentController::class, 'edit' ]
];

set_error_handler('report', E_WARNING);

	$uri    = $_SERVER['REQUEST_URI'];
	$method = $_SERVER['REQUEST_METHOD'];

	$found = false;
	foreach ($routes as $route) {
		if (!$found) {
			list($routeMethod, $uriPattern, $controller, $action) = $route;
			if ($method == $routeMethod) {
				$uriPattern = "!^$uriPattern$!";
				$matched = preg_match($uriPattern, $uri, $match);
				if ($matched) {
					array_shift($match);
					call_user_func_array([new $controller, $action], $match);
					$found = true;
				}
			}
		} else {
			break;
		}
	}
	if (!$found) {
		echo "No matchable route pattern found for `$method $uri`";
	}

restore_error_handler();

function report($errno, $errstr)
{
	echo "Internal error, please report!";
	if (DEBUG) echo " Code: $errno, message: $errstr";
	//return false;
}
