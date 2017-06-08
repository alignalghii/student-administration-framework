<?php

namespace Controller;

use Repository\StudyGroupRepository;
use Repository\StudentStudyGroupMembershipRepository;
use Repository\JoinedRepository;
use View\Helper;
use Utility\TextUtil;
use Utility\ArrayUtil;

class HomeViewModel
{
	private $viewVars;

	/** @todo -- possible further parameter: JavaScript-enabled/disabled mode */
	public function __construct($isGetMethod)
	{
		$studentsWithTheirGroupListForEach = $this->retrieveAndConvertStudents();
		$studyGroups                       = StudyGroupRepository::findAll();
		$countActiveStudents               = StudentStudyGroupMembershipRepository::countActiveStudents();
		$countStudents                     = count($studentsWithTheirGroupListForEach);
		$countStudyGroups                  = count($studyGroups);

		$this->viewVars = compact(
			'isGetMethod',
			'studentsWithTheirGroupListForEach', 'countStudents',
			'studyGroups',                       'countStudyGroups',
			'countActiveStudents'
		);
	}

	public function getViewVars() {return $this->viewVars;}

	private function retrieveAndConvertStudents()
	{
		$entities = JoinedRepository::findAllStudentsWithTheirGroupListForEach();
		return array_map(
			[$this, 'convertStudent'],
			$entities
		);
	}

	private function convertStudent($studentWithHisPossiblyEmptyGroupList)
	{
		extract($studentWithHisPossiblyEmptyGroupList); // $id, $name, $is_male, $place_of_birth, $date_of_birth, $email, $groupNamesText, $groupIdsText
		$sex = $is_male ? 'Male' : 'Female';
		$place_and_date_of_birth = TextUtil::contractBlankMembers([$place_of_birth, $date_of_birth]);
		$groupIds   = TextUtil::explode(' ~|!>~ ', $groupIdsText);
		$groupNames = TextUtil::explode(' ~|!>~ ', $groupNamesText);
		$groups = ArrayUtil::keyedZip($groupIds, $groupNames);
		// @todo: handling `see more' and `see less'
		$abbrev = count($groups) > 2;
		$helper = new Helper('/study_group/%d');
		$groupLinks = $helper->linkifyByIds($groups);
		$groupLinksHtml = implode(', ', $groupLinks);
		return compact('id', 'name', 'sex', 'place_and_date_of_birth', 'groupLinksHtml', 'abbrev');
	}

}
