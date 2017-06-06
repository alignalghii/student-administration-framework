<?php

namespace Controller;

/** @todo: Controller base class must go to a spearate Framework supernamespace, and StudentStudyGroupMembershipController to an App supernamespace */

use Repository\StudentStudyGroupMembershipRepository;
use Form\StudentStudyGroupMembershipForm;

class StudentStudyGroupMembershipController extends Controller
{
	public function index()
	{
		$studentStudyGroupMemberships = StudentStudyGroupMembershipRepository::findAll();
		require 'app/View/StudentStudyGroupMembership/index.php';
	}

	/** @todo: algebraic datatype `Maybe` */
	public function show($idOrNull = null)
	{
		/** @todo: ViewModel, e.g. PersistenceViewModel */
		$isNew  = !isset($idOrNull);
		if (!$isNew) $id = $idOrNull; // $id <- Just $id, see monads
		$title   = $isNew ? 'New membership between students and study groups'  : "Membership #$id between students and study groups";
		$action  = $isNew ? '/student_study_group_membership/new'               : "/student_study_group_membership/$id"; // POST in form submit action, GET in reset action
		$studentStudyGroupMembership = $isNew ? StudentStudyGroupMembershipForm::blankMissingFields() : StudentStudyGroupMembershipRepository::find($id);
		require 'app/View/StudentStudyGroupMembership/show.php';
	}

	/** @todo: algebraic datatype `Maybe` */
	public function edit($id)
	{
		StudentStudyGroupMembershipForm::saveOrHoldBack(
			$_POST,
			function() {$this->redirect('/student_study_group_membership');},
			function($studentStudyGroupMembership, $validationErrors) use($id) {
				/** @todo: ViewModel, e.g. PersistenceViewModel */
				$isNew   = false;
				$title   = "Membership #$id between students and study groups";
				$action  = "/student_study_group_membership/$id"; // POST in form submit action, GET in reset action
				require "app/View/StudentStudyGroupMembership/show.php";
			},
			$id // Just $id
		);
	}

	public function new()
	{
		StudentStudyGroupMembershipForm::saveOrHoldBack(
			$_POST,
			function() {$this->redirect('/student_study_group_membership');},
			function($studentStudyGroupMembership, $validationErrors) {
				/** @todo: ViewModel, e.g. PersistenceViewModel */
				$isNew   = true;
				$title   = "New membership between students and study groups";
				$action  = "/student_study_group_membership/new"; // POST in form submit action, GET in reset action
				require "app/View/StudentStudyGroupMembership/show.php";
			}
		);
	}

	public function delete($id)
	{
		StudentStudyGroupMembershipRepository::delete($id);
		$this->redirect('/student_study_group_membership');
	}
}
