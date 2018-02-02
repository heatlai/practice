<?php
/**
 * @todo Bits Field 判斷
 * @todo 用二進位計算可複數選擇的選項數字
 * @example 輸入 7 => 選擇了 1 , 2 , 4 三種選項
 */

# 輸入選擇參數
$input = 7;

# 可用的選項
$options = array(1, 2, 4, 8);

# 檢查選擇了哪些選項
foreach ($options as $option)
{
    # 二進位交集
    $pick = $option & $input;

    # $pick有值代表包含此選項 加到選擇清單內
    if($pick) $chooses[] = $option;
}

/* or */
# $input拆成十進位陣列 交集 可用的選項
// $picks = splitBitsToDecimalArray($input);
// $chooses = array_intersect($options, $picks);

# 執行選擇
foreach ($chooses as $value)
{
    switch ($value)
    {
        case 1:
            echo "choose 1".PHP_EOL;
            break;
        case 2:
            echo "choose 2".PHP_EOL;
            break;
        case 4:
            echo "choose 4".PHP_EOL;
            break;
        case 8:
            echo "choose 8".PHP_EOL;
            break;
        default:
            echo "choose unknown".PHP_EOL;
            break;
    }
}

exit;

# Bits 轉 Decimal Array
function splitBitsToDecimalArray($int)
{
    # 轉二進位字串
    $binary = base_convert($int, 10, 2);

    # 二進位字串長度
    $length = strlen($binary);

    $result = array();
    # 計算每位數 2^n 從最大算到最小
    for ($i = 0; $i < $length; $i++)
    {
        # 目前位數 0 or 1
        $number = substr($binary, $i, 1);

        # 目前位數為1 => 加入到結果
        if($number)
        {
            # 從前面插入到結果
            array_unshift($result, pow(2, ($length - 1) - $i) );
        }
    }

    return $result;
}
