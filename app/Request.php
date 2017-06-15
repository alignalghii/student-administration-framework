<?php

class Request
{
	private $superglobal;

	public function __construct($superglobal) {$this->superglobal = $superglobal;}

	public function checkboxIdsIn($checkboxesCommonName)
	{
		$checkboxArray = $this->superglobal[$checkboxesCommonName] ?? [];
		$keyIds        = array_keys($checkboxArray);
		return array_map('intval', $keyIds);
	}

	public function formFieldExists($formFieldName)
	{
		return array_key_exists($formFieldName, $this->superglobal);
	}

	public function FormFieldValue($formFieldName, $defaultValue)
	{
		return $this->superglobal[$formFieldName] ?? $defaultValue;
	}

	public function uriWithQueryString($uri)
	{
		$queryString = $this->queryString();
		return $queryString ? "$uri?$queryString" : $uri;
	}

	private function queryString()
	{
		$raw_queryString = http_build_query($this->superglobal);
		return htmlspecialchars($raw_queryString);
	}
}
