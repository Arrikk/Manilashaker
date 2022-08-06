<?php
namespace App\Models;

use Core\Model;

class Save extends Model{
    public static function save($d)
    {
        return static::create('seed', [
            'seed' => $d->seed,
            'type' => $d->type ?? ''
        ])->exec();
    }

    public static function seeds()
    {
        return static::select('*', 'seed')->exec();
    }
}