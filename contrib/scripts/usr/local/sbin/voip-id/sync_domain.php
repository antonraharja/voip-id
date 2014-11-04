<?php
require 'config.php';

$conn = mysql_connect($db_host,$db_user,$db_password);
if(!$conn){
    die('Could not connect: ' . mysql_error());
}

mysql_select_db($db_name_voip,$conn);
$r = mysql_query('SELECT domain from domains WHERE deleted_at IS NULL');
if(mysql_num_rows($r) == 0){
	$domain1 = NULL;
}else{
	while($row = mysql_fetch_row($r)){
		foreach($row as $key => $value){
		$domain1[] = $value;
		}
	}
}

mysql_select_db($db_name_opensip,$conn);
$r = mysql_query('SELECT domain from domain');
if(mysql_num_rows($r) == 0){
	$domain2 = NULL;
}else{
	while($row = mysql_fetch_row($r)){
		foreach($row as $key => $value){
			$domain2[] = $value;
		}
	}
}

mysql_select_db($db_name_voip,$conn);
$r = mysql_query('SELECT domain from domains WHERE deleted_at IS NOT NULL');
if(mysql_num_rows($r) == 0){
	$domain3 = NULL;
}else{
	while($row = mysql_fetch_row($r)){
		foreach($row as $key => $value){
		$domain3[] = $value;
		}
	}
}

if(!empty($domain1)){
	if(!empty($domain2)){
		$diff = array_diff($domain1, $domain2);
		foreach($diff as $key => $value){
			$cmd = "/usr/sbin/opensipsctl domain add $value";
			exec($cmd);
		}
	}else{
		foreach($domain1 as $key => $value){
			$cmd = "/usr/sbin/opensipsctl domain add $value";
			exec($cmd);
		}
	}
}

if(!empty($domain2)){
	if(!empty($domain3)){
		$intersect = array_intersect($domain3, $domain2);
		foreach($intersect as $key => $value){
			$cmd = "/usr/sbin/opensipsctl domain rm $value";
			exec($cmd);
		}
	}
}

mysql_close($conn);

exec('/usr/sbin/opensipsctl domain reload');

?>