<?php
date_default_timezone_set('Asia/Taipei');

# 本地資料夾
$localDir = "/var/www/html/image"; // Linux
$localDir = "D:/Heat_Desktop"; // Windows
pre_print_r("localDir: $localDir");

# 圖片網址
$imageUrl = "http://a1.att.hudong.com/86/38/300001140423130278388082725_950.jpg";
pre_print_r("imageUrl: $imageUrl");

# 檢查目標網址是否為圖片
$imageType = getImageType($imageUrl) or die('Target not found or is not image');
pre_print_r("imageType: $imageType");

# 下載後儲存的檔案名稱
$fileName = date("Ymd_His").'_'.uniqid().'.'.$imageType;
pre_print_r("fileName: $fileName");

# 下載完成的圖片路徑
$savedPath = saveImage($imageUrl, $localDir, $fileName);
pre_print_r("savedPath: $savedPath");

pre_print_r("Complete");
exit;

# 圖片網址檢查
function getImageType($imageUrl)
{
    $imgInfo = getimagesize($imageUrl);
    $imgTypeList = array(
        1 => 'GIF',
        2 => 'JPG',
        3 => 'PNG',
        4 => 'SWF',
        5 => 'PSD',
        6 => 'BMP',
        7 => 'TIFF',
        8 => 'TIFF',
        9 => 'JPC',
        10 => 'JP2',
        11 => 'JPX',
        12 => 'JB2',
        13 => 'SWC',
        14 => 'IFF',
        15 => 'WBMP',
        16 => 'XBM'
    );

    if(!$imgInfo) return false;
    return strtolower($imgTypeList[$imgInfo[2]]);
}

# 圖片下載
function saveImage($imageUrl, $localPath, $fileName)
{
    $fullPath = $localPath.'/'.$fileName;

    $ch = curl_init($imageUrl);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
    $rawdata = curl_exec($ch) or die('error: curl_exec');
    curl_close($ch);

    if (!file_exists($localPath) || !is_dir($localPath))
    {
        mkdir($localPath, 0777, true);
    }

    $fp = fopen($fullPath, 'wb') or die('error: fopen');
    fwrite($fp, $rawdata);
    fclose($fp);

    return $fullPath;
}

function pre_print_r($input)
{
    echo '<pre>';
    print_r($input);
    echo '</pre>';
}