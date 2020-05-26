<?php

// 原生函數
class Solution {

    /**
     * @param Integer $x
     * @return Integer
     */
    function mySqrt($x) {
        return (int)sqrt($x);
    }
}

echo (new Solution())->mySqrt(4).PHP_EOL;
