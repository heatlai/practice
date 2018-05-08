#!/bin/bash

# 切換到 evn.sh 檔案目錄底下
BASEDIR=$(dirname "$0")
cd "$BASEDIR"
clear
echo "PWD:"$PWD

USE_DOCKER_COMPOSE_YML=redis-cluster-docker-compose.yml
echo "USE_DOCKER_COMPOSE_YML:"$USE_DOCKER_COMPOSE_YML

while :
do
    # 選擇要啟動的系統
    echo "----------------------------------------"
    echo "選擇要啟動的系統:"
    echo "----------------------------------------"
    echo "a. Redis"
    echo "----------------------------------------"
    echo "1. redis"
    echo "----------------------------------------"
    echo "工具:"
    echo "----------------------------------------"
    echo "r. 重啟所有容器"
    echo "c. 關閉所有容器"
    echo "ca. 刪除所有容器"
    echo "l. 顯示 Docker 所有容器"
    echo "d. 指定關閉編號容器"
    echo "  - Example: 關閉 redis-1"
    echo "  - input: d 1"
    echo "rd. 指定重啟編號容器"
    echo "  - Example: 重啟 redis-1 容器"
    echo "  - input: rd 1"
    echo "----------------------------------------"
    echo "q. Exit"
    echo "----------------------------------------"
    read -p "Input:" input input2

    clear

    case $input in
        a)
            # 啟動 docker-compose 全部 container
            docker-compose -f $USE_DOCKER_COMPOSE_YML up -d
            ;;
        1)
            # 啟動 redis_1
            docker-compose -f $USE_DOCKER_COMPOSE_YML up -d --build redis_1
            ;;
        2)
            # 啟動 redis_2
            docker-compose -f $USE_DOCKER_COMPOSE_YML up -d --build redis_2
            ;;
        r)
            # 關閉透過 docker-compose 產生的 container
            docker-compose -f $USE_DOCKER_COMPOSE_YML down
            docker-compose -f $USE_DOCKER_COMPOSE_YML up -d
            ;;
        l)
            # 查看目前的 container
            docker ps -a
            ;;
        c)
            # 關閉透過 docker-compose 產生的 container
            docker-compose -f $USE_DOCKER_COMPOSE_YML down
            ;;
        ca)
            # 刪除所有 docker container
            docker rm $(docker ps -a -q)
            ;;
        *)
            # 離開程序
            exit
            ;;
    esac
done