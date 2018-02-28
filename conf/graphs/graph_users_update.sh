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

USERS_TOTAL=`$MYSQL_CLIENT_BIN -u $DB_USER -p$DB_PASSWORD -D $DB_NAME -e "select count(*) from userinfo"|tail -1`
USERS_IN=2
USERS_OUT=`expr $USERS_TOTAL - $USERS_IN`
if [[ $USERS_IN == '' ]]  ; then USERS_IN=U ; fi
if [[ $USERS_OUT == '' ]]  ; then USERS_OUT=U ; fi

$RRDTOOL_BIN update users.rrd N:$USERS_IN:$USERS_OUT

$RRDTOOL_BIN graph users_hour.png \
--start=-3600 \
--end=-300 \
--title="User Connection stats - hour (5 min avg)" \
--base=1000 \
--height=130 \
--width=380 \
--alt-autoscale-max \
--lower-limit=0 \
--color=BACK#FFFFFF \
--color=CANVAS#DDDDDD \
--vertical-label="Number of users" \
DEF:usersin="users.rrd":usersin:AVERAGE \
DEF:usersout="users.rrd":usersout:AVERAGE \
"CDEF:suma1=usersin" \
"CDEF:suma2=usersout" \
"CDEF:total=suma1,suma2,+" \
AREA:total#000000:"Total in DB "  \
GPRINT:total:LAST:"Current\:%8.0lf %s"  \
GPRINT:total:AVERAGE:"Average\:%8.0lf %s"  \
GPRINT:total:MAX:"Maximum\:%8.0lf %s" \
LINE3:usersin#00FF00:"Users LogIN "  \
GPRINT:usersin:LAST:"Current\:%8.0lf %s"  \
GPRINT:usersin:AVERAGE:"Average\:%8.0lf %s"  \
GPRINT:usersin:MAX:"Maximum\:%8.0lf %s\n" \
LINE3:usersout#0000FF:"Users LogOUT"  \
GPRINT:usersout:LAST:"Current\:%8.0lf %s"  \
GPRINT:usersout:AVERAGE:"Average\:%8.0lf %s"  \
GPRINT:usersout:MAX:"Maximum\:%8.0lf %s\n" 



$RRDTOOL_BIN graph users_day.png \
--start=-86400 \
--end=-300 \
--title="User Connection stats - day (5 min avg)" \
--base=1000 \
--height=130 \
--width=380 \
--alt-autoscale-max \
--lower-limit=0 \
--color=BACK#FFFFFF \
--color=CANVAS#DDDDDD \
--vertical-label="Number of users" \
DEF:usersin="users.rrd":usersin:AVERAGE \
DEF:usersout="users.rrd":usersout:AVERAGE \
"CDEF:suma1=usersin" \
"CDEF:suma2=usersout" \
"CDEF:total=suma1,suma2,+" \
AREA:total#000000:"Total in DB "  \
GPRINT:total:LAST:"Current\:%8.0lf %s"  \
GPRINT:total:AVERAGE:"Average\:%8.0lf %s"  \
GPRINT:total:MAX:"Maximum\:%8.0lf %s" \
LINE3:usersin#00FF00:"Users LogIN "  \
GPRINT:usersin:LAST:"Current\:%8.0lf %s"  \
GPRINT:usersin:AVERAGE:"Average\:%8.0lf %s"  \
GPRINT:usersin:MAX:"Maximum\:%8.0lf %s\n" \
LINE3:usersout#0000FF:"Users LogOUT"  \
GPRINT:usersout:LAST:"Current\:%8.0lf %s"  \
GPRINT:usersout:AVERAGE:"Average\:%8.0lf %s"  \
GPRINT:usersout:MAX:"Maximum\:%8.0lf %s\n"

$RRDTOOL_BIN graph users_week.png \
--start=-604800 \
--end=-1800 \
--title="User Connection stats - week (30 min avg)" \
--base=1000 \
--height=130 \
--width=380 \
--alt-autoscale-max \
--lower-limit=0 \
--color=BACK#FFFFFF \
--color=CANVAS#DDDDDD \
--vertical-label="Number of users" \
DEF:usersin="users.rrd":usersin:AVERAGE \
DEF:usersout="users.rrd":usersout:AVERAGE \
"CDEF:suma1=usersin" \
"CDEF:suma2=usersout" \
"CDEF:total=suma1,suma2,+" \
AREA:total#000000:"Total in DB "  \
GPRINT:total:LAST:"Current\:%8.0lf %s"  \
GPRINT:total:AVERAGE:"Average\:%8.0lf %s"  \
GPRINT:total:MAX:"Maximum\:%8.0lf %s" \
LINE3:usersin#00FF00:"Users LogIN "  \
GPRINT:usersin:LAST:"Current\:%8.0lf %s"  \
GPRINT:usersin:AVERAGE:"Average\:%8.0lf %s"  \
GPRINT:usersin:MAX:"Maximum\:%8.0lf %s\n" \
LINE3:usersout#0000FF:"Users LogOUT"  \
GPRINT:usersout:LAST:"Current\:%8.0lf %s"  \
GPRINT:usersout:AVERAGE:"Average\:%8.0lf %s"  \
GPRINT:usersout:MAX:"Maximum\:%8.0lf %s\n"

$RRDTOOL_BIN graph users_month.png \
--start=-2678400 \
--end=-7200 \
--title="User Connection stats - month (2 hours avg)" \
--base=1000 \
--height=130 \
--width=380 \
--alt-autoscale-max \
--lower-limit=0 \
--color=BACK#FFFFFF \
--color=CANVAS#DDDDDD \
--vertical-label="Number of users" \
DEF:usersin="users.rrd":usersin:AVERAGE \
DEF:usersout="users.rrd":usersout:AVERAGE \
"CDEF:suma1=usersin" \
"CDEF:suma2=usersout" \
"CDEF:total=suma1,suma2,+" \
AREA:total#000000:"Total in DB "  \
GPRINT:total:LAST:"Current\:%8.0lf %s"  \
GPRINT:total:AVERAGE:"Average\:%8.0lf %s"  \
GPRINT:total:MAX:"Maximum\:%8.0lf %s" \
LINE3:usersin#00FF00:"Users LogIN "  \
GPRINT:usersin:LAST:"Current\:%8.0lf %s"  \
GPRINT:usersin:AVERAGE:"Average\:%8.0lf %s"  \
GPRINT:usersin:MAX:"Maximum\:%8.0lf %s\n" \
LINE3:usersout#0000FF:"Users LogOUT"  \
GPRINT:usersout:LAST:"Current\:%8.0lf %s"  \
GPRINT:usersout:AVERAGE:"Average\:%8.0lf %s"  \
GPRINT:usersout:MAX:"Maximum\:%8.0lf %s\n"

$RRDTOOL_BIN graph users_year.png \
--start=-33053184 \
--end=-86400 \
--title="User Connection stats - year (1 day avg)" \
--base=1000 \
--height=130 \
--width=380 \
--alt-autoscale-max \
--lower-limit=0 \
--color=BACK#FFFFFF \
--color=CANVAS#DDDDDD \
--vertical-label="Number of users" \
DEF:usersin="users.rrd":usersin:AVERAGE \
DEF:usersout="users.rrd":usersout:AVERAGE \
"CDEF:suma1=usersin" \
"CDEF:suma2=usersout" \
"CDEF:total=suma1,suma2,+" \
AREA:total#000000:"Total in DB "  \
GPRINT:total:LAST:"Current\:%8.0lf %s"  \
GPRINT:total:AVERAGE:"Average\:%8.0lf %s"  \
GPRINT:total:MAX:"Maximum\:%8.0lf %s" \
LINE3:usersin#00FF00:"Users LogIN "  \
GPRINT:usersin:LAST:"Current\:%8.0lf %s"  \
GPRINT:usersin:AVERAGE:"Average\:%8.0lf %s"  \
GPRINT:usersin:MAX:"Maximum\:%8.0lf %s\n" \
LINE3:usersout#0000FF:"Users LogOUT"  \
GPRINT:usersout:LAST:"Current\:%8.0lf %s"  \
GPRINT:usersout:AVERAGE:"Average\:%8.0lf %s"  \
GPRINT:usersout:MAX:"Maximum\:%8.0lf %s\n"
