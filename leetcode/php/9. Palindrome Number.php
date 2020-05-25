<?php

class Solution
{
    /**
     * @param  Integer  $x
     * @return Boolean
     */
    function isPalindrome($x)
    {
        return $x == strrev($x);
    }
}

class Solution2
{

    /**
     * @param  Integer  $x
     * @return Boolean
     */
    function isPalindrome($x)
    {
        $x = (string)$x;
        $i = 0;
        $j = strlen($x) - 1;
        while ($i < $j) {
            if ($x[$i] != $x[$j]) {
                return false;
            }
            $i++;
            $j--;
        }

        return true;
    }
}
