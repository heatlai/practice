<?php

/**
 * Class UserModel
 *
 * @author Heat <hitgunlai@gmail.com>
 */
class UserModel extends Model
{
    const PASSWORD_COST = 11; // 演算成本 預設：10
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