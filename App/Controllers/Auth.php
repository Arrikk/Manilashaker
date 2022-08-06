<?php
namespace App\Controllers;

use \Core\View;
use \App\Models\User;
use \App\Auth as Auths;

/**
 * Auth 
 * 
 * Created By Bruiz(@~codeHart~) 2021
 * 
 * PHP Version 7.4.code
 */

class Auth extends \Core\Controller {

    protected function before(){

    }

// *****************************************************
// *****************************************************
// ========================= Login =====================
// *****************************************************
// *****************************************************

    /**
     * render Login page
     * 
     * @return void
     */
    public function LoginAction()
    {
        if(Auths::getUser() ?? null){
            $this->redirect('/');
        }
        View::draw('{/account/auth}');
        
    }
    
    /**
     * Authenticate User
     * 
     * @return void
     */
    public function authenticateAction()
    {
        $status = '';
        if(isset($_POST['email'])){
            $user = User::authenticate($_POST['email'], $_POST['key']);
            $remember = $_POST['remember'] ?? null;
            if($user){
                if($user->status == 2):
                    http_response_code(400);
                    $status = "Account Deactivated";
                else:
                    Auths::login($user, $remember);
                    http_response_code(200);
                    $status = Auths::getReturnToPage() ?? '/';
                endif;
            }
            else{
                http_response_code(400);
                $status = "Credentials Error !!!";
            }
        }
        header('content-type: application/json');
        echo json_encode($status);
    }

// *****************************************************
// *****************************************************
// ====================== Register =====================
// *****************************************************
// *****************************************************

    /**
     * Register
     * 
     * @return void
     */
    public function registerAction()
    {
        if(Auths::getUser()){
            $this->redirect('/account');
        }
        // View::draw('...');
    }

    /**
     * Register call
     * 
     * @return void
     */
    public function registerProcessAction()
    {
        if(isset($_POST)){
            $response = [];
            $user = new User($_POST);

            if($saved = $user->save()){
                \http_response_code(200);
                $response = Auths::getReturnToPage() ?? '/';
            }else if(!empty($user->errors)){
                \http_response_code(403);
                $response = $user->errors;
            }else{
                \http_response_code(400);
                $response = "Something went wrong";
            }
            echo \json_encode($response);
        }
    }

// *****************************************************
// *****************************************************
// ====================== Activate =====================
// *****************************************************
// *****************************************************

    /**
     * Send email activation link
     * 
     * @return void
     */
    public function sendActivationAction()
    {
        $user = Auths::getUser();
        if($user->sendEmailActivation()){
            \http_response_code(200);
            $response = 'Activation successfully sent';
        }else{
            \http_response_code(400);
            $response = 'Try again..';
        }
        header('content-type: application/json');
        echo \json_encode($response);
    }

    /**
     * Validate activation link
     * 
     * @return void
     */
    public function activateAction()
    {
        $token = $this->route_params['token'] ?? '';
        if($user = $this->validateToken($token)){
            if($user->activateAccount()){
                Auths::login($user);
                View::draw('auth/welcome.html');
            }else{
                echo "Token expired";
            }
        }else{
            echo "Invalid Token";
        }
    }

    public function validateToken($token)
    {
        $user = User::validateToken($token);
        if($user){
            return $user;
        }
        return false;
        exit;
    }

    public function tokenAction()
    {
        $token = new \App\Token();
        echo '<pre>';
        echo 'Value: '.$token->getValue().'<br>';
        echo 'Hashed: '.$token->getHashed();
        echo '</pre>';
    }

// *****************************************************
// *****************************************************
// ================= Reset Password ====================
// *****************************************************
// *****************************************************

    /**
     * Render Forgot password html 
     * 
     * @return void
     */
    public function forgotAction()
    {
        View::autoload();
        View::draw('auth/auth_forgot.html');
    }
    
    /**
     * Send password reset email 
     * 
     * @return void
     */
    public function sendResetAction()
    {
        if(isset($_POST['email'])){
            if($user = User::sendPasswordReset($_POST['email'])){
                \http_response_code(200);
                $response = "Check your email to proceed";
            }else{
                \http_response_code(400);
                // $response = $user;
                $response = "We do not recognize your email";
            }
            header('content-type: application/json');
            echo json_encode($response);
        }
    }

    /**
     * Show Reset Password Form
     * 
     * @return void
     */
    public function resetAction()
    {
        $token = $this->route_params['token'];
        $this->getUser($token);
        View::autoload();
        View::draw('auth/auth_reset.html', ['token' => $token]);
    }

    /**
     * Reset user Password
     */
    public function resetPasswordAction()
    {
        $token = $_POST['token'];
        $user = $this->getUser($token);
        if($user){
            if($user->resetPassword($_POST['password'])){
                \http_response_code(200);
                $response = "Reset was successful";
            }else{
                \http_response_code(400);
                $response = "Couldn't reset your password";
            }
            header("content-type: application/json");
            echo \json_encode($response);
        }
    }

    /**
     * Get User
     */
    public function getUser($token)
    {
        $user = User::findByPasswordReset($token);
        if($user){
            return $user;
        }else{
            View::autoload();
            View::draw('auth/auth_forgot.html');
            exit;
        }
    }

// *****************************************************
// *****************************************************
// ====================== Logout =======================
// *****************************************************
// *****************************************************

    /**
     * Logout user account 
     * 
     * @return void
     */
    public function destroyAction()
    {
        Auths::logout();
        $this->redirect('/');
    }

}