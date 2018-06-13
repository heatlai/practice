<?php
// 全域有效, 設定時只能在 script 開頭 否則會報錯
declare(strict_types=1);

function testStrict(int $a)
{
    var_dump($a);
}

$str = '123abc';
try
{
    testStrict($str);
}
catch( \TypeError $e)
{
    echo $e->getMessage();
}

// result : Argument 1 passed to testStrict() must be of the type integer, string given