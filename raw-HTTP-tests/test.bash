#!/bin/bash

for actiondata in *.data.http;
	do
		actual=${actiondata%.data.http}.actual.http;
		expected=${actiondata%.data.http}.expected.http;
		if test -f "$expected";
			then
				echo -ne "Request `awk 'NR == 1 {print $2}' $actiondata`\t:\t";
				if netcat localhost 8000 < "$actiondata" > "$actual";
					then
						if diff "$expected" "$actual";
							then
								echo OK;
							else
								echo Wrong;
						fi;
					else
						echo 'Server not running, or other network problem';
				fi;
			else
				echo "Expectation $expected missing";
		fi;
done;
