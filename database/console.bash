#!/bin/bash

if . config.bash;
	then
		echo 'Config file found';
		if test $# -eq 2;
			then
				case "$2" in
					database)
						case "$1" in
							create)
								mysql <<EOT;;
								CREATE DATABASE \`$DB_NAME\`;
								CREATE USER '$DB_USER' IDENTIFIED BY '$DB_PWD';
								GRANT ALL PRIVILEGES ON $DB_NAME.* TO '$DB_USER';
								FLUSH PRIVILEGES;
EOT
							drop)
								mysql <<EOT;;
								DROP DATABASE \`$DB_NAME\`;
								DROP USER \`$DB_USER\`;
EOT
							*)
								echo 'Wrong second argument! Usage: ./console.bash (create|drop) (database|schema)';
						esac;;
					schema)
						case "$1" in
							create)
								while read tablename;
									do
										mysql "$DB_NAME" < "table-create-$tablename.sql";
								done < schema-dependencies.dat;
								mysql "$DB_NAME" < trigger-create.sql;;
							drop)
								tac schema-dependencies.dat\
								|
								while read tablename;
									do
										echo 'DROP TABLE `'"$tablename"'`' | mysql "$DB_NAME";
								done;;
							*)
								echo 'Wrong second argument! Usage: ./console.bash (create|drop) (database|schema)';
						esac;;
					*)
						echo 'Wrong first argument! Usage: ./console.bash (create|drop) (database|schema)';
				esac;
			else
				echo 'Wrong number of arguments! Usage: ./console.bash (create|drop) (database|schema)';
		fi;
	else
		echo 'Config file not found, copy `config.bash.sample` to `config.bash`, and fill in assignments with values';
		echo 'Even better, if You use the standard configuration process: run ../configure.bash, and follow the advices, if any';
fi;
