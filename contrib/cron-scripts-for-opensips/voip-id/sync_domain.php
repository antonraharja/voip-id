<?php
require 'config.php';

$conn = mysql_connect($db_host,$db_user,$db_password);
if(!$conn){
        die('[ERROR] ['.date("Y-m-d H:i:s").'] Could not connect: ' . mysql_error()."\n");
}

mysql_select_db($db_name1,$conn);
$r = mysql_query("SELECT id,event_name from logs WHERE flag is NULL AND event_name IN ('domain_add','domain_remove')"."ORDER BY created_at ASC");
if(mysql_num_rows($r) == 0){
	$data1 = array();
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
			unset($data2['domain_name']);
			foreach($data2 as $k2 => $v2){
				$r = mysql_query("SELECT settings.value,domains.prefix,domains.sip_server from settings,domains ".
					"LEFT JOIN users ON domains.id=users.domain_id LEFT JOIN phone_numbers ON ".
					"users.profile_id=phone_numbers.user_id WHERE settings.name='global_prefix' AND domains.id='$v2' LIMIT 1");
				if(mysql_num_rows($r) == 0){
					$domain1 = NULL;
				}else{
					while($row = mysql_fetch_array($r)){
						$domain1 = $row['sip_server'];
						$prefix2domain = $row['value'].$row['prefix'];
					}
				}
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
					$cmd1 = "/usr/local/sbin/opensipsctl domain rm $domain1";
					exec($cmd1);
					$cmd2 = "/usr/local/sbin/opensipsctl fifo pdt_delete '*' $domain1";
					exec($cmd2);
					mysql_select_db($db_name1,$conn);
					$retval = mysql_query("UPDATE logs SET flag='1' WHERE id='$id'");
					if(!$retval){
		  				die('[ERROR] [date("Y-m-d H:i:s")] Could not update data: ' . mysql_error()."\n");
					}
					print('[INFO] ['.date("Y-m-d H:i:s").'] SUCCESSFULLY REMOVE DOMAIN '.$domain1."\n");
				}else{
					mysql_select_db($db_name1,$conn);
					$retval = mysql_query("UPDATE logs SET flag='1' WHERE id='$id'");
					if(!$retval){
		  				die('[ERROR] [date("Y-m-d H:i:s")] Could not update data: ' . mysql_error()."\n");
					}
					print('[INFO] ['.date("Y-m-d H:i:s").'] CANNOT REMOVE '.$domain1." DOMAIN NOT FOUND\n");
				}
			}else{
				mysql_select_db($db_name1,$conn);
				$retval = mysql_query("UPDATE logs SET flag='1' WHERE id='$id'");
				if(!$retval){
					die('[ERROR] [date("Y-m-d H:i:s")] Could not update data: ' . mysql_error()."\n");
				}
				print('[INFO] ['.date("Y-m-d H:i:s").'] CANNOT REMOVE '.$domain1." DOMAIN NOT FOUND\n");
			}
		}else{
			if(!empty($domain2)){
				if(in_array($domain1, $domain2)) {
					echo $domain1.' Found on db opensipsctl, Cannot add';
					mysql_select_db($db_name1,$conn);
					$retval = mysql_query("UPDATE logs SET flag='1' WHERE id='$id'");
					if(!$retval){
	  					die('[ERROR] [date("Y-m-d H:i:s")] Could not update data: ' . mysql_error()."\n");
					}
					print('[INFO] ['.date("Y-m-d H:i:s").'] CANNOT ADD '.$domain1." DOMAIN EXISTS\n");
				}else{
					$cmd1 = "/usr/local/sbin/opensipsctl domain add $domain1";
					exec($cmd1);
					$cmd2 = "/usr/local/sbin/opensipsctl fifo pdt_add '*' $prefix2domain $domain1";
					exec($cmd2);
					mysql_select_db($db_name1,$conn);
					$retval = mysql_query("UPDATE logs SET flag='1' WHERE id='$id'");
					if(!$retval){
	  					die('[ERROR] [date("Y-m-d H:i:s")] Could not update data: ' . mysql_error()."\n");
					}
					print('[INFO] ['.date("Y-m-d H:i:s").'] SUCCESSFULLY ADD DOMAIN '.$domain1."\n");
				}
			}else{
				$cmd1 = "/usr/local/sbin/opensipsctl domain add $domain1";
				exec($cmd1);
				$cmd2 = "/usr/local/sbin/opensipsctl fifo pdt_add '*' $prefix2domain $domain1";
				exec($cmd2);
				mysql_select_db($db_name1,$conn);
				$retval = mysql_query("UPDATE logs SET flag='1' WHERE id='$id'");
				if(!$retval){
	  				die('[ERROR] [date("Y-m-d H:i:s")] Could not update data: ' . mysql_error()."\n");
				}
				print('[INFO] ['.date("Y-m-d H:i:s").'] SUCCESSFULLY ADD DOMAIN '.$domain1."\n");
			}	
		}
		$cmd1 = "/usr/local/sbin/opensipsctl domain reload";
		exec($cmd1);
		$cmd2 = "/usr/local/sbin/opensipsctl fifo pdt_reload";
		exec($cmd2);
	}
}

mysql_close($conn);
