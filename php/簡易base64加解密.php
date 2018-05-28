<?php

/**
 * Class SimpleBase64Encrypt
 *
 * 以base64編碼重組排序，簡易的加解密
 * 沒特別資安需求，只是不想被明碼擷取
 * 沒有salt 不適合放在JS 小心被偷加解密邏輯
 *
 * @author Heat <hitgunlai@gmail.com>
 */
class SimpleBase64Encrypt
{
    public static function encrypt($data) : string
    {
        $str = strrev(rtrim(strtr(base64_encode(serialize($data)),['+' => '-', '/' => '_']), '='));
        $strlen = (int) ceil( strlen($str) / 2 );
        return implode(array_reverse(str_split($str, $strlen)));
    }

    public static function decrypt(string $encryptBase64String)
    {
        $strlen = (int) floor( strlen($encryptBase64String) / 2 );
        $input = strtr(strrev( substr($encryptBase64String, $strlen) . substr($encryptBase64String, 0, $strlen) ), ['-' => '+', '_' => '/']);
        return unserialize(base64_decode($input . str_repeat ( '=' , strlen($input) % 4 )));
    }
}