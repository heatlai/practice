<?php

class TimeTool
{
    public static function convertTimeZone(
        string $dateTime,
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
}