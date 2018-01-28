<?php

//氣泡排序法
function bubble_sort($array)
{
    $num = count($array);
    
    // Loop 1
    for($i = 0 ; $i < $num ; $i++)
    {
        // Loop 2
        // 從第一個數字往後比較，如果前項比較小就交換
        for($j = 1; $j < $num ; $j++)
        {
            if($array[$j] > $array[$j-1])
            {
                //交換兩個數值的小技巧，用list+each
                list($array[$j-1] , $array[$j]) = array($array[$j] , $array[$j-1]);
            }
        }
    }
    return $array;
}