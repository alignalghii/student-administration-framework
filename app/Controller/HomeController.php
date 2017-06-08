<?php

namespace Controller;

class HomeController
{
	public function index()
	{
		$viewModel = new HomeViewModel(true); // true: isGetmethod. @todo -- possible further parameter: JavaScript-enabled/disabled mode
		$viewVars = $viewModel->getViewVars();
		extract($viewVars); // $isGetMethod, $studentsWithTheirGroupListForEach, $countStudents, $countActiveStudents, $studyGroups, $countStudyGroups
		require 'app/View/Home/index.php';
	}
}
