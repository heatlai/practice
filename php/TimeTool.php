<?php

class TimeTool
{
    public static function convertTimeZone(
        string $dateTime = "now",
        string $toTimeZone = 'Asia/Taipei',
        string $fromTimeZone = 'UTC'
    )
    {
        $fromTZ = new DateTimeZone( $fromTimeZone );
        $toTZ = new DateTimeZone( $toTimeZone );
        $date = new DateTime( $dateTime, $fromTZ );
        $date->setTimezone( $toTZ );
        return $date->format( 'Y-m-d H:i:s' );
    }

    public static function getDateInterval(string $to, string $from = 'now')
    {
        $toDate = new DateTime($to);
        $fromDate = new DateTime($from);
        $interval = $fromDate->diff($toDate);
        return $interval->format('%R%a');
    }
}