<?php

namespace Controller;

/** @todo: Controller base class must go to a spearate Framework supernamespace, and StudyGroupController to an App supernamespace */

use Repository\StudyGroupRepository;
use Form\StudyGroupForm;

class StudyGroupController extends Controller
{
	public function index()
	{
		$studyGroups = StudyGroupRepository::findAll();
		require 'app/View/StudyGroup/index.php';
	}

	/** @todo: algebraic datatype `Maybe` */
	public function show($idOrNull = null)
	{
		/** @todo: ViewModel, e.g. PersistenceViewModel */
		$isNew  = !isset($idOrNull);
		if (!$isNew) $id = $idOrNull; // $id <- Just $id, see monads
		$title   = $isNew ? 'New study group'                     : "Study group #$id";
		$action  = $isNew ? '/study_group/new'                    : "/study_group/$id"; // POST in form submit action, GET in reset action
		$studyGroup = $isNew ? StudyGroupForm::blankMissingFields() : StudyGroupRepository::find($id);
		require 'app/View/StudyGroup/show.php';
	}

	/** @todo: algebraic datatype `Maybe` */
	public function edit($id)
	{
		StudyGroupForm::saveOrHoldBack(
			$_POST,
			function() {$this->redirect('/');},
			function($studyGroup, $validationErrors) use($id) {
				/** @todo: ViewModel, e.g. PersistenceViewModel */
				$isNew   = false;
				$title   = "Study group #$id";
				$action  = "/study_group/$id"; // POST in form submit action, GET in reset action
				require "app/View/StudyGroup/show.php";
			},
			$id // Just $id
		);
	}

	public function new()
	{
		StudyGroupForm::saveOrHoldBack(
			$_POST,
			function() {$this->redirect('/');},
			function($studyGroup, $validationErrors) {
				/** @todo: ViewModel, e.g. PersistenceViewModel */
				$isNew   = true;
				$title   = "New study group";
				$action  = "/study_group/new"; // POST in form submit action, GET in reset action
				require "app/View/StudyGroup/show.php";
			}
		);
	}

	public function delete($id)
	{
		StudyGroupRepository::delete($id);
		$this->redirect('/');
	}
}
