<?php

namespace Model\Traits;

/**
 * Trait IncrementAndDecrement
 * 加加和減減
 * @package Model\Traits
 */
trait IncrementAndDecrement
{
    public static function increment($id, $columnName, int $amount = 1)
    {
        if( $amount < 1 )
        {
            return false;
        }

        $entry = self::find($id);

        if( $entry === null )
        {
            return false;
        }

        $entry->$columnName += $amount;
        $entry->save();
        return $entry->$columnName;
    }

    public static function decrement($id, $columnName, int $amount = 1)
    {
        if( $amount < 1 )
        {
            return false;
        }

        $entry = self::find($id);

        if( $entry === null )
        {
            return false;
        }

        $count = $entry->$columnName - $amount;
        $entry->$columnName = ( $count > 0 ) ? $count : 0;
        $entry->save();
        return $entry->$columnName;
    }

    public static function incrementWithoutUpdateTime($id, $columnName, int $amount = 1)
    {
        if( $amount < 1 )
        {
            return false;
        }

        $data = array(
            $columnName => DB::expr("`{$columnName}` + {$amount}"),
        );

        $query = DB::update(self::table())
            ->where('id', '=', $id)
            ->set($data);

        return $query->execute();
    }

    public static function decrementWithoutUpdateTime($id, $columnName, int $amount = 1)
    {
        if( $amount < 1 )
        {
            return false;
        }

        $data = array(
            $columnName => DB::expr("IF(`{$columnName}` = 0 OR (`{$columnName}` - {$amount}) < 0 , 0, `{$columnName}` - {$amount})"),
        );

        $query = DB::update(self::table())
            ->where('id', '=', $id)
            ->set($data);

        return $query->execute();
    }
}