<?php
/**
 * 替換 sql column name
 *
 * 1. studly case to snake case
 * 2. prefix 'cb_'
 *
 * $input = 'cool.HeatNice, cool.YorkLin, cool.VikiGirl';
 * $return = 'cool.cb_heat_nice, cool.YorkLin, cool.VikiGirl'
 */
function replaceSqlColumnName($str)
{
    $re = '/\.(\w+)/';

    preg_match_all($re, $str, $matches, PREG_SET_ORDER);

    $results = [];
    foreach ($matches as $row) {
        $value = $row[1];
        $results[$value] = 'cb_'.mb_strtolower(preg_replace('/(.)(?=[A-Z])/u', '$1_', $value), 'UTF-8');
    }

    $find = array_keys($results);
    $replace = array_values($results);

    return str_replace($find, $replace, $str);
}