<?php

/**
 * preg_match 命名捕獲
 * Named Capturing Group
 * 可以不用管捕獲的順序數字 自訂捕獲名稱
 */

$urls = [
    '/shop/5566/singer',
    '/shop/9487/agent',
    '/shop/7788/result',
    '/shop/6666/shop',
];

foreach ($urls as $url) {
    if (preg_match("/\/shop\/(?P<shopId>\d+)\/(?P<type>\S+)/", $url, $matches)) {
        echo $matches['shopId'] . ':' . $matches['type'] . PHP_EOL;
    }
}

echo '---'.PHP_EOL;

// 排除 type 是 result 的情況
foreach ($urls as $url) {
    if (preg_match("/\/shop\/(?P<shopId>\d+)\/(?P<type>(?!result)\S+)/", $url, $matches)) {
        echo $matches['shopId'] . ':' . $matches['type'] . PHP_EOL;
    } else {
        echo $url.' => not match.' . PHP_EOL;
    }
}

echo '---'.PHP_EOL;

/**
 * 進階應用 ?P=named_group
 * 先捕獲 ?P<named_group> 在後面可直接用 (?P=named_group) 使用 ?P<named_group> 捕獲的結果
 */
// good 要出現兩次
if (preg_match("/(?P<named_group>good)[a-z ]+(?P=named_group)/", "good is good", $matches)) {
    var_dump($matches);
} else {
    var_dump('not good');
}
if (preg_match("/(?P<named_group>good)[a-z ]+(?P=named_group)/", "good is bad", $matches)) {
    var_dump($matches);
} else {
    var_dump('not good');
}