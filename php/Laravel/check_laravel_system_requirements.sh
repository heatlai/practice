#!/usr/bin/env bash

echo "Checking Laravel 6.x Server Requirements..."

echo "  [Version]"
PHP_VERSION=$(php -r "echo PHP_VERSION;")
CHECK_PHP_VERSION=$(php -r "echo version_compare(PHP_VERSION, '7.2.0', '>=') ? 'ture' : 'false';")
if [ "$CHECK_PHP_VERSION" = false ]; then
  echo "    PHP_VERSION must >= 7.2.0, now is ${PHP_VERSION}";
else
  echo '    PHP_VERSION >= 7.2.0 passed.';
fi

REQUIRE_MODULES=(
  bcmath
  ctype
  json
  mbstring
  openssl
  PDO
  pdo_mysql
  tokenizer
  xml
)

EXTENSION_MODULES=(
  zlib
  zip
  gd
  exif
)

PHP_MODULES=$(php -m | grep -v -e "\[Zend Modules\]" -e "\[PHP Modules\]" -e '^$' -e 'Zend OPcache' -e 'Xdebug')

echo "  [Require Modules]"
for mod_name in ${REQUIRE_MODULES[*]}
do
    if [[ "${PHP_MODULES[*]}" =~ ${mod_name} ]]; then
        echo "    Module \"${mod_name}\" is loaded."
    else
        echo "    Module \"${mod_name}\" is not loaded."
    fi
done

echo "  [Extension Modules]"
for mod_name in ${EXTENSION_MODULES[*]}
do
    if [[ "${PHP_MODULES[*]}" =~ ${mod_name} ]]; then
        echo "    Module \"${mod_name}\" is loaded."
    else
        echo "    Module \"${mod_name}\" is not loaded."
    fi
done