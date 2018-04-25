<?php

namespace Library\Google\Firebase;

/**
 * Class Push
 * @package Library\Google\Firebase
 *
 * @author Heat <hitgunlai@gmail.com>
 */
class Push
{
    public const FCM_ENDPOINT = 'https://fcm.googleapis.com/fcm/send';

    public const FCM_API_KEY = 'FCM_API_KEY';
    public const PUSH_DEBUG = false;
    public const TIME_TO_LIVE = 3600 * 24 * 7;

    private static $runtimeInvalidTokens = [];

    public static function addToken( string $userId, string $deviceId, string $token )
    {
        $result = \Library\Google\Datastore\PushToken::insert($userId, $deviceId, $token);

        \Model\Push\Data\PushToken::removeCache($userId);

        return $result;
    }

    public static function setTokensInvalidByDeviceId( string $userId, string $deviceId )
    {
        $result = \Library\Google\Datastore\PushToken::setTokensInvalidByDeviceId($userId, $deviceId);

        \Model\Push\Data\PushToken::removeCache($userId);

        return $result;
    }

    public static function deleteTokensByDeviceId( string $userId, string $deviceId )
    {
        $result = \Library\Google\Datastore\PushToken::deleteTokensByDeviceId($userId, $deviceId);

        \Model\Push\Data\PushToken::removeCache($userId);

        return $result;
    }

    public static function getTokensByUserId( string $userId )
    {
        return \Model\Push\Data\PushToken::instance($userId)->getList();
    }

    public static function getRuntimeInvalidTokens()
    {
        return self::$runtimeInvalidTokens;
    }

    private static function setInvalidByRuntimeInvalidTokens()
    {
        $invalidData = array();

        if ( ! empty(self::$runtimeInvalidTokens) )
        {
            $invalidData = \Library\Google\Datastore\PushToken::setTokensInvalid(self::$runtimeInvalidTokens);

            if ( ! empty($invalidData['userIds']) )
            {
                foreach ( $invalidData['userIds'] as $userId )
                {
                    \Model\Push\Data\PushToken::removeCache($userId);
                }
            }
        }

        return $invalidData;
    }

    public static function pushNotificationByUserId( $userIds, array $payloadData )
    {
        \Library\Google\Firebase\Push::pushToProberByUserId( $userIds, $payloadData );
        try
        {
            $userIds = (array) $userIds;

            $payloadData = self::checkPayloadData($payloadData);

            if ( empty($payloadData) )
            {
                throw new \RuntimeException('payloadData error');
            }

            $tokens = array();

            foreach ($userIds as $userId)
            {
                $tokens = array_merge($tokens, self::getTokensByUserId($userId));
            }

            if ( empty($tokens) )
            {
                return array();
            }

            $result = self::sendPushToFireBase($tokens, $payloadData);

            self::setInvalidByRuntimeInvalidTokens();

            return $result;
        }
        catch ( \RuntimeException $e )
        {
            return false;
        }
    }

    public static function sendPushToFireBase( array $tokens, array $payloadData )
    {
        try
        {
            if ( empty($tokens) )
            {
                throw new \RuntimeException('empty tokens.');
            }

            $tokensChunk = array_chunk($tokens, 1000);

            // Request 標頭
            $headers = array(
                'Authorization: key=' . self::FCM_API_KEY,
                'Content-Type: application/json',
            );

            // POST 資料
            $fields = array(
                'data'             => $payloadData,
                'registration_ids' => [],
                'priority'         => 'high',
                //'time_to_live'     => self::TIME_TO_LIVE,
            );

            if( self::PUSH_DEBUG )
            {
                $fields['dry_run'] = true;
            }

            // curl 設定
            $mh  = curl_multi_init();
            $chs = array();

            foreach ( $tokensChunk as $chunkNum => $chunkTokens )
            {
                $newCh = curl_init();

                $newChFields                     = $fields;
                $newChFields['registration_ids'] = $chunkTokens;

                curl_setopt($newCh, CURLOPT_URL, self::FCM_ENDPOINT);
                curl_setopt($newCh, CURLOPT_POST, TRUE);
                curl_setopt($newCh, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($newCh, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($newCh, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($newCh, CURLOPT_POSTFIELDS, json_encode($newChFields));

                $chs[$chunkNum] = $newCh;
                curl_multi_add_handle($mh, $chs[$chunkNum]);
            }

            // curl 執行
            $active = null;
            do
            {
                $mrc = curl_multi_exec($mh, $active);
            } while ( $mrc == CURLM_CALL_MULTI_PERFORM );

            while ( $active && $mrc == CURLM_OK )
            {
                if ( curl_multi_select($mh) == -1 )
                {
                    usleep(100);
                }
                do
                {
                    $mrc = curl_multi_exec($mh, $active);
                } while ( $mrc == CURLM_CALL_MULTI_PERFORM );
            }

            // 取得 curl 執行結果
            $curlResults = array();
            foreach ( $chs as $chunkNum => $ch )
            {
                $curlResults[$chunkNum] = curl_multi_getcontent($ch);
                curl_multi_remove_handle($mh, $ch);
            }
            curl_multi_close($mh);

            // 回傳結果處理
            $pushResult = array(
                'total'   => count($tokens),
                'success' => 0,
                'failure' => 0,
                'invalid' => 0,
                'detail'  => array(),
            );

            /*
             * 失效原因清單
             * Token失效 ／ 此Token不是這個的專案訂閱的(SenderId) ／ 錯誤的Token格式
             */
            $invalidReasons = array(
                'NotRegistered',
                'MismatchSenderId',
                'InvalidRegistration'
            );

            $invalidTokens = array();

            foreach ( $curlResults as $chunkNum => $curlResult )
            {
                $pushResult['detail'][$chunkNum] = $curlResult;

                // 回傳的結果 error 有在失效原因清單內 標記 invalid
                $chunkResult = json_decode($curlResult, TRUE);

                if ( is_array($chunkResult) )
                {
                    // 幾筆成功, 幾筆失敗
                    $pushResult['success'] += $chunkResult['success'];
                    $pushResult['failure'] += $chunkResult['failure'];

                    $results = $chunkResult['results'];
                    foreach ( $results as $key => $row )
                    {
                        /**
                         * 成功回傳的key == "message_id"
                         * 失敗回傳的key == "error"
                         */
                        if ( array_key_exists('error', $row) && in_array($row['error'], $invalidReasons) )
                        {
                            $invalidTokens[] = $tokensChunk[$chunkNum][$key];
                        }
                    }
                }
            }

            $pushResult['invalid'] = count($invalidTokens);

            if ( $pushResult['invalid'] > 0 )
            {
                self::$runtimeInvalidTokens = array_unique(array_merge(self::$runtimeInvalidTokens, $invalidTokens));
            }

            return $pushResult;
        }
        catch ( \RuntimeException $e )
        {
            return array();
        }
    }

    private static function checkPayloadData( array $data )
    {
        try
        {
            if ( empty($data['title']) )
            {
                throw new \RuntimeException('missing title.');
            }
            if ( empty($data['body']) )
            {
                throw new \RuntimeException('missing body.');
            }
            if ( empty($data['clickAction']) )
            {
                throw new \RuntimeException('missing clickAction.');
            }
            if ( empty($data['type']) )
            {
                throw new \RuntimeException('missing type.');
            }

            if ( empty($data['icon']) )
            {
                $data['icon'] = '';
            }

            $payload = array();

            foreach ( $data as $key => $value )
            {
                if ( $value === true )
                {
                    $payload[$key] = 'true';
                }
                elseif ( $value === false )
                {
                    $payload[$key] = 'false';
                }
                else
                {
                    $payload[$key] = (string) $value;
                }
            }

            return $payload;
        }
        catch ( \RuntimeException $e )
        {
            return array();
        }

    }
}