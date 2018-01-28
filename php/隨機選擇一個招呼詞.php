<?php
/**
 * 隨機選擇一個招呼詞
 */
function hello($name = 'Simon', $words = ['Hi'])
{
    //驗證招呼詞是陣列
    if(is_array($words))
    {
        // 隨機取數 rand(起始值,最大值,間距) 陣列長度計算 count($陣列)
        $index = rand(0, count($words)-1);
        $sentence = $words[$index].','.$name;
        return $sentence;
    }
    else
    {
        return 'words 不是陣列';
    }
}
//呼叫函式
echo hello('Tom',['Hola','Hello','Good Morning','God damn']);
?>