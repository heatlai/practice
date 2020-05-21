<?php

class Solution {

    /**
     * @param Integer[] $nums
     * @return Integer
     */
    function findDuplicate($nums)
    {
        $nums = array_diff_assoc($nums, array_unique($nums));
        return reset($nums);
    }
}

class Solution2 {

    /**
     * @param Integer[] $nums
     * @return Integer
     */
    function findDuplicate($nums)
    {
        $nums = array_reverse(array_diff_assoc($nums, array_unique($nums)));
        return array_pop($nums);
    }
}

/**
 * 這個解法只在這題限制條件下有效
 * $nums = n + 1 個
 * $num 在 1 ~ n 之間
 * example:
 * $nums length = 5 = 4 + 1
 * $n = 4
 * 1 <= $num <= 4
 */
class Solution3 {

    /**
     * @param Integer[] $nums
     * @return Integer
     */
    function findDuplicate($nums) {
        return $this->twoPointers($nums);
    }

    protected function twoPointers($nums) {
        $firstPointer = 0;
        $secondPointer = 0;
        do {
            $firstPointer = $nums[$firstPointer];
            $secondPointer = $nums[$nums[$secondPointer]];
        } while ($nums[$firstPointer] !== $nums[$secondPointer]);

        $metPoint = $firstPointer;

        $firstPointer = 0;
        $secondPointer = $metPoint;

        while ($nums[$firstPointer] !== $nums[$secondPointer]) {
            $firstPointer = $nums[$firstPointer];
            $secondPointer = $nums[$secondPointer];
        }

        return $nums[$firstPointer];
    }
}

class Solution4 {
    /**
     * @param Integer[] $nums
     * @return Integer
     */
    function findDuplicate($nums) {
        $tmp = [];
        foreach ($nums as $num) {
            if( isset($tmp[$num]) ) {
                return $num;
            }
            $tmp[$num] = true;
        }
    }
}
var_dump((new Solution)->findDuplicate([1,3,4,2,2]));
var_dump((new Solution)->findDuplicate([1,4,3,3,2]));
