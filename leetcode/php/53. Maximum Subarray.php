<?php

// Kadane, O(n)
class Solution
{
    /**
     * @param  Integer[]  $nums
     * @return Integer
     */
    function maxSubArray($nums)
    {
        $max = PHP_INT_MIN;
        $temp = 0;

        foreach ($nums as $num) {
            $temp = max($temp + $num, $num);
            $max = max($max, $temp);
        }

        return $max;
    }
}

// Divide and Conquer, O(n log n)
class Solution2
{
    /**
     * @param  Integer[]  $nums
     * @return Integer
     */
    function maxSubArray($nums)
    {
        return $this->maxSubArraySum($nums, 0, count($nums) - 1);
    }

    function maxSubArraySum($arr, $left, $right)
    {
        // 左邊界等於右邊界，是最後一個數字
        if ($left === $right) {
            return $arr[$left];
        }

        // 正中間的index
        $mid = (int)(($left + $right) / 2);

        // 左半邊最大段 or 右半邊最大段 or 有經過正中間(跨左右)最大段
        return max($this->maxSubArraySum($arr, $left, $mid), $this->maxSubArraySum($arr, $mid + 1, $right),
            $this->maxSubArrayCrossingSum($arr, $left, $mid, $right));
    }

    function maxSubArrayCrossingSum($arr, $left, $mid, $right)
    {
        // 從中間開始往左加
        $leftSum = PHP_INT_MIN;
        $temp = 0;
        for ($i = $mid; $i >= $left; $i--) {
            $temp += $arr[$i];
            $leftSum = max($temp, $leftSum);
        }

        // 從中間開始往右加
        $rightSum = PHP_INT_MIN;
        $temp = 0;
        for ($i = $mid + 1; $i <= $right; $i++) {
            $temp += $arr[$i];
            $rightSum = max($temp, $rightSum);
        }

        return ($leftSum + $rightSum);
    }
}

$tests = [
    [-2, 1, -3, 4, -1, 2, 1, -5, 4],
    [-1],
    [-3, -2, 0, -1],
];

foreach ($tests as $arr) {
    echo "Maximum contiguous sum is ".(new Solution())->maxSubArray($arr).PHP_EOL;
    echo "Maximum contiguous sum is ".(new Solution2())->maxSubArray($arr).PHP_EOL;
}


