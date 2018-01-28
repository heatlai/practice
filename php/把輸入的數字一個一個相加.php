<?php

function sum_num($num)
{
    $length = strlen($num);
    $result = 0;
    
    for ($i=0; $i < $length; $i++) 
    { 
        $result += substr($num, $i, 1);
    }
    return $result;
}

$num = 123456789;
echo sum_num($num);