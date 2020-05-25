<?php

class Solution {

    /**
     * @param String $s
     * @return Integer
     */
    function lengthOfLastWord($s) {
        $arr = array_filter(explode(' ', $s));
        return strlen(end($arr));
    }
}

echo (new Solution())->lengthOfLastWord("Hello World");
