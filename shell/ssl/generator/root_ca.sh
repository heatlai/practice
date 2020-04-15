#!/usr/bin/env bash

### ROOT CA

BASEDIR=`dirname $0`
KEY="${BASEDIR}/ca/rootCA.key"
CRT="${BASEDIR}/ca/rootCA.crt"

if [ ! -e "${KEY}" ]; then
  openssl genrsa -out "${KEY}" 4096
else
  echo "${KEY} is exists."
fi

CA_CONFIG="
[req]
prompt = no
distinguished_name = req_distinguished_name
x509_extensions = v3_ca

[req_distinguished_name]
C = TW
ST = Taiwan
L = Taipei
O = hypenode.tw Ltd.
CN = Dev Root CA

[v3_ca]
subjectKeyIdentifier = hash
authorityKeyIdentifier = keyid:always, issuer:always
basicConstraints = critical, CA:TRUE
keyUsage = critical, digitalSignature, cRLSign, keyCertSign

[ v3_intermediate_ca ]
subjectKeyIdentifier = hash
authorityKeyIdentifier = keyid:always,issuer:always
basicConstraints = critical, CA:TRUE, pathlen:0
keyUsage = critical, digitalSignature, cRLSign, keyCertSign
"
if [ ! -e "${CRT}" ]; then
  openssl req -new -sha256 -nodes -x509 \
  -days 35600 \
  -config <(echo "${CA_CONFIG}") \
  -key "${KEY}" \
  -out "${CRT}"
else
  echo "${CRT} is exists."
fi

echo "ROOT CA Done."

