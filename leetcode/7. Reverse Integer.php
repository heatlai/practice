<?php

class Solution {

    /**
     * @param Integer $x
     * @return Integer
     */
    function reverse($x) {
        $res = ( $x < 0 ) ? strrev(abs($x))*-1 : strrev($x)*1;

        $min_int_32bit = -2147483648;
        $max_int_32bit = 2147483647;
        if( $res < $min_int_32bit || $res > $max_int_32bit)
        {
            return 0;
        }
        return $res;
    }
}
