<?php

namespace Controller;

class StudentController
{
	public function index()   {echo 'List all users';}
	public function show($id) {echo "Show student #$id";}
}
