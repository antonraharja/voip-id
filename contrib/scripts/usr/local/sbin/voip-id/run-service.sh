#!/bin/bash

DATE=$(date +"%Y-%m-%d %T")
STATUS=`ls /var/run/opensips/opensips.pid |wc -l |tr -d 't\n\r'`

if [ "$STATUS" == "1" ];then
	CHECKPS=`cat /usr/local/sbin/voip-id/run-status |tr -d 't\n\r'`
	if [ "$CHECKPS" == "1" ]; then
		echo "[ERROR] [$DATE] INFO:CANNNOT SYNC, DAEMON STILL RUNNING" >> /var/log/opensips/sync.log
	else
		echo 1 > /usr/local/sbin/voip-id/run-status
		/usr/bin/php /usr/local/sbin/voip-id/sync_domain.php >/dev/null 2>&1
		sleep 2
		/usr/bin/php /usr/local/sbin/voip-id/sync_user.php >/dev/null 2>&1
		sleep 2
		echo 0 > /usr/local/sbin/voip-id/run-status
	fi
else
	echo "[ERROR] [$DATE] INFO:CANNNOT SYNC, OPENSIPS NOT RUNNING" >> /var/log/opensips/sync.log
fi

exit 0
