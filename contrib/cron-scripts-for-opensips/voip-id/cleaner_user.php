<?php
require 'config.php';

$conn = mysql_connect($db_host,$db_user,$db_password);
if(!$conn){
        die('Could not connect: ' . mysql_error()."\n");
}

mysql_select_db($db_name2,$conn);
	$r = mysql_query("SELECT username,domain FROM subscriber");
	if(mysql_num_rows($r) == 0){
		$ext2 = NULL;
	}else{
		while($row = mysql_fetch_array($r)){
			$ext2[] =  $row['username'].'@'.$row['domain'];
		}
	}

mysql_select_db($db_name1,$conn);
	$r = mysql_query("SELECT phone_numbers.extension,domains.sip_server FROM phone_numbers ".
		"LEFT JOIN users ON phone_numbers.user_id=users.profile_id LEFT JOIN domains ON domains.id=users.domain_id ".
		"WHERE phone_numbers.deleted_at IS NULL AND users.deleted_at IS NULL AND domains.deleted_at IS NULL");
	if(mysql_num_rows($r) == 0){
		$ext1 = NULL;
	}else{
		while($row = mysql_fetch_array($r)){
			$ext1[] = $row['extension'].'@'.$row['sip_server'];
		}
	}

if(!empty($ext2)){
	$diff = array_diff($ext2, $ext1);
	foreach($diff as $key => $value){
		$cmd = "/usr/local/sbin/opensipsctl rm $value";
		exec($cmd);
	}
}
