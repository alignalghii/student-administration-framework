<?php

$routes = [
	['GET', '/',                 'index',       ],
	['GET', '/student',          'student_index'],
	['GET', '/student/([0-9]+)', 'student_show' ]
];

function index()           {echo 'Root';}
function student_index()   {echo 'List of all students';}
function student_show($id) {echo "Show student #$id";}


$uri    = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

$found = false;
foreach ($routes as $route) {
	if (!$found) {
		list($routeMethod, $uriPattern, $action) = $route;
		if ($method == $routeMethod) {
			$uriPattern = "!^$uriPattern$!";
			$matched = preg_match($uriPattern, $uri, $match);
			if ($matched) {
				array_shift($match);
				call_user_func_array($action, $match);
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
