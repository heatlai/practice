#!/usr/bin/env bash

### Dev Domain CRT

BASEDIR=$(dirname $0)
CA_KEY="${BASEDIR}/ca/rootCA.key"
CA_CRT="${BASEDIR}/ca/rootCA.crt"
CA_SRL="${BASEDIR}/ca/rootCA.srl"
KEY="${BASEDIR}/selfsigned/selfsigned.key"
CSR="${BASEDIR}/selfsigned/selfsigned.csr"
CRT="${BASEDIR}/selfsigned/selfsigned.crt"

### read domain file
DNS=$(declare -i i=3; while IFS= read -r line; do
  echo "DNS.$((i+=1)) = ${line}"
done < "${BASEDIR}/domains")

CRT_CONFIG="
[req]
prompt = no
distinguished_name = req_distinguished_name
x509_extensions = v3_req

[req_distinguished_name]
C = TW
ST = Taiwan
L = Taipei
OU = Web self-signed
CN = self-signed.dev

[v3_req]
authorityKeyIdentifier = keyid,issuer:always
basicConstraints = critical, CA:FALSE
keyUsage = critical, digitalSignature, nonRepudiation, keyEncipherment, dataEncipherment
extendedKeyUsage = serverAuth, clientAuth
subjectAltName = @alt_names

[alt_names]
IP.1 = 127.0.0.1
DNS.1 = localhost
DNS.2 = self-signed.dev
DNS.3 = *.self-signed.dev
${DNS}
"

#### key
openssl genrsa -out "${KEY}" 4096
#### csr
openssl req -new -sha256 \
-config <(echo "${CRT_CONFIG}") \
-key "${KEY}" \
-out "${CSR}"
#### crt
openssl x509 -sha256 -req \
-days 36500 \
-CA "${CA_CRT}" \
-CAkey "${CA_KEY}" \
-CAserial "${CA_SRL}" -CAcreateserial \
-in "${CSR}" \
-out "${CRT}" \
-extensions v3_req \
-extfile <(echo "${CRT_CONFIG}")

echo "Dev Domain CRT Done."