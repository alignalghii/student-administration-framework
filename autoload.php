<?php

spl_autoload_register('namespaceBasedAutoload');

function namespaceBasedAutoload($namespacedClassName)
{
	$pathedModuleName = str_replace('\\', '/', $namespacedClassName);
	require "$pathedModuleName.php";
}
