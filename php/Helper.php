<?php
/*
|--------------------------------------------------------------------------
| Helper
|--------------------------------------------------------------------------
|
| 這裡存Helper共用的function
|
|--------------------------------------------------------------------------
| 修改記錄
|--------------------------------------------------------------------------
| 2017/06/23 York write_log
| 2017/06/27 York write_log換成log
| 2017/06/30 York log 陣列支援中文
| 2017/07/03 Heat 新增escape, error_response
| 2017/08/09 York 增加靜態變數document_root
| 2017/08/15 Heat 新增create_insert_sql
| 2017/08/17 York 新增csv匯出
| 2017/08/17 York 新增error_shotdown
*/
class Helper
{
    /**
     * @author  2017/08/09 York
     * @var     $document_root
     * @example include "/var/www/html/library/Helper";
     * @example define('ROOT_PATH',Helper::$document_root);
     * @example include (ROOT_PATH . "library/db_connect_subscribe.php");
     */
    public static $document_root = '/var/www/html/';
    public static function get_document_root()
    {
        return self::$document_root;
    }
    
    /**
     * @author  2017/06/27 York
     * @todo    寫log 
     * @param   string $fileName 
     * @param   string $contentType
     * @param   string $contentData
     * @example Helper::log(basename(__FILE__, '.php'),"log","web_id is undefined");
     * @example Helper::log(basename(__FILE__, '.php'),"log",array("web_id"=>"demo", "category"=>"20170706001000"));
     */

    public static function log($fileName, $contentType, $contentData)
    {
        //設定時區
        date_default_timezone_set("Asia/Taipei");
        //轉換陣列成json格式
        if(is_array($contentData))
        {
            array_walk_recursive($contentData, function(&$value, $key) 
            {
                if(is_string($value))$value = urlencode($value);
            });
            $contentData = urldecode(json_encode($contentData, JSON_FORCE_OBJECT));
        }
        //開啟檔案
        $txt = fopen(dirname(dirname(__FILE__))."/log/{$fileName}_{$contentType}.log", "a");
        //撰寫responseData
        fwrite($txt, "\r\n[".date("Y/m/d H:i:s")."]-$contentData");
        //關閉檔案
        fclose($txt);
        //return
        return "done";
    }

    /**
     * @author  2017/08/17 York
     * @todo    寫csv
     * @param   string $fileName 
     * @param   string $Type
     * @param   array $contentData
     * @example $response = array($web_id, $category_id, $webuserid, $os_type, $browser_type);
     * @example Helper::csv("2017-08-17", "impression", $response);
     */

    public static function csv($fileName, $Type, $contentData)
    {
        //宣告控自串
        $csv_str = "";
        //依照陣列組成csv格式字串
        foreach ($contentData as $value )
        {
            $csv_str = $csv_str . "," . $value;
        }
        //去除第一個逗號
        $csv_str = substr($csv_str,1);
        //開啟檔案
        $txt = fopen(dirname(dirname(__FILE__))."/csv/{$fileName}_{$Type}.csv", "a");
        //撰寫responseData
        fwrite($txt, "\r\n".$csv_str);
        //關閉檔案
        fclose($txt);
        //return
        return "done";
    }

    /**
     * @author  2017/07/03 Heat
     * @todo    欲跳脫字元(防止sql injection)
     * @param   string $str
     * @return  string
     * @example escape_str($url);
     */
    public static function escape_str($str)
    {
        return mysql_real_escape_string(trim($str));
    }

    /**
     * @author  2017/07/03 York
     * @todo    驗證 webuserid 格式
     * @param   string $webuserid
     * @return  boolean
     * @example $webuserid = (Helper::verify_webuserid($webuserid)) ? $webuserid : response_error("2","webuserid");
     */
    public static function verify_webuserid($webuserid)
    {
        //webuserid正規表示式
        $webuserid_pattern = '/^[a-zA-z0-9]{8}-[a-zA-z0-9]{4}-[a-zA-z0-9]{4}-[a-zA-z0-9]{4}-[a-zA-z0-9]{12}$/';
        //比對webuserid
        $webuserid_boolean = (preg_match($webuserid_pattern, $webuserid)) ? 1 : 0;
        return $webuserid_boolean;
    }

    /**
     * @author  2017/07/07 York
     * @todo    驗證 email 格式
     * @param     string $email
     * @return  boolean
     * @example $email = (Helper::verify_email($email)) ? $email : response_error("2","email");
     */
    public static function verify_email($email)
    {
        //email正規表示式
        $email_pattern = "/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/";
        //比對email
        $email_boolean = (preg_match($email_pattern, $email)) ? 1 : 0;
        return $email_boolean;
    }

    /**
     * @author  2017/07/07 York
     * @todo    驗證 url 格式
     * @param     string $url
     * @return  boolean
     * @example $url = (Helper::verify_url($url)) ? $url : response_error("2","url");
     */
    public static function verify_url($url)
    {
        //url正規表示式
        $url_pattern = "/\b(?:(?:https?|ftp|http):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";

        //比對email
        $url_boolean = (preg_match($url_pattern, $url)) ? 1 : 0;
        return $url_boolean;
    }

    /**
     * @author  2017/08/15 Heat
     * @todo    產生insert sql code 
     * @param   String $tablename 資料表名稱
     * @param   Array  $data
     * @return  String
     * @example Helper::create_insert_sql('user_data', array('name' => 'heat'));
     */
    public static function create_insert_sql($tablename, $data)
    {
        $keys = array_keys($data);
        $values = array();
        for ($i = 0; $i < count($keys); ++$i)
        {
            array_push($values, "'".$data[$keys[$i]]."'");
        }
        return "INSERT INTO $tablename (".implode(",", $keys).") VALUES (".implode(",", $values).")";
    }

    /**
     * @author    2017/08/31 York
     * @todo      紀錄錯誤並關閉程式
     * @param     String      $file_name  資料表名稱
     * @param     String      $type       錯誤類型(1:沒收到 2:驗證錯誤 3:查詢不到東西 4:mysql error)
     * @param     String      $error_msg  錯誤訊息
     * @param     Boolean     $exit       是否結束程式(預設不關閉)
     * @example   Helper::error_shotdown(basename(__FILE__, '.php'),  "1", "web_is", TURE);
     * @example   Helper::error_shotdown(basename(__FILE__, '.php'),  "1", "web_id");
     */
    public static function error_shotdown($file_name, $type, $error_msg, $exit = FALSE)
    {
        //整理錯誤訊息
        $response = array(
            "status"            => $type,
            "resText"           => $error_msg,
        );
        //編寫錯誤
        self::log($file_name, "error", $response);
        if( $exit ) exit();
    }
}
?>
