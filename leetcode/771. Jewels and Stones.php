<?php

class Solution
{
    /**
     * @param  String  $J
     * @param  String  $S
     * @return Integer
     */
    function numJewelsInStones($J, $S)
    {
        $length = strlen($J);
        $count = 0;

        for ($i = 0; $i < $length; $i++) {
            $char = $J[$i];

            $count += substr_count($S, $char);
        }

        return $count;
    }
}
