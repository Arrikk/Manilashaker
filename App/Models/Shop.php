<?php

namespace App\Models;

use App\Data;
use Core\Http\Res;
use Core\Model;

class Shop extends Model
{
    /**
     * Get all gadgets from store
     * ordered randomly limit of 15
     * @return mixed
     */
    public static function test()
    {
        $key = 'ram';
        $val = '3 gb';
        $param = '"' . $key . '":"' . str_replace('_', ' ', $val) . '"';

        $cat = static::select('*')
            ->from('products')
            ->where('product_specification', '%' . $param . '%', 'LIKE')
            ->exec();
        return $cat;
    }
    public static function gadgets($slug = '', int $page = 1)
    {


        if ($page < 0) {
            $page == 1;
        }
        $page = (int) $page - 1;
        $limit = (int) 15;
        $start = (int) ($page * $limit) + 1;

        if (isset($slug) && $slug !== '') {
            return static::select('*')->from('products p')->inner('product_category c')
                ->on('p.product_category = c.category_slug')
                ->where('product_slug', $slug)->obj()->exec();
        } else {
            // $from = $limit * $page;

            return static::select('*')
                ->from('products p')
                ->right('product_category c')
                ->on('p.product_category = c.category_slug')
                ->order('RAND() ASC')
                ->limit("$start, $limit")->exec();
        }
    }

    /**
     * Filter product
     * @param mixed $filter
     * @return array
     */
    public static function filter($filter)
    {
        return static::select('*')
            ->from('products p')
            ->right('product_category c')
            ->on('p.product_category = c.category_slug')
            ->where('product_category', $filter)
            ->or('in_stock', $filter)
            ->or('featured', $filter)
            ->exec();
    }

    /**
     * Get gadget paginated
     */
    public function productPage()
    {
        $count =  static::select('COUNT(*)')
            ->from('products')->exec();
        if ($count < 1) {
            $count == 1;
        }
        return $page = round($count / 15);
    }

    /**
     * Get Latest Product
     * @return object
     */
    public static function latestProduct()
    {
        return static::select('*')
            ->from('products')
            ->group('product_category')
            ->order('RAND() DESC')
            ->obj()->exec();
    }
    /**
     * Get Latest Product
     * @return object
     */
    public static function recommended()
    {
        return static::select('*')
            ->from('products')
            ->group('product_category')
            ->order('RAND() DESC')
            ->limit(3)->exec();
    }

    /**
     * Selecct Featured Products
     * @return array
     */
    public static function featured()
    {
        return static::select('*')
            ->from('products p')
            ->right('product_category c')
            ->on('p.product_category = c.category_slug')
            ->where('featured', 'on')
            ->order('RAND() ASC')
            ->limit(10)->exec();
    }

    // /**
    //  * Get a single product
    //  * @param string $slug Gadget /Product slug
    //  * @return object
    //  */
    // public static function productBySlug($slug)
    // {
    //     return static
    // }

    /**
     * Get produts by their category slug.
     * @param string $slug category slug
     * @return mixed
     */
    public static function productByCategory($slug, int $page = 1, $rest = [])
    {
        $page = $page - 1;
        if ($page < 0) $page = 1;
        $limit = 3;
        $start = $page * $limit;
        // return static::select('product_name, product_id, product_image, product_price, product_slug')
        //         ->from('products')  
        //         ->where('product_category', static::clean($slug))->exec();

        $select = static::select('category_parent as parent, category_id as id', 'product_category')
            ->where('category_slug', static::clean($slug))
            ->obj()->exec();


        if ($select->parent == '0') {
            $children = static::select('category_slug as slug', 'product_category')
                ->where('category_parent', $select->id)->order('RAND()')->exec();

            $categories = [];
            foreach ($children as $slug) :
                $cat = static::select('*')
                    ->from('products p')
                    ->right('product_category c')
                    ->on('p.product_category = c.category_slug')
                    ->where('product_category', static::clean($slug->slug));

                if (isset($rest['key']) && isset($rest['value'])) :
                    if ($rest['key'] !== '' && $rest['value'] !== '') {
                        $param = '"' . $rest['key'] . '":"' . str_replace('_', ' ', $rest['value']) . '"';
                        $cat->and('product_specification', '%' . $param . '%', 'LIKE');
                    }
                endif;

                $cat = $cat->limit("$start, $limit")->exec();
                foreach ($cat as $key) {
                    $categories[] = $key;
                }
            endforeach;
            return $categories;
        } else {
            $items = static::select('*')
                ->from('products p')
                ->right('product_category c')
                ->on('p.product_category = c.category_slug')
                ->where('product_category', static::clean($slug));
                if (isset($rest['key']) && isset($rest['value'])) :
                    if ($rest['key'] !== '' && $rest['value'] !== '') {
                        $param = '"' . $rest['key'] . '":"' . str_replace('_', ' ', $rest['value']) . '"';
                        $items->and('product_specification', '%' . $param . '%', 'LIKE');
                    }
                endif;

                if(isset($rest['key']) && isset($rest['to']) && isset($rest['from'])):
                    if ($rest['key'] !== '' && $rest['to'] !== '' && $rest['from'] !== '') {
                        extract($rest);
                        $exp = explode('_', $to);
                        $s = end($exp);
                        $to = (int) $to;
                        $from = (int) $from;

                        $param = '"' . $rest['key'] . '":"' . str_replace('_', ' ', $from.' '.$s) . '"';
                        $items->and('product_specification', '%' . $param . '%', 'LIKE');
                        for ($i=$from+1; $i <=$to ; $i++) { 
                            $param = '"' . $rest['key'] . '":"' . str_replace('_', ' ', $i.' '.$s) . '"';
                            $items->or('product_category', static::clean($slug));
                            $items->and('product_specification', '%' . $param . '%', 'LIKE');
                        }
                    }
                endif;

                $items = $items->order('product_id DESC')
                ->exec();
                // Res::json($items);
                return $items;
        }
    }

    /**
     * Search for a product by LIKE and product category
     * @param array $terms the search terms
     * @return array
     */
    public static function searchProduct($terms)
    {
        extract($terms);
        // if($product_cat == ''){
        return static::select('*')
            ->from('products p')
            ->inner('product_category c')
            ->on('p.product_category = c.category_slug')
            ->where('product_name', $s . '%', 'LIKE')
            ->and('product_category', $product_cat)
            ->or('product_name', $s . '%', 'LIKE')
            ->or('product_category', $product_cat . '%', 'LIKE')
            ->exec();
        // }else{
        //     return static::select('*')->from('products p')->inner('product_category c')
        //     ->on('p.product_category = c.category_slug')
        //     ->where('product_name', $s, 'LIKE')
        //     ->exec();
        // }

    }

    /**
     * Get product by their ID
     * @param array $array products to find
     * @return object
     */
    public static function productCompare($array, $field = '*')
    {
        $product = [];
        foreach ($array as $id) :
            if ($id == '') continue;
            $data = static::select($field, 'products')
                ->where('product_slug', $id)
                ->obj()
                ->exec();
            if ($data !== false)
                $product[] = $data;
        endforeach;
        return $product;
    }

    /**
     * Get details of carted product
     * @param string $slug slog for product
     * @return object
     */
    public static function cartProduct($slug)
    {
        return static::select('product_id, product_slug as slug', 'products')
            ->where('product_slug', $slug)
            ->obj()->exec();
    }

    /**
     * Get loggedin user billing address last used
     * @param int $id id of user
     * @return object
     */
    public static function billingAddress($id)
    {
        return static::select('*', 'billing_info')
            ->where('user_id', $id)
            ->obj()->exec();
    }

    /**
     * Checkout carted products, store and start 
     * order processig
     * @param array $field datas of product
     * @param int $user id of user who orderd
     * @return bool true or false otherwise
     */
    public static function checkout($fields = [], $user = 0)
    {
        extract($fields);

        $data = array(
            'order_user' => $user,
            'order_status' => 0,
        );

        $order = static::create('order', $data)->lid()->exec();

        $billing = array(
            'user_id' => $user,
            'billing_order_id' => $order,
            'billing_first_name' => static::clean($billing_first_name),
            'billing_last_name' => static::clean($billing_last_name),
            'billing_email' => static::clean($billing_email),
            'billing_phone' => static::clean($billing_phone),
            'billing_country' => static::clean($billing_country),
            'billing_postcode' => static::clean($billing_postcode),
            'billing_state' => static::clean($billing_state),
            'billing_city' => static::clean($billing_city),
            'billing_address_2' => static::clean($billing_address_2),
            'billing_address_1' => static::clean($billing_address_1),
            'payment_method' => static::clean($payment_method),
            'order_comments' => static::clean($order_comments)
        );

        $savedBilling = static::create('billing_info', $billing)->exec();

        $success = false;

        $orderTotal = 0;
        foreach ($checkout as $key) :
            $id = Blog::ambig('dec', $key['item']);
            $qty = $key['qty'];

            $product = static::select('*', 'products')
                ->where('product_id', $id)
                ->obj()->exec();

            $total = floatval($product->product_price) * floatval($qty);
            $orderTotal = $orderTotal + $total;

            $success = static::create('order_detail', [
                'order_product_id' => $product->product_id,
                'order_price' => $product->product_price,
                'order_quantity' => $qty,
                'order_id' => $order
            ])->exec();

        endforeach;
        if ($success) {
            $success = static::update('order', [
                'order_total' => $orderTotal
            ])->where('order_id', $order)->exec();
        }
        return $success;
    }

    /**
     * Product rating, comment and review
     * @param array $fields rating data
     * @return bool
     */
    public static function saveProductReview($fields)
    {
        extract($fields);
        $data = array(
            'message' => static::clean($comment),
            'rate' => (int) $star,
            'user_id' => $user,
            'product_id' => $product_rating
        );

        return static::create('product_review', $data)->exec();
    }

    /**
     * get product Reviews
     * @param int $id product id
     * @return array
     */
    public static function getReviews($id)
    {
        $comments =  static::select(
            'r.review_id, r.product_id, r.message, r.rate,
         DATE_FORMAT(r.createdAt, "%b %d %y") as date, u.username as lname, u.firstName as fname'
        )
            ->from('`product_review` r')
            ->inner('`users` u')
            ->on('r.user_id = u.user_id')
            ->where('product_id', $id)
            ->order('r.createdAt DESC')
            ->limit(10)->exec();

        $reviews = static::select('rate, count(rate) as count', 'product_review')
            ->where('product_id', $id)
            ->group('rate')
            ->order('rate DESC')->exec();

        $count = [
            'five'  => 0,
            'four'  => 0,
            'three' => 0,
            'two'   => 0,
            'one'   => 0
        ];

        $totalRev = 0;
        $totalCt = 0;

        foreach ($reviews as $key) :
            $ct = floatval($key->count) * floatval($key->rate);
            $totalRev = $totalRev + $ct;
            $totalCt = $totalCt + floatval($key->count);

            if ($key->rate == 5)
                $count['five'] = $key->count;
            if ($key->rate == 4)
                $count['four'] = $key->count;
            if ($key->rate == 3)
                $count['three'] = $key->count;
            if ($key->rate == 2)
                $count['two'] = $key->count;
            if ($key->rate == 1)
                $count['one'] = $key->count;

        endforeach;

        $total = $count['five'] + $count['four'] + $count['three'] + $count['two'] + $count['one'];
        if ($total == 0)
            $total = 1;

        $count['five'] = round($count['five'] * 100 / $total);
        $count['four'] = round($count['four'] * 100 / $total);
        $count['three'] = round($count['three'] * 100 / $total);
        $count['two'] = round($count['two'] * 100 / $total);
        $count['one'] = round($count['one'] * 100 / $total);

        $ratingCt = 0;
        if (!$totalRev == 0 || !$totalCt == 0) {
            $ratingCt = round($totalRev / $totalCt, PHP_ROUND_HALF_DOWN);
        }

        return [
            'comment' => $comments,
            'count' => $count,
            'rating' => $ratingCt
        ];
    }

    /**
     * Save Compared
     * @return bool
     */
    public static function saveCompare($array)
    {
        $pd = json_encode($array);
        return static::create('compared', [
            'category' => $array['compare_category'],
            'product' => $pd
        ])->exec();
    }

    /**
     * Get compared Lists
     */
    public static function compared()
    {
        $recent = static::select('*')
            ->from('compared')
            ->obj()
            ->order('id DESC')
            ->limit(1)->exec();

        $popular = static::select('*, count(category) as total')
            ->from('compared')
            ->group('category')
            ->order('id ASC')
            ->obj()->exec();

        return [
            'recent' => $recent,
            'popular' => $popular
        ];
    }

    /**
     * Select by random category
     * @return array
     */
    public static function getRandomCategory()
    {
        $categories = static::select('category_slug', 'product_category')
            ->where('category_parent', 0, '!=')->order('RAND()')
            ->limit(3)
            ->exec();

        $rt = [];
        foreach ($categories as $key => $value) {

            //    $rt[] = $categories[$key]->category_name;

            $rt[$categories[$key]->category_slug] = static::select('p.product_id, p.product_price, p.product_name, p.product_image, p.product_slug, p.product_category')->from('products p')->right('product_category c')
                ->on('p.product_category = c.category_slug')
                ->where('product_category', $categories[$key]->category_slug)
                ->order('RAND() ASC')
                ->limit(4)->exec();
        }
        return $rt;
    }

    public static function createImage()
    {
        $image = Data::images();

        foreach ($image as $key => $value) :
            $data = static::select('product_image as image, product_id as id', 'products')
                ->where('product_category', $key)->exec();

            foreach ($value as $key => $image) :
                // foreach ($data as $product) :
                if (isset($data[$key]->id)) {

                    $id = $data[$key]->id;
                    static::update(
                        'products',
                        ['product_image' => $image]
                    )->where('product_id', $id)
                        ->exec();
                }
            // endforeach;
            endforeach;
        endforeach;
    }
}
