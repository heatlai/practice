#!/usr/bin/env bash

urlencode() {
  python -c 'import urllib, sys; print urllib.quote(sys.argv[1], sys.argv[2])' \
    "$1" "$urlencode_safe"
}

urldecode() {
  python -c 'import urllib, sys; print urllib.unquote(sys.argv[1])' \
    "$1"
}

originStr="https://google.com/?aa=123&bb=456"
str=$(urlencode ${originStr})
str2=$(urlencode_safe=':/='  urlencode ${originStr})

echo str : ${str}
echo str2 : ${str2}

echo $(urldecode ${str})