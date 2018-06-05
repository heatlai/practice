SELECT * FROM users
INTO OUTFILE '/var/lib/mysql-files/export.csv'
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n';