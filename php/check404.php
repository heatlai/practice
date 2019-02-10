<?php

$url = 'https://stackoverflow.com/';

$handle = curl_init($url);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

/* Get the HTML or whatever is linked in $url. */
$response = curl_exec($handle);

/* Check for 404 (file not found). */
$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);

if ($httpCode == 404) {
    /* Handle 404 here. */
    echo "It's 404.";
}

curl_close($handle);

var_dump($httpCode);