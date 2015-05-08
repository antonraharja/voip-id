<?php
require 'config.php';

$conn = mysql_connect($db_host,$db_user,$db_password);
if(!$conn){
        die('[ERROR] ['.date("Y-m-d H:i:s").'] Could not connect: ' . mysql_error()."\n");
}

mysql_select_db($db_name1,$conn);
mysql_query('TRUNCATE TABLE online_phones;');

$output = trim(shell_exec("/usr/sbin/opensipsctl online"));
if(!empty($output)){
	$output = preg_split("/[\s,]+/", $output);

	foreach($output as $key => $value){
		$value = explode('@',$value);
		$username = $value['0'];
		$sip_server = $value['1'];
		$currentdate = date("Y-m-d H:i:s");
	
		mysql_select_db($db_name1,$conn);
		$r = "INSERT INTO online_phones ".
			"(username, sip_server, created_at) ".
			"VALUES ('$username', '$sip_server' ,'$currentdate')";
		$q = mysql_query($r);
		if(!$q){
			die('[ERROR] ['.date("Y-m-d H:i:s").'] Could not insert data: ' . mysql_error()."\n");
		}
		//echo "Insert data successfully\n";
	}
}

mysql_close($conn);
