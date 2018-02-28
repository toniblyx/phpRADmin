#!/bin/bash

PHPRADMIN_DIR=/usr/local/phpradmin

MYSQL_CLIENT_BIN=`grep MYSQL_CLIENT_BIN= $PHPRADMIN_DIR/conf/phpradmintool.sh |awk -F"=" '{ print $2 }'`

# General options to query database
DB_HOST=`grep \'host\' $PHPRADMIN_DIR/www/phpradmin.conf.php | awk -F\" '{ print $2 }'`
DB_USER=`grep \'user\' $PHPRADMIN_DIR/www/phpradmin.conf.php | awk -F\" '{ print $2 }'`
DB_PASSWORD=`grep \'password\' $PHPRADMIN_DIR/www/phpradmin.conf.php | awk -F\" '{ print $2 }'`
DB_NAME=`grep \'db\' $PHPRADMIN_DIR/www/phpradmin.conf.php | awk -F\" '{ print $2 }' `


PHPRADMIN_DIR=`$MYSQL_CLIENT_BIN -h $DB_HOST -u $DB_USER -p$DB_PASSWORD -D $DB_NAME -e "SELECT phpradmin_pwd FROM general_opt"|tail -1`

$PHPRADMIN_DIR/conf/graphs/graph_users_update.sh > /dev/null
$PHPRADMIN_DIR/conf/graphs/graph_clients_update.sh > /dev/null
$PHPRADMIN_DIR/conf/graphs/graph_db_update.sh > /dev/null
