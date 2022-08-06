<?php

namespace App\Controllers\Admin;

use App\Data;
use App\Model\ProductCategory;

class Setval extends Authenticated
{
    public function format($item)
    {
        return trim(ucwords(str_replace('_', ' ', $item)));
    }
    public function title()
    {


        $cat = strtolower($_GET['category']);
        $data = Data::keys();
        $groups = array_keys((array) $data[$cat]);
        $childCat = ProductCategory::childCategory(null, $cat);
        echo json_encode([
            'group' => array_map(array($this, 'format'), $groups),
            'child' => $childCat
        ]);
    }
    
    public function key()
    {
        $cat = strtolower($_GET['category']);
        $group = strtolower($_GET['group']);
        $data =  Data::keys();
        $data = $data[$cat];

        $ndata = [];
        foreach ($data as $key => $value) {
            $keys = array_keys((array) $value);
            $ndata[$this->format($key)] = array_map([$this, 'format'], $keys);
        }
        // echo $this->format($group);
        // echo json_encode($ndata['Modes Programs']);

        echo json_encode($ndata[$this->format($group)]);
    }
}
