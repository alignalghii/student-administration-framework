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

	public function create($updaterEntity, $fieldTypings)
	{
		$sqlAssignments = $typedBindings = [];
		foreach ($fieldTypings as $fieldName => $type) {
			if (array_key_exists($fieldName, $updaterEntity)) {
				$placeholder = ":$fieldName";
				$value       = $updaterEntity[$fieldName];
				$sqlSignatureParts[] = "`$fieldName`";
				$sqlRecordParts[]    = $placeholder;
				$typedBindings[$placeholder] = [$value, $type];
			}
		}
		$sqlSignature = implode(', ', $sqlSignatureParts);
		$sqlRecord    = implode(', ', $sqlRecordParts);
		$tableName = $this->tableName;
		$sql = "INSERT INTO `$tableName` ($sqlSignature) VALUES ($sqlRecord)";
		return compact('sql', 'typedBindings');
	}

	public function delete($id)
	{
		$sql           = 'DELETE FROM `'.$this->tableName.'` WHERE `id` = :id';
		$typedBindings = [':id' => [$id, \PDO::PARAM_INT]];
		return compact('sql', 'typedBindings');
	}
}
