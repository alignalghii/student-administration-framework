<?php

require 'autoload.php';

use Controller\HomeController;
use Controller\StudentController;
use Controller\StudyGroupController;
use Controller\StudentStudyGroupMembershipController;

/** @todo: put DEBUG value into config data */
const DEBUG = true;

$routes = [
	['GET',  '/',                        HomeController::class,    'index' ],

	['GET',  '/student',                 StudentController::class, 'index' ],
	['GET',  '/student/([0-9]+)',        StudentController::class, 'show'  ],
	['POST', '/student/([0-9]+)',        StudentController::class, 'edit'  ],
	['GET',  '/student/new',             StudentController::class, 'show'  ],
	['POST', '/student/new',             StudentController::class, 'new'   ],
	['POST', '/student/([0-9]+)/delete', StudentController::class, 'delete'],

	['GET',  '/study_group',                 StudyGroupController::class, 'index' ],
	['GET',  '/study_group/([0-9]+)',        StudyGroupController::class, 'show'  ],
	['POST', '/study_group/([0-9]+)',        StudyGroupController::class, 'edit'  ],
	['GET',  '/study_group/new',             StudyGroupController::class, 'show'  ],
	['POST', '/study_group/new',             StudyGroupController::class, 'new'   ],
	['POST', '/study_group/([0-9]+)/delete', StudyGroupController::class, 'delete'],

	['GET',  '/student_study_group_membership',                 StudentStudyGroupMembershipController::class, 'index' ],
	['GET',  '/student_study_group_membership/([0-9]+)',        StudentStudyGroupMembershipController::class, 'show'  ],
	['POST', '/student_study_group_membership/([0-9]+)',        StudentStudyGroupMembershipController::class, 'edit'  ],
	['GET',  '/student_study_group_membership/new',             StudentStudyGroupMembershipController::class, 'show'  ],
	['POST', '/student_study_group_membership/new',             StudentStudyGroupMembershipController::class, 'new'   ],
	['POST', '/student_study_group_membership/([0-9]+)/delete', StudentStudyGroupMembershipController::class, 'delete'],
];

set_error_handler('report', E_ALL);

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
