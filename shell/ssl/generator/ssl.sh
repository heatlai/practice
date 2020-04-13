#!/usr/bin/env bash

# check domain
if [ -z "${1}" ]; then
  echo "usage:$0 [example.com]"
  exit 0
fi
DOMAIN="${1}"

SHELL_DIR=$(dirname "$0")
SSL_DIR="${SHELL_DIR}/.."
OPENSSL_CNF="${SHELL_DIR}/openssl.cnf"
OPENSSL_CNF_TMPL="${SHELL_DIR}/openssl.cnf.tmpl"

## check openssl config tmpl
if [ ! -e "${OPENSSL_CNF_TMPL}" ]; then
  echo "${OPENSSL_CNF_TMPL} not exists."
  exit 1
fi

# replace DOMAIN in openssl config
DOMAIN="${DOMAIN}" envsubst <"${OPENSSL_CNF_TMPL}" >"${OPENSSL_CNF}"
OUTPUT_PATH="${SSL_DIR}/${DOMAIN}"

# create output dir
mkdir -p "${OUTPUT_PATH}"

# days 36500 means 100 years
openssl req \
  -new \
  -x509 \
  -sha256 \
  -nodes \
  -newkey "rsa:4096" \
  -days 36500 \
  -utf8 \
  -config "${OPENSSL_CNF}" \
  -keyout "${OUTPUT_PATH}/server.key" \
  -out "${OUTPUT_PATH}/server.crt"

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

REAL_KEY=$(realpath ${OUTPUT_PATH}/server.key)
REAL_CRT=$(realpath ${OUTPUT_PATH}/server.crt)

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
}
------------------------------------------
EOS
