<?php

class Solution
{
    /**
     * @param  Integer[]  $nums
     * @param  Integer  $target
     * @return Integer[]
     */
    function twoSum($nums, $target)
    {
        $tmp = [];
        foreach ($nums as $key => $num) {
            $a = $target - $num;
            // 比對是否 tmp array 已有可匹配的值
            if (isset($tmp[$a])) {
                return array($tmp[$a], $key);
            }
            // key/value 對調儲存 與 array_flip 相同
            $tmp[$num] = $key;
        }
    }
}
