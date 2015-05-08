#!/bin/bash

DATE=$(date +"%Y-%m-%d %T")
STATUS=`ls /var/run/opensips/opensips.pid |wc -l |tr -d '\n'`

if [ "$STATUS" == "1" ];then
	CHECKPS=`cat /usr/local/sbin/voip-id/run-status-cleaner |tr -d '\n'`
	if [ "$CHECKPS" == "1" ]; then
		echo "[ERROR] [$DATE] INFO:CANNNOT CLEAN, DAEMON STILL RUNNING" >> /var/log/opensips/cleaner.log
	else
		echo 1 > /usr/local/sbin/voip-id/run-status-cleaner
		/usr/bin/php /usr/local/sbin/voip-id/cleaner_user.php >/dev/null 2>&1
		sleep 3
		/usr/bin/php /usr/local/sbin/voip-id/cleaner_domain.php >/dev/null 2>&1
		sleep 2
		echo 0 > /usr/local/sbin/voip-id/run-status-cleaner
	fi
else
	echo "[ERROR] [$DATE] INFO:CANNNOT CLEAN, OPENSIPS NOT RUNNING" >> /var/log/opensips/cleaner.log
fi

exit 0
