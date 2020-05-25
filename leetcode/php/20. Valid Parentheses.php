<?php

class Solution
{
    /**
     * @param  String  $s
     * @return Boolean
     */
    function isValid($s)
    {
        $signs = [
            ')' => '(',
            ']' => '[',
            '}' => '{',
        ];
        $len = strlen($s);
        $txt = '';
        for ($i = 0; $i < $len; ++$i) {
            $char = $s[$i];
            if (isset($signs[$char])) {
                $last_char = substr($txt, -1);
                if ($last_char === $signs[$char]) {
                    $txt = substr($txt, 0, -1);
                } else {
                    return false;
                }
            } else {
                $txt .= $char;
            }
        }
        return $txt === '';
    }
}

class Solution2
{

    /**
     * @param  String  $s
     * @return Boolean
     */
    function isValid($s)
    {
        // empty string
        if ($s === '') {
            return true;
        }

        $stack = [];
        foreach (str_split($s) as $v) {
            // 遇到左括號就加個對應的右括號進 stack
            // stack 裡只會有右括號 [ ")", "]", "}" ]
            if ($v === '(') {
                $stack[] = ')';
            } elseif ($v === '[') {
                $stack[] = ']';
            } elseif ($v === '{') {
                $stack[] = '}';
            // 不是空陣列就代表先出現了右括號，那格式就直接錯了
            // 或者 stack pop 出來的右括號 跟 當前右括號 不一樣 代表不對稱
            } elseif ( 0 === count($stack) || ($v !== array_pop($stack))) {
                return false;
            }
        }

        // 最後陣列要是空的才正確
        return count($stack) === 0;
    }
}

$tests = [
    [
        "()",
        true,
    ],
    [
        "()[]{}",
        true,
    ],
    [
        "(]",
        false,
    ],
    [
        "([)]",
        false,
    ],
    [
        "{[]}",
        true,
    ]
];

foreach ($tests as $arr) {
    $res = (new Solution())->isValid($arr[0]);
    echo $arr[0].':'.($arr[1] ? 'true' : 'false').':'.($res ? 'true' : 'false').' => ';
    echo ($res === $arr[1]) ? 'ok' : '不一樣捏';
    echo PHP_EOL;
}
