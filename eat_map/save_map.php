	
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

        // Grab user input and sanitize 
        $dist_name = mysql_real_escape_string(filter_var(trim($_POST['dist_name']), FILTER_SANITIZE_STRING));
        $addr_dist = mysql_real_escape_string(filter_var(trim($_POST['addr_dist']), FILTER_SANITIZE_STRING));
        
		$insert = "INSERT INTO eatangcp_eat_erp.dist_map (dist_name, addr_dist, created_date) VALUES ('" . $dist_name . "', '" . $addr_dist . "', now())"; 
		mysql_query($insert);
		//{
		//echo "http://www.mydietist.com/dataFrom.htm?user_id=$id1&sub_id=$subid";
		echo '<script language="javascript">';
		echo 'window.open("map_input.php","_self","true");';
		echo '</script>';
		//}
	
		
		
		
        ?>
