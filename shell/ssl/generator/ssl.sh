#!/usr/bin/env bash

# check domain
if [ -z "${1}" ]; then
  echo "usage:$0 [example.com]"
  exit 0
fi
DOMAIN="${1}"

BASEDIR=$(dirname "$0")
SSL_CNF_TMPL="${BASEDIR}/openssl.cnf.tmpl"

OUTPUT_PATH="${BASEDIR}/ssl/${DOMAIN}"
KEY="${OUTPUT_PATH}/server.key"
CRT="${OUTPUT_PATH}/server.crt"

# create output dir
mkdir -p "${OUTPUT_PATH}"

# replace DOMAIN in openssl config
SSL_CNF=$(DOMAIN="${DOMAIN}" envsubst < "${SSL_CNF_TMPL}")

# days 36500 means 100 years
openssl req \
  -x509 \
  -sha256 \
  -nodes \
  -newkey "rsa:4096" \
  -days 36500 \
  -utf8 \
  -config <(echo "${SSL_CNF}") \
  -keyout "${KEY}" \
  -out "${CRT}"

# 分開的cmd
#cat << EOT > /tmp/san.ext
#authorityKeyIdentifier=keyid,issuer
#basicConstraints=CA:TRUE
#keyUsage = digitalSignature, nonRepudiation, keyEncipherment, dataEncipherment
#subjectAltName = @alt_names
#
#subjectAltName=DNS:*.${DOMAIN}
#EOT
#openssl genrsa -out ${OUTPUT_PATH}/server.key 2048
#openssl req -new -sha256 -key ${OUTPUT_PATH}/server.key -out ${OUTPUT_PATH}/server.csr -subj '/C=JP/ST=Tokyo/L=Tokyo/O=Example Ltd./OU=Web/CN='${DOMAIN}
#openssl x509 -sha256 -in ${OUTPUT_PATH}/server.csr -days 3650 -req -signkey ${OUTPUT_PATH}/server.key -out ${OUTPUT_PATH}/server.crt -extfile /tmp/san.ext

REAL_KEY=$(realpath "${KEY}")
REAL_CRT=$(realpath "${CRT}")

echo "key: ${REAL_KEY}"
echo "crt: ${REAL_CRT}"

cat <<EOS


apache VirtualHost
------------------------------------------
<VirtualHost *:443>
        //~~
        SSLEngine on
        SSLCertificateFile ${REAL_CRT}
        SSLCertificateKeyFile ${REAL_KEY}
        //~~
</VirtualHost>
------------------------------------------

nginx http or server
------------------------------------------
http {
    ssl_certificate      ${REAL_CRT};
    ssl_certificate_key  ${REAL_KEY};

    #server {
    #  ssl_certificate      ${REAL_CRT};
    #  ssl_certificate_key  ${REAL_KEY};
    #}
}
------------------------------------------
EOS
