BEGIN {print "SET foreign_key_checks = 0;"}
      {print "TRUNCATE TABLE `" $1 "`;"   }
END   {print "SET foreign_key_checks = 1;"}
