<?php

class Solution
{
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
}

class Solution2
{

    /**
     * @param  String  $s
     * @return Integer
     */
    function romanToInt($s)
    {
        $numbers = [
            'I' => 1,
            'V' => 5,
            'X' => 10,
            'L' => 50,
            'C' => 100,
            'D' => 500,
            'M' => 1000,
        ];
        $s = str_split($s);

        $int = 0;
        foreach ($s as $k => $letter) {
            // 第一項的時候直接加進去就跳下一項
            if ( ! array_key_exists($k - 1, $s)) {
                $int += $numbers[$letter];
                continue;
            }

            // 如果前項 I 比當前項 V 小，代表是組合數 IV，減兩次前項，因為前一圈 I 先加進去了
            // example : 要加進去的數字 = IV( 4 = 5(V) - 1(I) ) - I(前一圈預先加進去的1)
            if ($numbers[$s[$k - 1]] < $numbers[$letter]) {
                $int += ($numbers[$letter] - $numbers[$s[$k - 1]]) - $numbers[$s[$k - 1]];
            } else {
                $int += $numbers[$letter];
            }
        }

        return $int;
    }
}

$tests = [
    'III' => 3,
    'IV' => 4,
    'IX' => 9,
    'LVIII' => 58,
    'MCMXCIV' => 1994,
];

foreach ($tests as $s => $v) {
    print_r($s.' => '.$v.' res: '.(new Solution2())->romanToInt($s).PHP_EOL);
}



