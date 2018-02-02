<?php
/**
 * @todo DB Helper
 * @author Heat 架構
 * @author York 新增slave的insert, update
 * @author Heat 新增交易模式
 * @author York 新增slave的get_slave_list, slave_query
 * @version 2017-09-11
 */
class DBHelper
{
    /**
     * @todo 儲存最後一次Error Message
     */
    public static $error = '';

    /**
     * @todo DB Server List
     * @version 2017-08-29
     */
    public static $db_list = array(
        'localhost_test' => array(
                'host' => 'localhost',
                'dbname' => 'test',
                'username' => 'root',
                'password' => '1234',
            ),
    );

    /**
     * @todo 連線資料庫
     * @global Array $db_list
     * @param String $target
     * @return Link|Boolean
     */
    public static function connection($target)
    {
        $host = self::$db_list[$target]['host'];
        $dbname = self::$db_list[$target]['dbname'];
        $username = self::$db_list[$target]['username'];
        $password = self::$db_list[$target]['password'];
        $pconnect = FALSE; //是否長連接
        $charset = 'utf8mb4'; //設置默認編碼
        $dsn = "mysql:host={$host};dbname={$dbname};charset={$charset}";
        try
        {
            $db_conn_param = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . $charset,
                PDO::ATTR_PERSISTENT => $pconnect,
            );
            $conn = new PDO($dsn, $username, $password, $db_conn_param);
            return $conn;
        }
        catch (PDOException $e)
        {
            self::$error = 'Connection failed : ' . $e->getMessage();
            return FALSE;
        }
    }

    /**
     * @todo 取得DB最新錯誤訊息, 取出後清除錯誤訊息
     * @return String
     */
    public static function db_error()
    {
        $error = self::$error;
        self::$error = '';
        return $error;
    }

    /**
     * @todo 重置連線
     * @param Link $connection
     * @return None
     */
    public static function reset(&$conn)
    {
        $conn = null;
    }

    /**
     * @todo 測試連線
     * @param Link $connection
     * @return Boolean
     */
    public static function ping(&$conn)
    {
        try
        {
            $conn->getAttribute(PDO::ATTR_SERVER_INFO);
            return TRUE;
        }
        catch (PDOException $e)
        {
            if(strpos($e->getMessage(), 'MySQL server has gone away') !== FALSE)
            {
                return FALSE;
            }
        }
    }

    /**
     * @todo 取得最後一次 insert_id
     * @param Link $connection
     * @return number|Boolean
     */
    public static function last_insert_id(&$conn)
    {
        try
        {
            $id = $conn->lastInsertId();
            return $id;
        }
        catch (PDOException $e)
        {
            self::$error = $e->getMessage();
            return FALSE;
        }
    }


    /**
     * @todo DB Query Select
     * @param Link $connection
     * @param String $sql
     * @param Array $bind
     * @return Array|Boolean
     */
    public static function select(&$conn, $sql, $bind = array())
    {
        try
        {
            $sth = $conn->prepare($sql);
            $sth->execute($bind);
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
        catch (PDOException $e)
        {
            self::$error = $e->getMessage();
            return FALSE;
        }
    }

    /**
     * @todo DB Query Insert
     * @param Link $connection
     * @param String $sql
     * @param Array $bind
     * @return Boolean
     */
    public static function insert(&$conn, $sql, $bind = array())
    {
        try
        {
            $sth = $conn->prepare($sql);
            $sth->execute($bind);
            return TRUE;
        }
        catch (PDOException $e)
        {
            self::$error = $e->getMessage();
            return FALSE;
        }
    }

    /**
     * @todo DB Query Slave Insert
     * @param String $sql
     * @param Array $bind
     * @return TRUE|Boolean
     */
    public static function slave_insert($sql, $bind = array())
    {
        $result = self::slave_query($sql, $bind);
        return $result;
    }

    /**
     * @todo DB Query Update
     * @param Link $connection
     * @param String $sql
     * @param Array $bind
     * @return Number|Boolean
     */
    public static function update(&$conn, $sql, $bind = array())
    {
        try
        {
            $sth = $conn->prepare($sql);
            $sth->execute($bind);
            $result = $sth->rowCount();
            return $result;
        }
        catch (PDOException $e)
        {
            self::$error = $e->getMessage();
            return FALSE;
        }
    }

   /**
     * @todo DB Query Slave_Update
     * @param String $sql
     * @param Array $bind
     * @return TRUE|Boolean
     */
    public static function slave_update($sql, $bind = array())
    {
        $result = self::slave_query($sql, $bind);
        return $result;
    }

    /**
     * @todo DB Query Delete
     * @param Link $connection
     * @param String $sql
     * @param Array $bind
     * @return Number|Boolean
     */
    public static function delete(&$conn, $sql, $bind = array())
    {
        try
        {
            $sth = $conn->prepare($sql);
            $sth->execute($bind);
            $result = $sth->rowCount();
            return $result;
        }
        catch (PDOException $e)
        {
            self::$error = $e->getMessage();
            return FALSE;
        }
    }

    /**
     * @todo 交易模式
     * @param Link $connection
     * @return Boolean
     */
    public static function begin(&$conn)
    {
        try
        {
            $result = $conn->beginTransaction();
            return $result;
        }
        catch (PDOException $e)
        {
            self::$error = $e->getMessage();
            return FALSE;
        }
    }
    public static function commit(&$conn)
    {
        try
        {
            $result = $conn->commit();
            return $result;
        }
        catch (PDOException $e)
        {
            self::$error = $e->getMessage();
            return FALSE;
        }
    }
    public static function rollback(&$conn)
    {
        try
        {
            $result = $conn->rollBack();
            return $result;
        }
        catch (PDOException $e)
        {
            self::$error = $e->getMessage();
            return FALSE;
        }
    }

    /**
     * @todo Get slave list
     * @return Array | FALSE
     */
    public static function get_slave_list()
    {
        $slave_list = array();
        $query = "SELECT ip, name FROM slave_list WHERE status = '1' ORDER BY name ASC";
        $result = DBHelper::select(self::connection('master_web_push'), $query);
        if($result)
        {
            foreach ( $result as $row )
            {
                $slave = array(
                        'host'      => $row['ip'],
                        'name'      => $row['name'],
                        'dbname'    => 'test',
                        'username'  => 'root',
                        'password'  => '1234',
                );
                array_push($slave_list, $slave);
            }
            return $slave_list;
        }
        else
        {
            return FALSE;
        }
    }
    /**
     * @todo DB Query all slave
     * @return  Boolean
     */
    public static function slave_query($sql, $bind = array())
    {
        $slave_list_array = self::get_slave_list();
        if( is_array( $slave_list_array ) )
        {
            foreach ( $slave_list_array as $row )
            {
                $host = $row['host'];
                $dbname = $row['dbname'];
                $username = $row['username'];
                $password = $row['password'];
                $pconnect = FALSE; //是否長連接
                $charset = 'utf8mb4'; //設置默認編碼
                $dsn = "mysql:host={$host};dbname={$dbname};charset={$charset}";
                try
                {
                    $db_conn_param = array(
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . $charset,
                        PDO::ATTR_PERSISTENT => $pconnect,
                    );
                    $conn = new PDO($dsn, $username, $password, $db_conn_param);

                    //query
                    try
                    {
                        $sth = $conn->prepare($sql);
                        $sth->execute($bind);
                    }
                    catch (PDOException $e)
                    {
                        self::$error = $e->getMessage();
                        return FALSE;
                    }

                }
                catch (PDOException $e)
                {
                    self::$error = 'Connection failed : ' . $e->getMessage();
                    return FALSE;
                }
            }
            return TRUE;
        }
        else
        {
            self::$error = 'Undefined any slave server';
            return FALSE;
        }
    }
}
