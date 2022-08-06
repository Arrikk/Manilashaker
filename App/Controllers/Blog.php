<?php

namespace App\Controllers;

use App\Model\Blog as ModelBlog;
use App\Model\Blog\Blog as BlogBlog;
use App\Model\Post;
use App\Model\Test\Post as TestPost;
use \Core\View;
use \App\Models\Blog as Model;
use App\Rate;

/**
 * Contacts
 * 
 * ===============================
 * Author ======= Bruiz(CodeHart)
 * ==============================
 * 
 * PHP v 7.4.8
 */

class Blog extends \Core\Controller
{
    // public function tst(){
    //     TestPost::Tst();
    //     echo "New Test Route";
    // }
    public function blogAction()
    {
        View::draw('{/blog/blog}', [
            '__class' => 'right-sidebar blog-grid',
            '__BLOG__' => 'MAIN',
            '__post__page' => $this->route_params['page'] ?? 1,
            '__total_posts' => Model::blogPosts(Model::PUBLISHED, 1, true)
        ]);
    }

    public function postAction()
    {
        $slug = $this->route_params['payload'] ?? null;
        if ($slug == null)
            $this->redirect('/');

        # save post comment
        $id = Model::singleBlogPost($slug)->post_id ?? '';
        if (isset($_POST['comment'])) {
            $_POST['post'] = $id;
            $saved = Model::saveComment($_POST);
            $this->redirect('/blog/post/' . $slug);
            // echo json_encode($_POST);
        }

        # get single blog post
        $post = Model::singleBlogPost($id);
        Model::updateViews(['id' => $id, 'view' => $post->views]);
        $comment = Model::getComment($id);
        View::draw('{/blog/blog}', [
            '__class' => 'single-post right-sidebar',
            '__BLOG__' => 'SINGLE',
            '__POST__' => $post,
            '__COMM__' => $comment,
        ]);
    }

    public function categoryAction()
    {
        $params = $this->route_params;
        // echo json_encode($params);
        // return;
        if (isset($params['ref'])) {

            View::draw('{/blog/blog}', [
                '__class' => 'blog blog-list right-sidebar',
                '__BLOG__' => 'CATEGORY',
                '__cat_post' => Model::postByCategory($this->ambig('dc', $params['ref']), $params['page'] ?? 1),
                '__style' => 'height:auto !important',
                '__post__page' => $params['page'] ?? 1,
                '__category_name' => $params['category'],
                '__total_posts' => Model::postByCategory($this->ambig('dc', $params['ref']), 1, true)
            ]);

            // header('content-type: application/json');
            // echo json_encode(Model::postByCategory($this->ambig('dc', $_GET['ref'])));

            return;
        }
        $this->redirect('/blog/post');
    }
    public function tagAction()
    {
        $params = $this->route_params;
        // echo json_encode($params);
        // return;
        if (isset($params['ref'])) {

            View::draw('{/blog/blog}', [
                '__class' => 'blog blog-list right-sidebar',
                '__BLOG__' => 'CATEGORY',
                '__cat_post' => Model::postByTag($params['ref']),
                '__style' => 'height:auto !important',
                '__category_name' => ucwords(str_replace('-', ' ', $params['ref']))
            ]);

            // header('content-type: application/json');
            // echo json_encode(Model::postByCategory($this->ambig('dc', $_GET['ref'])));

            return;
        }
        $this->redirect('/blog/post');
    }

    public function blogPostAction()
    {
        echo json_encode(\App\Models\Blog::blogPosts());
    }

    public function test()
    {
        $rate = Rate::convert(3999);
        echo $rate;
    }
}
