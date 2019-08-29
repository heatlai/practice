<?php

/**
 * 找出買賣價格週期最佳利潤
 * profit = 10(賣出點) - 5(買進點) = 5
 */
$arr = [9, 11, 8, 5, 7, 10];
print_r(buy_and_sell($arr));

function buy_and_sell($arr) {
    $count = count($arr);
    $min = $arr[0];
    $max = $arr[0];
    $maxProfit = 0;
    $buy = $arr[0];
    for ($i = 1; $i < $count; $i++)
    {
        $current = $arr[$i];

        if( $current < $min ) {
            $min = $current;
        } else {
            $profit = $current - $min;
            if( $profit > $maxProfit )
            {
                $buy = $min;
                $max = $current;
                $maxProfit = $profit;
            }
        }
    }
    return ['buy' => $buy, 'sell' => $max, 'profit' => $maxProfit];
}