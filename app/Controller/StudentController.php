<?php

namespace Controller;

class StudentController
{
	public function index()
	{
		require 'app/View/Student/index.php';
	}

	public function show($id)
	{
		require 'app/View/Student/show.php';
	}
}
