<?php

/** @todo: Controller base class must go to a spearate Framework supernamespace, and StudentController to an App supernamespace */
namespace Controller;

class Controller
{
	protected function redirect($uri)
	{
		header("Location: $uri");
	}
}
