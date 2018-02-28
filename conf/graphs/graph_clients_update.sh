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

CLIENTS_TOTAL=`$MYSQL_CLIENT_BIN -u $DB_USER -p$DB_PASSWORD -D $DB_NAME -e "select count(*) from nas"|tail -1`
CLIENTS_ON=1
CLIENTS_OFF=`expr $CLIENTS_TOTAL - $CLIENTS_ON`
if [[ $CLIENTS_ON == '' ]]  ; then CLIENTS_ON=U ; fi
if [[ $CLIENTS_OFF == '' ]]  ; then CLIENTS_OFF=U ; fi

$RRDTOOL_BIN update clients.rrd N:$CLIENTS_ON:$CLIENTS_OFF

$RRDTOOL_BIN graph clients_hour.png \
--start=-3600 \
--end=-300 \
--title="Clients Connection stats - hour (5 min avg)" \
--base=1000 \
--height=130 \
--width=380 \
--alt-autoscale-max \
--lower-limit=0 \
--color=BACK#FFFFFF \
--color=CANVAS#DDDDDD \
--vertical-label="Number of clients" \
DEF:usersin="clients.rrd":usersin:AVERAGE \
DEF:usersout="clients.rrd":usersout:AVERAGE \
"CDEF:suma1=usersin" \
"CDEF:suma2=usersout" \
"CDEF:total=suma1,suma2,+" \
AREA:total#000000:"Total in DB"  \
GPRINT:total:LAST:"Current\:%8.0lf %s"  \
GPRINT:total:AVERAGE:"Average\:%8.0lf %s"  \
GPRINT:total:MAX:"Maximum\:%8.0lf %s" \
LINE3:usersin#80A040:"Clients ON "  \
GPRINT:usersin:LAST:"Current\:%8.0lf %s"  \
GPRINT:usersin:AVERAGE:"Average\:%8.0lf %s"  \
GPRINT:usersin:MAX:"Maximum\:%8.0lf %s\n" \
LINE3:usersout#486591:"Clients OFF"  \
GPRINT:usersout:LAST:"Current\:%8.0lf %s"  \
GPRINT:usersout:AVERAGE:"Average\:%8.0lf %s"  \
GPRINT:usersout:MAX:"Maximum\:%8.0lf %s\n" 

$RRDTOOL_BIN graph clients_day.png \
--start=-86400 \
--end=-300 \
--title="Clients Connection stats - day (5 min avg)" \
--base=1000 \
--height=130 \
--width=380 \
--alt-autoscale-max \
--lower-limit=0 \
--color=BACK#FFFFFF \
--color=CANVAS#DDDDDD \
--vertical-label="Number of clients" \
DEF:usersin="clients.rrd":usersin:AVERAGE \
DEF:usersout="clients.rrd":usersout:AVERAGE \
"CDEF:suma1=usersin" \
"CDEF:suma2=usersout" \
"CDEF:total=suma1,suma2,+" \
AREA:total#000000:"Total in DB"  \
GPRINT:total:LAST:"Current\:%8.0lf %s"  \
GPRINT:total:AVERAGE:"Average\:%8.0lf %s"  \
GPRINT:total:MAX:"Maximum\:%8.0lf %s" \
LINE3:usersin#80A040:"Clients ON "  \
GPRINT:usersin:LAST:"Current\:%8.0lf %s"  \
GPRINT:usersin:AVERAGE:"Average\:%8.0lf %s"  \
GPRINT:usersin:MAX:"Maximum\:%8.0lf %s\n" \
LINE3:usersout#486591:"Clients OFF"  \
GPRINT:usersout:LAST:"Current\:%8.0lf %s"  \
GPRINT:usersout:AVERAGE:"Average\:%8.0lf %s"  \
GPRINT:usersout:MAX:"Maximum\:%8.0lf %s\n"

$RRDTOOL_BIN graph clients_week.png \
--start=-604800 \
--end=-1800 \
--title="Clients Connection stats - week (30 min avg)" \
--base=1000 \
--height=130 \
--width=380 \
--alt-autoscale-max \
--lower-limit=0 \
--color=BACK#FFFFFF \
--color=CANVAS#DDDDDD \
--vertical-label="Number of clients" \
DEF:usersin="clients.rrd":usersin:AVERAGE \
DEF:usersout="clients.rrd":usersout:AVERAGE \
"CDEF:suma1=usersin" \
"CDEF:suma2=usersout" \
"CDEF:total=suma1,suma2,+" \
AREA:total#000000:"Total in DB"  \
GPRINT:total:LAST:"Current\:%8.0lf %s"  \
GPRINT:total:AVERAGE:"Average\:%8.0lf %s"  \
GPRINT:total:MAX:"Maximum\:%8.0lf %s" \
LINE3:usersin#80A040:"Clients ON "  \
GPRINT:usersin:LAST:"Current\:%8.0lf %s"  \
GPRINT:usersin:AVERAGE:"Average\:%8.0lf %s"  \
GPRINT:usersin:MAX:"Maximum\:%8.0lf %s\n" \
LINE3:usersout#486591:"Clients OFF"  \
GPRINT:usersout:LAST:"Current\:%8.0lf %s"  \
GPRINT:usersout:AVERAGE:"Average\:%8.0lf %s"  \
GPRINT:usersout:MAX:"Maximum\:%8.0lf %s\n"

$RRDTOOL_BIN graph clients_month.png \
--start=-2678400 \
--end=-7200 \
--title="Clients Connection stats - month (2 hours avg)" \
--base=1000 \
--height=130 \
--width=380 \
--alt-autoscale-max \
--lower-limit=0 \
--color=BACK#FFFFFF \
--color=CANVAS#DDDDDD \
--vertical-label="Number of clients" \
DEF:usersin="clients.rrd":usersin:AVERAGE \
DEF:usersout="clients.rrd":usersout:AVERAGE \
"CDEF:suma1=usersin" \
"CDEF:suma2=usersout" \
"CDEF:total=suma1,suma2,+" \
AREA:total#000000:"Total in DB"  \
GPRINT:total:LAST:"Current\:%8.0lf %s"  \
GPRINT:total:AVERAGE:"Average\:%8.0lf %s"  \
GPRINT:total:MAX:"Maximum\:%8.0lf %s" \
LINE3:usersin#80A040:"Clients ON "  \
GPRINT:usersin:LAST:"Current\:%8.0lf %s"  \
GPRINT:usersin:AVERAGE:"Average\:%8.0lf %s"  \
GPRINT:usersin:MAX:"Maximum\:%8.0lf %s\n" \
LINE3:usersout#486591:"Clients OFF"  \
GPRINT:usersout:LAST:"Current\:%8.0lf %s"  \
GPRINT:usersout:AVERAGE:"Average\:%8.0lf %s"  \
GPRINT:usersout:MAX:"Maximum\:%8.0lf %s\n"

$RRDTOOL_BIN graph clients_year.png \
--start=-33053184 \
--end=-86400 \
--title="Clients Connection stats - year (1 day avg)" \
--base=1000 \
--height=130 \
--width=380 \
--alt-autoscale-max \
--lower-limit=0 \
--color=BACK#FFFFFF \
--color=CANVAS#DDDDDD \
--vertical-label="Number of clients" \
DEF:usersin="clients.rrd":usersin:AVERAGE \
DEF:usersout="clients.rrd":usersout:AVERAGE \
"CDEF:suma1=usersin" \
"CDEF:suma2=usersout" \
"CDEF:total=suma1,suma2,+" \
AREA:total#000000:"Total in DB"  \
GPRINT:total:LAST:"Current\:%8.0lf %s"  \
GPRINT:total:AVERAGE:"Average\:%8.0lf %s"  \
GPRINT:total:MAX:"Maximum\:%8.0lf %s" \
LINE3:usersin#80A040:"Clients ON "  \
GPRINT:usersin:LAST:"Current\:%8.0lf %s"  \
GPRINT:usersin:AVERAGE:"Average\:%8.0lf %s"  \
GPRINT:usersin:MAX:"Maximum\:%8.0lf %s\n" \
LINE3:usersout#486591:"Clients OFF"  \
GPRINT:usersout:LAST:"Current\:%8.0lf %s"  \
GPRINT:usersout:AVERAGE:"Average\:%8.0lf %s"  \
GPRINT:usersout:MAX:"Maximum\:%8.0lf %s\n"
