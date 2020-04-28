<?php

class Sign
{
    private const GAS_POST_SIGN_SALT = 'MTUyNTMxOTliNDdkNDQ3Ng==';
    private const GAS_ENDPOINT_URL = 'https://script.google.com/macros/s/12345678/exec';

    public function newSalt() : string
    {
        $bytes = random_bytes(8);
        $hex = bin2hex($bytes);
        return base64_encode($hex);
    }

    public function signature($data): string
    {
        unset($data['_token']);
        ksort($data);
        $col = [];
        foreach ($data as $k => $v) {
            $col[] = $k.'='.$v;
        }
        $t = time();
        $body = implode('|', $col).'||'.self::GAS_POST_SIGN_SALT.'@'.$t;
        return hash('sha256', $body).dechex($t);
    }

    public function getPostBody($data)
    {
        $data['_datetime'] = date('Y-m-d H:i:s');
        $data['_token'] = $this->signature($data);
        return $data;
    }
}
