<?php

namespace App\Controllers;

use App\Model\Post;
use App\Models\Blog;
use Core\Controller;
use Core\Http\Res;
use simplehtmldom\HtmlWeb;

class Plugin extends Controller
{

    public function pull($page = 22)
    {
        $page = $_GET['page'];
        $posts = file_get_contents("https://manilashaker.com/wp-json/wl/v1/posts?page=$page");
        $posts = json_decode($posts);

        foreach ($posts as $post) :
            $postObj = (object) $post;

            // ==============TAGS==========
            $tags = $postObj->tags;
            $tagToSave = [];
            if ($tags && !empty($tags)) :
                foreach ($tags as $tag) :
                    $tagToSave[] = $tag->name;
                endforeach;
            endif;
            $image = (object) $postObj->featured_image;
            // ==============TAGS==========

            // ==============Categories==========
            $categories = $postObj->categories;
            $categoryToSave = [];
            if ($categories && !empty($categories)) :
                foreach ($categories as $category) :
                    $categoryToSave[] = $category->name;
                endforeach;
            endif;
            $image = (object) $postObj->featured_image;
            // ==============categories==========

            $data[] = [
                'title' => $postObj->title ?? '',
                'post' => $postObj->content ?? '',
                'slug' => $postObj->slug ?? '',
                'image' => $image->large ?? '',
                'meta_description' => $postObj->title,
                'tag' => $tagToSave,
                'categories' => $categoryToSave,
                'status' => Blog::PUBLISHED,
                'email' => $postObj->author->user_email,
                'name' => $postObj->author->user_login

            ];

        endforeach;

        // return;
        
        // header('content-type: application/json');
        // echo json_encode($data);
        $new = [];
        foreach ($data as $data) :
           $new[] = Post::post($data);
            // $new[] = Blog::savePost($data);
        endforeach;
        echo json_encode($new);
    }
    public function page()
    {
        if(isset($_GET['page'])){
            $page = (int) $_GET['page'];
            $page = ($page) ." ". ($page+1) ." ". ($page+2);
            Blog::restoreOrLastPage(['opt' => 'set', 'last' => $page]);
        }

        $pages = Blog::restoreOrLastPage(['opt' => 'get'])->last;
        $pages = explode(' ', $pages);

        $next = [];
        foreach ($pages as $page) :
            if ($page <= 1){$next == false; break;};
            $count = $page - count($pages);
            $next[] = (int) $count;
            $this->pull($count);
        endforeach;

        if($next == false) return;

        $next = implode(',', $next);
        $next = str_replace(',', ' ', $next);
        Blog::restoreOrLastPage(['opt' => 'set', 'last' => $next]);
        
        if(isset($_GET['page'])) return Res::send("<script>window.location='/site/plugin/pull'</script>");
        return Res::send('
            <script>
                setTimeout(() => {
                    window.location.reload()
                }, 5000)
            </script>
        ');
        // header("refresh:6;url=?page=$this->current");
        return;
    }
}
