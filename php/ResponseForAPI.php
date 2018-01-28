<?php

# 成功
function successResponse($data)
{
    $res = array(
        'status' => 'ok',
        'data' => $data,
    );
    $resJSON = json_encode($res, JSON_UNESCAPED_UNICODE);
    echo $resJSON;
    exit;
}

# 失敗
function errorResponse($data)
{
    $res = array(
        'status' => 'failed',
        'error' => $data,
    );
    $resJson = json_encode($res, JSON_UNESCAPED_UNICODE);
    echo $resJson;
    exit;
}