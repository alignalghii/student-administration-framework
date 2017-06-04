<?php

require 'autoload.php';

use ORM\Query;
use Repository\StudentRepository;

//$a = Query::doAll('SELECT * FROM `student`', []);
//var_dump($a);

$b = StudentRepository::findAll();
var_dump($b);
