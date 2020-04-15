#!/usr/bin/env bash

CSR_PATH="${1}"
if [ -z "${1}" ]; then
  echo "usage:$0 [CSR_PATH]"
  exit 0
fi
if [ ! -e "${CSR_PATH}" ]; then
  echo "${CSR_PATH} not exists."
  exit 1
fi

openssl req -noout -text -in "${CSR_PATH}"