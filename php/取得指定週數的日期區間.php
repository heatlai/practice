<?php

function getFirstDayOfWeek( $year, $week )
{
    $first_day      = strtotime($year . "-01-01");
    $is_monday      = date("w", $first_day) == 1;
    $week_one_start = ! $is_monday ? strtotime("last monday", $first_day) : $first_day;
    return $year . '年, 第' . $week . '周, Start：' . date('Y-m-d', $week_one_start + (3600 * 24 * 7 * ($week - 1))) . ' , End：' . date('Y-m-d', $week_one_start + ((3600 * 24) * (7 * ($week - 1) + 6)));
}