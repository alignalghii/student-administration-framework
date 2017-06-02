<?php

spl_auoload_register('autoload');

function autoload($className)
{
	require "$className.php";
}
