# Redis 操作

## 進入 redis-cli
redis-cli

## 進入 redis-cli (docker)
docker exec -it redis bash  
redis-cli -p [port]

## 查當前資料的key
keys *

##取指定key的value
get [key]

## 清除全部資料
flushall

## pattern del
redis-cli -p 7006 keys "key1:key2:*" | xargs redis-cli -p 7006 del