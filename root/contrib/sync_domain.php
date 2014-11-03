<?php
require 'config.php';

$conn = mysql_connect($db_host,$db_user,$db_password);
if(!$conn){
    die('Could not connect: ' . mysql_error());
}

$r = mysql_query('SELECT domain from voip_id.domains');
if(mysql_num_rows($r) == 0){
	$domain1 = NULL;
}else{
	while($row = mysql_fetch_row($r)){
		foreach($row as $key => $value){
		$domain1[] = $value;
		}
	}
}

$r = mysql_query('SELECT domain from opensips.domain');
if(mysql_num_rows($r) == 0){
	$domain2 = NULL;
}else{
	while($row = mysql_fetch_row($r)){
		foreach($row as $key => $value){
			$domain2[] = $value;
		}
	}
}

if(!empty($domain1)){
	if(!empty($domain2)){
		$diff1 = array_diff($domain1, $domain2);
		foreach($diff1 as $key => $value){
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
	if(!empty($domain1)){
		$diff2 = array_diff($domain2, $domain1);
		foreach($diff2 as $key => $value){
			$cmd = "/usr/sbin/opensipsctl domain rm $value";
			exec($cmd);
		}
	}else{
		foreach($domain2 as $key => $value)
			$cmd = "/usr/sbin/opensipsctl domain rm $value";
			exec($cmd);
	}
}

exec('/usr/sbin/opensipsctl domain reload');
mysql_close($conn);

?>