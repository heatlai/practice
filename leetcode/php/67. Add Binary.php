<?php

// String
class Solution
{
    /**
     * @param  String  $a
     * @param  String  $b
     * @return String
     */
    function addBinary($a, $b)
    {
        $res = '';
        $plus = 0;

        for ($i = strlen($a) - 1, $j = strlen($b) - 1; $i >= 0 || $j >= 0; --$i, --$j) {
            $t_a = ($i >= 0 ? $a[$i] : 0);
            $t_b = ($j >= 0 ? $b[$j] : 0);
            $t = $t_a + $t_b + $plus;
            $plus = ($t > 1) ? 1 : 0;
            $res = ($t % 2).$res;
        }

        return $plus ? $plus.$res : $res;
    }
}

// Array
class Solution2 {

    /**
     * @param String $a
     * @param String $b
     * @return String
     */
    function addBinary($a, $b)
    {
        $arr_a = str_split($a);
        $arr_b = str_split($b);
        $base_arr = (strlen($a) > strlen($b)) ? $arr_a : $arr_b;

        $res = '';
        $plus = 0;
        foreach ($base_arr as $v) {
            $pop_a = array_pop($arr_a);
            $pop_b = array_pop($arr_b);
            $t = $pop_a + $pop_b + $plus;
            $plus = ($t > 1) ? 1 : 0;
            $res = ($t % 2).$res;
        }

        return $plus ? $plus.$res : $res;
    }
}


echo (new Solution2())->addBinary('11', '1').PHP_EOL;
echo (new Solution2())->addBinary('1010', '1011').PHP_EOL;
echo (new Solution2())->addBinary('1111', '1111').PHP_EOL;
