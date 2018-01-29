/* MySQL 硬碟總使用量 */
SELECT Concat(Round(Sum(data_length + index_length) / ( 1024 * 1024 * 1024 ), 6)
       , ' GB'
       ) AS 'Total Size'
FROM   information_schema.tables

/* MySQL 硬碟各資料庫使用量 */
SELECT table_schema,
       Concat(Round(Sum(data_length + index_length) / ( 1024 * 1024 * 1024 ), 6)
       , ' GB'
       ) AS 'Total Size'
FROM   information_schema.tables
GROUP  BY 1