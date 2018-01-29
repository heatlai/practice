/* 連線數 */
show status where `variable_name` = 'Threads_connected';

/* 最大連線數 */
show variables like 'max_connections';

/* 進程數 */
show processlist;