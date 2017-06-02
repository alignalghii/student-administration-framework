<?php

/** @todo: put DEBUG value into config data */
const DEBUG = true;

$routes = [
	['GET', '/',                 'DefaultController', 'index'],
	['GET', '/student',          'StudentController', 'index'],
	['GET', '/student/([0-9]+)', 'StudentController', 'show' ]
];

class DefaultController
{
	public function index() {echo 'Root';}
}

class StudentController
{
	public function index()   {echo 'List all users';}
	public function show($id) {echo "Show student #$id";}
}


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
}
