<?php

$uri = $_SERVER['REQUEST_URI'];
switch ($uri) {
	case '/':
		echo 'Root';
		break;
	case '/student';
		echo 'List of all students';
		break;
	case '/student/1';
		echo 'Show first student';
		break;
	default:
		echo "Resource not found at request URI $uri";
}
