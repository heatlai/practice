<!--
<h1> 標題字    
<p> 段落
<br> 換行
<pre> 陣列格式化顯示
<hr> 頁面水平分隔線
&nbsp; 空白字元
-->

<?php
//單引號 純字串 可含html標籤
$str = 'abc';
$str = 'abc<br>';

//雙引號 可含變數
$int = 1;
$str = "abc{$int}"; //結果 => abc1

//印資料
echo $str; //show 單一字串 比print快
$r = print "Hello World"; // echo輸出後沒有返回值，但print有返回值，當其執行失敗時返回flase
print($r);// 輸出結果 Hello World1
print_r($array, bool $return); //show 陣列 , bool $return - 選用，可設為 true 或 false，設為 true 的話，字串就不會被列印
var_dump($array); //show 字串 陣列 含型態 字串長度

//for 迴圈

for ($i=0 ; $i <=3 ; $i++) {
    ${"a$i"} = "a{$i}";
}
echo "<pre>";
echo $a1;
echo $a2;
echo $a3;
echo "</pre>";

//定義函式 name($a = 預設值 , $b = '預設值' , $c = ['預設值1','預設值2'])
function hello($name = 'Simon', $words = ['Hi'])
{
    print_r ($name)."</br>";
    echo "<br>";
    print_r ($words)."</br>";
    echo "<br>";
    echo count($words)."<br>";

    if(is_array($words) === TRUE) //檢查words是陣列
    {
        $index = rand(0, count($words) - 1); // 隨機取數 rand(起始值,最大值,間距) 陣列長度計算 count($陣列)
        $sentence = $words[$index].','.$name;
        return $sentence;
    }
    else
    {
        return 'words 不是陣列';
    }
}
//呼叫函式
// echo hello('a','a')
echo hello('Tom',['Hola','Hello','Good Morning','God damn']);

//array 陣列
$array1 = 
[
    'id1' => 1,
    'name1' => 'Tom',
    'id2' => 2,
    'name2' => 'Simon'
];
    
$array2 = array(
    'id1' => 1,
    'name1' => 'Tom',
    'id2' => 2,
    'name2' => 'Simon'
);

echo "<pre>";
print_r($array2);
echo "</pre>";

//foreach 陣列迴圈 不顯示key值
foreach ($test as $value) {
    echo '<pre>';
    print_r($value);
    echo '</pre>';
}
echo "<br>";
//foreach 陣列迴圈 三種印出方式
foreach ($test as $index => $value) 
{
    echo '<pre>';
    echo "index 第".($index+1)."個陣列"."<br>";
    print_r($value);  // 第一種
    echo '<br>';
    print_r("$index : $value"); // 第二種
    echo '<br>';
    echo "$index: $value"; // 第三種
    echo '</pre>';
}
//刪除不要的陣列資料
foreach ($information as $key => $value)
{
    if($value[1] == "0")
    {
        unset($information[$key]);
    }     
}
//排序測試 一維陣列
$rand_count=100;
for($k=0; $k<$rand_count ; $k++)
{
    $rand_array[] = rand(0,10000);
}
//靜態變數 演示
function counter() {
    static $count = 0;
    $count++;
    var_dump($count);
    unset($count);      // $count = NULL, 但沒有真正的被清除
    static $count = 55; // 以最後宣告為初始值

    // 以下皆為 parse error, 必須直接給定值
    // static $count = new stdClass;
    // static $count = 1 + 1;
    // static $count = $GLOBALS['num'];
    // static $count = func();
}

counter();              // int(56)
counter();              // int(57)

// IF ELSE 簡化
//如果 a=b,c就=yes ; a不等於b,c就=no
$c = ($a==$b) ? ("yes") : ("no");

/**
 * call by reference
 * function add()收到的&$a是$x記憶體位址
 * 所以在function add()裡面對$a做事等於對$x做事
 */
function add(&$a, $b) {
   $a += $b;
}

$x = 1;
$y = 2;
add($x, $y);
//結果 x = 3 , y = 2
echo "x = {$x}<br>y = {$y}";

/**
 * array_map 
 * 把陣列的每個值丟進function裡跑
 * 再把return存回原本的位置
 * Array(
 *     [0] => DogPuppy
 *     [1] => CatKitten
 * )
 */
function add(&$a, $b) {
   $a = $a.$b;
   return $a;
}

$a1=array("Dog","Cat");
$a2=array("Puppy","Kitten");

echo '<pre>';
print_r(array_map("add",$a1,$a2));
echo '</pre>';
/**function的位置輸入null 結果會合併陣列
 * Array(
 *     [0] => Array(
 *         [0] => Dog
 *         [1] => Puppy
 *     )
 *     [1] => Array(
 *         [0] => Cat
 *         [1] => Kitten
 *     )
 * )
 */
echo '<pre>';
print_r(array_map(null,$a1,$a2));
echo '</pre>';

//時間 2016 年 07 月 11 日 15:58:47
$date = date("Y 年 m 月 d 日 H:i:s");

//正規表示 中文 注音符號 和 二三四輕聲符
'/[\x{4E00}-\x{9FA5}\x{3105}-\x{3129}\x{02CA}\x{02C7}\x{02CB}\x{02D9}]/'

//正規表示 擋<script>
'/</*(?:script|xss).*?>/'
