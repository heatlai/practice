<?php

class Solution {

    /**
     * @param String $s
     * @return Integer
     */
    function lengthOfLongestSubstring($s)
    {
        $size = strlen($s);
        // 紀錄不同 char 的 start index
        $dict = [];
        // 要從 哪個index 計算到 目前index (左邊界)
        $start_index = 0;
        // 最大長度
        $max = 0;
        for ($i = 0; $i < $size; $i++)
        {
            $char = $s[$i];
            // 如果 $char 是重複的，而且 $char 的 起始index >= $start_index
            if (isset($dict[$char]) && $dict[$char] >= $start_index)
            {
                // 目前 index 減去 $char 最後一次出現的 index
                $count = $i - $dict[$char];
                if ($count > $max) $max = $count;
                // 從 $char 的 起始index 的下一個開始算
                // example : 'abca',
                // 遇到第二個 'a' 就是取第一個'a'的index(0)的下一個，也就是 'b'(1) 開始算
                $start_index = $dict[$char] + 1;
            }
            else
            {
                $count = ($i + 1) - $start_index;
                if ($count > $max) $max = $count;
            }
            // 每個字都更新最後一次出現的 index
            $dict[$char] = $i;
        }

        return $max;
    }
}

class Solution2
{
    /**
     * @param  String  $s
     * @return Integer
     */
    function lengthOfLongestSubstring($s)
    {
        $max = 0;
        $current = '';
        $len = 0;
        $s_length = strlen($s);
        for ($i = 0; $i < $s_length; $i++) {
            if (strpos($current, $s[$i]) !== false) {
                $current = substr($current, strpos($current, $s[$i]) + 1);
                $len = strlen($current);
            }
            $current .= $s[$i];
            $len++;
            $max = max($max, $len);
        }

        return $max;
    }
}

class Solution3
{

    /**
     * @param  String  $s
     * @return Integer
     */
    function lengthOfLongestSubstring($s)
    {
        $source = str_split($s);
        $length = strlen($s);
        $tmp = [];
        $max = 0;
        for ($i = 0; $i < $length; $i++) {
            $char = $source[$i];
            if (in_array($char, $tmp, true)) {
                $search = array_search($char, $tmp, true);
                $tmp = array_slice($tmp, $search + 1);
            }
            $tmp[] = $char;
            $current = count($tmp);
            if ($current > $max) {
                $max = $current;
            }
        }

        return $max;
    }
}

$tests = [
    ["aab", 2],
    ["abcabcbb", 3],
    ["bbbbb", 1],
    ["pwwkew", 3],
    ["", 0],
    [" ", 1],
    ["au", 2],
];

foreach ($tests as $arr) {
    $a = (new Solution())->lengthOfLongestSubstring($arr[0]);
    echo $arr[0].':'.$arr[1].':'.$a.' => ';
    echo ($a === $arr[1]) ? 'ok' : '不一樣捏';
    echo PHP_EOL;
}
