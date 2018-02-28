#!/bin/sh

## Script to make some security tasks

## Modify PHPRADIMIN_DIR and MYSQL_CLIENT_BIN as you need
PHPRADIMIN_DIR=/usr/local/phpradmin
MYSQL_CLIENT_BIN=/usr/bin/mysql

# General options to query database
DB_HOST=`grep \'host\' $PHPRADIMIN_DIR/www/phpradmin.conf.php | awk -F\" '{ print $2 }'`
DB_USER=`grep \'user\' $PHPRADIMIN_DIR/www/phpradmin.conf.php | awk -F\" '{ print $2 }'`
DB_PASSWORD=`grep \'password\' $PHPRADIMIN_DIR/www/phpradmin.conf.php | awk -F\" '{ print $2 }'`
DB_NAME=`grep \'db\' $PHPRADIMIN_DIR/www/phpradmin.conf.php | awk -F\" '{ print $2 }' `

PHPRADMIN_DIR=`$MYSQL_CLIENT_BIN -h $DB_HOST -u $DB_USER -p$DB_PASSWORD -D $DB_NAME -e "SELECT phpradmin_pwd FROM general_opt"|tail -1`


# RADIUS configuration files
#

PHPRADMIN_LANG_DIR=`$MYSQL_CLIENT_BIN -h $DB_HOST -u $DB_USER -p$DB_PASSWORD -D $DB_NAME -e "SELECT phpradmin_pwd FROM general_opt"|tail -1`www/lang

DIALUP_ADMIN_CONF_DIR=`$MYSQL_CLIENT_BIN -h $DB_HOST -u $DB_USER -p$DB_PASSWORD -D $DB_NAME -e "SELECT phpradmin_pwd FROM general_opt"|tail -1`conf/dialup_admin/conf

USER_EDIT_ATTRS=`$MYSQL_CLIENT_BIN -h $DB_HOST -u $DB_USER -p$DB_PASSWORD -D $DB_NAME -e "SELECT phpradmin_pwd FROM general_opt"|tail -1`conf/dialup_admin/conf/user_edit.attrs

RADIUS_LOG=`$MYSQL_CLIENT_BIN -h $DB_HOST -u $DB_USER -p$DB_PASSWORD -D $DB_NAME -e "SELECT radius_log_path FROM general_opt"|tail -1`

SYSTEM_LOG=`$MYSQL_CLIENT_BIN -h $DB_HOST -u $DB_USER -p$DB_PASSWORD -D $DB_NAME -e "SELECT system_log_path FROM general_opt"|tail -1`

RADIUSD_CONF_DIR=`$MYSQL_CLIENT_BIN -h $DB_HOST -u $DB_USER -p$DB_PASSWORD -D $DB_NAME -e "SELECT radius_pwd FROM general_opt"|tail -1`

RADIUSD_CONF=`$MYSQL_CLIENT_BIN -h $DB_HOST -u $DB_USER -p$DB_PASSWORD -D $DB_NAME -e "SELECT radius_pwd FROM general_opt"|tail -1`radiusd.conf

SQL_CONF=`$MYSQL_CLIENT_BIN -h $DB_HOST -u $DB_USER -p$DB_PASSWORD -D $DB_NAME -e "SELECT radius_pwd FROM general_opt"|tail -1`sql.conf

CLIENTS_CONF=`$MYSQL_CLIENT_BIN -h $DB_HOST -u $DB_USER -p$DB_PASSWORD -D $DB_NAME -e "SELECT radius_pwd FROM general_opt"|tail -1`clients.conf

NASPASSWD=`$MYSQL_CLIENT_BIN -h $DB_HOST -u $DB_USER -p$DB_PASSWORD -D $DB_NAME -e "SELECT radius_pwd FROM general_opt"|tail -1`naspasswd

DICTIONARY_DIR=`$MYSQL_CLIENT_BIN -h $DB_HOST -u $DB_USER -p$DB_PASSWORD -D $DB_NAME -e "SELECT dictionary_path FROM general_opt"|tail -1`

RADIUS_STARTUP_SCRIPT=`$MYSQL_CLIENT_BIN -h $DB_HOST -u $DB_USER -p$DB_PASSWORD -D $DB_NAME -e "SELECT startup_script FROM general_opt"|tail -1`

case "$1" in

        unlock)
                if test -f $PHPRADIMIN_DIR/www/locked ; then
			#chmod 777 $RADIUSD_CONF $CLIENTS_CONF $NASPASSWD $SQL_CONF $USER_EDIT_ATTRS
			chmod 777 $RADIUSD_CONF_DIR/*.conf $DIALUP_ADMIN_CONF_DIR/*.conf $NASPASSWD $USER_EDIT_ATTRS
			chmod -R 777 $DICTIONARY_DIR
			chmod -R 777 $PHPRADMIN_LANG_DIR
			rm $PHPRADIMIN_DIR/www/locked
                        echo "UNLOCK done!"
                else
                        echo "Alredy UNLOCKED"
                fi
                ;;
        lock)
                if test -f $PHPRADIMIN_DIR/www/locked ; then
                        echo "Alredy LOCKED"
                else
			#chmod 644 $RADIUSD_CONF $SQL_CONF $USER_EDIT_ATTRS
			chmod 644 $RADIUSD_CONF_DIR/*.conf $DIALUP_ADMIN_CONF_DIR/*.conf $USER_EDIT_ATTRS
			chmod 640 $NASPASSWD
                        chmod -R 644 $DICTIONARY_DIR
			chmod -R 755 $PHPRADMIN_LANG_DIR
                        touch $PHPRADIMIN_DIR/www/locked
                        echo "LOCK done!"
                fi
                ;;
        ask)
                if test -f  $PHPRADIMIN_DIR/www/locked ; then
                        echo "LOCKED"
                else
                        echo "UNLOCKED"
                fi
                ;;
	restart)
                if test -f  $PHPRADIMIN_DIR/www/locked ; then
                        $RADIUS_STARTUP_SCRIPT restart
                else
                        echo "Your system is not SECURE pleas LOCK IT"
                fi
                ;;
        systemlog)
                if test -f  $SYSTEM_LOG ; then
                        tail -30 $SYSTEM_LOG
                else
                        echo "Can not found $SYSTEM_LOG"
                fi
                ;;
        radiuslog)
                if test -f  $RADIUS_LOG ; then
                        tail -30 $RADIUS_LOG
                else
                        echo "Can not found $RADIUS_LOG"
                fi
                ;;

        *)
                echo "Usage: phpradmintool.sh {lock|unlock|ask|restart|systemlog|radiuslog}"
                exit 1
                ;;
esac  

# End of this script
