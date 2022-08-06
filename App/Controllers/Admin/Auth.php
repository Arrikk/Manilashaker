<?php
namespace App\Controllers\Admin;

use App\Auth as AppAuth;
use \Core\View;

class Auth extends \Core\Controller
{

    /**
     * Render Login Page
     * 
     * @return void
     */
    public function loginAction()
    {
        if(AppAuth::getAdmin()){
            $this->redirect('/admin/post/all');
        }
        View::render('Admin/auth/login.html');
    }

    /**
     * Login Controller... Authenticated Admin
     * 
     * @return void
     */
    public function loginAdminAction()
    {
        $admin = \App\Models\User::authenticate($_POST['email'], $_POST['key']);

        if($admin){
            if($admin->type != 0){
                \App\Auth::loginAdmin($admin);
                $status = "";
            }else{
                http_response_code(400);
                $status = "This looks like a user account";
            }
        }else{
            http_response_code(400);
            $status = "Credentials Error !!!";
        }
        
        header('content-type: application/json');
        echo json_encode($status);
    }

    /**
     * Logout loginAdminAction
     * @return void
     */
    public function logout()
    {
        $_SESSION['admin_id'] = null;
        $this->redirect('/master');
    }
}
