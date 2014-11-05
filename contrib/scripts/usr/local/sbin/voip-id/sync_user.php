<?php
require 'config.php';

$conn = mysql_connect($db_host,$db_user,$db_password);
if(!$conn){
        die('Could not connect: ' . mysql_error());
}

mysql_select_db($db_name_voip,$conn);
$r = mysql_query("SELECT settings.value,domains.prefix,phone_numbers.extension,domains.domain FROM ".
"phone_numbers,users,domains,settings WHERE users.profile_id=phone_numbers.user_id AND users.domain_id=domains.id AND ".
"settings.name='global_prefix' AND settings.deleted_at IS NULL AND domains.deleted_at IS NULL AND phone_numbers.deleted_at IS NULL AND ".
"users.deleted_at IS NULL");
if(mysql_num_rows($r) == 0){
	$v_users1 = NULL;
}else{
	while($row = mysql_fetch_array($r)){
		$v_users1[] = $row['value'].$row['prefix'].$row['extension'].'@'.$row['domain'];
	}
}

mysql_select_db($db_name_voip,$conn);
$r = mysql_query("SELECT settings.value,domains.prefix,phone_numbers.extension,domains.domain FROM ".
"phone_numbers,users,domains,settings WHERE users.profile_id=phone_numbers.user_id AND users.domain_id=domains.id AND ".
"settings.name='global_prefix' AND phone_numbers.deleted_at IS NOT NULL");
if(mysql_num_rows($r) == 0){
	$vd_users1 = NULL;
}else{
	while($row = mysql_fetch_array($r)){
		$vd_users1[] = $row['value'].$row['prefix'].$row['extension'].'@'.$row['domain'];
	}
}

mysql_select_db($db_name_opensip,$conn);
$r = mysql_query("SELECT username,domain FROM subscriber");
if(mysql_num_rows($r) == 0){
	$o_users1 = NULL;
}else{
	while($row = mysql_fetch_array($r)){
		$o_users1[] =  $row['username'].'@'.$row['domain'];
	}
}

// ADD
if(!empty($v_users1)){
	if(!empty($o_users1)){
		$diff = array_diff($v_users1, $o_users1);
		foreach($diff as $key => $value){
			$value1 = explode("@", $value);
			mysql_select_db($db_name_voip,$conn);
			$r = mysql_query("SELECT sip_password FROM (SELECT CONCAT(settings.value,domains.prefix,phone_numbers.extension) ".
			"AS ext, phone_numbers.sip_password,domains.domain FROM phone_numbers,users,domains,settings ".
			" WHERE users.profile_id=phone_numbers.user_id AND users.domain_id=domains.id AND settings.name='global_prefix' ".
			"AND settings.deleted_at IS NULL AND domains.deleted_at IS NULL AND phone_numbers.deleted_at IS NULL ".
			"AND users.deleted_at IS NULL) AS ext WHERE ext='$value1[0]' AND domain='$value1[1]'");
			while($row = mysql_fetch_array($r)){
				$password = $row['sip_password'];
			}
			$cmd = "/usr/sbin/opensipsctl add $value $password";
			exec($cmd);
		}
	}else{
		foreach($v_users1 as $key => $value){
			$value1 = explode("@", $value);
			mysql_select_db($db_name_voip,$conn);
			$r = mysql_query("SELECT sip_password FROM (SELECT CONCAT(settings.value,domains.prefix,phone_numbers.extension) ".
			"AS ext, phone_numbers.sip_password,domains.domain FROM phone_numbers,users,domains,settings ".
			" WHERE users.profile_id=phone_numbers.user_id AND users.domain_id=domains.id AND settings.name='global_prefix' ".
			"AND settings.deleted_at IS NULL AND domains.deleted_at IS NULL AND phone_numbers.deleted_at IS NULL ".
			"AND users.deleted_at IS NULL) AS ext WHERE ext='$value1[0]' AND domain='$value1[1]'");
			while($row = mysql_fetch_array($r)){
				$password = $row['sip_password'];
			}
			$cmd = "/usr/sbin/opensipsctl add $value $password";
			exec($cmd);
		}
	}
}

//Delete
if(!empty($vd_users1)){
	if(!empty($o_users1)){
		$intersect = array_intersect($vd_users1, $o_users1);
		foreach($intersect as $key => $value){
			$cmd = "/usr/sbin/opensipsctl rm $value";
			exec($cmd);
		}
	}
}

mysql_close($conn);

?>
