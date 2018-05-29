<?php

/**
 * Class UserModel
 *
 * @author Heat <hitgunlai@gmail.com>
 */
class UserModel extends Model
{
    const PASSWORD_COST = 10; // 演算成本(迭代幾次hash) 預設：10 一般設 10 ~ 12 即可
    const PASSWORD_ALGO = PASSWORD_BCRYPT; // 演算法 PASSWORD_BCRYPT 產出 hash 為 60 字元
    const PASSWORD_LENGTH_MAX = 72; // PASSWORD_BCRYPT 輸入字串最長只能 72 字元

    /**
     * 驗證密碼是否正確
     *
     * @param string $plainPassword 明文密碼
     * @param bool $autoRehash 是否重新計算 hash 值
     * @return bool
     */
    public function verifyPassword( string $plainPassword, bool $autoRehash = false ) : bool
    {
        /*
         * password_verify 原理
         *
         * password_hash 60 字元拆解
         *
         * example : $2y$10$B8kDHnXSBptN2MeX/C19yulciiqMMVhsZ3XjjPoRMQ1a4kOlBbxiy
         * 分隔符號 3 字元: $
         * 演算法 2 字元 (PASSWORD_BCRYPT): 2y
         * cost 次數 2 字元: 10
         * salt 22 字元 : B8kDHnXSBptN2MeX/C19yu
         * hash 31 字元: lciiqMMVhsZ3XjjPoRMQ1a4kOlBbxiy
         */
        if ( $this->checkPasswordLength( $plainPassword ) && password_verify( $plainPassword, $this->password ) )
        {
            if ( $autoRehash && password_needs_rehash( $this->password, self::PASSWORD_ALGO,
                    [ 'cost' => self::PASSWORD_COST ] ) )
            {
                $this->updatePassword( $plainPassword );
            }

            return true;
        }

        return false;
    }

    /**
     * 更新密碼
     *
     * @param string $newPlainPassword 新的明文密碼
     */
    public function updatePassword( string $newPlainPassword ) : void
    {
        $this->password = password_hash( $newPlainPassword, self::PASSWORD_ALGO, [ 'cost' => self::PASSWORD_COST ] );
        $this->save();
    }

    /**
     * 密碼長度檢查
     *
     * @param string $plainPassword 明文密碼
     *
     * @return bool
     */
    public function checkPasswordLength( string $plainPassword )
    {
        return ! ( strlen( $plainPassword ) > self::PASSWORD_LENGTH_MAX );
    }
}