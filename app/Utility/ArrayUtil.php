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

	public static function take($key, $assoc, $default)
	{
		$value = $assoc[$key] ?? $default;
		unset($assoc[$key]);
		return compact('value', 'assoc');
	}

	public static function paginate($n, $arr)
	{
		return [$arr];
	}
}
