<?php

class Solution
{

    /**
     * @param  Integer  $x
     * @return Integer
     */
    function reverse($x)
    {
        $res = ($x < 0) ? strrev(abs($x)) * -1 : strrev($x) * 1;

        $min_int_32bit = -2147483648;
        $max_int_32bit = 2147483647;
        if ($res < $min_int_32bit || $res > $max_int_32bit) {
            return 0;
        }
        return $res;
    }
}

class Solution2
{

    /**
     * @param  Integer  $x
     * @return Integer
     */
    function reverse($x)
    {
        $sign = '';
        if ($x < 0) {
            $x = 0 - $x;
            $sign = '-';
        }
        $x = (string)$x;
        $r = '';
        $stringLength = strlen($x);
        for ($i = 0; $i < $stringLength; $i++) {
            $r = $x[$i].$r;
        }
        if ($r > 2147483647) {
            return 0;
        }
        return $sign.(int)$r;
    }
}
