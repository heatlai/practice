## config 初始化
gcloud init

## 目前使用的 config
gcloud config list

## 新增 config
gcloud config configurations create [CONFIGURATION_NAME]

## config 清單
gcloud config configurations list

## 切換 config
gcloud config configurations activate [CONFIGURATION_NAME]

## VM 清單
gcloud compute instances list

## 連線至執行個體
gcloud compute ssh [INSTANCE_NAME]