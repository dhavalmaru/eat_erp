<?php
        // Define database credentials
        $host = 'localhost';
        $user = 'eatangcp_root';
        $password = 'EatErp@12345#';
        $database = 'eatangcp_eat_erp';
		
		// $host = 'localhost';
        // $user = 'root';
        // $password = '';
        // $database = 'eat_erp';

        // Create db connection
        $conn = mysql_connect($host, $user, $password) or die('Error: Could not connect to database - ' . mysql_error());
        // Once connected, we can select a database
        mysql_select_db($database, $conn) or die('Error in selecting the database: ' . mysql_error());

        
		$select = "Select * from eatangcp_eat_erp.dist_map"; 
		$result=mysql_query($select,$conn);
		$mlabel;
		while($data = mysql_fetch_array($result))
		{
			$mlabel="['".$data[dist_name]."', '".$data[addr_dist]."', 'Location 1 URL'],";
		}
		$mlabel="[".$mlabel."]";
		echo $mlabel;
		
        ?>
