#!/bin/bash

. ../database/config.bash;
echo "Database: \`$DB_NAME\`";

find . -mindepth 1 -maxdepth 1 -type d\
|
while read fixture;
	do
		echo "Fixture $fixture";
		echo -e "\tSetup";
		if awk -f truncate.awk < ../database/schema-dependencies.dat | mysql "$DB_NAME";
			then echo -e "\t\tTruncation successful";
			else echo -e "\t\tTruncation failed";
		fi;
		while read tableName;
			do
				dataFile="$fixture/$tableName.data.sql"
				if test -f "$dataFile";
					then
						echo -en "\t\tLoading table \`$tableName\`... ";
						if mysql "$DB_NAME" < "$dataFile";
							then echo "loaded successfully";
							else echo "failed loading";
						fi;
					else
						echo -e "\t\tNo testdata for $tableName";
				fi;
		done < ../database/schema-dependencies.dat;
		if test -f $fixture/functionality-to-be-tested.bash;
			then
				echo -en "\tRunning the app functionality to be tested... ";
				if $fixture/functionality-to-be-tested.bash;
					then echo " correct run";
					else echo " broken run";
				fi;
			else
				echo -e "\tImplicit idle functionality assumed: no interaction with app provided";
		fi;
		echo -e "\tComparisons";
		find "$fixture" -name '*.expected.tsv'\
		|
		while read expected;
			do
				table=`basename ${expected%.expected.tsv}`;
				actual="${expected%.expected.tsv}.actual.tsv";
				echo -en "\t\tGenerating actual data for expectation of \`$table\`... ";
				if echo "SELECT * FROM \`$table\`" | mysql "$DB_NAME" > "$actual";
					then echo "done";
					else echo "failed";
				fi;
				if diff $expected $actual;
					then echo -e "\t\t - OK, actual meets expectation";
					else echo -e "\t\t - Wrong, actual differs from expectation";
				fi;
		done;
done;
