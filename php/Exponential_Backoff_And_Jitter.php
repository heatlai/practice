<?php

/**
 * 指數退避 + 抖動
 * Exponential Backoff And Jitter
 */
$cap = 1000 * 15; // 15 sec 最大等待時間
$base = 100; // ms 基本等待時間
$max_retries = 10; // 最大重試次數
$attempt = 0; // 目前嘗試次數

do {
    echo PHP_EOL;
    echo "第 ${attempt} 次 getStatus".PHP_EOL;

    $status = getStatus();

    echo ($status ?: 'NULL')." => ";

    if ($status === 'SUCCESS') {
        $retry = false;
    } elseif ($status === 'NOT_READY') {
        $retry = true;
    } elseif ($status === 'THROTTLED') {
        $retry = true;
    } else {
        error_log('Some other error occurred, so stop calling the API.');
        $retry = false;
    }

    if ($retry) {
        // 抖動值
        $jitter = min($cap, $base * 2 ** $attempt++);
        // Full Jitter 全抖動
        $sleep_ms = random_int(0, $jitter);
        echo "抖動值: ${jitter} , 睡 ${sleep_ms} ms";
        usleep($sleep_ms);
    }
} while ($retry && ($attempt <= $max_retries));

function getStatus($num = null)
{
    $array = ['SUCCESS', 'NOT_READY', 'THROTTLED'];
    return $array[$num ?? random_int(0, count($array) - 1)];
}
