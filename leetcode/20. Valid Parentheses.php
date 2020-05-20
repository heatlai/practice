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
