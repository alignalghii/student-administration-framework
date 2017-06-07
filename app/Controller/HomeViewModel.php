<?php

namespace Controller;

use Repository\StudentRepository;
use Repository\StudyGroupRepository;
use Repository\JoinedRepository;
use Utility\TextUtil;

class HomeViewModel
{
	private $viewVars;

	/** @todo -- possible further parameter: JavaScript-enabled/disabled mode */
	public function __construct($isGetMethod)
	{
		$students            = $this->retrieveAndConvertStudents();
		$studyGroups         = StudyGroupRepository::findAll();
		$countActiveStudents = JoinedRepository::countActiveStudents();
		$countStudents    = count($students);
		$countStudyGroups = count($studyGroups);

		$this->viewVars = compact(
			'isGetMethod',
			'students', 'countStudents',
			'studyGroups', 'countStudyGroups',
			'countActiveStudents'
		);
	}

	public function getViewVars() {return $this->viewVars;}

	private function retrieveAndConvertStudents()
	{
		$studentEntities = StudentRepository::findAll();
		return array_map(
			[$this, 'convertStudent'],
			$studentEntities
		);
	}

	private function convertStudent($studentEntity)
	{
		extract($studentEntity); // $id, $name, $is_male, $place_of_birth, $date_of_birth, $email
		$sex = $is_male ? 'Male' : 'Female';
		$place_and_date_of_birth = TextUtil::contractBlankMembers([$place_of_birth, $date_of_birth]);
		$groups = '[TODO]';
		return compact('id', 'name', 'sex', 'place_and_date_of_birth', 'groups');
	}
}
