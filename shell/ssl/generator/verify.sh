#!/usr/bin/env bash

set -eu -o pipefail

if [ ${#} -ne 2 ]; then
  echo "Check if certificate and private key match."
  echo ""
  echo "Usage:"
  echo "    ${0} [certificate] [privatekey]"
  exit 1
fi

TMP="$(mktemp -d)"

# Checking internal consistency of private key
openssl rsa -in "${2}" -check -noout

# Checking spkisha256 hash
hashkey=$(openssl pkey -in "${2}" -pubout -outform der | sha256sum)
hashcrt=$(openssl x509 -in "${1}" -pubkey | openssl pkey -pubin -pubout -outform der | sha256sum)
if [[ "${hashkey}" == "${hashcrt}" ]]; then
  echo "SPKI SHA256 hash matches"
else
  echo "SPKI SHA256 hash does not match"
fi

# check test signature
openssl x509 -in "${1}" -noout -pubkey >"${TMP}/pubkey.pem"

if [[ "$OSTYPE" == "darwin"* ]]; then
  # MacOS
  dd if=/dev/urandom of="${TMP}/rnd" bs=32 count=1 &> /dev/null
else
  # Linux
  dd if=/dev/urandom of="${TMP}/rnd" bs=32 count=1 status=none
fi

openssl rsautl -sign -pkcs -inkey "${2}" -in "${TMP}/rnd" -out "${TMP}/sig"
openssl rsautl -verify -pkcs -pubin -inkey "${TMP}/pubkey.pem" -in "${TMP}/sig" -out "${TMP}/check"

if cmp -s "${TMP}/check" "${TMP}/rnd"; then
  echo "Signature ok"
else
  echo "Signature verify failed"
fi

rm -rf "${TMP}"
