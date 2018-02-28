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

DB_SENT=`mysqladmin -u $DB_USER -p$DB_PASSWORD extended-status|grep -i bytes|awk '{ print $4 }'|tail -1`
DB_RECEIVED=`mysqladmin -u $DB_USER -p$DB_PASSWORD extended-status|grep -i bytes|awk '{ print $4 }'|head -1`

if [[ $DB_SENT == '' ]]  ; then DB_SENT=U ; fi
if [[ $DB_RECEIVED == '' ]]  ; then DB_RECEIVED=U ; fi

$RRDTOOL_BIN update db.rrd N:$DB_SENT:$DB_RECEIVED

##--only-graph \
##--height=150 \
##--width=350 \

$RRDTOOL_BIN graph db_traffic_hour.png \
--start=-3600 \
--end=-300 \
--title="Data Base Throughtput - hour (5 min avg)" \
--base=1000 \
--alt-autoscale-max \
--height=130 \
--width=380 \
--lower-limit=0 \
--color=BACK#FFFFFF \
--color=CANVAS#DDDDDD \
--vertical-label="Bytes sent/received" \
DEF:dbsent="db.rrd":dbsent:AVERAGE \
DEF:dbreceived="db.rrd":dbreceived:AVERAGE \
"CDEF:suma1=dbsent" \
"CDEF:suma2=dbreceived" \
"CDEF:total=suma1,suma2,+" \
AREA:dbsent#00FF8f:"Bytes sent    "  \
GPRINT:dbsent:LAST:"Current\:%8.0lf %s"  \
GPRINT:dbsent:AVERAGE:"Average\:%8.0lf %s"  \
GPRINT:dbsent:MAX:"Maximum\:%8.0lf %s\n" \
AREA:dbreceived#FF8f00:"Bytes received"  \
GPRINT:dbreceived:LAST:"Current\:%8.0lf %s"  \
GPRINT:dbreceived:AVERAGE:"Average\:%8.0lf %s"  \
GPRINT:dbreceived:MAX:"Maximum\:%8.0lf %s\n" \

$RRDTOOL_BIN graph db_traffic_day.png \
--start=-86400 \
--end=-300 \
--title="Data Base Throughtput - day (5 min avg)" \
--base=1000 \
--height=130 \
--width=380 \
--alt-autoscale-max \
--lower-limit=0 \
--color=BACK#FFFFFF \
--color=CANVAS#DDDDDD \
--vertical-label="Bytes sent/received" \
DEF:dbsent="db.rrd":dbsent:AVERAGE \
DEF:dbreceived="db.rrd":dbreceived:AVERAGE \
"CDEF:suma1=dbsent" \
"CDEF:suma2=dbreceived" \
"CDEF:total=suma1,suma2,+" \
AREA:dbsent#00FF8f:"Bytes sent    "  \
GPRINT:dbsent:LAST:"Current\:%8.0lf %s"  \
GPRINT:dbsent:AVERAGE:"Average\:%8.0lf %s"  \
GPRINT:dbsent:MAX:"Maximum\:%8.0lf %s\n" \
AREA:dbreceived#FF8f00:"Bytes received"  \
GPRINT:dbreceived:LAST:"Current\:%8.0lf %s"  \
GPRINT:dbreceived:AVERAGE:"Average\:%8.0lf %s"  \
GPRINT:dbreceived:MAX:"Maximum\:%8.0lf %s\n" \

$RRDTOOL_BIN graph db_traffic_week.png \
--start=-604800 \
--end=-1800 \
--title="Data Base Throughtput - week (30 min avg)" \
--base=1000 \
--height=130 \
--width=380 \
--alt-autoscale-max \
--lower-limit=0 \
--color=BACK#FFFFFF \
--color=CANVAS#DDDDDD \
--vertical-label="Bytes sent/received" \
DEF:dbsent="db.rrd":dbsent:AVERAGE \
DEF:dbreceived="db.rrd":dbreceived:AVERAGE \
"CDEF:suma1=dbsent" \
"CDEF:suma2=dbreceived" \
"CDEF:total=suma1,suma2,+" \
AREA:dbsent#00FF8f:"Bytes sent    "  \
GPRINT:dbsent:LAST:"Current\:%8.0lf %s"  \
GPRINT:dbsent:AVERAGE:"Average\:%8.0lf %s"  \
GPRINT:dbsent:MAX:"Maximum\:%8.0lf %s\n" \
AREA:dbreceived#FF8f00:"Bytes received"  \
GPRINT:dbreceived:LAST:"Current\:%8.0lf %s"  \
GPRINT:dbreceived:AVERAGE:"Average\:%8.0lf %s"  \
GPRINT:dbreceived:MAX:"Maximum\:%8.0lf %s\n" \

$RRDTOOL_BIN graph db_traffic_month.png \
--start=-2678400 \
--end=-7200 \
--title="Data Base Throughtput - month (2 hours avg)" \
--base=1000 \
--height=130 \
--width=380 \
--alt-autoscale-max \
--lower-limit=0 \
--color=BACK#FFFFFF \
--color=CANVAS#DDDDDD \
--vertical-label="Bytes sent/received" \
DEF:dbsent="db.rrd":dbsent:AVERAGE \
DEF:dbreceived="db.rrd":dbreceived:AVERAGE \
"CDEF:suma1=dbsent" \
"CDEF:suma2=dbreceived" \
"CDEF:total=suma1,suma2,+" \
AREA:dbsent#00FF8f:"Bytes sent    "  \
GPRINT:dbsent:LAST:"Current\:%8.0lf %s"  \
GPRINT:dbsent:AVERAGE:"Average\:%8.0lf %s"  \
GPRINT:dbsent:MAX:"Maximum\:%8.0lf %s\n" \
AREA:dbreceived#FF8f00:"Bytes received"  \
GPRINT:dbreceived:LAST:"Current\:%8.0lf %s"  \
GPRINT:dbreceived:AVERAGE:"Average\:%8.0lf %s"  \
GPRINT:dbreceived:MAX:"Maximum\:%8.0lf %s\n" \

$RRDTOOL_BIN graph db_traffic_year.png \
--start=-33053184 \
--end=-86400 \
--title="Data Base Throughtput - year (1 day avg)" \
--base=1000 \
--height=130 \
--width=380 \
--alt-autoscale-max \
--lower-limit=0 \
--color=BACK#FFFFFF \
--color=CANVAS#DDDDDD \
--vertical-label="Bytes sent/received" \
DEF:dbsent="db.rrd":dbsent:AVERAGE \
DEF:dbreceived="db.rrd":dbreceived:AVERAGE \
"CDEF:suma1=dbsent" \
"CDEF:suma2=dbreceived" \
"CDEF:total=suma1,suma2,+" \
AREA:dbsent#00FF8f:"Bytes sent    "  \
GPRINT:dbsent:LAST:"Current\:%8.0lf %s"  \
GPRINT:dbsent:AVERAGE:"Average\:%8.0lf %s"  \
GPRINT:dbsent:MAX:"Maximum\:%8.0lf %s\n" \
AREA:dbreceived#FF8f00:"Bytes received"  \
GPRINT:dbreceived:LAST:"Current\:%8.0lf %s"  \
GPRINT:dbreceived:AVERAGE:"Average\:%8.0lf %s"  \
GPRINT:dbreceived:MAX:"Maximum\:%8.0lf %s\n" \
