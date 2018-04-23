<?php

/**
 * arrayPartition
 *
 * @param array $data 資料
 * @param int $partAmount 分區數
 * @param bool $pad 是否補滿分區數
 *
 * @return array
 *
 * @author Heat <hitgunlai@gmail.com>
 */
function arrayPartition( array $data, int $partAmount, bool $pad = true ) : array
{
    // 資料總數
    $dataCount = count( $data );
    // 每分區要幾筆 無條件捨去
    $perPart = (int) floor( $dataCount / $partAmount );
    // 餘數
    $remainder = $dataCount % $partAmount;

    // 特殊情況 資料是空陣列
    if ( $dataCount === 0 )
    {
        if ( $pad )
        {
            $result = array_fill( 0, $partAmount, array() );
        }
        else
        {
            $result = array();
        }
    }
    // 餘數 == 0 / 餘數 == 分區數 - 1 / 分區數 >= 資料總數 這幾種狀況可以加速
    elseif ( $remainder === 0 || $remainder == $partAmount - 1 || $partAmount >= $dataCount )
    {
        $perPartPlus = ( $remainder > 0 ) ? 1 : 0;
        $result = array_chunk( $data, $perPart + $perPartPlus );

        // 補滿分區數 & 分區數 > 資料總數
        if ( $pad && $partAmount > $dataCount )
        {
            $result = array_merge( $result, array_fill( 0, $partAmount - $dataCount, array() ) );
        }
    }
    // 0 < 餘數 && 餘數 < ( 分區數 - 1 ) && 分區數 < 資料總數
    else
    {
        // 計算消耗餘數的 offset
        $remainderOffset = $remainder * ( $perPart + 1 );

        // 先用 offset 取得 有使用餘數 的分區
        $result = array_chunk( array_slice( $data, 0, $remainderOffset ), $perPart + 1 );

        // 後加上 offset 之後的 沒有使用餘數 的分區
        $result = array_merge( $result, array_chunk( array_slice( $data, $remainderOffset ), $perPart ) );
    }
    return $result;
}