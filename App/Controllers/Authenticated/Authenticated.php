<?php
namespace App\Controllers\Authenticated;

use \App\Auth;

/**
 * Authenticated Users Private Page
 * 
 * ===============================
 * Author ======= Bruiz(CodeHart)
 * ==============================
 * 
 * PHP v 7.4.8
 */

abstract class Authenticated extends \Core\Controller
{
    /**
     * View Page
     * 
     * @return void
     */
    protected function before(){
        parent::before();
        $this->requireLogin();
        $this->user = Auth::getUser();
        // if($this->user->status == 0){
        //     \Core\View::draw('auth/activate.html');
        //     return false;
        // }
    }
}
