<?php

//開陣列
//$rand = array();
//$rand_result = array();

//數字範圍 1 ~ 100
$rand = range(1, 100);

//for($i = 1; $i <=100 ; $i++)
//{
//    $rand[] = $i;
//}

//陣列隨機排序
//shuffle($rand);

//要取幾個數字
//$rand_result = array_slice($rand, 0, 5);

//for($i = 0; $i < 5 ; $i++)
//{
//    $rand_result[$i] = $rand[$i];
//}

//砍掉$rand
//unset($rand);

$rand_result = array_rand($rand, 5);

//輸出結果
print_r($rand_result);
