<?php
function arrayMode($sequence)
{
    //統計值出現的次數 例如 1 出現 5次 array('1' => 5)
    $count_values = array_count_values($sequence);
    //找出統計最多的次數
    $count_max = max($count_values);
    //用最多的次數找它的key值
    $result = array_keys($count_values, $count_max);
    //結果: array('0' = > 'key')
    return $result[0];
}

$array = array(1, 3, 3, 3, 1, 2, 2, 3, 3, 3, 2);
echo arrayMode($array);