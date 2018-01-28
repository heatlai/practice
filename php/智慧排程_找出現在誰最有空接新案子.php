<?php
/*
智慧排程 找出現在誰最有空接新案子

輸入陣列 array([名字,休假狀態(0 or 1),身上專案數(後比對),等待報告數(先比對)])
$info = array(["John","1","3","6"],["Martin","1","1","6"],["Tim","0","4","5"]);
結果: Martin

*/
/**
 * smart_assigning
 * 智慧排程 找出現在誰最有空接新案子
 * @param array $info 輸入陣列 array([名字,休假狀態(0 or 1),身上專案數(後比對),等待報告數(先比對)])
 * @return string|
 * @author Heat <heat.lai@uitox.com>
 */
function smart_assigning($info) 
{
    echo "原始資料<pre>";
    print_r($info);
    echo "</pre>";

    //排除休假人員
    foreach ($info as $key => $value)
    {
       if($value[1] == "0")
       {
           unset($info[$key]);
       }     
    }

    //氣泡排序比對 從小到大 從第一個數字往後比較，如果前項比較大就交換
    $num = count($info);
    //只是做迴圈
    for($i = 0; $i < $num; $i++)
    {
        //比對報告數
        for($j = 1; $j < $num; $j++)
        {
            if($info[$j][3] < $info[$j - 1][3])
            {
                //交換兩個數值的小技巧，用list+each
                list($info[$j] , $info[$j - 1]) = array($info[$j - 1] , $info[$j]);
            }
            //報告數一樣 比對專案數
            elseif($info[$j][3] == $info[$j - 1][3])
            {
                if($info[$j][2] < $info[$j - 1][2])
                {
                    list($info[$j] , $info[$j - 1]) = array($info[$j - 1] , $info[$j]);
                }
            }
        }
    }
    echo "<BR>";
    echo "排序後資料<pre>";
    print_r($info);
    echo "</PRE>";

    return $info[0][0];
}
//輸入陣列
$info = array(["John","1","3","6"],["Martin","1","1","6"],["Tim","0","4","5"]);
echo "結果：".smart_assigning($info);
?> 