<?php

function createDateRange($startDate, $endDate, $format = 'Y-m-d')
{
    $begin = new DateTime($startDate);
    $endPlusOne = date($format, strtotime('+1 day', strtotime($endDate)));
    $end = new DateTime($endPlusOne);

    $interval = new DateInterval('P1D'); // 1 Day
    $dateRange = new DatePeriod($begin, $interval, $end);

    $range = [];
    foreach ($dateRange as $date) {
        $range[] = $date->format($format);
    }

    return $range;
}
$dates = createDateRange("2015-02-25", "2015-03-05");
var_dump($dates);