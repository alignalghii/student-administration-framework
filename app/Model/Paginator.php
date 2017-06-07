<?php

namespace Model;

use Utility\ArrayUtil;

class Paginator
{
	private $search;
	private $n;

	public function __construct($search, $n = 10)
	{
		$this->search = $search;
		$this->n      = $n;
	}

	public function paginatedSearch($propertiesWithPageNum)
	{
		list($pageNum, $properties) = ArrayUtil::take('page', $propertiesWihPagenum, 0);
		$resultSet = $this->search($properties);
		$paginatedSet = ArrayUtil::paginate($this->n, $resultSet)[$pageNum];
		$allCount = count($resultSet);
		return compact('paginatedSet', 'count');
	}

}
