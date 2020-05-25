<?php

// 二分搜尋 用index定位
class Solution
{

    /**
     * @param  Integer[]  $nums
     * @param  Integer  $target
     * @return Integer
     */
    function searchInsert($nums, $target)
    {
        $lastIndex = count($nums) - 1;
        return $this->binarySearch($nums, $target, 0, $lastIndex);
    }

    /**
     * @param $nums
     * @param $target
     * @param $left
     * @param $right
     * @return int
     */
    function binarySearch($nums, $target, $left, $right)
    {
        // 左邊界等於右邊界，是最後一個數字
        if ($left === $right) {
            return ($nums[$left] < $target) ? $left + 1 : $left;
        }
        // 中位數
        $mid = (int)floor(($left + $right) / 2);
        // 中位數 比 目標 大 往左搜尋，右邊界 設為 中位數 的 index
        if ($nums[$mid] > $target) {
            return $this->binarySearch($nums, $target, $left, $mid);
        }
        // 中位數 比 目標 小 往右搜尋，左邊界 設為 中位數 的 index
        if ($nums[$mid] < $target) {
            return $this->binarySearch($nums, $target, $mid + 1, $right);
        }
        // 一樣大 return 中位數的 index
        return $mid;
    }
}

// foreach 跑一圈
class Solution2
{

    /**
     * @param  Integer[]  $nums
     * @param  Integer  $target
     * @return Integer
     */
    function searchInsert($nums, $target)
    {
        foreach ($nums as $i => $num) {
            if ($num >= $target) {
                return $i;
            }
        }
        return count($nums);
    }
}

// 二分搜尋 每次比對完都只留下下次要比對的部分
class Solution3
{

    /**
     * @param  Integer[]  $nums
     * @param  Integer  $target
     * @return Integer
     */
    function searchInsert($nums, $target)
    {
        return $this->binarySearch($nums, $target);
    }

    /**
     * @param $nums
     * @param $target
     * @return int
     */
    function binarySearch($nums, $target)
    {
        $total = count($nums);
        // 最後一個數字
        if ($total === 1) {
            $key = key($nums);
            $val = $nums[$key];
            return ($val < $target) ? $key + 1 : $key;
        }
        // 中位數
        $half = (int)($total / 2);
        $mid = array_slice($nums, $half, 1, true);
        $midValue = current($mid);
        // 中位數 比 目標 大，保留左半部
        if ($midValue > $target) {
            return $this->binarySearch(array_slice($nums, 0, $half, true), $target);
        }
        // 中位數 比 目標 小 ，保留右半部
        if ($midValue < $target) {
            return $this->binarySearch(array_slice($nums, $half, null, true), $target);
        }
        // 一樣大 return 中位數的 index
        return key($mid);
    }
}

echo (new Solution3())->searchInsert([0, 1,], 1);
