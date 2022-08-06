<?php
namespace App\Controllers\Post;

use App\Model\Post as ModelPost;
use \Core\View;
use \App\Models\Blog as Model;
use App\Models\Blog;
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

class Post extends \Core\Controller
{
    public function indexAction()
    {
        $page = $this->route_params['page'] ?? 1;
        View::draw('{/blog/post}', [
            '__BLOG__' => 'MAIN',
            '__post__page' => $page,
            '__total_posts' => Model::blogPosts(Model::PUBLISHED, 1, true),
            '__post_list' => Model::blogPosts(Model::PUBLISHED, $page),
            '__template' => true
        ]);
    }
    public function singleAction()
    {
        $slug = $this->route_params['payload'] ?? null;
        if($slug == null)
            $this->redirect('/');

        $id = Model::singleBlogPost($slug)->post_id ?? '';
        if(isset($_POST['comment'])){
          $_POST['post'] = $id;
          $saved = Model::saveComment($_POST);
          $this->redirect($_SERVER['REDIRECT_URL']);
          // echo json_encode($_POST);
        }
        $post = Model::singleBlogPost($id);
        Model::updateViews(['id' => $id, 'view' => $post->views]);
        $comment = Model::getComment($id);
        View::draw('{/blog/post}', [
            '__BLOG__' => 'SINGLE',
            '__POST__' => $post,
            '__COMM__' => $comment,
            '__template' => true
        ]);
    }

    public function categoryAction()
    {
      $params = $this->route_params;
      // echo json_encode($params);
      // return;
        if(isset($params['category'])){
            $cat = Blog::oneCategory($params['category']); 

            View::draw('{/blog/post}', [
                '__BLOG__' => 'CATEGORY',
                '__post_list' => Model::postByCategory($cat->category_id ?? '', $params['page'] ?? 1),
                '__style' => 'height:auto !important',
                '__post__page' => $params['page'] ?? 1,
                '__category_name' => $cat->category_name ?? '',
                '__total_posts' => Model::postByCategory($cat->category_id ?? '', 1, true),
                '__template' => true
            ]);

            // header('content-type: application/json');
            // echo json_encode(Model::postByCategory($this->ambig('dc', $_GET['ref'])));

            return;
        }  
        $this->redirect('/');
    }

    public function tagAction()
    {
      $params = $this->route_params;
      // echo json_encode($params);
      // return;
        if(isset($params['ref'])){

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
    

    /**
     * Get posts of an author by username
     * @return void
     */
    public function authorPost()
    {
        $page = $_GET['page'] ?? 1;
        $author = $this->route_params['author'] ?? '';
        if (!$author == '') :
            $author = strtolower($author);
            $post = ModelPost::dumpPost($author, ModelPost::BY_AUTHOR, $page);

            // $author = ModelPost::totalAuthorPost($author);
            // echo json_encode($author);
            // return;

            View::draw('{/blog/post}', [
                '__class' => 'right-sidebar blog-grid',
                '__post_list' => $post,
                '__BLOG__' => 'AUTHOR',
                '__post__page' => $page,
                '__total_posts' => ModelPost::totalAuthorPost($author),
                '__template' => true
            ]);
            
            return;

        # Get author posts
        else :
        # Smtin else;
        endif;
        // View::draw('{blog/author}', );
    }
}
