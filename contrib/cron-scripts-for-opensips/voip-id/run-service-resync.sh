#!/bin/bash

DATE=$(date +"%Y-%m-%d %T")
STATUS=`ls /var/run/opensips/opensips.pid |wc -l |tr -d '\n'`

if [ "$STATUS" == "1" ];then
	CHECKPS=`cat /usr/local/sbin/teleponrakyat/run-status-resync |tr -d '\n'`
	if [ "$CHECKPS" == "1" ]; then
		echo "[ERROR] [$DATE] INFO:CANNNOT RESYNC, SERVICE STILL RUNNING" >>/var/log/opensips/resync.log
		STATEFILE=`find /usr/local/sbin/teleponrakyat/run-status-resync -mmin -2|tr -d '\n'`
		if [ -z "$STATEFILE" ]; then
			echo 0 > /usr/local/sbin/teleponrakyat/run-status-resync
		fi
		
	else
		echo 1 > /usr/local/sbin/teleponrakyat/run-status-resync
		/usr/bin/php /usr/local/sbin/teleponrakyat/resync_domain.php >>/var/log/opensips/resync.log 2>&1
		sleep 2
		/usr/bin/php /usr/local/sbin/teleponrakyat/resync_user.php >>/var/log/opensips/resync.log 2>&1
		sleep 2
		echo 0 > /usr/local/sbin/teleponrakyat/run-status-resync
	fi
else
	echo "[ERROR] [$DATE] INFO:CANNNOT RESYNC, OPENSIPS NOT RUNNING" >>/var/log/opensips/resync.log
fi

exit 0
