<?php

class Solution
{
    /**
     * @param  Integer  $n
     * @return String
     */
    function countAndSay($n)
    {
        if ($n === 1) {
            return '1';
        }

        $res = '1';
        for ($i = 1; $i < $n; ++$i) {
            $len = strlen($res);
            $tmp = '';
            $count = 1;
            $lastChar = $res[0];
            for ($j = 1; $j < $len; ++$j) {
                if ($res[$j] !== $lastChar) {
                    if ($lastChar > 0) {
                        $tmp .= $count.$lastChar;
                    }
                    $lastChar = $res[$j];
                    $count = 1;
                } else {
                    $count++;
                }
            }

            $tmp .= $count.$lastChar;
            $res = $tmp;
        }

        return $res;
    }
}

echo (new Solution())->countAndSay(5);
