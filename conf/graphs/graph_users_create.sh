#!/bin/bash

PHPRADMIN_DIR=/usr/local/phpradmin

MYSQL_CLIENT_BIN=`grep MYSQL_CLIENT_BIN= $PHPRADMIN_DIR/conf/phpradmintool.sh |awk -F"=" '{ print $2 }'`

# General options to query database
DB_HOST=`grep \'host\' $PHPRADMIN_DIR/www/phpradmin.conf.php | awk -F\" '{ print $2 }'`
DB_USER=`grep \'user\' $PHPRADMIN_DIR/www/phpradmin.conf.php | awk -F\" '{ print $2 }'`
DB_PASSWORD=`grep \'password\' $PHPRADMIN_DIR/www/phpradmin.conf.php | awk -F\" '{ print $2 }'`
DB_NAME=`grep \'db\' $PHPRADMIN_DIR/www/phpradmin.conf.php | awk -F\" '{ print $2 }' `

##PHPRADMIN_DIR=`$MYSQL_CLIENT_BIN -h $DB_HOST -u $DB_USER -p$DB_PASSWORD -D $DB_NAME -e "SELECT phpradmin_pwd FROM general_opt"|tail -1`
RRDTOOL_BIN=`$MYSQL_CLIENT_BIN -h $DB_HOST -u $DB_USER -p$DB_PASSWORD -D $DB_NAME -e "SELECT rrd_pwd FROM general_opt"|tail -1`

cd $PHPRADMIN_DIR/www/rrd/

$RRDTOOL_BIN create users.rrd  --start `date +"%s"` \
--step 300  \
DS:usersin:GAUGE:600:0:5000 \
DS:usersout:GAUGE:600:0:5000 \
RRA:AVERAGE:0.5:1:600 \
RRA:AVERAGE:0.5:6:700 \
RRA:MAX:0.5:1:600 \
RRA:MAX:0.5:6:700 \
