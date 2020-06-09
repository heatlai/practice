<?php

class Solution
{

    /**
     * @param  Integer[]  $nums1
     * @param  Integer  $m
     * @param  Integer[]  $nums2
     * @param  Integer  $n
     * @return NULL
     */
    function merge(&$nums1, $m, $nums2, $n)
    {
        $nums1_pointer = $m - 1; // nums1 最後一個 index
        $nums2_pointer = $n - 1; // nums2 最後一個 index
        $put_in = $m + $n - 1; // nums1 + nums2 元素總數的最後一個 index

        // 從尾巴開始塞，
        // 如果 $m 跟 $n 一樣的話 會剛好一起跑完
        while ($nums1_pointer >= 0 && $nums2_pointer >= 0) {
            // 比對 nums1 最後一個 跟 nums2 最後一個
            // 比較大的放到 nums1 後面
            if ($nums1[$nums1_pointer] > $nums2[$nums2_pointer]) {
                // $nums1[$nums1_pointer] 塞到 $nums1[$put_in]
                $nums1[$put_in] = $nums1[$nums1_pointer];
                $put_in--; // $put_in 塞過了，指針往前移一格
                $nums1_pointer--; // $nums1[$nums1_pointer] 塞過了，指針往前移一格
                // $nums2[$nums2_pointer] 比較小，沒塞進 $nums1，下一圈繼續比對，所以指針不用往前移
            } else {
                $nums1[$put_in] = $nums2[$nums2_pointer];
                $put_in--;
                $nums2_pointer--;
            }
        }

        // 如果 $nums2_pointer 比較長 補跑一輪
        while ($nums2_pointer >= 0) {
            $nums1[$put_in] = $nums2[$nums2_pointer];
            $put_in--;
            $nums2_pointer--;
        }
    }
}

class Solution2
{
    /**
     * @param  Integer[]  $nums1
     * @param  Integer  $m
     * @param  Integer[]  $nums2
     * @param  Integer  $n
     * @return NULL
     */
    function merge(&$nums1, $m, $nums2, $n)
    {
        $nums1 = array_slice($nums1, 0, $m);
        $nums1 = array_merge($nums1, $nums2);
        sort($nums1);
        return $nums1;
    }
}

class Solution3
{
    /**
     * @param  Integer[]  $nums1
     * @param  Integer  $m
     * @param  Integer[]  $nums2
     * @param  Integer  $n
     * @return NULL
     */
    function merge(&$nums1, $m, $nums2, $n)
    {
        foreach ($nums2 as $k => $v){
            $nums1[$m + $k] = $v;
        }
        sort($nums1);
        return $nums1;
    }
}


$nums1 = [1, 2, 3, 0, 0, 0, 0];
$m = 3;
$nums2 = [2, 4, 5, 6];
$n = 4;
$output = [1, 2, 2, 3, 4, 5, 6];

(new Solution())->merge($nums1, $m, $nums2, $n);
echo "Results : ".json_encode($nums1).PHP_EOL;
echo "Expected : ".json_encode($output).PHP_EOL;

$nums1 = [0];
$m = 0;
$nums2 = [1];
$n = 1;
$output = [1];
(new Solution())->merge($nums1, $m, $nums2, $n);
echo "Results : ".json_encode($nums1).PHP_EOL;
echo "Expected : ".json_encode($output).PHP_EOL;

$nums1 = [2, 0];
$m = 1;
$nums2 = [1];
$n = 1;
$output = [1, 2];
(new Solution())->merge($nums1, $m, $nums2, $n);
echo "Results : ".json_encode($nums1).PHP_EOL;
echo "Expected : ".json_encode($output).PHP_EOL;
