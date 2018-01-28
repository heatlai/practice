<?php
/**
 * @todo QueryString(GET參數)加解密
 * @example 加密 QueryStringEncrypt::encryptQueryString($str);
 * @example 解密 QueryStringEncrypt::decryptQueryString($_SERVER['QUERY_STRING']);
 */

class QueryStringEncrypt
{
    //加解密標記
    public static $salt = 'password';

    //加密
    public static function encryptQueryString($str)
    {
        return rawurlencode( base64_encode( self::encrypt($str, self::$salt) ) );
    }

    //解密
    public static function decryptQueryString($str)
    {
        $str = self::decrypt_url($str, self::$salt);
        $url_array = explode('&', $str);
        if ( is_array($url_array) )
        {
            foreach ($url_array as $var)
            {
                $var_array = explode("=", $var);
                $vars[$var_array[0]] = $var_array[1];
            }
        }
        return $vars;
    }

    public static function keyED($txt, $salt)
    {
        $encrypt_key = md5($salt);
        $ctr = 0;
        $tmp = "";
        for($i = 0;$i < strlen($txt); $i++)
        {
            if ($ctr == strlen($encrypt_key))
            {
                $ctr = 0;
            }

            $tmp .= substr($txt, $i, 1) ^ substr($encrypt_key, $ctr, 1);
            $ctr++;
        }
        return $tmp;
    }

    public static function encrypt($txt, $salt)
    {
        $encrypt_key = md5(mt_rand(0, 100));
        $ctr = 0;
        $tmp = "";
        for ($i = 0; $i < strlen($txt); $i++)
        {
            if ( $ctr == strlen($encrypt_key) )
            {
                $ctr = 0;
            }

            $tmp .= substr($encrypt_key, $ctr, 1) . (substr($txt, $i, 1) ^ substr($encrypt_key, $ctr, 1));
            $ctr++;
        }
        return self::keyED($tmp, $salt);
    }

    public static function decrypt($txt, $salt)
    {
        $txt = self::keyED($txt, $salt);
        $tmp = "";
        for($i = 0; $i < strlen($txt); $i++)
        {
            $md5 = substr($txt, $i, 1);
            $i++;
            $tmp .= (substr($txt, $i, 1) ^ $md5);
        }
        return $tmp;
    }

    public static function decrypt_url($str, $salt)
    {
        return self::decrypt( base64_decode( rawurldecode($str) ), $salt);
    }
}
