<?php

namespace Controller;

/** @todo: Controller base class must go to a spearate Framework supernamespace, and StudentController to an App supernamespace */

use Repository\StudentRepository;
use Form\StudentForm;

class StudentController extends Controller
{
	public function index()
	{
		$students = StudentRepository::findAll();
		require 'app/View/Student/index.php';
	}

	public function show($id)
	{
		$student = StudentRepository::find($id);
		require 'app/View/Student/show.php';
	}

	/** @todo: algebraic datatype `Maybe` */
	public function edit($id)
	{
		StudentForm::saveOrHoldBack(
			$_POST,
			function() {$this->redirect('/student');},
			function($student, $validationErrors) use($id) {require "app/View/Student/show.php";},
			$id // Just $id
		);
	}
}
