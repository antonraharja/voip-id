#!/bin/sh

HOSTNAME="localhost"
USER="root"
PASS="password"
DATABASE="opensips"

mysql -h $HOSTNAME -u $USER -p$PASS -e "call opensips_cdrs(); " $DATABASE
