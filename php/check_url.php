<?php

$url = 'https://heat.hypenode.tw';
echo is_working_url($url) ? "{$url} is working." : "{$url} is down.";

function is_working_url($url) {
    $handle = curl_init($url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true); // return 結果，不要直接輸出在畫面上
    curl_setopt($handle, CURLOPT_NOBODY, true); // 不要 response body (會發出 HEAD method request)
    curl_setopt($handle, CURLOPT_FOLLOWLOCATION, true); // 要跟隨轉址(http code 30x)
    // curl_setopt($handle, CURLOPT_USERAGENT, "Google Bot"); //設定AGENT
    curl_exec($handle);

    $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);

    curl_close($handle);

    if ($httpCode >= 200 && $httpCode < 300) {
        return true;
    }
    else {
        return false;
    }
}
