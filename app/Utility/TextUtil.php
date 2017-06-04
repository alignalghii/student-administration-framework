<?php

namespace Utility;

class TextUtil
{
	public static function isBlank(&$str) {
		return empty($str) || empty(trim($str));
	}
}
