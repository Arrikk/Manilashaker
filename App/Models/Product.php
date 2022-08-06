<?php

namespace App\Models;

use Core\Model;
use Core\Traits\Model as TraitsModel;

class Product extends Model
{
    // ******************************************************
    // *************** PRODUCT MANAGEMENT *******************
    // ******************************************************
    /**
     * Add new Product and Update product
     * @param array $data form data
     * @return bool
     */
    public static function saveProduct($data, $bot = false)
    {
        extract($data);
        // if($name == '' || $price == '' || $category == '' || $description == '') {
        //     return false;
        // }
        $slug = preg_replace('/[^a-z0-9]+/i', '-', $name);
        $slug = static::clean(strtolower($slug));
        $productData = [
            'product_name' => static::clean($name),
            'product_price' => static::clean($price),
            'featured' => static::clean($featured ?? 'off'),
            'in_stock' => static::clean(isset($instock) ? 1 : 0),
            'product_quantity' => static::clean($quantity ?? ''),
            'product_category' => static::clean($category),
            'product_image' => static::clean($image),
            'product_description' => static::clean($description ?? ''),
            'product_summary' => static::clean($summary ?? ''),
            'product_specification' => $specification ?? '',
            'product_slug' => static::clean($slug),
            'design' => static::clean(json_encode($design ?? '')),
            'general' => static::clean(json_encode($general ?? '')),
        ];

        if ($action_type == 'editing') {
            return static::update('products', $productData)
                ->where('product_id', $product_update)->exec();
        }

        if ($bot) {
            $cat = static::select('category_slug', 'product_category')
                ->where('category_slug', $category)->obj()->exec();
            if (!$cat || $cat == false) {
                static::create('product_category', [
                    'category_name' => ucfirst(str_replace('-', ' ', $category)),
                    'category_slug' => self::clean($category),
                    'category_image' => $image,
                ])->exec();
            }

            $sel = static::select('*', 'products')
                ->where('product_slug', $slug)->obj()->exec();

            if (!$sel) {
                return static::create('products', $productData)->exec();
            }
            return false;
        }

        return static::create('products', $productData)->exec();
    }

    /**
     * Get products
     * @param string $category product category
     * @return array
     */
    public static function getProduct($category = 'laptops', $page = 1)
    {
        if (isset($category) && $category !== '') {
            $product = [];
            $parent = static::select('category_id as id, category_parent as parent', 'product_category')
                ->where('category_slug', $category)->obj()->exec();

            if ($parent->parent == 0) :

                $children = static::select('category_slug as slug', 'product_category')
                    ->where('category_parent', $parent->id)
                    ->exec();

                foreach ($children as $key) :
                    $products = static::select('product_name, product_id, product_image, product_slug', 'products')
                        ->where('product_category', $key->slug)
                        ->order('product_id DESC')->exec();
                    $product = array_merge($product, $products);
                endforeach;
                return $product;
            endif;

            return static::select('product_name, product_id, product_image, product_slug', 'products')
                ->where('product_category', $category)
                ->order('product_id DESC')->exec();
        }
        if($page < 0) $page = 1;
        $limit = 20;
        if($page < 0) $page = 0;
        $page = $page - 1;
        $start = (int) ($page * $limit) + 0;

        $products = static::select('*', 'products')->order('createdAt DESC')->limit("$start, $limit")->exec();
        
        $count =  static::select('COUNT(*) as count')
            ->from('products')->obj()->exec()->count;
        if ($count < 1) {
            $count == 1;
        }
        $avg = round($count / $limit);
        return[
            'product' => $products,
            'avg' => $avg
        ];
    }

    /**
     * All Product by their category
     * @param mixed $category product category
     * @return array
     */
    public static function getProductByCategory($category)
    {
        return static::select('*', 'products')
            ->where('product_category', $category)
            ->exec();
    }

    /**
     * Get product by id and slug
     * @param array $data
     * @return object
     */
    public static function getProductBySlugAndId($data)
    {
        extract($data);
        return static::select('*', 'products')
            ->where('product_slug', $edit)
            ->and('product_id', $product)
            ->obj()->exec();
    }

    /**
     * Delete a product
     * @param int $id product id
     * @return boolean
     */
    public static function deleteProduct(int $id)
    {
        return static::trash('products')
        ->where('product_id', $id)->exec();
    }

    /**
     * Get latest products
     * Select product by created date DESC
     * @return array
     */
    public static function latestProduct()
    {
        return static::select('product_name as name, product_image as image, product_price as price, product_slug as slug, product_category as category')
            ->from('products')->order('createdAt DESC')
            ->limit(5)->exec();
    }

    public function FunctionName()
    {
        # code...
    }

    // ******************************************************
    // *************** Category MANAGEMENT *******************
    // ******************************************************

    /**
     * Add new category and update category 
     * @param array $data form fields
     * @return bool
     */
    public static function saveCategory($data)
    {
        extract($data);
        $slug = preg_replace('/[^a-z]+/i', '-', $name);
        $slug = strtolower($slug);

        $fields = [
            'category_name' => static::clean($name),
            'category_slug' => static::clean($slug),
            'category_desc' => static::clean($description),
            'category_image' => static::clean($image ?? 'image'),
            'category_parent' => (int) $parent
        ];

        if ($type == 'update') :
            $old_slug = self::categories($category, 'category_slug');
            $with_old_slug = self::getProductByCategory($old_slug);

            foreach ($with_old_slug as $key => $value) :
                static::update('products', [
                    'product_category' => $slug
                ])->where('product_category', $old_slug)->exec();
            endforeach;

            return static::update('product_category', $fields)
                ->where('category_id', $category)
                ->exec();
        endif;

        if (static::select('category_slug', 'product_category')->where('category_slug', $slug)->exec()) :
            return false;
        endif;
        // if ($image == '') {
        //     return false;
        // }

        if ($type == 'save')
            return static::create('product_category', $fields)->exec();
    }

    /**
     * Get all categories
     * @param int $id category id
     * @param string $name return only name
     * @return object
     */
    public static function categories($id = null, $name = null)
    {
        if ($id !== null) {
            if ($id == 0) return 'Uncategorized';
            $cat =  static::select('*', 'product_category')
                ->where('category_id', $id)
                ->obj()
                ->exec();
            if ($name !== null) return $cat->$name ?? 'Uncategorized';
            return $cat;
        }
        return static::select('*', 'product_category')
            ->where('category_parent = 0')
            // ->or('category_id = category_parent')
            ->exec();
    }
    public static function productCategory($cat = null)
    {
        if ($cat !== null)
            return static::select('count(*) as counts', 'products')
                ->where('product_category', $cat)
                ->obj()->exec()->counts;

        return static::select('*', 'product_category')
            ->exec();
    }

    /**
     * Get Category by their slug
     * @param string $slug Category slug
     * @return object
     */
    public static function getCategoryBySlug(string $slug)
    {
        return static::select('*', 'product_category')
            ->where('category_slug', $slug)
            ->obj()->exec();
    }

    /**
     * Get Product Category Filter
     * @param string $slug product category slug
     * @return array
     */
    public static function filterCategory(string $slug)
    {
        $filtered = [];
        if ($slug !== null) {
            $type = self::getCategoryBySlug($slug);
            if ($type) :
                if ($type->category_parent == 0) :
                    $children = self::childCategory($type->category_id);
                    return $children;
                endif;
            endif;
        }
        return self::allChildCategory();
    }

    public static function cat($parent = 0)
    {
        $product = static::select('*', 'product_category')
            ->where('category_id', 0)->or('category_parent', $parent)->obj()->exec();
        // return static::cat($product->category_parent);
    }
    public static function childCategory($id)
    {
        return static::select('*', 'product_category')
            ->where('category_parent', $id)->exec();
    }

    /**
     * Get all child category
     * @return array
     */
    public static function allChildCategory()
    {
        return static::select('*', 'product_category')
            ->where('category_parent', 0, '!=')->exec();
    }

    /**
     * Return category name
     * @param int @id categor_id
     * @return string
     */
    public static function categoryName($id)
    {
        $name = static::select('category_name', 'product_category')
            ->where('category_id', $id)->obj()
            ->exec();
        return $name->category_name;
    }

    /**
     * Delete Category from product categories
     * Move all product category to uncategorized
     * if uncategorized does not exist create a new category
     * @param array product category ['id', 'slug']
     * @return bool
     */
    public static function trashCategory($data)
    {
        extract($data);
        $slug = static::clean($slug);
        $products = static::select('*', 'products')
            ->where('product_category', $slug)->exec();

        $uncategorized = static::select('category_name',  'product_category')
            ->where('category_slug', $slug)->obj()->exec();

        if (!$uncategorized) :
            static::create('product_category', [
                'category_name' => 'Uncategorized',
                'category_slug' => 'uncategorized',
                'category_image' => ''
            ])->exec();
        endif;

        foreach ($products as $key) :
            static::update('products', [
                'product_category' => 'uncategorized'
            ])->where('product_id', $key->product_id)->exec();
        endforeach;

        return static::trash('product_category')
            ->where('category_slug', $slug)
            ->or('category_id', $id)->exec();
    }

    // ******************************************************
    // *************** Order MANAGEMENT *******************
    // ******************************************************

    /**
     * Product ORDER
     */
    public static function orders()
    {
        return static::select('o.order_id as id, o.order_status as status, o.order_total as total, 
        o.createdAt as date, b.billing_first_name as fname, b.billing_last_name as lname')
            ->from('`order` o')->left('billing_info b')->on('b.billing_order_id = o.order_id')->order('o.createdAt DESC')
            ->exec();
    }

    /**
     * Order Details
     */
    public static function orderDetails($id)
    {
        $d =  static::select('*')->from('order_detail o')
            ->left('billing_info b')->on('o.order_id = b.billing_order_id')
            ->where('order_id', $id)->exec();

        $s =  static::select('*')->from('order_detail o')
            ->left('billing_info b')->on('o.order_id = b.billing_order_id')
            ->where('order_id', $id)->obj()->exec();

        return [
            'user' => $s,
            'item' => $d
        ];
    }

    /**
     * Product Details 
     */
    public static function orderProduct($id)
    {
        return static::select('product_name, product_image')
            ->from('products')->where('product_id', $id)
            ->obj()->exec();
    }

    /**
     * Product order status
     */
    public static function orderStatus($id)
    {
        $status = static::select('order_status', 'order')
            ->where('order_id', $id)
            ->obj()->exec();
        switch ($status->order_status) {
            case '0':
                return 'Not Paid';
                break;
            case '1':
                return 'Awaiting Payment';
                break;
            case '2':
                return 'Shipped';
                break;
            case '3':
                return 'Confirmed';
                break;
            case '4':
                return 'Delivered';
                break;
            default:
        }
    }

    /**
     * Change order status
     */
    public static function changeStatus($arg)
    {
        return static::update('order', [
            'order_status' => (int) $arg['change']
        ])->where('order_id', (int) $arg['details'])->exec();
    }

    // =====================================
    public function featuredProduct()
    {
        return static::select('*', 'product')->exec();
    }

    public static function multiple($data)
    {
        foreach ($data['multiselect'] as $key => $value) :
            static::update('product_category', [
                'category_parent' => $data['parentCategory']
            ])->where('category_id', $value)->exec();
        endforeach;
        return true;
    }

    /**
     * Get Highest Price
     * @param string $slug category slug
     * @return object
     */
    public static function priceFilter(string $slug)
    {
        $sel = static::select('product_price as price', 'products');
        if ($slug !== '') {
            $parent = self::getCategoryBySlug($slug);
            if ($parent) :
                if ($parent->category_parent == 0) {
                    $children = static::select('product_category as slug', 'products')
                        ->order('product_price DESC')->limit(1)
                        ->obj()->exec();
                    $sel->where('product_category', $children->slug);
                } else {
                    $sel->where('product_category', $slug);
                }
            endif;
        }
        $sel->order('product_price DESC')->limit(1);
        $sel = $sel->obj()->exec();

        return $sel;
    }

    /**
     * Filter Product By Price
     * @param array $range price range
     * @return array
     */
    public static function priceRange($range)
    {
        $from = (int) static::clean($range['from']);
        $to = (int) static::clean($range['to']);
        return static::select('*')
            ->from('products p')
            ->right('product_category c')
            ->on('p.product_category = c.category_slug')
            ->where('product_price')
            ->btw($from, $to)->and('product_category', $range['category'])
            ->order('product_id DESC')
            ->exec();
    }
}
