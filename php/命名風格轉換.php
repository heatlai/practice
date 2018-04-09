<?php
function toCamelCase( $string, $capitalizeFirstCharacter = false )
{

    $str = str_replace('_', '', ucwords($string, '_'));

    if ( ! $capitalizeFirstCharacter )
    {
        $str = lcfirst($str);
    }

    return $str;
}

function toSnakeCase($string)
{
    return strtolower(preg_replace(['/([a-z\d])([A-Z])/', '/([^_])([A-Z][a-z])/'], '$1_$2', $string));
}