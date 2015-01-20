#!/bin/bash

DATE=$(date +"%Y-%m-%d %T")
STATUS=`ls /var/run/opensips/opensips.pid |wc -l |tr -d '\n'`

if [ "$STATUS" == "1" ];then
	CHECKPS=`cat /usr/local/sbin/teleponrakyat/run-status-sync |tr -d '\n'`
	if [ "$CHECKPS" == "1" ]; then
		echo "[ERROR] [$DATE] INFO:CANNNOT SYNC, DAEMON STILL RUNNING" >> /var/log/opensips/sync.log
		STATEFILE=`find /usr/local/sbin/teleponrakyat/run-status-sync -mmin -2|tr -d '\n'`
		if [ -z "$STATEFILE" ]; then
			echo 0 > /usr/local/sbin/teleponrakyat/run-status-sync
		fi
	else
		echo 1 > /usr/local/sbin/teleponrakyat/run-status-sync
		/usr/bin/php /usr/local/sbin/teleponrakyat/sync_user.php >/dev/null 2>&1
		sleep 3
		/usr/bin/php /usr/local/sbin/teleponrakyat/sync_domain.php >/dev/null 2>&1
		sleep 3
		/usr/bin/php /usr/local/sbin/teleponrakyat/sync_gateway.php >/dev/null 2>&1
		sleep 5
		/usr/bin/php /usr/local/sbin/teleponrakyat/online_phones.php >/dev/null 2>&1
		sleep 2
		echo 0 > /usr/local/sbin/teleponrakyat/run-status-sync
	fi
else
	echo "[ERROR] [$DATE] INFO:CANNNOT SYNC, OPENSIPS NOT RUNNING" >> /var/log/opensips/sync.log
fi

exit 0
