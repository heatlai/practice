#!/usr/bin/env bash

# password length => fold -w 16
echo "$(openssl rand -base64 100 | tr -dc 'a-zA-Z0-9' | fold -w 16 | head -n 1)"
