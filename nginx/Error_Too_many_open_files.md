Nginx 出現 500 Error, 錯誤訊息只能從 Log 查到, 有遇到下述兩種狀況:

socket() failed (24: Too many open files) while connecting to upstream
512 worker_connections are not enough while connecting to upstream

Nginx "Too many open files" 修復錯誤訊息
2011/05/01 23:00:49 [alert] 7387#0: *6259768 socket() failed (24: Too many open files) while connecting to upstream, client: 123.123.123.123, server: www.example.com, request: "GET [[/]] HTTP/1.1", upstream: "fastcgi://127.0.0.1:1234", host: "www.example.com"

解法
$ sudo -i
$ ulimit -n # 看目前系統設定的限制 (ulimit -a # 可查看全部參數)
1024

vim /etc/security/limits.conf # 由此檔案設定 nofile (nofile - max number of open files) 的大小
# 增加/修改 下述兩行
* soft nofile 655360
* hard nofile 655360

ulimit -n # 登出後, 在登入, 執行就會出現此值
655360

4. 若 ulimit -n 沒出現 655360 的話, 可使用 ulimit -n 655360 # 強制設定

5. 再用 ulimit -n 或 ulimit -Sn (驗證軟式設定)、ulimit -Hn (驗證硬式設定) 檢查看看(或 ulimit -a).

從系統面另外計算 + 設定
lsof | wc -l # 計算開啟檔案數量
sudo vim /etc/sysctl.conf
fs.file-max = 3268890
sudo sysctl -p