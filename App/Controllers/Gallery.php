<?php
namespace App\Controllers;

use App\Flash;
use App\Models\User;
use Core\Controller;
use App\Models\Upload;

class Gallery extends Controller
{
    /**
     * Gallery items
     * @return void
     */
    public function galleryAction()
    {
        echo json_encode(\App\Models\Site::__gallery());
    }

    /**
     * Create new gallery
     * @return void
     */
    public function addGalleryAction()
    {
        $files = [];
        $err = [];
            
        for($i=0; $i < count($_FILES['image']['name']); $i++){
            $files['name'] = $_FILES['image']['name'][$i];
            $files['type'] = $_FILES['image']['type'][$i];
            $files['tmp_name'] = $_FILES['image']['tmp_name'][$i];
            $files['error'] = $_FILES['image']['error'][$i];
            $files['size'] = $_FILES['image']['size'][$i];

           $upload = new Upload($files);
           if($up = $upload->upload()){
               if(is_array($up)){
                   foreach ($up as $msg) {
                       Flash::addMessage($msg, Flash::DANGER);
                   }
               }else{
                   Flash::addMessage('File was successfully uploaded', Flash::SUCCESS);
               }
           }
        }
        echo true;
        // echo json_encode($err);
    }

    public function phones(){
        echo json_encode($this->route_params);
    }
}