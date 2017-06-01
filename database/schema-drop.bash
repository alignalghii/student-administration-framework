#!/bin/bash

tac schema-dependencies.dat\
| \
while read tablename;
	do
		echo 'DROP TABLE `'"$tablename"'`' | mysql student_administration_framework;
done;
