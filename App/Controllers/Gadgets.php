<?php

namespace App\Controllers;

use App\Auth;
use App\Controllers\Authenticated\Authenticated;
use App\Model\Post;
use App\Model\ProductCategory;
use App\Model\Products;
use App\Models\Product;
use App\Models\Shop as ModelsShop;
use App\Rate;
use Core\Controller;
use Core\Http\Res;
use Core\View;

class Gadgets extends Authenticated
{
    public function product()
    {
        $slug = $this->route_params['parent'] ?? null;
        if ($slug == 'mobile-phones') $slug = 'phones';

        $filtered = [
            'slug' => $slug,
            'category' => ProductCategory::filterCategory($slug ?? ''),
        ];

        $subCat = $this->route_params['payload'] ?? $slug ;
        $sideFilterList = $this->getFilterList($subCat);
        // return;

        if (isset($slug) || isset($_GET['product_cat'])) {
            View::draw('{/shop/home}', [
                '__class' => 'home-v2',
                '__category' => true,
                '__slug' => ucfirst($slug ?? $_GET['product_cat']),
                '__prices' => $this->genNum($slug ?? ''),
                '__filtered' => $filtered,
                '__filterList' => $sideFilterList,
                '__filterRange' => $this->filterRange()
            ]);
            // echo json_encode(Product::test());
            return;
        }

        // View::draw('{/shop/home}', [
        //     '__class' => 'home-v2',
        //     '__prices' => $this->genNum($slug ?? ''),
        //     '__filtered' => $filtered,
        // ]);
        // return;
    }

    public function getFilterList($item)
    {
        $slug = [];
        $specs = [];
        $specKey = [];
        $formatted = [];

        $product = Products::getProduct($item);
        foreach ($product as $key) :
            $slug[] = $key->product_slug;
        endforeach;
        $product = ModelsShop::productCompare($slug);
        $specifications = [];

        foreach ($product as $key => $value) :
            $spec = str_replace('amp;', '', $product[$key]->product_specification);
            $spec = json_decode($spec);
            if ($spec === null || empty($spec)) continue;
            else $specifications[] = $spec;
        endforeach;

        $i = 0;


        // echo json_encode($specifications);return;

        foreach ($specifications as $key => $value) :
            $i++;
            $specs[$i] = $value;
            //    array_push($specs, $value->specification);

            if (!empty($value) && is_object($value)) {
                foreach ($value as $key => $value) :
                    $key = trim(str_replace(['__', '_'], ' ', $key));
                    array_push($specKey, strtolower($key));
                endforeach;
            }
        endforeach;

        $tol = [];
        // echo json_encode($specs); return;
        $specKey = array_unique($specKey);
        foreach ($specKey as $key => $title) :
            $title = strtolower($title);
            // $title =  trim(str_replace(['__', '_'], ' ', $title));
            $formatted[$title] = array();
            foreach ($specs as $item => $value) :
                if (is_object($value)) :
                    foreach ($value as $name => $data) :
                        $name = strtolower(trim(str_replace(['__', '_'], ' ', $name)));
                        if ($name == $title) {
                            if (is_iterable((array) $data)) :
                                foreach ((array) $data as $key => $value) :
                                    if ($key == '0') continue;
                                    $formatted[$title][strtolower(rtrim(str_replace(' ', '_', $key)))][] = $value;
                                endforeach;
                            endif;
                        }
                    endforeach;
                endif;
            endforeach;
        endforeach;

        // echo json_encode($formatted);
        // return;

        $item = $this->alignItems(['formatted' => $formatted, 'slug' => $item]);
        return $item;
    }


    public function alignItems($items)
    {
        $formatted = $items['formatted'];
        $toSend = [];
        // echo json_encode($formatted);
        // return;
        if (array_key_exists('key specs', $formatted)) {
            $item = $formatted['key specs'];
            foreach ($item as $key => $value) {
                $item[$key] = array_unique($item[$key]);
            }
            // echo json_encode($item);
            return $item;
        }
        if (array_key_exists('performance', $formatted)) {
            $item = $formatted['performance'];
            foreach ($item as $key => $value) {
                $item[$key] = array_unique($item[$key]);
            }
            // echo json_encode($item);
            return $item;
        }
        if (array_key_exists('design', $formatted)) {
            $item = $formatted['design'];
            foreach ($item as $key => $value) {
                if ($key == 'title') continue;
                $item[$key] = array_unique($item[$key]);
            }
            // echo json_encode($item);
            return $item;
        }
        if (array_key_exists('dimensions', $formatted)) {
            $item = $formatted['dimensions'];
            foreach ($item as $key => $value) {
                if ($key == 'title') continue;
                $item[$key] = array_unique($item[$key]);
            }
            // echo json_encode($item);
            return $item;
        }
        if (array_key_exists('general', $formatted)) {
            $item = $formatted['general'];
            foreach ($item as $key => $value) {
                if ($key == 'title') continue;
                $item[$key] = array_unique($item[$key]);
            }
            // echo json_encode($item);
            return $item;
        }
        if (array_key_exists('filters', $formatted)) {
            $item = $formatted['filters'];
            foreach ($item as $key => $value) {
                if ($key == 'title') continue;
                $item[$key] = array_unique($item[$key]);
            }
            // echo json_encode($item);
            return $item;
        }
        if (array_key_exists('compatibility', $formatted)) {
            $item = $formatted['compatibility'];
            foreach ($item as $key => $value) {
                if ($key == 'title') continue;
                $item[$key] = array_unique($item[$key]);
            }
            // echo json_encode($item);
            return $item;
        }
        if (array_key_exists('storage', $formatted)) {
            $item = $formatted['storage'];
            foreach ($item as $key => $value) {
                if ($key == 'title') continue;
                $item[$key] = array_unique($item[$key]);
            }
            // echo json_encode($item);
            return $item;
        }
        if (array_key_exists('memory', $formatted)) {
            $item = $formatted['memory'];
            foreach ($item as $key => $value) {
                if ($key == 'title') continue;
                $item[$key] = array_unique($item[$key]);
            }
            // echo json_encode($item);
            return $item;
        }
        if (array_key_exists('connectivityports', $formatted)) {
            $item = $formatted['connectivityports'];
            foreach ($item as $key => $value) {
                if ($key == 'title') continue;
                $item[$key] = array_unique($item[$key]);
            }
            // echo json_encode($item);
            return $item;
        }
        if (array_key_exists('audio', $formatted)) {
            $item = $formatted['audio'];
            foreach ($item as $key => $value) {
                if ($key == 'title') continue;
                $item[$key] = array_unique($item[$key]);
            }
            // echo json_encode($item);
            return $item;
        }
        if (array_key_exists('connectivity', $formatted)) {
            $item = $formatted['connectivity'];
            foreach ($item as $key => $value) {
                if ($key == 'title') continue;
                $item[$key] = array_unique($item[$key]);
            }
            // echo json_encode($item);
            return $item;
        }
        if (array_key_exists('display', $formatted)) {
            $item = $formatted['display'];
            foreach ($item as $key => $value) {
                if ($key == 'title') continue;
                $item[$key] = array_unique($item[$key]);
            }
            // echo json_encode($item);
            return $item;
        }
        // return $items;
        // return json_encode($items['formatted']);
    }

    public function gadgets()
    {
        $slug = $this->route_params['payload'] ?? null;
        $category = $this->route_params['category'] ?? null;
        $_GET['category'] = $slug;
        $page = isset($_GET["page"]) ? $_GET["page"] : 1;

        if (isset($slug) && $slug == 'fetch_all_product') {

            if (isset($_GET['filter'])) {
                $gadgets = Product::priceRange($_GET);
            } else {
                $gadgets = ModelsShop::gadgets('', $page);
            }
            foreach ($gadgets as $key => $value) {
                $gadgets[$key]->category_name = str_replace(' ', '-', $gadgets[$key]->category_name);
                $gadgets[$key]->product_price = Rate::convert($gadgets[$key]->product_price);
                $gadgets[$key]->rating = ModelsShop::getReviews($gadgets[$key]->product_id);
                $gadgets[$key]->product_id = $this->ambig('en',  $gadgets[$key]->product_id);
                $product_specification = json_decode($gadgets[$key]->product_specification);
                $gadgets[$key]->product_specification = json_encode($product_specification);
            }
            header('content-type: application/json');
            echo json_encode($gadgets);
            return;
        }

        if (isset($slug) && $slug !== 'fetch_all_product') {
            if ($slug == 'mobile-phones') $slug = 'phones';
            if (isset($_GET['filter'])) $gadgets = Product::priceRange($_GET);
            else $gadgets = ModelsShop::productByCategory($slug, $page, $_GET ?? []);

            // header('content-type: application/json');
            // echo json_encode($gadgets);
            // return;
            //
            foreach ($gadgets as $key => $value) {
                $gadgets[$key]->category = $slug;
                $gadgets[$key]->product_price = Rate::convert($gadgets[$key]->product_price);
                $gadgets[$key]->rating = ModelsShop::getReviews($gadgets[$key]->product_id);
                $gadgets[$key]->product_id = $this->ambig('en',  $gadgets[$key]->product_id);
                $gadgets[$key]->product_specification = json_decode($gadgets[$key]->product_specification);
            }

            header('content-type: application/json');
            echo json_encode($gadgets);
            return;
        }

        if ($slug == null)
            $this->redirect('/mobile-phones/');
    }

    /**
     * Get single Product
     */
    public function singleProduct()
    {
        $slug = $this->route_params['payload'] ?? null;

        if ($slug == null)
            $this->redirect('/mobile-phones/');

        if ($slug) {
            $product = ModelsShop::gadgets($slug);
            !$product && $this->redirect('/mobile-phones/');
            $reviews = ModelsShop::getReviews($product->product_id);
            Products::updateVisited($slug);

            if (!empty($product) || $product !== null) {
                // header('content-type: application/json');
                $product->product_price = Rate::convert($product->product_price);
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
        if (isset($_GET['success'])) {
            View::draw('{/shop/success}');
            return;
        }

        if (isset($_POST['checkout']) && isset($_POST['payment_method'])) {
            $items = [];
            foreach ($_POST['checkout'] as $key => $value) :
                $items[] = [
                    'item' => $key,
                    'qty' => $value
                ];
            endforeach;
            $_POST['checkout'] = $items;
            if ($shop = ModelsShop::checkout($_POST, $this->user->user_id)) {

                header('content-type: application/json');
                echo json_encode($shop);
            } else {
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
        if (isset($_POST['star'])) {
            $_POST['product_rating'] = $this->ambig('dc', $_POST['product_rating']);
            $user = Auth::getUser();
            if ($user) {
                $_POST['user'] = $user->user_id;
                if (ModelsShop::saveProductReview($_POST)) {
                    http_response_code(200);
                    echo true;
                    return;
                }
                echo false;
                return;
            }
            http_response_code(401);
            echo json_encode(array('Login First'));
        } else {
            http_response_code(400);
            echo json_encode(array('Select star to continue'));
            return;
        }
    }

    public function filter()
    {
        $gadgets = ModelsShop::filter($_GET['filter']);
        foreach ($gadgets as $key => $value) {
            $gadgets[$key]->product_price = Rate::convert($gadgets[$key]->product_price);
            $gadgets[$key]->rating = ModelsShop::getReviews($gadgets[$key]->product_id);
            $gadgets[$key]->product_id = $this->ambig('en',  $gadgets[$key]->product_id);
        }
        if ($gadgets) :
            header('content-type: application/json');
            echo json_encode($gadgets);
            return;
        endif;
    }
    public function test()
    {
        echo json_encode(Product::priceRange($_GET));
        // echo json_encode(ModelsShop::createImage());
    }

    /**
     * Generate Price Filter Number
     */
    public function genNum(string $slug)
    {
        // $max = Product::priceFilter($slug)->price ?? 0;
        // $rows = 20;

        // $divided = $max / $rows;
        // $array = [];
        // $limit = 0;

        // for ($i = 0; $i <= $divided; $i++) {
        //     if ($i >= $rows) break;
        //     $array[] = array(
        //         'l' => ($divided * $i) + 1,
        //         'r' => ($divided * $i + $divided)
        //     );
        // }

        $array = [
            [
                'l' => 1,
                'r' => 5000,
            ],
            [
                'l' => 5001,
                'r' => 10000,
            ],
            [
                'l' => 10001,
                'r' => 14999,
            ],
            [
                'l' => 15000,
                'r' => 19999,
            ]
        ];
        return $array;
    }

    public function filterRange()
    {
        $ram = [
            [
                'l' => 1,
                'r' => 3,
            ],
            [
                'l' => 4,
                'r' => 6,
            ],
            [
                'l' => 7,
                'r' => 9,
            ],
            [
                'l' => 10,
                'r' => 12,
            ]
        ];
        $rows = 25;
        $battteryMax = 100000;

        $divided = $battteryMax / $rows;
        $battery = [];
        $limit = 0;

        for ($i = 0; $i <= $divided; $i++) {
            if ($i >= $rows) break;
            $battery[] = array(
                'l' => $i <= 0 ? 2500 : ($divided * $i) + 1,
                'r' => ($divided * $i + $divided)
            );
        }
        
        $rows = 5;
        $max = 24.5;
        $divided = $max / $rows;

        $display = [];
        for ($i = 0; $i <= $divided; $i++) {
            if ($i >= $rows) break;
            $display[] = array(
                'l' =>  ($divided * $i) + 1,
                'r' => ($divided * $i + $divided)
            );
        }

        return [
            'ram' => [$ram, 'GB'],
            'battery' => [$battery, 'Mah'],
            'display' => [$display, 'Inches']
        ];
    }

    public function Tests()
    {
        $post = Post::testModel();
        echo json_encode($post);
    }
}
