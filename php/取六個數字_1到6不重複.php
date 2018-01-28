<?php 

/**
 * 取六個數字 1~6 不重複
 */
function random_six_numbers()
{
    //開陣列
    $array = array();
    
    //一共取六個數字
    for ($r = 0; $r < 6; $r++)
    { 
        //隨機取數 1~6
        $array[$r] = rand(1,6);
        print_r($array);

        //驗證是否重複
        for ($x = 0; $x < $r; $x++)
        { 
            //if判斷數值是否重復，若重復則重取，直到沒有重復
            if ($array[$r] == $array[$x])
            {
                echo "{$array[$r]} = {$array[$r]} => 重取";
                $array[$r] = rand(1,6);
                //重置驗證圈數
                $x = -1;
            }
            else
            {
                echo "{$array[$r]} != {$array[$x]} => OK";
            }
            //驗證圈數
            echo " ※{$x}※<br>";
        }
        echo '<hr>';
    }

    //輸出結果
    $array_length = count($array);
    echo "結果 : ";
    for ($i = 0; $i < $array_length; $i++)
    { 
        echo $array[$i].' ';        
    }   
}
echo '<pre>';
random_number();
echo '</pre>';
