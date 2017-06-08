<?php

namespace View;

class Helper
{
	private $urlFormat;

	public function __construct($urlFormat) {$this->urlFormat = $urlFormat;}

	public function linkifyByIds($idKeyedTextParts)
	{
		return array_map(
			[$this, 'linkify'],
			array_keys($idKeyedTextParts),
			$idKeyedTextParts
		);
	}

	public function linkify($id, $text)
	{
		$url = sprintf($this->urlFormat, $id);
		return "<a href=\"$url\">$text</a>";
	}
}
