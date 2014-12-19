<?php
require 'config.php';

$conn = mysql_connect($db_host,$db_user,$db_password);
if(!$conn){
        die('Could not connect: ' . mysql_error());
}

mysql_select_db($db_name1,$conn);
mysql_query('TRUNCATE TABLE online_phones;');

$output = trim(shell_exec("/usr/sbin/opensipsctl online"));
$output = preg_split("/[\s,]+/", $output);

foreach($output as $key => $value){
	$value = explode('@',$value);
	$username = $value['0'];
	$domain = $value['1'];
	$currentdate = date("Y-m-d H:i:s");

	mysql_select_db($db_name1,$conn);
	$r = "INSERT INTO online_phones ".
		"(username, domain, created_at) ".
		"VALUES ('$username', '$domain' ,'$currentdate')";
	$q = mysql_query($r);
	if(!$q){
		die('Could not insert data: ' . mysql_error());
	}
	echo "Insert data successfully\n";
}

mysql_close($conn);

?>