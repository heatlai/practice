<?php

class Solution
{
    /**
     * @param  String[]  $strs
     * @return String
     */
    function longestCommonPrefix($strs)
    {
        $first = $strs[0];
        $len = strlen($first);
        $strs_len = count($strs);
        $res = '';
        for ($i = 0; $i < $len; ++$i) {
            $char = $first[$i];
            for ($j = 1; $j < $strs_len; ++$j) {
                if ($strs[$j][$i] !== $char) {
                    return $res;
                }
            }
            $res .= $char;
        }
        return $res;
    }
}

$tests = [
    [
        ["flower", "flow", "flight"],
        "fl",
    ],
    [
        ["dog", "racecar", "car"],
        "",
    ],
];

foreach ($tests as $arr) {
    $res = (new Solution())->longestCommonPrefix($arr[0]);
    echo json_encode($arr[0], JSON_THROW_ON_ERROR, 512).':'.$arr[1].':'.$res.' => ';
    echo ($res === $arr[1]) ? 'ok' : '不一樣捏';
    echo PHP_EOL;
}
