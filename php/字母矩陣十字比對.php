<?php

/**
 * 輸入 字母矩陣 和 字串 比對 橫向 或 直向 是否與字串相符
 */
$matrix = [
    ['F', 'A', 'C', 'I'],
    ['O', 'B', 'Q', 'P'],
    ['A', 'N', 'O', 'B'],
    ['M', 'A', 'S', 'S'],
];

var_dump(word_search($matrix, 'FACI')); // true
var_dump(word_search($matrix, 'FOAM')); // true
var_dump(word_search($matrix, 'ABNA')); // true
var_dump(word_search($matrix, 'ANOB')); // true
var_dump(word_search($matrix, 'ABNB')); // false

/**
 * @param $matrix
 * @param $word
 * @return bool
 */
function word_search($matrix, $word)
{
    foreach ($matrix as $index => $row)
    {
        $leftRightWord = implode($row);
        if( $leftRightWord === $word )
        {
            return true;
        }

        $topBottomWord = implode(array_column($matrix, $index));
        if( $topBottomWord === $word )
        {
            return true;
        }
    }

    return false;
}