#!/bin/bash

# 切換到 evn.sh 檔案目錄底下
BASEDIR=$(dirname "$0")
cd "$BASEDIR"
# clear
echo $BASEDIR

while :
do
    # 選擇要啟動的系統
    echo "----------------------------------------"
    echo "選擇要啟動的系統:"
    echo "----------------------------------------"
    echo "a. 所有 Server"
    echo "----------------------------------------"
    echo "1. PHP"
    echo "2. Nginx"
    echo "3. Mariadb"
    echo "4. PhpMyAdmin"
    echo "5. Redis"
    echo "----------------------------------------"
    echo "工具:"
    echo "----------------------------------------"
    echo "r. 重啟 Docker 所有容器"
    echo "c. 關閉 docker-compose 產生的所有容器"
    echo "ca. 關閉 Docker 所有容器"
    echo "l. 顯示 Docker 所有容器"
    echo "d. 指定重啟 Docker 項目編號容器"
    echo "  - Example: 重啟 PHP 容器"
    echo "  - input: d 1"
    echo "q. Exit"
    echo "----------------------------------------"
    echo "選擇 migrate 設定:"
    echo "----------------------------------------"
    echo "mg. 執行 migrate"
    echo "rb. 執行 rollback"
    echo "----------------------------------------"
    read -p "Input:" input input2

    clear

    case $input in
        a)
            # 啟動 php
            docker-compose up -d --build php
            # 啟動 nginx
            docker-compose up -d --build nginx
            # 啟動 mysql
            docker-compose up -d --build mariadb
            # 啟動 phpmyadmin_mysql
            docker-compose up -d --build phpmyadmin
            # 啟動 redis
            docker-compose up -d --build redis
            ;;
        1)
            # 啟動 php
            docker-compose up -d --build php
            ;;
        2)
            # 啟動 nginx
            docker-compose up -d --build nginx
            ;;
        3)
            # 啟動 mysql
            docker-compose up -d --build mariadb
            ;;
        4)
            # 啟動 phpmyadmin_mysql
            docker-compose up -d --build phpmyadmin
            ;;
        5)
            # 啟動 redis
            docker-compose up -d --build redis
            ;;
        r)
            # 關閉透過 docker-compose 產生的 container
            docker-compose down
            # 啟動 php
            docker-compose up -d --build php
            # 啟動 nginx
            docker-compose up -d --build nginx
            # 啟動 mysql
            docker-compose up -d --build mariadb
            # 啟動 phpmyadmin_mysql
            docker-compose up -d --build phpmyadmin
            # 啟動 redis
            docker-compose up -d --build redis
            ;;
        l)
            # 查看目前的 container
            docker ps -a
            ;;
        c)
            # 關閉透過 docker-compose 產生的 container
            docker-compose down
            ;;
        ca)
            # 關閉所有 docker container
            docker rm $(docker ps -a -q)
            ;;
        d)
            # 重啟指定的服務
            if [  "$input2" == "" ]; then
                echo "which service do you want to shutdown?"
            else
                case $input2 in
                    1)
                        docker rm -f php
                        docker-compose up -d --build php
                        ;;
                    2)
                        docker rm -f nginx
                        docker-compose up -d --build nginx
                        ;;
                    3)
                        docker rm -f mysql
                        docker-compose up -d --build mariadb
                        ;;
                    4)
                        docker rm -f phpmyadmin_mysql
                        docker-compose up -d --build phpmyadmin
                        ;;
                    5)
                        docker rm -f redis
                        docker-compose up -d --build redis
                        ;;
                esac
            fi
            ;;
        mg)
            # 執行 migrate
            php ./../vendor/bin/phinx migrate
            ;;
        rb)
            # 執行 rollback
            php ./../vendor/bin/phinx rollback -t 0
            ;;
        *)
            # 離開程序
            exit
            ;;
    esac
done