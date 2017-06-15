<?php

namespace Controller;

use Repository\JoinedRepository;
use Repository\StudentRepository;

class HomeController extends Controller
{
	public function index()
	{
		$viewModel  = new HomeViewModel(true, $_GET); // true: GET, false: POST
		$viewVars = $viewModel->getViewVars();
		extract($viewVars);
		// $studentsWithTheirGroupListForEach, $countStudents, $countActiveStudents, $studyGroups, $countStudyGroups
		require 'app/View/Home/index.php';

	}

	public function deleteSelectedOnes()
	{
		array_map(
			[StudentRepository::class, 'delete'],
			array_keys($_POST['delete_student'] ?? [])
		);
		$viewModel = new HomeViewModel(false, $_GET + $_POST); // true: GET, false: POST
		$viewVars = $viewModel->getViewVars();
		extract($viewVars);
		require 'app/View/Home/index.php';
	}
}
