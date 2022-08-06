<?php
namespace App\Controllers;

use App\Models\Blog;
use Core\Controller;
use simplehtmldom\HtmlWeb;

class Migrate extends Controller
{

    public function pull($page = 2)
    {
        $cat = $_GET['cat'];
        $link = "https://manilashaker.com/category/tech/$cat/page/$page/";

        $init = new HtmlWeb;
        $html = $init->load($link);
        $posts = $html->find('div.td-block-span6');
        $i = 0;
        (array) $data = [];

        foreach ($posts as $post) :
            // if ($i == 2) break;
            $i++;
            $dataUrl = 'data-img-url';
            $img = $post->find('img', 0)->$dataUrl; # post image

            $ttc = $post->find('h3', 0);

            # post link
            $href = $ttc->find('a', 0)->href;

            # post title
            $title = $ttc->find('a', 0)->innertext;

            #post slug
            $slug = preg_replace('/[_+.\s]+/i', '-', $title);

            # Post Redirect lINK
            $postBody = $init->load($href);
            $content = $postBody->find('div.td-post-content.td-pb-padding-side', 0);
            if(!$content->find('div.td-post-featured-image', 0) == null){
                $img = $content->find('div.td-post-featured-image', 0);
                $img = $img->find('a', 0)->href;
                $content->removeChild($content->find('div.td-post-featured-image', 0));
            }
            $body = $content->innertext;

            $data[] = [
                'image' => $img ?? '',
                'link' => $href,
                'title' => $title ?? '',
                'meta_description' => $title,
                '_slug' => $slug ?? '',
                'post' => $body ?? '',
                'tag' => '',
                'category' => [],
                '__new_category' => $cat,
                'type' => 'bot',
                'status' => Blog::PUBLISHED
            ];

        endforeach;

        // echo '<pre>';
        // echo print_r($data);
        // echo '</pre>';

        $new = [];
        foreach ($data as $data) :
            $new[] = Blog::savePost($data);
        endforeach;
        echo json_encode($new);
    }
    public function page()
    {
        $current = $_GET['page'] ?? 1;
        $cat = $_GET['cat'];

        $pages = Blog::restoreOrLastPage(['opt' => 'get'])->last;
        $pages = explode(' ', $pages);

        $next = [];
        foreach ($pages as $page) :
            $count = $page - count($pages);
            $next[] = (int) $count;
            if ($count < 1){$next == false; break;}
            echo $count;
            $this->pull($count);
        endforeach;

        if($next == false) return;

        $next = implode(',', $next);
        $next = str_replace(',', ' ', $next);
        Blog::restoreOrLastPage(['opt' => 'set', 'last' => $next]);
        header( "refresh:6;url=?page=$current&cat=$cat" );
        // return;
    }
    public function setPage()
    {
        $total = (int) $_GET['page'];
        $next = [];
        if ($total) {
            $from = $total + 3;
            for ($i = $from; $i > $total; $i--) {
                $next[] = (int) $i;
            }
            $next = implode(',', $next);
            $next = str_replace(',', ' ', $next);
            return Blog::restoreOrLastPage(['opt' => 'set', 'last' => $next]);
        }
    }
}
