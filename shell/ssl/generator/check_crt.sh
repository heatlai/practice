#!/usr/bin/env bash

CERT_PATH="${1}"
if [ -z "${1}" ]; then
  echo "usage:$0 [CERT_PATH]"
  exit 0
fi
if [ ! -e "${CERT_PATH}" ]; then
  echo "${CERT_PATH} not exists."
  exit 1
fi

declare -a PARAMS=( "${@}" )
if [[ " ${PARAMS[*]} " =~ " -a " ]]; then
    openssl x509 -noout -text -in "${CERT_PATH}"
    exit 0
fi

openssl x509 -noout -in "${CERT_PATH}" \
  -issuer \
  -subject \
  -dates \
  -fingerprint
openssl x509 -noout -in "${CERT_PATH}" -text | grep "DNS:" | sed -e 's/^[[:space:]]*//'