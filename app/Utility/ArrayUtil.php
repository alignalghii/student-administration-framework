<?php

namespace Utility;

class ArrayUtil
{
	public static function reshapeAs($assoc, $keys)
	{
		$reshapedAssoc = [];
		foreach ($keys as $key) {
			$reshapedAssoc[$key] = $assoc[$key] ?? null;
		}
		return $reshapedAssoc;
	}
}
