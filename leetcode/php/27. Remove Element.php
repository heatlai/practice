<?php

class Solution
{
    /**
     * @param  Integer[]  $nums
     * @param  Integer  $val
     * @return Integer
     */
    function removeElement(&$nums, $val)
    {
        $nums = array_diff($nums,[$val]);
        return count($nums);
    }
}

class Solution2
{
    /**
     * @param  Integer[]  $nums
     * @param  Integer  $val
     * @return Integer
     */
    function removeElement(&$nums, $val)
    {
        $nums = array_filter($nums, static function ($item) use ($val) {
            return $item !== $val;
        });

        return count($nums);
    }
}

// $nums = [3,2,2,3];
$nums = [0,1,2,2,3,0,4,2];
$val = 2;

// nums is passed in by reference. (i.e., without making a copy)
$len = (new Solution())->removeElement($nums, $val);

foreach ($nums as $key => $val) {
    print_r($key.':'.$val.PHP_EOL);
}
