<?php
namespace App\Views;

abstract class Component {

    static function __callStatic($name, $arguments)
    {
        $method = '__'.$name;
        $static = (new static);
        if(method_exists($static, $method)){
            call_user_func_array([$static, $method], $arguments);
        }else{
            echo $method."Dosent Exist";
        }

    }
}