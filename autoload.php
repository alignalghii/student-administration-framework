<?php

spl_autoload_register('namespaceBasedAutoload');

function namespaceBasedAutoload($namespacedClassName)
{
	$pathedModuleName = str_replace('\\', DIRECTORY_SEPARATOR, $namespacedClassName);
	require "../app/$pathedModuleName.php";
}
