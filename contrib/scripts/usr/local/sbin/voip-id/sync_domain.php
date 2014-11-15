<?php
require 'config.php';

$conn = mysql_connect($db_host,$db_user,$db_password);
if(!$conn){
        die('Could not connect: ' . mysql_error());
}

mysql_select_db($db_name1,$conn);
$r = mysql_query("SELECT id,event_name from logs WHERE event_name='domain_add' OR event_name='domain_remove'".
"AND flag IS NULL ORDER BY created_at ASC");
if(mysql_num_rows($r) == 0){
	$data1 = NULL;
}else{
	while($row = mysql_fetch_array($r)){
		$data1[$row['id']] = $row['event_name'];
	}
}

foreach ($data1 as $k1 => $v1) {
	mysql_select_db($db_name1,$conn);
	$r = mysql_query("SELECT custom_parameter from logs WHERE id='$k1' AND event_name='$v1'".
	"AND flag IS NULL ORDER BY created_at ASC");
	if(mysql_num_rows($r) == 0){
		$data2 = NULL;
	}else{
		while($row = mysql_fetch_array($r)){
			$data2 = json_decode($row['custom_parameter'],true);
			unset($data2['id']);
			foreach($data2 as $k2 => $v2){
				$domain1 = $v2;
			}
			
		}
	}
	
	mysql_select_db($db_name2,$conn);
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
	if(!empty($domain1)){
		$arr=array($k1,$v1,$domain1);
		$id = $arr[0];
		if($arr[1]=='domain_remove'){
			$event = 'rm';
		}else{
			$event = 'add';
		}
		$domain1 = $arr[2];
		
		if($event=='rm'){
			if(!empty($domain2)){
				if(in_array($domain1, $domain2)){
					$cmd = "/usr/sbin/opensipsctl domain rm $domain1";
					exec($cmd);
					mysql_select_db($db_name1,$conn);
					$retval = mysql_query("UPDATE logs SET flag='1' WHERE id='$id'");
					if(!$retval){
		  				die('Could not update data: ' . mysql_error());
					}
					printf("Records update: %d\n", mysql_affected_rows());
				}else{
					mysql_select_db($db_name1,$conn);
					$retval = mysql_query("UPDATE logs SET flag='1' WHERE id='$id'");
					if(!$retval){
		  				die('Could not update data: ' . mysql_error());
					}
					printf("Records update: %d\n", mysql_affected_rows());
				}
			}else{
				mysql_select_db($db_name1,$conn);
				$retval = mysql_query("UPDATE logs SET flag='1' WHERE id='$id'");
				if(!$retval){
		  			die('Could not update data: ' . mysql_error());
				}
				printf("Records update: %d\n", mysql_affected_rows());
			}
		}else{
			if(!empty($domain2)){
				if(in_array($domain1, $domain2)) {
					echo $domain1.' Found on db opensipsctl, Cannot add';
					mysql_select_db($db_name1,$conn);
					$retval = mysql_query("UPDATE logs SET flag='1' WHERE id='$id'");
					if(!$retval){
	  					die('Could not update data: ' . mysql_error());
					}
					printf("Records update: %d\n", mysql_affected_rows());
				}else{
					$cmd = "/usr/sbin/opensipsctl domain add $domain1";
					exec($cmd);
					mysql_select_db($db_name1,$conn);
					$retval = mysql_query("UPDATE logs SET flag='1' WHERE id='$id'");
					if(!$retval){
	  					die('Could not update data: ' . mysql_error());
					}
					printf("Records update: %d\n", mysql_affected_rows());
				}
			}else{
				$cmd = "/usr/sbin/opensipsctl domain add $domain1";
				exec($cmd);
				mysql_select_db($db_name1,$conn);
				$retval = mysql_query("UPDATE logs SET flag='1' WHERE id='$id'");
				if(!$retval){
	  				die('Could not update data: ' . mysql_error());
				}
				printf("Records update: %d\n", mysql_affected_rows());
			}	
		}
		$cmd = "/usr/sbin/opensipsctl domain reload";
		exec($cmd);
	}
}

mysql_close($conn);

?>