<?php

namespace ORM;

class Builder
{
	private $tableName;

	public function __construct($tableName)
	{
		$this->tableName = $tableName;
	}

	public function update($updaterEntity, $fieldTypings)
	{
		$sqlAssignments = $typedBindings = [];
		foreach ($fieldTypings as $fieldName => $type) {
			if (array_key_exists($fieldName, $updaterEntity)) {
				$placeholder = ":$fieldName";
				$value       = $updaterEntity[$fieldName];
				$sqlAssignments[] = "`$fieldName` = $placeholder";
				$typedBindings[$placeholder] = [$value, $type];
			}
		}
		$sqlBigAssignment = implode(', ', $sqlAssignments);
		$tableName = $this->tableName;
		$sql = "UPDATE `$tableName` SET $sqlBigAssignment WHERE `id` = :id";
		return compact('sql', 'typedBindings');
	}
}

