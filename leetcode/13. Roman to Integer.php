<?php

/**
 * @param  String  $s
 * @return Integer
 */
function romanToInt($s)
{
    $symbol = [
        'M' => 1000,
        'CM' => 900,
        'D' => 500,
        'CD' => 400,
        'C' => 100,
        'XC' => 90,
        'L' => 50,
        'XL' => 40,
        'X' => 10,
        'IX' => 9,
        'V' => 5,
        'IV' => 4,
        'I' => 1,
    ];

    $res = 0;
    foreach ($symbol as $k => $v) {
        while (strpos($s, $k) === 0) {
            $res += $v;
            $s = substr($s, strlen($k));
        }
    }

    return $res;
}

$tests = [
    'III' => 3,
    'IV' => 4,
    'IX' => 9,
    'LVIII' => 58,
    'MCMXCIV' => 1994

];

foreach ($tests as $s => $v) {
    print_r($s.' => '. $v.' res: '.romanToInt($s). PHP_EOL);
}



