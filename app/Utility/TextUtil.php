<?php

namespace Utility;

class TextUtil
{
	public static function isBlank(&$str)
	{
		return empty($str) || empty(trim($str));
	}

	public static function isNotBlank($str) {return !self::isBlank($str);}

	public static function contractBlankMembers($stringMembers)
	{
		$nonBlankStringMembers = array_filter(
			$stringMembers,
			[self::class, 'isNotBlank']
		);
		return implode(', ', $nonBlankStringMembers);
	}
}
