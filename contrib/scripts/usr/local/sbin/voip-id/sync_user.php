<?php
require 'config.php';

$conn = mysql_connect($db_host,$db_user,$db_password);
if(!$conn){
        die('Could not connect: ' . mysql_error());
}

mysql_select_db($db_name1,$conn);
$r = mysql_query("SELECT id,event_name from logs WHERE event_name='phone_number_add' OR event_name='phone_number_remove' OR event_name='phone_number_sip_password_update' AND flag IS NULL ORDER BY created_at ASC");
if(mysql_num_rows($r) == 0 ){
	$data1 = NULL;
}else{
	while($row = mysql_fetch_array($r)){
		$data1[$row['id']] = $row['event_name'];
	}
}

foreach($data1 as $k1 => $v1){
	mysql_select_db($db_name1,$conn);
	$r = mysql_query("SELECT custom_parameter from logs WHERE id='$k1' AND event_name='$v1'".
	"AND flag IS NULL ORDER BY created_at ASC");
	if(mysql_num_rows($r) == 0){
		$data2 = NULL;
	}else{
		while($row = mysql_fetch_array($r)){
			$data2 = json_decode($row['custom_parameter'],true);
		}
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

	if(!empty($data2)){
		$arr=array($k1,$v1,$data2['id'],$data2['extension']);
		$id = $arr[0];
		if($arr[1]=='phone_number_remove'){
			$event = 'rm';
		}elseif ($arr[1]=='phone_number_add'){
			$event = 'add';
		}else{
			$event = 'edit';
		}
		$id_phone_numbers = $arr[2];
		$extension = $arr[3];

		mysql_select_db($db_name1,$conn);
		$r = mysql_query("SELECT domains.domain,phone_numbers.sip_password FROM domains LEFT JOIN users ON domains.id=users.domain_id LEFT JOIN phone_numbers ON users.profile_id=phone_numbers.user_id WHERE phone_numbers.id='$id_phone_numbers' AND phone_numbers.extension='$extension'");
		if(mysql_num_rows($r) == 0){
			$domain = NULL;
		}else{
			while($row = mysql_fetch_array($r)){
				$domain = $row['domain'];
				$sip_password = $row['sip_password'];
			}
		}
		
		if($event=='rm'){
			if(!empty($ext2)){
				if(in_array($extension.'@'.$domain, $ext2)){
					$cmd = "/usr/sbin/opensipsctl rm $extension@$domain";
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
		}elseif($event=='add'){
			if(!empty($ext2)){
				if(in_array($extension.'@'.$domain, $domain2)) {
					echo $extension.'@'.$domain.' Found on db opensipsctl, Cannot add';
					mysql_select_db($db_name1,$conn);
					$retval = mysql_query("UPDATE logs SET flag='1' WHERE id='$id'");
					if(!$retval){
	  					die('Could not update data: ' . mysql_error());
					}
					printf("Records update: %d\n", mysql_affected_rows());
				}else{
					$cmd = "/usr/sbin/opensipsctl add $extension@$domain $sip_password";
					exec($cmd);
					mysql_select_db($db_name1,$conn);
					$retval = mysql_query("UPDATE logs SET flag='1' WHERE id='$id'");
					if(!$retval){
	  					die('Could not update data: ' . mysql_error());
					}
					printf("Records update: %d\n", mysql_affected_rows());
				}
			}else{
				$cmd = "/usr/sbin/opensipsctl add $extension@$domain $sip_password";
				exec($cmd);
				mysql_select_db($db_name1,$conn);
				$retval = mysql_query("UPDATE logs SET flag='1' WHERE id='$id'");
				if(!$retval){
	  				die('Could not update data: ' . mysql_error());
				}
				printf("Records update: %d\n", mysql_affected_rows());
			}	
		}else{
			if(!empty($ext2)){
				if(in_array($extension.'@'.$domain, $ext2)){
					$cmd = "/usr/sbin/opensipsctl passwd $extension@$domain $sip_password";
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
		}
	}
}

mysql_close($conn);
?>