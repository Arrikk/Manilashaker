<?php
namespace App\Controllers\Admin;

use App\Flash;
use App\Models\Product as ModelsProduct;
use App\Models\Shop;
use App\Models\Upload;
use Core\Controller;
use \Core\View;

class Product extends Authenticated
{
    /**
     * Render new product and add product
     * 
     * @return void
     */
    public function newAction()
    {
        if(isset($_POST['name'])){
            // echo json_encode($_POST);
            // return;

            $_POST['specification'] = json_encode($_POST['product_specification'] ?? []);
            if(ModelsProduct::saveProduct($_POST)){
                if($_POST['action_type'] == 'editing'){
                    Flash::addMessage('You have modified a product', 'success');
                }else{
                    Flash::addMessage('New product was added to store', 'success');
                }
                $this->redirect('/admin/product/all');
            }else{
                Flash::addMessage('Something went wrong', 'danger');
                $_SESSION['options'] = $_POST;
            }
            return;

        }
        
        if(isset($_GET['edit']) && isset($_GET['product'])){
            if($_GET['edit'] !== '' && $_GET['product'] !== ''){
                $_GET['edit'] = str_replace(' ', '+', $_GET['edit']);
                // echo json_encode($_GET);return;
                $product = ModelsProduct::getProductBySlugAndId($_GET);
                if(!empty($product) || $product !== null){

                    // header('content-type: application/json');
                    $product->design = json_decode(htmlspecialchars_decode($product->design));
                    $product->general = json_decode(htmlspecialchars_decode($product->general));

                    $product->specification = json_decode(htmlspecialchars_decode($product->product_specification));


                    // echo json_encode(($product->specification));
                    // return;


                    View::draw('{product/new}', [
                        '__is_admin' => true,
                        '__is_edit' => true,
                        '__product' => $product
                    ]);
                    return;
                }
            }
        }

        // Render New product View
        View::draw('{product/new}', [
            '__is_admin' => true
        ]);

    }

    /**
     * Update /modify a product
     * @return void
     */
    public function editAction()
    {
    }

    /**
     * Render and modify product
     * 
     * @return void
     */
    public function allAction()
    {
        if(isset($_GET['fetch'])){
            $product = ModelsProduct::getProduct('', $_GET['page'] ?? 1);
            foreach ($product['product'] as $key => $value):
                $product['product'][$key]->review = Shop::getReviews($value->product_id);
            endforeach;
            
            echo json_encode($product);
            return; 
        }

        View::draw('{product/all}', [
            '__is_admin' => true
        ]);
    }

    /**
     * Render, delete, add and edit category
     * @return void
     */
    public function categoriesAction()
    {
        // Delete a category
        if(isset($_GET['slug']) && $_GET['slug']  !== ''){
            if(ModelsProduct::trashCategory($_GET)):
                Flash::addMessage('Category Deleted', 'success');
                Flash::addMessage('Product under this category is moved to <strong>Uncategorized</strong>', 'primary');
            else:
                Flash::addMessage('Sorry we can\'t complete the initated action.', 'danger');
            endif;

            $this->redirect('/admin/product/categories');
        }

        // Create a new category
        if(isset($_POST['name'])){
            if($_POST['name'] !== ''){
                if($model = ModelsProduct::saveCategory($_POST)):
                    Flash::addMessage('Category saved', Flash::SUCCESS);
                else:
                    Flash::addMessage('Sorry looks like something isn\'t right', Flash::DANGER);
                    if($_POST['type'] == 'update')
                        $this->redirect('/admin/product/categories?edit='.$_GET['edit']);
                endif;
            }else{
                Flash::addMessage('Category name is required', Flash::WARNING);
                if($_POST['type'] == 'update')
                    $this->redirect('/admin/product/categories?edit='.$_GET['edit']);
            }
            $this->redirect('/admin/product/categories');
        }

        //  Get all categories
        if(isset($_GET['fetch'])){
            echo json_encode(ModelsProduct::categories());
            return;
        }

        $category = [];
        if(isset($_GET['edit'])){
            $id = (int) $_GET['edit'];
            $category = ModelsProduct::categories($id);
            // echo json_encode($category);
            // return;
        }

        // Render Category View
        View::draw('{product/category}', [
            '__is_admin' => true,
            '__edit_category' => $category
        ]);
    }

    /**
     * Delete Product 
     */
    public function deleteAction(){
        if(isset($_GET['id'])){
            $id = (int) $_GET['id'];
            $deleted = ModelsProduct::deleteProduct($id);
            if($deleted){
                Flash::addMessage('Product Deleted', 'success');
                $this->redirect('/admin/product/all');
            }
        }
    }



    public function ordersAction()
    {
        
        if(isset($_GET['change']) && isset($_GET['details'])){
            echo json_encode(ModelsProduct::changeStatus($_GET));
            return;
        }
        if(isset($_GET['details']) && $_GET['details'] !== ''){
            View::draw('{product/order-details}', [
                '__is_admin' => true,
                '__details' => ModelsProduct::orderDetails((int) floatval( $_GET['details']))
            ]);
            // echo json_encode(ModelsProduct::orderDetails((int) floatval( $_GET['details'])));
            return;
        }

        // Render order 
        View::draw('{product/orders}', [
            '__is_admin' => true,
            '__orders' => ModelsProduct::orders()
        ]);
        // echo json_encode( ModelsProduct::orders());
    }

    public function multiple()
    {
        if(empty($_POST['multiselect']) || empty($_POST['parentCategory'])){
            Flash::addMessage("Please select product categories to move", Flash::WARNING);
            echo true;
            return;
        } 
        echo ModelsProduct::multiple($_POST);
    }

    public function recAction()
    {
        $data = '';
        echo json_encode(ModelsProduct::cat());
    }


}
