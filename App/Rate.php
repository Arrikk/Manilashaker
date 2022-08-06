<?php
namespace App;

class Rate 
{
    protected $rate = 1;

    public function __construct() {

    }

    public function getRate()
    {
        # code...
    }

    public static function convert($amout)
    {
        $rate = new Rate;
        return $amout * $rate->rate;
    }
}