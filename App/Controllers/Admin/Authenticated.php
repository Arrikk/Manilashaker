<?php
namespace App\Controllers\Admin;

use App\Auth;
use App\Flash;
use App\Models\Admin;

class Authenticated extends \Core\Controller
{

    protected function before()
    {
        $this->requireAdmin();
        $this->user = Auth::getAdmin(); 
        if($this->user->type == Admin::WRITER){
            Flash::addMessage('The page you requested is restricted', Flash::INFO);
            $this->redirect('/admin/post/all');
        }
    }

}
