<?php


class Solution {

    /**
     * @param Integer[] $digits
     * @return Integer[]
     */
    function plusOne($digits) {
        $len = count($digits);
        $lastIndex = $len - 1;
        for ($i = $lastIndex; $i > -1; --$i) {
            if ( $digits[$i] < 9 ) {
                $digits[$i]++;
                return $digits;
            }

            $digits[$i] = 0;
        }

        array_unshift($digits, 1);
        return $digits;
    }
}
