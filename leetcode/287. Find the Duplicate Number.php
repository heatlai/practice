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

class Solution1 {

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
