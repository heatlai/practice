<?php

$start = 3;
$first = 1;
$second = 1;
$current = 0;

echo "第 1 個月 有 {$first} 對<br>";
echo "第 2 個月 有 {$second} 對<br>";

for ($i = $start; $i <= 36; $i++)
{ 
    $current = $first + $second;
    $first = $second;
    $second = $current;
    echo "第 {$i} 個月 有 {$current} 對<br>";
}