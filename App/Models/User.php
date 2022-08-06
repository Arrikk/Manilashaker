<?php

namespace App\Models;

use PDO;
use \App\Token;

/**
 * User model
 *
 * PHP version 7.0
 */
class User extends \Core\Model
{

    /**
     * Error messages
     *
     * @var array
     */
    public $errors = [];

    /**
     * Class constructor
     *
     * @param array $data  Initial property values (optional)
     *
     * @return void
     */
    public function __construct($data = [])
    {
        foreach($data as $key => $value){
            $this->$key = $value; 
        }
    }

    /**
     * Save the user model with the current property values
     *
     * @return boolean  True if the user was saved, false otherwise
     */
    public function save()
    {
        $token = new Token();

        $this->hashed = $token->getHashed();
        $this->token = $token->getValue();

      $this->validate();

      if(empty($this->errors)){

          $password = password_hash($this->password, PASSWORD_DEFAULT);
          $this->time = date('y-m-d H:i:s', time() + 60 * 60 * 3);
          $user = static::create('users', [
            'email' => static::clean($this->email),
            'uniqId' => 'NULL',
            'type' => 0,
            'profile' => '',
            'password_hash' => $password,
            'password_reset_hash' => $this->hashed,
            'status' => 0,
            'password_reset_expiry' => $this->time
          ])->lid()->exec();

            if(isset($user)){
                return $user;
            }
      };
    }

    /**
     * Validate current property values, adding valiation error messages to the errors array property
     *
     * @return void
     */
    protected function validate()
    {
        if($this->email == '')
            $this->errors[] = 'Email is required';

        if($this->emailExists($this->email, $this->user_id ?? null))
            $this->errors[] = 'Email already exists';

        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL))
            $this->errors[] = 'Invalid Email';

        if(isset($this->password) &&!empty($this->password)){
            if($this->password == '')
                $this->errors[] = 'Password cannot be empty';
            if($this->confirmPassword !== $this->password){
                $this->errors[] = 'Password Mismatch';
            }
            if(!preg_match('/.*\d+.*/', $this->password))
                $this->errors[] = 'Password Must contain atleast a number';
        }
        
        return true;
    }
    
    // ---------------------------------------------------------------
    // ---------------------------------------------------------------
    // =================== User Find / Authentic =====================
    // ---------------------------------------------------------------
    // ---------------------------------------------------------------

    /**
     * See if a user record already exists with the specified email
     *
     * @param string $email email address to search for
     *
     * @return boolean  True if a record already exists with the specified email, false otherwise
     */
    public static function emailExists($email, $ignore_id = null)
    {
        $user = self::findByEmail($email);
        if($user):
            if($user->user_id !== $ignore_id){
                return true;
            }
        endif;
        return false;
    }

    /**
     * Find a user model by email address
     *
     * @param string $email email address to search for
     *
     * @return mixed User object if found, false otherwise
     */
    public static function findByEmail($email)
    {
        $data = static::select('*','users', [
            'email' => $email
        ])->class()->exec();
        return $data;
    }

    /**
     * Authenticate a user by email and password.
     *
     * @param string $email email address
     * @param string $password password
     *
     * @return mixed  The user object or false if authentication fails
     */
    public static function authenticate($email, $password)
    {
        $user = self::findByEmail($email);
        if($user){
            if(password_verify($password, $user->password_hash)){
                return $user;
            }
        }
        return false;
    }

    /**
     * Find a user model by ID
     *
     * @param string $id The user ID
     *
     * @return mixed User object if found, false otherwise
     */
    public static function findByID($id)
    {
        $data = static::select('*', 'users', [
            'user_id' => $id
        ])->class()->exec();
        return $data;
    }
    public static function findBy(array $param = [])
    {
        $data = static::select('*', 'users', $param)->class()->exec();
        return $data;
    }
    
    // ---------------------------------------------------------------
    // ---------------------------------------------------------------
    // =================== Save Remembered Login =====================
    // ---------------------------------------------------------------
    // ---------------------------------------------------------------

    /**
     * Remember the login by inserting a new unique token into the remembered_logins table
     * for this user record
     *
     * @return boolean  True if the login was remembered successfully, false otherwise
     */
    public function rememberLogin()
    {
        $token = new Token();
        $token_hash = $token->getHashed();
        $this->token_value = $token->getValue();

        $this->expiry = time() + 60 * 60 * 24 * 30;
        static::create('remembered_logins', [
            'token_hash' => $token_hash,
            'user_id' => $this->user_id,
            'expires_at' => date('Y-m-d H:i:s', $this->expiry)
        ])->exec();
        return true;
    }


    // ---------------------------------------------------------------
    // ---------------------------------------------------------------
    // =================== Password Reset Starts =====================
    // ---------------------------------------------------------------
    // ---------------------------------------------------------------

    /**
     * Verify user email to send Reset link
     * 
     * @param string $email user email
     */
    public static function sendPasswordReset($email)
    {
        $user = self::findByEmail($email);
        if($user){
            if($user->startPasswordReset()){
                if($user->forgotEmail()){
                    return true;
                }
                return $errors['mail'] = "Unable to sent email";
            }
        }else{
            return false;
        }
    }

    /**
     * Start password reset by generating a new token and expiry
     * 
     * @return mixed
     */
    public function startPasswordReset()
    {
        $token = new Token();
        $token_hash = $token->getHashed();
        $this->token = $token->getValue();

        $expiry = time() + 60 * 60 * 2;
        $user = static::update('users', [
            'password_reset_hash' => $token_hash,
            'password_reset_expiry' => date('Y-m-d H:i:s',$expiry)
        ])->where('user_id',  $this->user_id)->exec();
        return true;
    }

    /**
     * Find user Model by token
     * 
     * @param string $token User token
     * 
     * @return mixed
     */
    public static function findByPasswordReset($token)
    {
        $token = new Token($token);
        $token_hash = $token->getHashed();

        $user = 
        static::select('*', 'users', ['password_reset_hash' => $token_hash])
        ->class()->exec();

        if($user){
            if(strtotime($user->password_reset_expiry) > time()){
                return $user;
            }
        }
    }

    /**
     * Verify  Password 
     * 
     * @return mixed
     */
    public function verifyPassword($password){
        if(\password_verify($password, $this->password_hash)){
            return true;
        }
        return false;
    }

    /**
     * Reset account Password
     * 
     * @param string $password New password
     * 
     * @return void
     */
    public function resetPassword($password)
    {
        $this->password = $password;
        // $this->validate();
        // if(empty($this->errors)){
            $password = password_hash($this->password, PASSWORD_DEFAULT);
            return static::update('users', [
                'password_hash' => $password,
                'password_reset_hash' => NULL,
                'password_reset_expiry' => NULL
            ])->where('user_id', $this->user_id)->exec();
            return false;
        // }
    }
    
    // ---------------------------------------------------------------
    // ---------------------------------------------------------------
    // =================== Profile Update Starts =====================
    // ---------------------------------------------------------------
    // ---------------------------------------------------------------

    /**
     * Update User Profile
     * 
     * @param array User data
     * 
     * @return void
     */
    public function updateProfile($data)
    {
        $this->name     = $data['name'] ?? '';
        $this->email    = $data['email'] ?? '';
        $this->phone    = $data['phone'] ?? '';
        $this->password = $data['password'] ?? '';

        if(empty($this->errors)){
            $password = password_hash($this->password, PASSWORD_DEFAULT);

            if(!empty($this->password)){
                static::update('users', [
                    'name' => $this->name,
                    'email' => $this->email,
                    'password_hash' => $password
                ])->where('user_id', $this->user_id)->exec();
            }else{
                static::update('users', [
                    'phone' => $this->phone,
                ])->where('user_id', $this->user_id)->exec();

            }
            return true;
        }
        return false;

    }

    /**
     * updatePics 
     * 
     * @params string $pics user picture
     * 
     * @return bool
     */
    public function updatePics($file){
        $this->files = $file;
        $image = $this->uploadPics();
        $upload = static::update('users', [
            'profile' => $image
        ])->where('user_id', $this->user_id)->exec();
        if($upload)
            return true;
    }

    /**
     * Upload profile picture
     * 
     * @return void
     */
    protected function uploadPics()
    {
        $files = $this->files;
        $name = \basename($files['name']);
        $tmp = $files['tmp_name'];
        $type = $files['type'];
        $newName = time().$name;
        $path = '/Public/assets/images/'.$newName;
        if($type == 'image/jpeg' || $type == 'image/png'){
            if(\move_uploaded_file($tmp, dirname('path').$path)){
                return $newName;
            }
        }
        return false;
    }

    
    // ---------------------------------------------------------------
    // ---------------------------------------------------------------
    // ==================== Activate user account ====================
    // ---------------------------------------------------------------
    // ---------------------------------------------------------------

    /**
     * Validate Token
     * 
     * @param string $token user token to verify
     * 
     * @return object
     */
    public static function validateToken($token)
    {
        $token = new Token($token);
        $token_hash = $token->getHashed();
        $user = static::select('*', 'users', ['password_reset_hash' => $token_hash], 'OBJ');
        if($user){
            return $user;
        }
    }
    /**
     * Activate user Account
     * 
     * @param string $token user token to verify
     * 
     * @return bool
     */
    public function activateAccount()
    {
        if(!strtotime($this->password_reset_expiry) < time()){

            $user = static::update('users', [
                'password_reset_hash' => NULL,
                'password_reset_expiry' => NULL,
                'status' => 1
            ])->where('user_id', $this->user_id)->exec();
            return true;

        }
        return false;
    }

    // ---------------------------------------------------------------
    // ---------------------------------------------------------------
    // ================= Email Activation Processes ==================
    // ---------------------------------------------------------------
    // ---------------------------------------------------------------

    /**
     * Send email activation link
     * 
     * @return void
     */
    public function sendEmailActivation()
    {
        $token = new Token();
        $this->token = $token->getValue();
        $this->hashed = $token->getHashed();
        $this->expiry = date('y-m-d H:i:s', time() + 60 * 5);
        if($activation = $this->startEmailReset()){
            if($this->activationEmail()){
                return true;
            }
        }
        
    }

    /**
     * Start Email activation process 
     * 
     * @return bool
     */
    protected function startEmailReset(){
        $update = static::update('users', [
            'password_reset_hash' => $this->hashed,
            'password_reset_expiry' => $this->expiry
        ])->where('user_id', $this->user_id)->exec();
        if($update){
            return true;
        }
    }

    // ---------------------------------------------------------------
    // ---------------------------------------------------------------
    // ==================== Send Email Templates =====================
    // ---------------------------------------------------------------
    // ---------------------------------------------------------------
    protected function activationEmail()
    {
        $to = $this->email;
        $from = \App\Config::DEFAULT_EMAIL;
        $subject = 'Verify you want to use this emaill address';
        $body = \Core\View::template('emailTemplates/emails_activate.html', [
            'email' => $this->email,
            'token' => $this->token,
            'URL' => $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST']
        ]);
        return \App\Mail::mail($to, $from, $subject, $body);
    }
    protected function welcomeEmail()
    {
        $to = $this->email;
        $from = \App\Config::DEFAULT_EMAIL;
        $subject = 'Thank you for signing up';
        $body = \Core\View::template('emailTemplates/emails_welcome.html', [
            'email' => $this->email,
            'URL' => $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST']
        ]);
        return \App\Mail::mail($to, $from, $subject, $body);
    }
    protected function forgotEmail()
    {
        $to = $this->email;
        $from = \App\Config::DEFAULT_EMAIL;
        $subject = 'Reset Account Password';
        $body = \Core\View::template('emailTemplates/emails_forgot.html', [
            'email' => $this->email,
            'token' => $this->token,
            'URL' => $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST']
        ]);
        return \App\Mail::mail($to, $from, $subject, $body);
    }

}
