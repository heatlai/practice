#!/usr/bin/env bash

# token length => forld -w 64
echo "$(openssl rand -base64 100 | tr -dc 'a-zA-Z0-9' | fold -w 64 | head -n 1)"
