<?php
namespace App\Models;
use PDO;
use \App\Token;
use \App\Models\User;

/**
 * Remember login model
 */

class RememberedLogin extends \Core\Model
{
    
    /**
     * Find a remembered login model by token
     * 
     * @param string the remembered token
     * 
     * @return mixed
     */
    public static function findByToken($token)
    {
        $token = new Token($token);
        $token_hash = $token->getHashed();

        $user = static::select('*', 'remembered_logins', [
            'token_hash' => $token_hash
        ])->exec();

        return $user;
    }

    /** 
     * Get user associative with remembered login
     * 
     * @return User the user model
     */ 
    public function getUser()
    {
        $user = User::findById($this->user_id);
        return $user;
    }

    /**
     * Check if remember me token is still valid
     * 
     * @return bool
     */
    public function notExpired()
    {
        return strtotime($this->expires_at) > time();
    }

    /**
     * Delete login
     */
    public function delete()
    {
        static::trash('remembered_logins', ['token_hash' => $this->token_hash]);
    }
}