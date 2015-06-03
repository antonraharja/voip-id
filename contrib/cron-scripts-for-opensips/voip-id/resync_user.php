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

$result = array_diff($ext1, $ext2);

foreach($result as  $value){
	$value = explode("@",$value);
	$e = $value[0];
	$d = $value[1];
	mysql_select_db($db_name1,$conn);
	$r = mysql_query("SELECT phone_numbers.extension,domains.sip_server,phone_numbers.sip_password FROM phone_numbers ".
		"LEFT JOIN users ON phone_numbers.user_id=users.profile_id LEFT JOIN domains ON domains.id=users.domain_id ".
		"WHERE phone_numbers.deleted_at IS NULL AND users.deleted_at IS NULL AND domains.deleted_at IS NULL ".
		"AND phone_numbers.extension='$value[0]' AND domains.sip_server='$value[1]'");
		if(mysql_num_rows($r) == 0){
		$ext = NULL;
	}else{
		while ($row = mysql_fetch_array($r)){
			$user = $row['extension'].'@'.$row['sip_server'].' '.$row['sip_password'];
			$cmd = "/usr/sbin/opensipsctl add $user";
			exec($cmd);
			print('[INFO] ['.date("Y-m-d H:i:s").'] SUCCESSFULLY RESYNC FOR '.$row['extension'].'@'.$row['sip_server']."\n");
		}
	}

}

?>