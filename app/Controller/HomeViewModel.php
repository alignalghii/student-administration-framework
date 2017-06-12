<?php

namespace Controller;

use Request;
use Repository\StudentRepository;
use Repository\StudyGroupRepository;
use Repository\StudentStudyGroupMembershipRepository;
use Repository\JoinedRepository;
use Entity\Entity;
use View\Helper;
use Utility\TextUtil;
use Utility\ArrayUtil;

class HomeViewModel
{
	private $viewVars;

	/** @todo -- possible further parameter: JavaScript-enabled/disabled mode */
	public function __construct($isGetMethod, $superglobal)
	{
		$studyGroups                       = StudyGroupRepository::findAll();
		$countActiveStudents               = StudentStudyGroupMembershipRepository::countActiveStudents();
		$countAllStudents                  = StudentRepository::countAll();
		$countStudyGroups                  = count($studyGroups);

		$request = new Request($superglobal);
		if ($request->formFieldExists('search_submitted')) {
			$groupIdsForSearch            = $request->checkboxIdsIn('search_student_by_group');
			$includeAlsoGrouplessStudents = $request->formFieldExists('include_also_groupless_students');
		} else { // if they are not unset explicity, they count as all-filled:
			$groupIdsForSearch            = Entity::getAllIds($studyGroups);
			$includeAlsoGrouplessStudents = true;
		}
		$studentIdsToDelete               = $request->checkboxIdsIn('delete_student');
		$namePattern                      = $request->FormFieldValue('search_student_by_name', '');
		$queryString                      = $request->queryString();

		$studentSearchResult = JoinedRepository::search($namePattern, $groupIdsForSearch, $includeAlsoGrouplessStudents);

		// Some restructuration/conversion in order to be easier to present
		$studentsWithTheirGroupListForEach = array_map(
			[$this, 'convertStudent'],
			$studentSearchResult
		);
		$countFoundStudents = count($studentsWithTheirGroupListForEach);

		$this->viewVars = compact(
			'countAllStudents',
			'studentsWithTheirGroupListForEach', 'countFoundStudents',
			'studyGroups',                       'countStudyGroups',
			'countActiveStudents',
			'namePattern', 'groupIdsForSearch', 'includeAlsoGrouplessStudents'
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
