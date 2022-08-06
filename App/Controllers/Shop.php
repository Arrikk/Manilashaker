<?php

namespace App\Controllers;

use App\Auth;
use App\Controllers\Authenticated\Authenticated;
use App\Models\Product;
use App\Models\Shop as ModelsShop;
use Core\Controller;
use Core\Http\Res;
use Core\View;

class Shop extends Authenticated
{
    public function testing()
    {
        Res::json(ModelsShop::test());
    }
    public function product()
    {
        if(isset($_GET['category']) || isset($_GET['product_cat'])){
            View::draw('{/shop/home}', [
                '__class' => 'home-v2',
                '__category' =>true,
                '__slug' => ucfirst($_GET['category'] ?? $_GET['product_cat'])
            ]);
            return;
        }

        View::draw('{/shop/home}', [
            '__class' => 'home-v2',
        ]);
    }

    public function gadgets()
    {
        $slug = $this->route_params['payload'] ?? null;
        $page = isset($_GET["page"]) ? $_GET["page"] : 1;
        
        if (isset($_GET['all'])) {
            $gadgets = ModelsShop::gadgets('', $page);
            foreach ($gadgets as $key => $value) {
                $gadgets[$key]->rating = ModelsShop::getReviews($gadgets[$key]->product_id);
                $gadgets[$key]->product_id = $this->ambig('en',  $gadgets[$key]->product_id);
            }
            echo json_encode($gadgets);
            return;
        }

        if (isset($_GET['category'])) {
            $gadgets = ModelsShop::productByCategory($_GET['category'], $page, $_GET);
            foreach ($gadgets as $key => $value) {
                $gadgets[$key]->category = $_GET['category'];
                $gadgets[$key]->rating = ModelsShop::getReviews($gadgets[$key]->product_id);
                $gadgets[$key]->product_id = $this->ambig('en',  $gadgets[$key]->product_id);
            }
            
            echo json_encode($gadgets);
            return;
        }

        if($slug == null)
            $this->redirect('/shop/product');

        if($slug){
            $product = ModelsShop::gadgets($slug);
            !$product && $this->redirect('/shop/product');
            $reviews = ModelsShop::getReviews($product->product_id);
            
            if(!empty($product) || $product !== null){
                // header('content-type: application/json');
                $product->design = json_decode(htmlspecialchars_decode($product->design));
                $product->general = json_decode(htmlspecialchars_decode($product->general));
            }
            View::draw('{/shop/single}', [
                '__product' => $product,
                '__class' => 'single-product',
                '__reviews' => $reviews
            ]);
            // header('content-type: application/json');
            // echo json_encode($reviews);
            return;
        }
    }

    public function cart()
    {
        // if (isset($_POST['cart'])) {
        //     $cartItem = [];
        //     foreach ($_POST['cart'] as $key => $value) {
        //         $cartItem[] = ModelsShop::cartProduct($value);
        //     }

        //     foreach ($cartItem as $key => $value) {
        //         $cartItem[$key]->product_id = $this->ambig('en', $cartItem[$key]->product_id);
        //     }
        //     header('content-type: application/json');
        //     echo json_encode($cartItem);
        //     return;
        // }

        View::draw('{/shop/cart}');
    }



    /**
     * Checkout Product
     * @return void
     */
    public function checkoutAction()
    {
        if(isset($_GET['success'])){
            View::draw('{/shop/success}');
            return;
        }

        if (isset($_POST['checkout']) && isset($_POST['payment_method'])) {
            $items = [];
            foreach ($_POST['checkout'] as $key => $value):
                $items[] = [
                    'item' => $key,
                    'qty' => $value
                ];
            endforeach;
            $_POST['checkout'] = $items;
            if($shop = ModelsShop::checkout($_POST, $this->user->user_id)){

                header('content-type: application/json');
                echo json_encode($shop);
            }else{
                header('content-type: application/json');
                echo json_encode($shop);
                
            }
            return;
        }
        View::draw('{/shop/checkout}', [
            '__billing' => ModelsShop::billingAddress($this->user->user_id)
        ]);
    }

    public function productRating()
    {
        if(isset($_POST['star'])){
            $_POST['product_rating'] = $this->ambig('dc', $_POST['product_rating']);
            $user = Auth::getUser();
            if($user){
                $_POST['user'] = $user->user_id;
                if(ModelsShop::saveProductReview($_POST)){
                    http_response_code(200);
                    echo true;
                    return;
                }
                echo false;
                return;
            }
            http_response_code(401);
            echo json_encode(array('Login First'));
        }else{
            http_response_code(400);
            echo json_encode(array('Select star to continue'));
            return;
        }
    }

    public function filter()
    {
        $gadgets = ModelsShop::filter($_GET['filter']);
        foreach ($gadgets as $key => $value) {
            $gadgets[$key]->rating = ModelsShop::getReviews($gadgets[$key]->product_id);
            $gadgets[$key]->product_id = $this->ambig('en',  $gadgets[$key]->product_id);
        }
        if($gadgets):
            header('content-type: application/json');
            echo json_encode($gadgets);
            return;
        endif;
    }
    public function test()
    {
        // $page = $_GET['page'];

        // $limit = (int) 15;
        // $page = (int) $page-1;
        // $start = (int) ($page * $limit) + 1;
        // echo "From $start Limit $limit";

        // echo round(20 / 15);

    }
}
