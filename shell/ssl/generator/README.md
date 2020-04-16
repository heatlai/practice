# SSL self-signed certs 

### Use
```shell script
chmod +x ssl.sh check.sh verify.sh

# generate cert & key
./ssl.sh example.com
# show cert detail
./check.sh ./ssl/example.com/server.crt
# verify cert & key
./verify.sh ./ssl/example.com/server.crt ./ssl/example.com/server.key
```

### MacOS Dependency Installation
```shell script
# realpath
brew install coreutils

# envsubst in gettext package
brew install gettext
brew link --force gettext
```

### One Line
```shell script
openssl req \
-x509 \
-newkey "rsa:4096" \
-sha256 \
-days 35600 \
-nodes \
-keyout server.key \
-out server.crt \
-subj '/C=TW/ST=Taiwan/L=Taipei/O=Example Ltd./CN=example.com' \
-extensions SAN \
-reqexts SAN \
-config <(cat /etc/ssl/openssl.cnf \
  <(printf "\n[SAN]\nsubjectAltName=DNS:example.com,DNS:*.example.com"))
```

## SSL with Root CA

### Root CA (只要一次)
```shell script
./root_ca.sh
ls ./ca
```

### SSL for dev
加自己的 domain 到 `domains` 檔案裡面  
**注意：要保留最後一行是空白行**
```shell script
./ssl_ca.sh
ls ./selfsigned
```
