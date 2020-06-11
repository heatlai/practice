<?php

/**
 * 指數退避 + 抖動
 * Exponential Backoff And Jitter
 */

// 最大等待時間 微秒(μs)
$cap = 1000 * 1000 * 5; // 5 sec
// 基本等待時間 微秒(μs)
$base = 1000 * 10; // 10 ms
// 最大重試次數
$max_retries = 10;
// 目前嘗試次數
$attempt = 0;
// 累計等待時間
$total_wait = 0;

do {
    echo "第 ${attempt} 次重試".PHP_EOL;

    // Full Jitter 全抖動
    $wait_time = min($cap, $attempt === 0 ? 0 : $base * 2 ** $attempt);
    $sleep_micro_seconds = random_int(0, $wait_time);
    $total_wait += $sleep_micro_seconds;
    echo "=> 最大等待時間: ".round($wait_time / 1000)." ms, 睡 ".round($sleep_micro_seconds / 1000)." ms".PHP_EOL;
    usleep($sleep_micro_seconds);

    // do something
    $status = getStatus(1);

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
} while ($retry && ($attempt++ < $max_retries));

echo "總共等待時間: ".round($total_wait / 1000)." ms";

function getStatus($num = null)
{
    $array = ['SUCCESS', 'NOT_READY', 'THROTTLED', null];
    return $array[$num ?? random_int(0, count($array) - 1)];
}
