<?php

class Solution
{
    /**
     * @param  Integer[]  $nums
     * @return Boolean
     */
    function checkPossibility($nums)
    {
        $k = null;
        $length = count($nums) - 1;
        for ($i = 0; $i < $length; $i++) {
            if ($nums[$i] > $nums[$i + 1]) {
                // 只能有一個比後項高，因為只能修改一個數字
                if ($k !== null) {
                    return false;
                }
                $k = $i;
            }
        }

        // 全部遞增
        if ($k === null) {
            return true;
        }
        // 是第一項比後項高，只需修改第一項
        if ($k === 0) {
            return true;
        }
        // 是倒數第二項比最後一項高，只需修改最後一項
        if ($k === count($nums) - 2) {
            return true;
        }
        // 前項小於等於後項，只需修改 $k 項
        if ($nums[$k - 1] <= $nums[$k + 1]) {
            return true;
        }
        // $k 項小於等於後後項，只需修改 $k+1 項
        if ($nums[$k] <= $nums[$k + 2]) {
            return true;
        }

        return false;
    }
}

class Solution2
{
    /**
     * @param  Integer[]  $nums
     * @return Boolean
     */
    function checkPossibility($nums)
    {
        $changed = 0;
        foreach ($nums as $k => $v) {
            if ($k === 0) {
                continue;
            }

            $prev1Exists = isset($nums[$k - 1]);
            $prev2Exists = isset($nums[$k - 2]);
            $prev1 = $prev1Exists ? $nums[$k - 1] : null;
            $prev2 = $prev2Exists ? $nums[$k - 2] : null;

            if ($prev1Exists && ! $prev2Exists) {
                if ($prev1 > $v) {
                    $nums[$k - 1] = $v;
                    if ($changed !== 0) {
                        return false;
                    }
                    $changed++;
                }
            } elseif ($prev1Exists && $prev2Exists) {
                if ($prev1 > $v) {
                    if ($prev2 <= $v) {
                        $nums[$k - 1] = $v;
                        if ($changed !== 0) {
                            return false;
                        }
                        $changed++;
                    } else {
                        $nums[$k] = $nums[$k - 1];
                        if ($changed !== 0) {
                            return false;
                        }
                        $changed++;
                    }
                }
            }
        }
        return true;
    }
}

class Solution3
{
    /**
     * @param  Integer[]  $nums
     * @return Boolean
     */
    function checkPossibility($nums)
    {
        $count = 0;
        $length = count($nums) - 1;
        for ($i = 0; $i < $length && $count <= 1; $i++) {
            if ($nums[$i] > $nums[$i + 1]) {
                $count++;
                if ($i - 1 < 0) {
                    $nums[$i] = $nums[$i + 1];
                } elseif ($nums[$i - 1] <= $nums[$i + 1]) {
                    $nums[$i] = $nums[$i + 1];
                } elseif ($nums[$i - 1] > $nums[$i + 1]) {
                    $nums[$i + 1] = $nums[$i];
                }
            }
        }
        return $count <= 1;
    }
}

$tests = [
    [
        [4, 2, 3],
        true,
    ],
    [
        [4, 2, 1],
        false,
    ],
    [
        [3, 4, 2, 3],
        false,
    ],
    [
        [1, 5, 4, 6, 7, 8, 9],
        true,
    ],
    [
        [1, 2, 3],
        true,
    ],
    [
        [2, 3, 3, 2, 4],
        true,
    ],
    [
        [1, 2, 4, 5, 3],
        true,
    ]
];

foreach ($tests as $arr) {
    $shouldBe = $arr[1] ? 'true' : 'false';
    $check = (new Solution())->checkPossibility($arr[0]) ? 'true' : 'false';
    var_dump('shouldBe: '.$shouldBe.' => check :'.$check);
}
