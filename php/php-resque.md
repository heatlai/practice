#php-resque

##啟動
QUEUE=* php resque.php &

## 檢查程序
ps -e -o pid,command | grep [r]esque

## 新增Job進queue
php /var/www/html/php-resque/demo/queue.php PHP_Job