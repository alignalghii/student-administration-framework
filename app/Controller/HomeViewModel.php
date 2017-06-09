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
	public function __construct($inputModel)
	{
		/**
		 * MANDATORY:                           $isGetMethod = (true | false)
		 * OPTIONAL (if $isGetMethod is false):                           \--> $name, $groupIds, $includeAlsoGrouplessStudents
		 */
		extract($inputModel);
		$studentsWithTheirGroupListForEach = $isGetMethod ? JoinedRepository::findAllStudentsWithTheirGroupListForEach()
		                                                  : JoinedRepository::search($name, $groupIds, $includeAlsoGrouplessStudents);

		// Some restructuration/conversion in order to be easier to present
		$studentsWithTheirGroupListForEach = array_map(
			[$this, 'convertStudent'],
			$studentsWithTheirGroupListForEach
		);

		$studyGroups                       = StudyGroupRepository::findAll();
		$countActiveStudents               = StudentStudyGroupMembershipRepository::countActiveStudents();
		$countStudents                     = count($studentsWithTheirGroupListForEach);
		$countStudyGroups                  = count($studyGroups);

		if ($isGetMethod) {
			$name     = '';
			$groupIds = array_map(
				function($g) {return $g['id'];},
				$studyGroups
			);
			$includeAlsoGrouplessStudents = true;
		}

		$this->viewVars = compact(
			'isGetMethod',
			'studentsWithTheirGroupListForEach', 'countStudents',
			'studyGroups',                       'countStudyGroups',
			'countActiveStudents',
			'name', 'groupIds', 'includeAlsoGrouplessStudents'
		);
	}

	public function getViewVars() {return $this->viewVars;}

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
