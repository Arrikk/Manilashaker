<?php

namespace App\Model;

use App\Model\Products;
use App\Token;
use Core\Traits\Model;
use Core\Http\Res;

/**
 * User model
 *
 * PHP version 7.4.8
 */
class ProductCategory extends \Core\Model
{
    use Model; # Use trait only if using the find methods

    /**
     * Each model class requires a unique table base on field
     * @return string $table ..... the table name e.g 
     * (users, posts, products etc based on your Model)
     */
    public static $table = "product_category"; # declear table only if using traitModel
    public static $error = [];

    /**
     * Error messages
     *
     * @var array
     */
    public $errors = [];

    /**
     * dump a product category
     * @param array $items
     * @return object
     */
    public static function dumpCategory($item = [])
    {
        return ProductCategory::dump($item);
    }
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
            'category_name' => static::clean($name ?? ''),
            'category_slug' => static::clean($slug ?? ''),
            'category_desc' => static::clean($description ?? ''),
            'category_image' => static::clean($image ?? 'image'),
            'category_parent' => (int) $parent
        ];

        if ($type == 'update') :
            $old_slug = ProductCategory::categories([$category => 'category_slug']);
            $with_old_slug = Products::findProductByCategory($old_slug);

            foreach ($with_old_slug as $key => $value) :
                Products::updateProduct(
                    ['product_category' => $old_slug],
                    ['product_category' => $slug]
                );
            endforeach;

            return ProductCategory::findAndUpdate(['category_id' => $category], $fields);
        endif;

        if (ProductCategory::findOneCategory($slug)) :
            return false;
        endif;
        // if ($image == '') {
        //     return false;
        // }

        if ($type == 'save')
            return ProductCategory::dump($fields);
    }


    /**
     * Find a category
     * @param string $param1
     * @param string $param2
     * @return object
     */
    public static function findOneCategory($param1 = '', $param2 = '*')
    {
        return ProductCategory::findOne([
            'category_slug' => self::clean($param1)
        ], $param2);
    }
    /**
     * Get all categories (parent category or by id)
     * @param int $id category id
     * @param string $name return only name
     * @return object
     */
    public static function categories($id = null, $name = null)
    {
        if ($id !== null) {
            if ($id == 0) return Res::status(401)->send('Unrecognized');
            $cat =  ProductCategory::findOne(['category_id' => $id]);
            if ($name !== null) return Res::Send($cat->$name ?? 'Uncategorized');
            return Res::json($cat);
        }

        return ProductCategory::find(['category_parent' =>  0]);
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
            $type = self::findOneCategory($slug);
            // return $type;
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
        $product = static::findOne([
            'category_id' => 0,
            'or.category_parent' => $parent
        ]);
        // return static::cat($product->category_parent);
    }

    /**
     * Find child category
     */
    public static function childCategory($id, $slug = null, $param2 = '*')
    {
        if($slug){
            $pcat = self::findOneCategory($slug);
            if(!$pcat) return [];
            return self::find(['category_parent' => $pcat->category_id], $param2);
        }
        return self::find(['category_parent' => $id], $param2);
    }

    /**
     * Get all child category
     * @return array
     */
    public static function allChildCategory()
    {
        return self::find(['$' => 'category_parent != 0']);
    }

    /**
     * Return category name
     * @param int @id categor_id
     * @return string
     */
    public static function categoryName($id)
    {
        $name = static::findOne(['category_id' => $id], 'category_name');
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
        $products = Products::findProductByCategory($slug);

        $uncategorized = self::findOneCategory(['category_slug' => $slug], 'category_name');

        if (!$uncategorized) :
            static::dump([
                'category_name' => 'Uncategorized',
                'category_slug' => 'uncategorized',
                'category_image' => ''
            ]);
        endif;

        foreach ($products as $key) :
            Products::updateProduct(
                ['product_id' => $key->product_id],
                ['product_category' => 'uncategorized']
            );
        endforeach;

        return self::findAndDelete([
            'category_slug' => $slug,
            'or.category_id' => $id
        ]);
    }


    public static function description($data)
    {
        extract($data);
        $cat = self::findOne([
            'category_id' => (int) $category,
            'and.!category_parent' => 0
        ]);
        
        if ($cat) :
                return self::findAndUpdate(['category_id' => self::clean($category)], ['note' => self::clean($description ?? '')]);
        endif;
    }


    //===================================================== ===============
    //===================================================== ===============
    //===================================================== ===============
    //===================================================== ===============
    //===================================================== ===============
    //===================================================== ===============
}
