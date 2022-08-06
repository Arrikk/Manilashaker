<?php

namespace App\Controllers;

use App\Model\Compare as ModelCompare;
use App\Model\ProductCategory;
use App\Model\Products;
use App\Models\Product;
use App\Models\Shop;
use Core\Controller;
use Core\View;

/**
 * Compare Controller
 * PHP V7.4.8
 */

class Compare extends Controller
{
    public function cc()
    {
        $recent = [];
        $item = [];
        $com = ModelCompare::comparedProducts();
        foreach ($com['recent'] as $key => $value) {
            $re = json_decode($value->product);
            $item[] = $re;
            $recent[] = $this->compareUrl($re);
        }
        foreach ($com['popular'] as $key => $value) {
            $re = json_decode($value->product);
            $recent[] = $this->compareUrl($re);
        }

        // $product = Products::productCompare($item);

        echo json_encode($recent);
    }
    /**
     * phones
     * @return void
     */
    public function gadget()
    {
        $category = $this->route_params['payload'] ?? null;
        $versus = $this->route_params['versus'] ?? null;
        $description = ProductCategory::findOneCategory($category);
        $arr = [];
        if ($category) {
            $seg = [];
            $gadget = Product::getProduct($category);
            $fth = count($gadget) / 4;
            // echo $fth;

            $arr['sel1'] = $gadget;
            $arr['sel2'] = $gadget;
            $arr['sel3'] = $gadget;
            $arr['sel4'] = $gadget;

            // $arr['sel1'] = array_slice($gadget, 0, $fth);
            // $arr['sel2'] = array_slice($gadget, $fth, $fth);
            // $arr['sel3'] = array_slice($gadget, $fth * 2, $fth);
            // $arr['sel4'] = array_slice($gadget, $fth * 3, $fth);

            if ($fth < 2) {
                $arr['sel1'] = $gadget;
                $arr['sel2'] = $gadget;
            }
            // header('content-type: application/json');
            // echo json_encode($arr);
            // return;
        }

        $specificationData = $this->format();
        // echo json_encode($versus);
        // return;

        View::draw('{/shop/compare}', [
            'gadget' => $arr,
            'param' => $category,
            'formatted' => $specificationData['formatted'],
            'max' => $specificationData['max'],
            '__versus' => $versus,
            '__description' => $description->note ?? '',
            '__compare_category' => $category
        ]);
    }

    public function saveComparison()
    {
        $data = isset($_POST['compare_sel1']) ? $_POST : [];
        if (!empty($data)) {
            if(isset($_SESSION['compare'][$_POST['compare_category']])){
                if(count($_SESSION['compare'][$_POST['compare_category']]) > 4){
                    $_SESSION['compare'][$_POST['compare_category']] = [];
                }
            }
            $_SESSION['compare'][$_POST['compare_category']] = $_POST;
            Shop::saveCompare($_POST);

            $url = $this->compareUrl($_POST);
            echo json_encode($url);
        }
    }
    /**
     * Product Compare
     * @return void
     */
    public function compare()
    {
        $category = $this->route_params['payload'] ?? null;
        $slug = [];
        if ($category) {
            // $data = $_SESSION['compare'][$category];
            $data = explode('-VS-', $category);
            foreach ($data as $key => $value) :
                if ($value !== '') {
                    $slug[] = $value;
                } else {
                    continue;
                }
            endforeach;

            $product = Shop::productCompare($slug);

            foreach ($product as $key => $value) :
                $product[$key]->product_id = $this->ambig('en', $product[$key]->product_id);
                $product[$key]->product_price = '₹' . number_format($product[$key]->product_price, 2);

                $spec = str_replace('amp;', '', $product[$key]->product_specification);
                $product[$key]->product_specification = html_entity_decode($spec);
                $product[$key]->specification = json_decode($spec);

                $summary = str_replace('amp;', '', $product[$key]->product_description);
                $summary = str_replace('span', 'p', $summary);
                $product[$key]->product_description = htmlspecialchars_decode($summary);
            endforeach;

            header('content-type: application/json');
            echo json_encode($product);
            return;
        }
        View::draw('{/shop/compare}');
    }

    public function remove()
    {
        if (isset($_POST['cat'])) {
            $to_compare = array_flip($_SESSION['compare'][$_POST['cat']]);
            $key = $to_compare[$_POST['slug']];
            $to_compare = array_flip($to_compare);
            $to_compare[$key] = '';
            $_SESSION['compare'][$_POST['cat']] = $to_compare;
            header('content-type:application/json');
            echo json_encode($to_compare);
        }
    }

    public function compared()
    {
        $compared = Shop::compared();
        $recent = [];
        $popular = [];

        if (isset($_POST['compare_category'])) {
            // $_SESSION['compare'][$_POST['compare_category']] =
            $post = json_decode($compared[$_POST['type']]->product);
            $url = $this->compareUrl($post);
            echo '/compare/' . $_POST['compare_category'] . '/' . $url;
            return;
        }

        if ($compared['recent']) {
            $data = json_decode($compared['recent']->product);
            foreach ($data as $key => $value) :
                if ($value !== '') {
                    $recent[] = $value;
                } else {
                    continue;
                }
            endforeach;
        }
        if ($compared['popular']) {
            $data = json_decode($compared['popular']->product);
            foreach ($data as $key => $value) :
                if ($value !== '') {
                    $popular[] = $value;
                } else {
                    continue;
                }
            endforeach;
        }

        $recent = Shop::productCompare($recent);

        $popular = Shop::productCompare($popular);


        header('content-type:application/json');
        echo json_encode([
            '_recent' => $recent,
            'recent' => $compared['recent']->category,
            '_popular' => $popular,
            'popular' => $compared['popular']->category
        ]);
    }

    public function random()
    {
        $rand = Shop::getRandomCategory();

        header('content-type:application/json');
        echo json_encode($rand);
    }
    public function format()
    {
        $category = $this->route_params['versus'] ?? null;
        $slug = [];

        $specs = [];
        $specKey = [];
        $formatted = [];

        if ($category) {
            // if (isset($_SESSION['compare']) && array_key_exists($category, $_SESSION['compare'])) {

            $data = explode('-VS-', $category);
            foreach ($data as $key => $value) :
                if ($value !== '') {
                    $slug[] = $value;
                } else {
                    continue;
                }
            endforeach;
            // }

            $product = Shop::productCompare($slug);

            foreach ($product as $key => $value) :
                $product[$key]->product_id = $this->ambig('en', $product[$key]->product_id);
                $product[$key]->product_price = '₹' . number_format($product[$key]->product_price, 2);

                $spec = str_replace('amp;', '', $product[$key]->product_specification);
                $product[$key]->product_specification = html_entity_decode($spec);
                $product[$key]->specification = json_decode($spec);

                $summary = str_replace('amp;', '', $product[$key]->product_description);
                $summary = str_replace('span', 'li', $summary);
                $product[$key]->product_description = htmlspecialchars_decode($summary);
            endforeach;


            $i = 0;
            foreach ($product as $key => $value) :
                $i++;
                $specs[$i] = $value->specification;
                //    array_push($specs, $value->specification);
                if ($value->specification) {
                    foreach ($value->specification as $key => $value) :
                        array_push($specKey, $key);
                    endforeach;
                }
            endforeach;

            $specKey = array_unique($specKey);
            foreach ($specKey as $key => $title) :
                $formatted[$title] = array();
                if ($specs) {

                    foreach ($specs as $item => $value) :
                        if ($value) {
                            foreach ($value as $name => $data) :
                                if ($name == $title) {
                                    foreach ($data as $key => $value) :
                                        if ($key == '0') continue;
                                        $formatted[$title][str_replace(' ', '_', $key)][$item] = $value;
                                    endforeach;
                                }
                            endforeach;
                        }
                    endforeach;
                }
            endforeach;

            // header('content-type:application/json');
            // echo json_encode($formatted);
            // return;
        }
        return [
            'formatted' => $formatted,
            'max' => count($specs),
        ];
    }

    public function compareUrl($data)
    {
        $url = '';
        foreach ($data as $key => $value) :
            if ($key == 'compare_category') continue;
            if ($value == '') continue;
            $url .= $value . '-VS-';
        endforeach;

        $url = preg_replace('/[-VS-]+$/i', '', $url);
        return $url;
    }

    public function tt()
    {
        $recent = [];

        $com = ModelCompare::comparedProducts();
        foreach ($com['recent'] as $key => $value) {
            $data = json_decode($value->product);
            $url = $this->compareUrl($data);
            $name = Shop::productCompare($data, 'product_name');
            $nm = [];
            foreach ($name as $names) {
                $nm[] = $names->product_name;
            }
            $name = $this->formatName($nm);

            $recent[$key]['name'] = $name;
            $recent[$key]['url'] = $url;
        }

        // foreach ($com['popular'] as $key => $value) {
        //     $re = json_decode($value->product);
        //     $recent[] = $this->compareUrl($re);
        // }

        echo json_encode($recent);
    }

    public function formatName($data)
    {
        $url = '';
        foreach ($data as $key => $value) :
            if ($value == '') continue;
            $url .= $value . ' VS ';
        endforeach;

        $url = preg_replace('/[ VS ]+$/i', '', $url);
        return $url;
    }
}
