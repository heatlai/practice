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
        foreach ($nums as $key => $value) {
            // 比對是否 tmp array 已有可匹配的值
            if (isset($tmp[$target - $value])) {
                return [$tmp[$target - $value], $key];
            }
            // key/value 對調儲存 與 array_flip 相同
            $tmp[$value] = $key;
        }
        return [];
    }
}
