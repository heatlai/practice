<?php

/**
 * @param string $key
 * @param string|array $value
 * @return string|false
 */
function encrypt($key, $value)
{
    $serialized = serialize($value);
    $iv = random_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($serialized, 'aes-256-cbc', $key, 0, $iv);
    return base64_encode($encrypted.'::'.$iv);
}

/**
 * @param string $key
 * @param string $garble
 * @return string|array|false
 */
function decrypt($key, $garble)
{
    $exploded = explode('::', base64_decode($garble), 2);
    [$encrypted, $iv] = $exploded;
    $serialized = openssl_decrypt($encrypted, 'aes-256-cbc', $key, 0, $iv);
    return unserialize($serialized);
}

echo $encode = encrypt("secure_key", "gg3be0").PHP_EOL; // encrypted payload
echo $decode = decrypt("secure_key", $encode); // print gg3be0
