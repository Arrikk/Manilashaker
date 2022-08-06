<?php
namespace App\Controllers\Admin;

use App\Flash;
use App\Models\Admin;
use Core\View;

class Members extends Authenticated
{
    public function authorAction()
    {
        
        $isediting = isset($this->route_params['id']);

        if(isset($_GET['d']) && $_GET['d'] !== ''){
            if(Admin::trashAuthor((int) $_GET['d']))
                Flash::addMessage('Author has been successfully deleted', Flash::SUCCESS);
            else 
                Flash::addMessage('Operation was unable to complete', Flash::DANGER);
            $this->redirect($_SERVER['REDIRECT_URL']);
        }

        if(isset($_POST['type'])){
            if($_POST['type'] == 'edit')
                $_POST['user'] = (int) $this->route_params['id'];

            if($save = Admin::saveAuthor($_POST)){
                if($_POST['type'] == 'save'):
                    Flash::addMessage('You add created a new Author', Flash::SUCCESS);
                    Flash::addMessage('AUTHOR PASSWORD IS <strong>'.strtolower(str_replace(' ', '_', $_POST['name'])).'</strong>', Flash::DEFAULT);
                else:
                    Flash::addMessage('Author Modification was successful', Flash::SUCCESS);
                endif;
            }else{
                if($_POST['type'] == 'save'):
                    Flash::addMessage('Creation of Author Failed', Flash::DANGER);
                else:
                    Flash::addMessage('Author Modification cannot be completed', Flash::DANGER);
                    $this->redirect($_SERVER['REQUEST_URI']);
                endif;

            }
            $this->redirect('/admin/members/author');
            
        }
        if($isediting){
            $isediting = Admin::authors((int) $this->route_params['id']);
        }
        View::draw('{author}', [
            '__is_admin' => true,
            '__is_editing' => $isediting
        ]);
    }

    public function test()
    {
        header('content-type: application/json');
        echo json_encode($_SERVER);
    }
}
