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
