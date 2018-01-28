<?php
set_time_limit(2000);

$st = getMicrotime();

// 資料來源 $data
require_once 'data.php'; 
// $data = array(-761,-538,-1724,2631,-7633,-2459,-7393,-6571,7242,1943,-4345,8966,-5901,-2758,-4411,3143,4511,5830,3638,-2579);

pre_print_r(test2($data));

$et = getMicrotime();

echo '執行時間 ', $et - $st , '秒';

function test1($a)
{
    $end = count($a);

    $max = $a[0];

    $temp = 0;
    $start_key = 0;
    $end_key = 0;

    $final = array(
        'start' => '',
        'end' => '',
        'max' => ''
    );
        
    for ($i = 0; $i < $end; $i++)
    {
        if ($a[$i] < 0)
        {
            continue;   
        }

        $temp = 0;
        $start_key = $i;
        $end_key = 0;

        for ($j = $i; $j < $end; $j++)
        {
            $temp += $a[$j];

            if ($temp < 0)
            {
                break;
            }

            if ($temp > $max)
            {
                $max = $temp;
                $end_key = $j;
            }
        }

        if($end !== 0)
        {
            $current = array('start' => $start_key,'end' => $end_key,'max' => $max);
            if ($current['max'] > $final['max'])
            {
                $final = $current;
            }
        }
    }
}

function test2($a)
{
    $end = count($a);

    $max = 0;
    $temp = 0;

    $start_key = 0;
    $end_key = 0;

    $start_val = 0;
    $end_val = 0;

    for ($i = 0; $i < $end; $i++)
    {
        $temp += $a[$i];

        if ($temp > $max)
        {
            $max = $temp;
            $end_key = $i;
            $end_val = $a[$i];
        }
        elseif ($temp < 0)
        {
            $temp = 0;
            $start_key = $i + 1;
            $start_val = $a[$i+1];
        }
    }

    return array('start_key' => $start_key,'end_key' => $end_key,'max' => $max,'start_val' => $start_val, 'end_val' => $end_val);
}

function pre_print_r($input)
{
    echo '<pre>';
    print_r($input);
    echo '</pre>';
}

function getMicrotime()
{
    $arr = explode(" ",microtime());
    return $arr[0] + $arr[1];
}