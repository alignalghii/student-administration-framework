<?php

namespace Controller;

use Repository\JoinedRepository;
use Repository\StudentRepository;

class HomeController extends Controller
{
	public function index()
	{
		$isGetMethod = true;

		$inputModel = compact('isGetMethod');
		$viewModel  = new HomeViewModel($inputModel); // @todo -- possible further parameter: JavaScript-enabled/disabled mode

		$viewVars = $viewModel->getViewVars();
		extract($viewVars); // $isGetMethod, $studentsWithTheirGroupListForEach, $countStudents, $countActiveStudents, $studyGroups, $countStudyGroups
		require 'app/View/Home/index.php';
	}

	public function search()
	{
		$isGetMethod = false;
		$name        = $_POST['search_student_by_name'];
		$groupIds    = array_keys($_POST['search_student_by_group'] ?? []);
		$includeAlsoGrouplessStudents = array_key_exists('include_also_groupless_students', $_POST);

		$inputModel = compact('isGetMethod', 'name', 'groupIds', 'includeAlsoGrouplessStudents');
		$viewModel  = new HomeViewModel($inputModel); // @todo -- possible further parameter: JavaScript-enabled/disabled mode

		$viewVars = $viewModel->getViewVars();
		extract($viewVars); // $isGetMethod, $studentsWithTheirGroupListForEach, $countStudents, $countActiveStudents, $studyGroups, $countStudyGroups
		require 'app/View/Home/index.php';
	}

	public function deleteSelectedOnes()
	{
		array_map(
			[StudentRepository::class, 'delete'],
			array_keys($_POST['delete_student'] ?? [])
		);
		$this->redirect('/');
	}
}
