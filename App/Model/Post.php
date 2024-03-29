<?php

namespace App\Model;

use App\Models\User;
use Core\Http\Res;
use Core\Traits\Model;

/**
 * Post model
 *
 * PHP version 7.4.8
 */
class Post extends \Core\Model
{
    use Model; # Use trait only if using the find methods

    /**
     * Each model class requires a unique table base on field
     * @return string $table ..... the table name e.g 
     * (users, posts, products etc based on your Model)
     */
    public static $table = "posts"; # declear table only if using traitModel
    public static $error = [];

    const ALL = 'ALL';
    const BY_SLUG = 'BY_SLUG';
    const BY_ID = 'BY_ID';
    const BY_AUTHOR = 'BY_AUTHOR';
    const LIMIT = 10;

    /**
     * Error messages
     *
     * @var array
     */
    public $errors = [];

    /**
     * Dump post Method.... Get posts from the post model
     * @return mixed
     */
    public static function dumpPost($param = '', $type = Post::ALL, $page = 1)
    {
        $limit = Post::setLimit($page);
        $limit = $limit . ', ' . Post::LIMIT;

        //  query cols 
        $col = 'p.category_id, p.post_body, p.views, p.post_id as post_id,
        p.post_image, p.post_slug, p.post_tag,p.post_title, u.firstName,
         DATE_FORMAT(p.createdAt, "%b %a %y") as date, p.createdAt as dtime';


        switch ($type) {
            case Post::ALL:
                return static::findPost([], $col);
                break;
            case Post::BY_SLUG:
                return static::findOnePost([
                    'post_slug' => $param,
                    '$.limit' => $limit
                ]);
                break;
            case Post::BY_ID:
                return static::findOnePost([
                    'post_id' => $param
                ]);
                break;
            case Post::BY_AUTHOR:
                return static::findByAuthor($param, $limit);
                break;
            default:
                return [];
                break;
        }
    }

    /**
     * Find Post By specified params
     * @param array $param customize search params
     * @param string $column specify search column
     * @return array 
     */
    public static function findPost(array $param = [], string $column = '*')
    {
        return Post::find($param, $column);
    }

    /**
     * Find one post
     * @param array $param customize search params
     * @param string $column specify search column
     * @return object otherwise return bool
     */
    public static function findOnePost(array $param = [], $column = '*')
    {
        return Post::col('category_id')::findOne($param, $column);
    }

    /**
     * Find one post
     * @param array $param customize search params
     * @return array>bool  otherwise return bool
     */
    public static function findByAuthor(string $param, $limit = 5)
    {
        $col = 'p.category_id, p.post_body, p.views, p.post_id as post_id,
        p.post_image, p.post_slug, p.post_tag,p.post_title, u.firstName,
         DATE_FORMAT(p.createdAt, "%b %a %y") as date, p.createdAt as dtime';


        $author = User::findBy(['username' => $param]);

        if ($author) {

            static::$table = '';
            $posts = Post::findPost([
                '$.from' => 'posts p',
                '$.left' => 'post_comments c',
                '$.on' => 'c.post_id = p.post_id',
                '$.left' => 'users u',
                '$.on' => 'p.post_author = u.user_id',
                'post_author' => $author->user_id,
                'and.post_status' => 'published',
                '$.order' => 'p.post_id DESC',
                '$.limit' => $limit
            ], $col);
            static::$table = 'posts';

            return $posts;
        }
        return [];
    }

    /**
     * Get total post by author
     * @param string author username
     * @return 
     */
    public static function totalAuthorPost(string $username)
    {
        $author = User::findBy(['username' => $username]);

        if ($author) {

            $posts = Post::findPost([
                'post_author' => $author->user_id,
                'and.post_status' => 'published',
            ]);

            return count($posts);
        }

        return 1;
    }

    public static function setLimit($page, $lit = false)
    {
        $limit = $lit ? $lit : self::LIMIT;
        if ($page <= 0) $page = 1;
        $page = ($page - 1) * $limit;
        return $page;
    }

    /**
     * save post from migration
     */

    public static function post($data)
    {
        extract((array) $data);
        $tags = implode(',', $tag);
        $category = [];
        # check for incoming categories
        if (isset($categories) && !empty($categories)) :
            $category = array_map(function ($category) {
                return PostCategory::saveCategory([
                    'name' => $category,
                    'parent' => 0
                ]);
            }, $categories);
        endif;

        $author = self::getAuthor($email, $name);

        $data = [
            'post_title' => htmlspecialchars(trim($title)),
            'post_image' => htmlspecialchars(trim($image)),
            'category_id' => implode(',', $category),
            'post_body' => self::clean(htmlspecialchars(trim($post))),
            'post_description' => static::clean($meta_description),
            'post_author' => $author ?? 1,
            'post_status' => $status,
            'post_slug' => static::clean($slug),
            'post_tag' => $tags,
            'createdAt' => $createdAt
        ];
        if($post = Post::findOnePost(['post_slug' => $slug]))
            return;

        return Post::col('category_id')::dump($data);
    }

    public static function getAuthor($email, $name)
    {
        if($user = User::findByEmail($email)):
            return $user->user_id;
        else:
            $user = self::create('users', [
                'email' => $email,
                'firstName' => $name,
                'username' => strtolower(str_replace(' ', '_', $name)),
                'password_hash' => password_hash('author', PASSWORD_DEFAULT)
            ])->lid()->exec();
            $user = self::select('*', 'users')->where('user_id', $user)->obj()->exec();    
            return $user->user_id;
        endif;
    }

    //===================================================== ===============
    //===================================================== ===============
    //===================================================== ===============
    //===================================================== ===============
    //===================================================== ===============
    //===================================================== ===============
}
