<?php

namespace App\Models;

use App\Auth;
use Core\Http\Res;
use PDO;

/**
 * **** Blog Model
 * **** BRUIZ*******
 * **** PHP V7
 * 
 */

class Blog extends \Core\Model
{

    const DRAFT = 'draft';
    const PUBLISHED = 'published';
    const TRASH = 'trash';
    const DELETE = 'delete';
    const POST_LIMIT = 20;
    /**
     * Encrypt and decrypt data ..(message, string, int, func etc...)
     * @param string $type Encrypt = en Decrypt = dc
     * @param string $string any
     * @return string
     */
    public static function ambig($type, $string)
    {
        $output = '';

        $enc_type = 'AES-256-CBC';
        $secret = \App\Config::SECRET_KEY;
        $secret_iv = \substr($secret, 0, 14);

        $key = \hash('sha256', $secret);
        $initVect = \substr(\hash('sha256', $secret_iv), 0, 16);

        if ($type == 'enc') {
            $output = \openssl_encrypt($string, $enc_type, $key, 0, $initVect);
            $output = \base64_encode($output);
        }
        if ($type == 'dec') {
            $output = \base64_decode($string);
            $output = \openssl_decrypt($output, $enc_type, $key, 0, $initVect);
        }

        return $output;
    }

    public static function enc($text)
    {
        return static::ambig('enc', $text);
    }
    // ***********************************************
    // **************** BLOG POSTS****************
    // ***********************************************

    /**
     * Create new Blog Post
     * 
     * @return bool
     */
    public static function savePost($form = [])
    {
        extract($form);
        // return $form;
        $cat = '';
        foreach ($category ?? [] as $c) {
            $cat .= $c . ',';
        }
        $tag_split = explode(',', $tag);
        $tags = '';
        if (count($tag_split) > 0) {
            foreach ($tag_split as $key) :
                if ($key == '') continue;
                $item = [
                    'name' => $key,
                    'slug' => strtolower(str_replace(' ', '-', rtrim(ltrim($key))))
                ];
                if (static::select('slug', 'tags')->where('slug', $item['slug'])->exec()) :
                    $tags .= $item['slug'] . ',';
                    continue;
                else :
                    static::create('tags', $item)->lid()->exec();
                    $tags .= $item['slug'] . ',';
                endif;
            endforeach;
        }

        $slug = preg_replace('/[^\d\w]+/i', '-', $_slug !== '' ? $_slug : $title);
        if (isset($__new_category) && $__new_category !== '') {

            $newCat = self::saveCategory([
                '__type' => 'save',
                '__name' => $__new_category,
            ], true);
            $cat .= $newCat . ',';
        }
        $data = [
            'post_title' => htmlspecialchars(trim($title)),
            'post_image' => htmlspecialchars(trim($image)),
            'category_id' => $cat,
            'post_body' => self::clean(htmlspecialchars(trim($post))),
            'post_description' => static::clean($meta_description),
            'post_author' => $author ?? 1,
            'post_status' => $status,
            'post_slug' => static::clean($slug),
            'post_tag' => $tags
        ];

        $post = static::singleBlogPost($slug);
        if ($post) {
            return static::update('posts', $data)
                ->where('post_slug', $slug)->exec();
        }

        if ($type == 'bot') {
            return static::create('posts', $data)->exec();
        } elseif ($type == 'edit') {
            return static::update('posts', $data)
                ->where('post_id', $edit)
                ->exec();
        } else {
            return static::create('posts', $data)
                ->lid()->exec();
        }
        // echo json_encode($data);
    }

    /**
     * Get Blog POSTS
     * 
     * @return mixed
     */
    public static function blogPosts($param = self::PUBLISHED, $page = 1, $total = false, $random = false, $lit = false)
    {
        $limit = $lit ? $lit : self::POST_LIMIT;
        if ($page <= 0) $page = 1;
        $page = ($page - 1) * $limit;

        if ($total) {
            return static::select('COUNT(*) as total', 'posts')->where('post_status', Blog::PUBLISHED)->obj()->exec()->total;
        }
        if ($random) {
            return static::select('*')->from('posts')->order('RAND() ASC')->limit("$page, $limit")->exec();
        }
        return static::select(
            '
        p.category_id, p.post_body, p.views, p.post_id as post_id,
        p.post_image, p.post_slug, p.post_tag,p.post_title, u.firstName,
         DATE_FORMAT(p.createdAt, "%b %a %y") as date, p.createdAt as dtime'
        )   
            ->from('posts p')->left('post_comments c')->on('c.post_id = p.post_id')
            ->left('users u')->on('p.post_author = u.user_id')
            ->where('post_status', $param)
            ->order('p.post_id DESC')->limit("$page, $limit")->exec();
    }

    /**
     * Get Post For Card
     * 
     * @return array
     */
    public static function blogPostCard($param = self::PUBLISHED, $page = 6)
    {
        $limit = 6;
        if ($page <= 0) $page = 1;
        $page = ($page - 1) * $limit;
        return static::select(
            '
        p.category_id, p.post_body, p.views, p.post_id as post_id,
        p.post_image, p.post_slug, p.post_tag, p.post_title,
         DATE_FORMAT(p.createdAt, "%b %a %y") as date, p.createdAt as dtime'
        )
            ->from('posts p')->left('post_comments c')->on('c.post_id = p.post_id')

            ->where('post_status', $param)
            ->order('p.post_id DESC')->limit("$page, $limit")->exec();
    }

    /**
     * Get footer Post
     */
    public static function footerPostWidget($param = self::PUBLISHED, $page = 8)
    {
        $limit = 6;
        if ($page <= 0) $page = 1;
        $page = ($page - 1) * $limit;
        return static::select('*, DATE_FORMAT(createdAt, "%b %a %y") as date')
            ->from('posts')
            ->where('post_status', $param)
            ->order('views ASC')->limit("$page, $limit")->exec();
    }
    public static function blogPost($param = self::PUBLISHED, $page = 1)
    {
        $limit = self::POST_LIMIT;
        if ($page <= 0) $page = 1;
        $page = ($page - 1) * $limit;

        return static::select('*, DATE_FORMAT(createdAt, "%b %a %y") as date, createdAt as dtime')
            ->from('posts')
            ->where('post_status', $param)
            ->order('post_id DESC')->limit("$page, $limit")->exec();
    }

    /**
     * Get Post Statistic
     * @param string $type type of post to get
     * @return mixed array, object or otherwise
     */
    public static function postStat($type = null)
    {
        $stat = static::select('post_status as status, count(*) as user, count(post_status) as count')
            ->from('posts')->group('post_status')
            ->order('post_status DESC')->exec();
        $all = static::select('count(*) as total', 'posts');
        if ($type !== null) $all->where('post_status', $type);
        $all = $all->obj()->exec();
        return ['stat' => $stat, 'all' => $all];
    }

    /**
     * Get Post Author
     * @param int author id
     * @return mixed
     */
    public static function getAuthor($id)
    {
        $author = static::select('firstName as name', 'users')->where('user_id',  11)->obj()
            ->exec();
        return $author->name;
    }

    /*
     * Recent Posts
     * 
     * @return array
     */
    public static function recentPost()
    {
        return static::select('*, DATE_FORMAT(createdAt, "%b %a %y") as date', 'posts')
            ->where('post_status', static::PUBLISHED)
            ->order('RAND() ASC')->limit(10)->exec();
    }

    public static function otherPost()
    {
        return static::select('*, DATE_FORMAT(createdAt, "%b %a %y") as date', 'posts')
            ->where('post_status', static::PUBLISHED)
            ->order('RAND() DESC')->limit(10)->exec();
    }

    /**
     * select a single Post
     * 
     * @param mixed
     * 
     * @return object
     */
    public static function singleBlogPost($opt)
    {
        // return static::select('*', 'posts')
        //     ->where('post_id', $opt)
        //     ->or('post_slug', $opt)
        //     ->obj()->exec();

            return static::select(
                '
            p.category_id, p.post_body, p.post_status, p.views, p.post_id as post_id,
            p.post_image, p.post_slug, p.post_tag,p.post_title, u.firstName as author,
            u.profile as author_img, u.username as username, u.desc as author_desc,
             DATE_FORMAT(p.createdAt, "%b %a %y") as date, p.createdAt as dtime'
            )
                ->from('posts p')
                ->left('users u')->on('p.post_author = u.user_id')
                ->where('post_id', $opt)
                ->or('post_slug', $opt)->obj()->exec();
    }

    /**
     * Other related posts
     * 
     */
    public static function relatedPosts($id)
    {
        return static::select(
            '
        p.category_id, p.post_title, p.post_image, c.category_id as cat_id, 
        c.category_name as cat_name, c.slug as cat_slug, p.post_slug,
         DATE_FORMAT(p.createdAt, "%b %a %y") as date, p.createdAt as dtime'
        )
            ->from('posts p')->left('post_categories c')->on('c.category_id = p.category_id')
            ->order('p.post_id DESC')->limit("$id, 4")->exec();
    }

    /**
     * Update post view
     * @param array $param
     * @return bool
     */
    public static function updateViews($param)
    {
        extract($param);
        return static::update('posts', ['views' => $view + 1])
            ->where('post_id', $id)->exec();
    }

    /**
     * get Posts by Category 
     * 
     * @param int $id category id
     * 
     * @return array
     */
    public static function postByCategory($id = 0, $page = 1, $total = false, $lit = false)
    {
        $limit =  $lit ? $lit : self::POST_LIMIT;
        if ($page <= 0) $page = 1;
        $page = ($page - 1) * $limit;

        if ($total) {
            return static::select('COUNT(*) as total', 'posts')
                ->where('FIND_IN_SET("' . $id . '", category_id)')
                ->and('post_status', self::PUBLISHED)
                ->obj()->exec()->total;
        }

        return static::select('
        p.category_id, p.post_body, p.views, p.post_id as post_id,
        p.post_image, p.post_slug, p.post_tag,p.post_title, u.firstName,
         DATE_FORMAT(p.createdAt, "%b %a %y") as date'
        )
        ->from('posts p')
        ->left('users u')->on('p.post_author = u.user_id')
            ->where('FIND_IN_SET("' . $id . '", p.category_id)')
            ->and('post_status', self::PUBLISHED)
            ->limit("$page, $limit")->exec();
    }

    public static function postByTag($tag)
    {
        return static::select('*, DATE_FORMAT(createdAt, "%b %a %y") as date', 'posts')
            ->where('FIND_IN_SET("' . $tag . '", post_tag)')
            ->and('post_status', self::PUBLISHED)->limit(20)->exec();
    }

    /**
     * Trash post
     * @return bool
     */
    public static function trashPost($id)
    {
        return static::update('posts', ['post_status' => self::TRASH])
            ->where('post_id', $id)
            ->exec();
    }
    /**
     * Restore post
     * @return bool
     */
    public static function restorePost($id)
    {
        return static::update('posts', ['post_status' => self::PUBLISHED])
            ->where('post_id', $id)
            ->exec();
    }
    /**
     * Restore post
     * @return bool
     */
    public static function draftPost($id)
    {
        return static::update('posts', ['post_status' => self::DRAFT])
            ->where('post_id', $id)
            ->exec();
    }
    /**
     * Delete a post
     * @return bool
     */
    public static function deletePost($id)
    {
        return static::trash('posts')
            ->where('post_id', $id)
            ->exec();
    }

    /**
     * Bulk action (delete, trash, restore, publish, draft)
     * @param array $data POST Data
     * @return bool
     */
    public static function bulkAction($data)
    {
        extract($data);
        switch ($action) {
            case self::DRAFT:
                return static::draftPost($id);
                break;
            case self::PUBLISHED:
                return static::restorePost($id);
                break;
            case self::TRASH:
                return static::trashPost($id);
                break;
            case self::DELETE:
                return static::deletePost($id);
                break;
            default:
        }
    }

    // ***********************************************
    // **************** BLOG CATEGORY ****************
    // ***********************************************

    /**
     * create new Category
     * 
     * @return bool
     */
    public static function saveCategory($form, $return = false)
    {
        extract($form);

        $slug = preg_replace('/[^a-z0-9]+/i', '-', $__name ?? '');
        $slug = strtolower($slug);
        $data = [
            'category_name' => static::clean(ucfirst($__name ?? '')),
            'category_description' => static::clean(ucfirst(($__description ?? ''))),
            'parent_category' => static::clean($__parent ?? 0),
            'slug' => static::clean($slug)
        ];
        if ($__type == 'update') {
            return static::update('post_categories', $data)->where('category_id', $__category)->exec();
        } elseif ($__type == 'save') {
            $exist = static::select('category_id as id', 'post_categories')->where('slug', $slug)
                ->obj()->exec();
            if ($exist) {
                if ($return) return $exist->id;
                return true;
            } else {
                $saved = static::create('post_categories', $data);
                if ($return) $saved->lid();
                $saved = $saved->exec();
                return $saved;
            }
        }
        return false;
    }

    /**
     * Get a catgory by slug
     * 
     * @return object
     */
    public static function oneCategory($prop = '')
    {
        if($prop !== '')
        return static::select('*', 'post_categories')
        ->where('slug', $prop)
        ->or('category_id', $prop)
        ->obj()->exec();
    }

    /**
     * get category list
     * @param array $id categories id
     * @return array
     */
    public static function categories($array = null)
    {
        if ($array !== null) {
            $id = (int) $array['edit'];
            return static::select('*', 'post_categories')
                ->where('category_id', $id)
                ->obj()->exec();
        }
        return static::select('*', 'post_categories')->exec();
    }
    public static function postCategory($id, $opt = null)
    {
        $cat_id = explode(',', $id);
        $item = [];
        foreach ($cat_id as $key) {
            if ($key == '' || $key == ' ') continue;

            if ($opt === null) {
                $item[] = static::select('category_name, category_id,slug', 'post_categories')
                    ->where('category_id', $key)->class()->exec();
            } else {
                $item[] = static::select('name, slug', 'tags')
                    ->where('slug', $key)->obj()->exec();
            }
        }
        return $item;
    }

    /**
     * Delete Category
     * @param int $id Category_id
     * @return bool
     */
    public static function trashCategory($id)
    {

        $posts = static::select('*')
            ->from('posts')
            ->where('FIND_IN_SET("' . $id . '", category_id)')
            ->exec();
        // return $posts;

        $update  = [];
        foreach ($posts as $key => $value) {
            $update[$value->post_id] = [
                'post_id' => $value->post_id,
                'category_id' => str_replace($id . ',', '', $value->category_id)
            ];
        }

        foreach ($update as $key => $value) {
            static::update('posts', [
                'category_id' => $value['category_id']
            ])->where('post_id', $value['post_id'])
                ->exec();
        }
        static::update('post_categories', ['parent_category' => 0])
            ->where('category_id', $id)->exec();
        // 
        if (static::trash('post_categories')
            ->where('category_id', $id)
            ->exec()
        ) return true;

        return false;
    }


    // ***********************************************
    // **************** BLOG Tags ********************
    // ***********************************************

    /**
     * Save new Tag
     * @param array $data Tag data to insert
     * @return bool
     */
    public static function saveTag($field = [])
    {
        extract($field);

        # set fields to update as an array()
        $data = [
            'name' => static::clean(ucfirst($__name)),
            'slug' => static::clean(strtolower(str_replace(' ', '-', rtrim(ltrim($_slug !== '' ? $_slug :  $__name)))))
        ];

        # if the field type is set to save, save the tag
        if ($__type == 'save') {
            return static::create('tags', $data)->exec();

            # if the field tag is set to update, follow below procedure
        } elseif ($__type == 'update') {

            #Get all posts associated with tag
            $post = static::select('post_tag, post_id')
                ->from('posts')
                ->where('FIND_IN_SET("' . $__slug . '", post_tag)')
                ->exec();

            # update all post assiciated with tag
            foreach ($post as $key => $value) :
                static::update('posts', [
                    'post_tag' => str_replace($__slug . ',', $_slug . ',', $value->post_tag)
                ])->where('post_id', $value->post_id)->exec();
            endforeach;

            # update tag to new changes
            return static::update('tags', $data)->where('slug', $__slug)->exec();
        }
    }

    /**
     * Select Tags
     * 
     * @return array
     */
    public static function tags($slug = null)
    {
        if ($slug !== null) {
            $slug = preg_replace('/[^\d\w-]+/', '', $slug);
            return static::select('*', 'tags')
                ->where('slug', $slug)->obj()->exec();
        }
        return static::select('*', 'tags')->limit('20')->exec();
    }

    /**
     * Delete tags by id
     * @param int $id Tag id
     * @return bool
     */
    public static function trashTag($slug)
    {
        $post = static::select('post_tag, post_id')
            ->from('posts')
            ->where('FIND_IN_SET("' . $slug . '", post_tag)')
            ->exec();

        foreach ($post as $key => $value) {
            $tag =  str_replace($slug . ',', '', $value->post_tag);
            static::update('posts', [
                'post_tag' => $tag,
            ])->where('post_id', $value->post_id)
                ->exec();
        }

        if (static::trash('tags')
            ->where('slug', $slug)
            ->exec()
        ) return true;

        return false;
    }


    // ***********************************************
    // **************** BLOG Comments ********************
    // ***********************************************

    /**
     * Save Comment
     * @return bool
     */
    public static function saveComment($data)
    {
        extract($data);
        return static::create('post_comments', [
            'user_id' => $user ?? 0,
            'post_id' => $post ?? '',
            'comment' => static::clean($comment ?? ''),
            'name' => static::clean($author ?? ''),
            'email' => static::clean($email ?? ''),
            // 'website' => static::clean($url)
        ])->exec();
    }

    /**
     * Get comments
     * 
     * @return mixed
     */
    public static function getComment($id)
    {
        return
            static::select('
            c.comment_id as comment_id, DATE_FORMAT(c.createdAt, "%b %a %y") as date,
            c.comment as comment, u.firstName as f_name, c.name as name, u.username as username, u.profile as image')
            ->from('post_comments c')->left('users u')
            ->on('u.user_id = c.user_id')->where('post_id', $id)
            ->order('c.createdAt DESC')->exec();
    }

    public static function getCommentCount($id)
    {
        return static::select('count(*) as count', 'post_comments')->where('post_id', $id)
            ->obj()->exec()->count;
    }

    public static function saveJson($data)
    {
        return static::create('test_json', ['data' => $data])->exec();
    }

    public static function restoreOrLastPage($arg)
    {
        extract($arg);
        $date = time() + 60 * 604800;
        if ($opt == 'set') {
            return static::update('last_page', [
                'last' => $last,
                'check_date' => date('y-m-d H:i:s', $date)
            ])->exec();
        } else {
            return static::select('last', 'last_page')->obj()->exec();
        }
    }
}
