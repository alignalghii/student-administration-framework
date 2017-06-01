#!/bin/bash

while read tablename;
	do
		mysql student_administration_framework < "table-create-$tablename.sql";
done < schema-dependencies.dat;

mysql student_administration_framework < trigger-create.sql;
