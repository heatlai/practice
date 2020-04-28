<?php

/**
 * Google App Script API curl example
 */

define('GOOGLE_APP_SCRIPT_API', 'https://script.google.com/macros/s/12345678/exec');

$param = array('name' => 'SuperSaiyan', 'location' => 'earth', 'status' => 'gg3be0');

var_dump(get($param));
var_dump(post($param));

function get(array $queryParams) {
    $curl = curl_init();
    $queryString = http_build_query($queryParams);

    curl_setopt_array($curl, array(
        CURLOPT_URL => GOOGLE_APP_SCRIPT_API.'?'.$queryString,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_FOLLOWLOCATION => true, // 這個一定要
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    // < 7.3.0
    $decoded = json_decode($response, true);
    if( json_last_error() === JSON_ERROR_NONE ) {
        return $decoded;
    } else {
        throw new \RuntimeException(json_last_error_msg());
    }

    // >= 7.3.0 throw JsonException
    // return json_decode($response, true, 512,JSON_THROW_ON_ERROR);
}

function post(array $postData) {
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => GOOGLE_APP_SCRIPT_API,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_FOLLOWLOCATION => true, // 這個一定要
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_POSTFIELDS => $postData,
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    // < 7.3.0
    $decoded = json_decode($response, true);
    if( json_last_error() === JSON_ERROR_NONE ) {
        return $decoded;
    } else {
        throw new \RuntimeException(json_last_error_msg());
    }

    // >= 7.3.0 throw JsonException
    // return json_decode($response, true, 512,JSON_THROW_ON_ERROR);
}


