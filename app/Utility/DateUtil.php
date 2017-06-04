<?php

namespace Utility;

class Dateutil
{
	public static function isValid($rawDate)
	{
		try {
			$date = new \DateTime($rawDate);
			$status = !empty($date);
		} catch (\Exception $e) {
			$status = false;
		}
		return $status;
	}
}

