<?php
namespace App\Controllers\Admin;

use App\Models\Upload;

class Dashboard extends \Core\Controller
{
    public function uploadAction()
    {
        $init = new Upload(end($_FILES));
        $uploader = $init->upload();
        echo json_encode($uploader, JSON_PRETTY_PRINT);
    }
}
 