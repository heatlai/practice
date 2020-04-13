# SSL self-signed certs 

### Use
```shell script
chmod +x ssl.sh check.sh verify.sh

# generate cert & key
./ssl.sh example.com
# show cert detail
./check.sh ./../example.com/server.crt
# verify cert & key
./verify.sh ./../example.com/server.crt ./../example.com/server.key
```

### MacOS Dependency Installation
```shell script
# realpath
brew install coreutils

# envsubst in gettext package
brew install gettext
brew link --force gettext
```