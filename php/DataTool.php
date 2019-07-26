<?php

class DataTool
{
    // DB data 的 columnName 從 SnakeCase 轉 CamelCase
    public static function dataToCamelCase( array $dbData ) : array
    {
        $data = array();
        foreach ( $dbData as $columnName => $columnValue )
        {
            // 處理多維陣列
            if ( \is_array($columnValue) && ! empty($columnValue) )
            {
                $columnValue = self::dataToCamelCase($columnValue);
            }

            $data[self::snakeToCamelCase($columnName)] = $columnValue;
        }
        return $data;
    }

    // DB data 用 Primary / Unique Key 去重複
    public static function uniqueData( array $dbData, string $uniqueKey = 'id' ) : array
    {
        return array_values(array_column($dbData, null, $uniqueKey));
    }

    // SnakeCase 轉 CamelCase
    public static function snakeToCamelCase( $string, $capitalizeFirstCharacter = false ) : string
    {

        $str = str_replace('_', '', ucwords($string, '_'));

        if ( ! $capitalizeFirstCharacter )
        {
            $str = lcfirst($str);
        }

        return $str;
    }

    // CamelCase 轉 SnakeCase
    public static function camelCaseToSnakeCase( string $string ) : string
    {
        return strtolower(preg_replace(['/([a-z\d])([A-Z])/', '/([^_])([A-Z][a-z])/'], '$1_$2', $string));
    }

    // 取得 array 內重複的 value
    public static function duplicatesInArray( array $haystack, bool $strict = false ) : array
    {
        return array_unique( array_diff_assoc( $haystack, array_unique( $haystack, $strict ) ), $strict );
    }

    // 取 array 內完全不重複的 value
    public static function realUniqueInArray( array $haystack ) : array
    {
        return array_diff($haystack, array_diff_assoc($haystack, array_unique($haystack)));
    }

    // 取 array 內第一個不重複的 value
    public static function firstUniqueInArray(array $haystack)
    {
        return array_search(1, array_count_values($haystack), true);
    }
}