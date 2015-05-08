<?php
require 'config.php';

$conn = mysql_connect($db_host,$db_user,$db_password);
if(!$conn){
        die('Could not connect: ' . mysql_error()."/n");
}

mysql_select_db($db_name2,$conn);
	$r = mysql_query('SELECT domain from domain');
		if(mysql_num_rows($r) == 0){
			$domain2 = NULL;
	}else{
		while($row = mysql_fetch_row($r)){
			foreach ($row as $key => $value) {
			$domain2[] = $value;
			}
		}
	}

mysql_select_db($db_name1,$conn);
	$r = mysql_query('SELECT sip_server from domains WHERE deleted_at IS NULL');
		if(mysql_num_rows($r) == 0){
			$domain1 = NULL;
		}else{
			while($row = mysql_fetch_row($r)){
				foreach ($row as $key => $value) {
					$domain1[] = $value;
				}
			}
		}


if(!empty($domain2)){
	$diff = array_diff($domain2, $domain1);
	foreach($diff as $key => $value){
		$cmd = "/usr/sbin/opensipsctl domain rm $value";
		exec($cmd);
	}
}

$cmd = "/usr/sbin/opensipsctl domain reload";
exec($cmd);

mysql_close($conn);
