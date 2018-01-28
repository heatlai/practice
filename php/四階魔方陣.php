<?php
set_time_limit(1000);
//4*4 魔方陣 總共符合條件 7040種
//程式開始時間
$st = time();
//最大數字
$max = 16;
//計算次數累積
$total = 0;
//總結果陣列
$total_square = array();

//執行產生魔方陣
step_one();

//印出陣列
foreach ($total_square as $key => $item)
{
    echo 'This is ', $key + 1, ' : <br>';
    foreach ($item as $key2 => $row)
    {
        foreach ($row as $key3 => $col)
        {
            echo ($key3 != 3) ? sprintf(" %02d |", $col) : sprintf(" %02d ", $col);
        }
        echo '<br>';
    }
    echo '<hr>';
}

//結束時間
$et = time();

echo '總共', count($total_square) , '種結果<br>';
echo '執行時間 ', $et - $st , '秒<br>';
echo "計算{$total}次";

die();

/**
 *  A B C D
 *  E F G H
 *  I J K L
 *  M N O P
 */
//第一階段 填ABC 得到 D
function step_one()
{   
    //最大數字
    $max = $GLOBALS['max'];

    // A 迴圈
    for ($row0_0 = 1; $row0_0 <= $max; $row0_0++)
    {
        //初始化當前陣列 清除上一圈計算結果
        $square = array();

        // 填入 A
        $square[0][0] = $row0_0;

        // B 迴圈
        for ($row0_1 = 1; $row0_1 <= $max; $row0_1++)
        {   
            //重置 B C D 清除上一圈計算結果
            $square[0][1] = 0;
            $square[0][2] = 0;
            $square[0][3] = 0;

            //檢查 B 不重複
            if (!in_multi_array($row0_1,$square))
            {
                //填入 B
                $square[0][1] = $row0_1;
                
                // C 迴圈
                for ($row0_2 = 1; $row0_2 <= $max; $row0_2++)
                { 
                    //重置 C D 清除上一圈計算結果
                    $square[0][2] = 0;
                    $square[0][3] = 0;

                    //檢查 C 不重複
                    if (!in_multi_array($row0_2,$square))
                    {
                        //填入 C
                        $square[0][2] = $row0_2;
                        //用 34 - A - B - C 算出 D 結果
                        $row0_3 = 34 - array_sum($square[0]);

                        //檢查 0 < D 結果 < 17 且不重複 
                        if (0 < $row0_3 && $row0_3 < 17 && !in_multi_array($row0_3,$square))
                        {
                            //填入 D
                            $square[0][3] = $row0_3;
                            //執行第二階段
                            $square_next = step_two($square);

                            // if ($square_next === FALSE) continue;
                            // $square = $square_next;
                            // return $square;
                            // $total_square[] = $square_next;
                        }
                    }
                }
            }
        } 
    }
    return FALSE;
}
//第二階段 填EFG 得到 H
function step_two($square)
{
    //最大數字
    $max = $GLOBALS['max'];

    // E 迴圈
    for ($row1_0 = 1; $row1_0 <= $max; $row1_0++)
    {
        //用第一階段結果初始化第二階段 清除上一圈計算結果
        $temp = $square;

        //檢查 E 不重複
        if (!in_multi_array($row1_0,$temp))
        {
            //填入 E
            $temp[1][0] = $row1_0;

            // F 迴圈
            for ($row1_1 = 1; $row1_1 <= $max; $row1_1++)
            {
                //重置 F G H 清除上一圈計算結果
                $temp[1][1] = 0;
                $temp[1][2] = 0;
                $temp[1][3] = 0;

                //檢查 F 不重複
                if (!in_multi_array($row1_1,$temp))
                {
                    //填入 F
                    $temp[1][1] = $row1_1;

                    // G 迴圈
                    for ($row1_2 = 1; $row1_2 <= $max; $row1_2++)
                    {
                        //重置 G H 清除上一圈計算結果
                        $temp[1][2] = 0;
                        $temp[1][3] = 0;

                        //檢查 G 不重複
                        if (!in_multi_array($row1_2,$temp))
                        {
                            //填入 G
                            $temp[1][2] = $row1_2;
                            //用 34 - E - F - G 算出 H 結果
                            $row1_3 = 34 - array_sum($temp[1]);

                            //檢查 0 < H 結果 < 17 且不重複
                            if (0 < $row1_3 && $row1_3 < 17 && !in_multi_array($row1_3,$temp))
                            {
                                //填入 H
                                $temp[1][3] = $row1_3;
                                //執行第三階段
                                $square_next = step_three($temp);

                                // if ($square_next === FALSE) continue;
                                // $temp = $square_next;
                                // return $temp;
                            }
                        }
                    }
                }
            }
        } 
    }
    return FALSE;
}
//第三階段 填 I 得到 M J N
function step_three($square)
{
    //最大數字
    $max = $GLOBALS['max'];

    // I 迴圈
    for ($row2_0 = 1; $row2_0 <= $max; $row2_0++)
    { 
        //用第二階段結果初始化第三階段 清除上一圈計算結果
        $temp = $square;

        //檢查 I 不重複
        if (!in_multi_array($row2_0, $temp))
        {
            //填入 I
            $temp[2][0] = $row2_0;
            //用 34 - A - E - I 算出 M 結果
            $row3_0 = 34 - $temp[0][0] - $temp[1][0] - $temp[2][0];

            //檢查 0 < M 結果 < 17 且不重複
            if (0 < $row3_0 && $row3_0 < 17 && !in_multi_array($row3_0,$temp))
            {
                //填入 M
                $temp[3][0] = $row3_0;
                //用 34 - D - G - M 算出 J 結果
                $row2_1 = 34 - $temp[3][0] - $temp[1][2] - $temp[0][3];

                //檢查 0 < J 結果 < 17 且不重複
                if (0 < $row2_1 && $row2_1 < 17 && !in_multi_array($row2_1,$temp))
                {
                    //填入 J
                    $temp[2][1] = $row2_1;
                    //用 34 - B - F - J 算出 N 結果
                    $row3_1 = 34 - $temp[0][1] - $temp[1][1] - $temp[2][1];

                    //檢查 0 < N 結果 < 17 且不重複
                    if (0 < $row3_1 && $row3_1 < 17 && !in_multi_array($row3_1,$temp))
                    {
                        //填入 N
                        $temp[3][1] = $row3_1;
                        //執行第四階段
                        $square_next = step_four($temp);

                        // if ($square_next === FALSE) continue;
                        // $square = $square_next;
                        // return $square;
                    }
                }
            }
        }
    }   
    return FALSE;
}

//第四階段 填 K 得到 L O P
function step_four($square)
{
    //最大數字
    $max = $GLOBALS['max'];

    // K 迴圈
    for ($row2_2 = 1; $row2_2 <= $max; $row2_2++)
    { 
        //用第三階段結果初始化第四階段 清除上一圈計算結果
        $temp = $square;
        //累積第四階段計算次數
        $GLOBALS['total']++;

        //檢查 K 不重複
        if (!in_multi_array($row2_2, $temp))
        {
            //填入 K
            $temp[2][2] = $row2_2;
            //用 34 - I - J - K 算出 L 結果
            $row2_3 = 34 - array_sum($temp[2]);

            //檢查 0 < L 結果 < 17 且不重複
            if (0 < $row2_3 && $row2_3 < 17 && !in_multi_array($row2_3,$temp))
            {
                //填入 L
                $temp[2][3] = $row2_3;
                //用 34 - C - G - K 算出 O 結果
                $row3_2 = 34 - $temp[0][2] - $temp[1][2] - $temp[2][2];

                //檢查 0 < O 結果 < 17 且不重複
                if (0 < $row3_2 && $row3_2 < 17 && !in_multi_array($row3_2,$temp))
                {
                    //填入 O
                    $temp[3][2] = $row3_2;
                    //用 34 - A - F - K 算出 P 結果
                    $row3_3 = 34 - array_sum($temp[3]);

                     //檢查 0 < P 結果 < 17 且不重複
                    if (0 < $row3_3 && $row3_3 < 17 && !in_multi_array($row3_3,$temp))
                    {
                        //填入 P
                        $temp[3][3] = $row3_3;

                        //檢查 X型加總 魔方陣條件 符合就增加一筆到總結果陣列
                        if (check_sum_x($temp)) $GLOBALS['total_square'][] = $temp;
                    }
                }
            }
        }
    }   
    return FALSE;  
}

//檢查多維陣列內數值是否存在
function in_multi_array($value, $input_array)
{
    foreach ($input_array as $in_num)
    {
        //非陣列直接比對數值 有比到回TRUE
        if(!is_array($in_num))
        {
            if ($value == $in_num)
                return TRUE;
        }
        //是陣列的call自己執行下一層 有比到回TRUE
        else
        {
            if(in_multi_array($value,$in_num))
                return TRUE;
        }
    }
    return FALSE;
}

//檢查 X 型加總是否符合魔方陣條件
function check_sum_x($array)
{
    //檢查 A + F + K + P == 34
    if ($array[0][0] + $array[1][1] + $array[2][2] + $array[3][3] == 34)
    {
        //檢查 M + J + G + D == 34 符合條件回TRUE
        if ($array[0][3] + $array[1][2] + $array[2][1] + $array[3][0] == 34)
        {
            return TRUE;
        }
    }
    return FALSE; 
}

//檢查方陣直行加總是否符合魔方陣條件
// function check_sum_column($input_array)
// {
//     //總共幾行
//     $array_count = count($input_array);
//     //檢查第幾直行 從0開始
//     $column = 0;

//     //檢查垂直加總
//     for ($i = 0; $i < $array_count; $i++)
//     {   
//         //暫存當前直行加總
//         $count_temp = 0;

//         //直行加總
//         for ($k = 0; $k < $array_count; $k++)
//         { 
//             $count_temp += $input_array[$k][$column];
//         }

//         //檢查是否為34 是就做下一個直行 否就回FALSE
//         if ($count_temp != 34)
//         {
//             return FALSE;
//         }

//         //下一個直行
//         $column++;
//     }

//     return TRUE;
// }

//檢查方陣橫列加總是否符合魔方陣條件
// function check_sum_row($input_array)
// {
//     //總共幾橫列
//     $array_count = count($input_array);

//     //檢查橫向加總
//     for ($i = 0; $i < $array_count; $i++)
//     {
//         $sum = array_sum($input_array[$i]);
//         echo "※{$i}※",$sum.'<br>';

//         //檢查是否為34 是就做下一個橫列 否就回FALSE
//         if ($sum != 34)
//         {
//             return FALSE;
//         }
//     }

//     return TRUE;
// }
