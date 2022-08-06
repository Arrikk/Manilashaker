<?php
namespace App\Models;

use PDO;
use \App\Token;

/**
 * User model
 *
 * PHP version 7.0
 */
class Admin extends \Core\Model
{

    /**
     * Error messages
     *
     * @var array
     */
    public $errors = [];

    CONST DEFAULT = 1;
    CONST MASTER = 2;
    CONST WRITER = 3;

    /**
     * Class constructor
     *
     * @param array $data  Initial property values (optional)
     *
     * @return void
     */
    public function __construct($data = [])
    {
        foreach($data as $key => $value){
            $this->$key = $value;
        }
    }

    /**
     * Create or modify an author account
     * @param array $data to create or modify
     * @return bool
     */
    public static function saveAuthor($data)
    {
        extract($data);
        $fields = array(
            'firstName' => static::clean(ucwords($name)),
            'email' => $email,
            'type' => $role,
            'desc' => static::clean($description)
        );

        if($role == '') return false;

        if($type == 'save'){
            $fields['password_hash'] = password_hash(strtolower(str_replace(' ', '_',$name)), PASSWORD_DEFAULT);
            return static::create('users', $fields)->exec();
        }else{
            return static::update('users', $fields)
            ->where('user_id', $user)->exec();
        }
    }

    /**
     * Get Authors
     * @param int $id single author id
     * @return array
     */
    public static function authors($id = null)
    {
        if($id !== null){
            return static::select('*', 'users')
            ->where('user_id', $id)->obj()->exec();
        }
        return static::select('*', 'users')
        ->where('type', 0, '!=')->order('type ASC')->exec();
    }

    /**
     * Trash author (delete all post of author and comments)
     * @param int $id author id
     * @return bool
     */
    public static function trashAuthor($id)
    {
        $posts = static::select('post_id', 'posts')
        ->where('post_author', $id)->exec();

        foreach ($posts as $key => $value):
            static::trash('post_comments', ['post_id' => $value->post_id])->exec();
        endforeach;

        static::trash('posts', ['post_author' => $id])->exec();
        return static::trash('users', ['user_id' => $id])->exec();

    }
}