<?php

class Solution
{
    /**
     * @param  Integer  $x
     * @return Boolean
     */
    function isPalindrome($x)
    {
        if ($x < 0) {
            return false;
        }

        $x = (string)$x;
        return $x == strrev($x);
    }
}
