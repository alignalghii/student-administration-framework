#!/bin/bash

if test -f config.sed;
	then
		sed -f config.sed database/config.bash.tpl > database/config.bash;
		sed -f config.sed app/Config.php.tpl       > app/Config.php;
	else
		echo 'No configuration datafile `config.sed` found, I am using `config.sample.sed` instead.'
		echo 'If You disagree, type `cp config.sample.sed config.sed`, and customize it.';
		sed -f config.sample.sed database/config.bash.tpl > database/config.bash;
		sed -f config.sample.sed app/Config.php.tpl       > app/Config.php;
fi;
