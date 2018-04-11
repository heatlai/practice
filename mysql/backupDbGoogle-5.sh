#!/bin/sh

# DB
DB_HOST="localhost"
DB_USER="root"
DB_PASSWD="@@mysql"

# Path
PATH_BASE="/root/sqlback/"
PATH_TEMP="/root/sqlbackTemp/"
PATH_GOOGLE="gs://You-GCS" 

# Date 
NEXT_TIME="$(date +"%Y-%m-%d_%H")"
DELETE_TIME="$(date --date="1 weeks ago" +"%Y-%m-%d_%H")"

# File Name
NEXT_FILE="sql_"$NEXT_TIME".tar"
DELETE_FILE="sql_"$DELETE_TIME".tar"

# Command Path
MYSQL="$(which mysql)"
MYSQLDUMP="$(which mysqldump)"
#GZIP="$(which gzip)"
BZIP2="$(which bzip2)"
TAR="$(which tar)"
RM="$(which rm)"
MKDIR="$(which mkdir)"
SEVENZ="$(which 7za)"

# test backup dir exist
test ! -d $PATH_BASE && $MKDIR $PATH_BASE
test ! -d $PATH_TEMP && $MKDIR $PATH_TEMP

ulimit -n 655350
 
# get all databases
ALLDB="$($MYSQL -u $DB_USER -h $DB_HOST -p$DB_PASSWD -Bse 'show databases')"

cd $PATH_TEMP

for DB in $ALLDB
do
	if [ "$DB"x = "information_schema"x ] || [ "$DB"x = "mysql"x ] || [ "$DB"x = "performance_schema"x ] || [ "$DB"x = "test"x ]; then
        	continue
	fi

	echo "$DB"
	
	PATH_TEMP_TABLE=$PATH_TEMP$DB
	
	test ! -d $PATH_TEMP_TABLE && $MKDIR $PATH_TEMP_TABLE
	
	echo $PATH_TEMP_TABLE

	# get all tables
	TEMPTABLE="$($MYSQL -u $DB_USER -h $DB_HOST -p$DB_PASSWD -Bse 'use '$DB';show tables;')"
	
	for TABLE in $TEMPTABLE
	do
		echo "$TABLE"
		
		# Backup Table
		$MYSQLDUMP --user $DB_USER --password=$DB_PASSWD $DB $TABLE > $PATH_TEMP_TABLE'/'$TABLE.sql
	done

	$SEVENZ a -mx9 -t7z -v100m $DB.7z $PATH_TEMP_TABLE
	$RM -rf $PATH_TEMP_TABLE

done

#TAR
$TAR -cv -f $PATH_BASE$NEXT_FILE $PATH_TEMP

#Clean temp
$RM -rf $PATH_TEMP*

# Delete Backup file

cd $PATH_BASE
BACKUPSQLS="$(ls -alt sql_* | awk '{print $9}')"

for sql in $BACKUPSQLS
do
	if [ "$sql" \< "$DELETE_FILE" ]; then
		test -f $PATH_BASE$sql && $RM $PATH_BASE$sql
	fi
done

/usr/local/bin/gsutil rsync -d /root/sqlback $PATH_GOOGLE

exit 0;
