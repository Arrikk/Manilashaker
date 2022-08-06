<?php

namespace App\Controllers\Admin;

use App\Flash;
use App\Model\ProductCategory;
use App\Models\Product;
use Core\Http\Res;
use Core\View;

class Compare extends Authenticated
{
    public function description()
    {

        if (isset($_POST['description'])) :
            $save = ProductCategory::description($_POST);
            if ($save) :
                Flash::addMessage('Category Compare Description Modified', 'success');
                $this->redirect('/admin/compare/description');
            else :
                Flash::addMessage('Description Modification failed', 'warning');
            endif;
        endif;


        $category = null;
        $id = $_GET['edit'] ?? 1;
        if (isset($_GET['edit'])) :
            $id = $_GET['edit'];
            $category = Product::categories($id);
        endif;

        // Res::json($category);
        // return;
        View::draw('{product/compare-desc}', [
            '__is_admin' => true,
            'edit_product_category_desc' => $category
        ]);
    }

    public function save()
    {
    }
}
