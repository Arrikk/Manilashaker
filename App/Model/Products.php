<?php

namespace App\Model;

use App\Model\ProductCategory;
use Core\Traits\Model;

/**
 * User model
 *
 * PHP version 7.4.8
 */
class Products extends \Core\Model
{
    use Model; # Use trait only if using the find methods

    /**
     * Each model class requires a unique table base on field
     * @return string $table ..... the table name e.g 
     * (users, posts, products etc based on your Model)
     */
    public static $table = "products"; # declear table only if using traitModel
    public static $error = [];

    /**
     * Error messages
     *
     * @var array
     */
    public $errors = [];

    const VISITED = "visited";
    const FAVORITE = "favorite";
    const LIMIT = 20;

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
            return static::findAndUpdate(
                ['product_id', $product_update],
                $productData
            );
        }

        if ($bot) {
            $cat = ProductCategory::findOneCategory($category);
            if (!$cat || $cat == false) {
                ProductCategory::dumpCategory([
                    'category_name' => ucfirst(str_replace('-', ' ', $category)),
                    'category_slug' => self::clean($category),
                    'category_image' => $image,
                ]);
            }

            $sel = Products::findOneProduct($slug);

            if (!$sel) {
                return Products::dump($productData);
            }
            return false;
        }

        return Products::dump($productData);
    }

    /**
     * update Product
     */
    public static function updateProduct($params1, $params2)
    {
        return Products::findAndUpdate($params1, $params2);
    }

    /**
     * Update Product Visited / Favorite
     * @param string $slug product slug
     * @return bool
     */
    public static function updateVisited($slug, $type = Products::VISITED)
    {
        $product = Products::findOneProduct($slug, Products::VISITED);
        $visited = $product->visited;
        return Products::updateProduct(
            ['product_slug' => $slug],
            ['visited' => $visited+1]
        );
    }

    /**
     * Find one product
     * @param string $param1
     * @param string $param2
     * @return object
     */
    public static function findOneProduct($param1, $param2 = '*')
    {
        return Products::findOne([
            'product_slug' => $param1
        ], $param2);
    }

    /**
     * Find product by category
     * @param mixed $category category
     * @return array
     */
    public static function findProductByCategory($category)
    {
        return Products::find(['product_category' => $category]);
    }

    /**
     * Get products
     * @param string $category product category
     * @return array
     */
    public static function getProduct($category = '', $page = 1, $limit = false)
    {
        if (isset($category) && $category !== '') {
            $product = [];
            $textFind = 'category_id as id, category_parent as parent';
            $parent = ProductCategory::findOneCategory($category, $textFind);

            if ($parent->parent == 0) :

                $children = ProductCategory::childCategory($parent->id, 'category_slug as slug');

                foreach ($children as $key) :

                    $products = static::find([
                        'product_category' => $key->slug,
                        '$.order' => 'product_id DESC',
                    ], 'product_name, product_id, product_image, product_slug, product_price');

                    $product = array_merge($product, $products);

                endforeach;
                return $product;
            endif;

            return self::find([
                'product_category' => $category,
                '$.order' => 'product_id DESC'
            ], 'product_name, product_id, product_image, product_slug');
        }

        if ($page < 0) $page = 1;
        $limit = $limit ? $limit : static::LIMIT;
        $page = $page - 1;
        $start = (int) ($page * $limit) + 1;

        $products = self::find([
            '$.order' => 'createdAt DESC',
            '$.limit' => "$page, $limit"
        ]);

        $count =  static::findOne([], 'COUNT(*) as count')->count;
        if ($count < 1) {
            $count == 1;
        }

        $avg = round($count / $limit);
        return [
            'product' => $products,
            'avg' => $avg
        ];
    }

    /**
     * Get product by id and slug
     * @param array $data
     * @return object
     */
    public static function getProductBySlugAndId($data)
    {
        extract($data);
        return static::findOne([
            'product_slug' => $edit,
            'and.product_id' => $product
        ]);
    }

    /**
     * Get latest products
     * Select product by created date DESC
     * @return array
     */
    public static function latestProduct()
    {
        return static::find([
            '$.order' => 'createdAt DESC',
            '$.limit' => '5'
        ]);
    }

    /**
     * Get Popular Products
     */
    public static function popuLarProducts()
    {
        return static::find([
            '$.order' => 'visited ASC',
            '$.limit' => 10
        ], '*, DATE_FORMAT(createdAt, "%b %d %y") as date');
    }

    /**
     * 
     * 
     */ /**
     * Get product by their ID
     * @param array $array products to find
     * @return array
     */
    public static function productCompare($array)
    {
        $product = [];
        foreach ($array as $id) :
            $data = Products::findOne(['product_slug' => $id]);
            if ($data !== false)
                $product[] = $data;
        endforeach;
        return $product;
    }

    /**
     * Footer Products Smartphones
     */
    public static function footerGadgets($category = '', $page = 1, $limit = 1)
    {
        if (isset($category) && $category !== '') {
            $product = [];
            $textFind = 'category_id as id, category_parent as parent';
            $parent = ProductCategory::findOneCategory($category, $textFind);

            if ($parent->parent == 0) :

                $children = ProductCategory::childCategory($parent->id, 'category_slug as slug');

                foreach ($children as $key) :

                    $products = static::find([
                        'product_category' => $key->slug,
                        '$.order' => 'product_id DESC',
                        '$.limit' => $limit
                    ], 'product_name, product_category, product_id, product_image, product_slug, product_price');

                    $product = array_merge($product, $products);

                endforeach;
                return $product;
            endif;

            return self::find([
                'product_category' => $category,
                '$.order' => 'product_id DESC'
            ], 'product_name, product_id, product_image, product_slug');
        }
    }


    //===================================================== ===============
    //===================================================== ===============
    //===================================================== ===============
    //===================================================== ===============
    //===================================================== ===============
    //===================================================== ===============
}
