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

	/**
	 * @todo: algebraic datatype `Maybe`
	 * @todo: derivative viewVariables belong to a standalone `StudentViewModel` module
	 */
	public function show($idOrNull = null)
	{
		/** @todo: ViewModel, e.g. PersistenceViewModel */
		$isNew  = !isset($idOrNull);
		if (!$isNew) $id = $idOrNull; // $id <- Just $id, see monads
		$title   = $isNew ? 'New student'                     : "Student #$id";
		$action  = $isNew ? '/student/new'                    : "/student/$id"; // POST in form submit action, GET in reset action
		$student = $isNew ? StudentForm::blankMissingFields() : StudentRepository::find($id);
		require 'app/View/Student/show.php';
	}

	/** @todo: algebraic datatype `Maybe` */
	public function edit($id)
	{
		StudentForm::saveOrHoldBack(
			$_POST,
			function() {$this->redirect('/');},
			function($student, $validationErrors) use($id) {
				/** @todo: ViewModel, e.g. PersistenceViewModel */
				$isNew   = false;
				$title   = "Student #$id";
				$action  = "/student/$id"; // POST in form submit action, GET in reset action
				require "app/View/Student/show.php";
			},
			$id // Just $id
		);
	}

	public function new()
	{
		StudentForm::saveOrHoldBack(
			$_POST,
			function() {$this->redirect('/');},
			function($student, $validationErrors) {
				/** @todo: ViewModel, e.g. PersistenceViewModel */
				$isNew   = true;
				$title   = "New student";
				$action  = "/student/new"; // POST in form submit action, GET in reset action
				require "app/View/Student/show.php";
			}
		);
	}

	public function delete($id)
	{
		StudentRepository::delete($id);
		$this->redirect('/');
	}

}
