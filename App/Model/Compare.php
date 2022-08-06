<?php
namespace App\Model;

use Core\Model;
use Core\Traits\Model as TraitsModel;

class Compare extends Model {
    static $table = 'compared';
    use TraitsModel;

    public static function comparedProducts($limit = 5)
    {
        $recent = Compare::find([
            '$.order' => 'id DESC',
            '$.limit' => $limit
        ]);

        $popular = Compare::find(
            [
                '$.group' => 'category',
                '$.order' => 'id ASC'
            ],
            '*, count(category) as total');

        return [
            'recent' => $recent,
            'popular' => $popular
        ];
    }
}