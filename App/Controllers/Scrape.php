<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Blog;
use simplehtmldom\HtmlWeb;

class Scrape extends Controller
{

    public $current = 1;

    public function scrape($page = 1)
    {
        $init = new HtmlWeb;
        $html = $init->load("https://gadgets.ndtv.com/news/page-$page");
        $posts = $html->find("div.story_list.row.margin_b30", 0);
        $i = 0;
        $data = [];

        foreach ($posts->find('li') as $post) :
            // if($i == 2) break;
            $i++;
            # Find Post Title and link
            if (!$post->find('div.caption_box', 0) == null) :
                $postTitle = $post->find('div.caption_box', 0)->find('a', 0);
                $postTitleText = $postTitle->find('span.news_listing', 0)->plaintext;
                $postTitleLink = $postTitle->href;
                // $slug = str_replace('_', '', $postTitleText);

                # creat slug
                $slug = preg_replace('/[^\w]+/i', '-', $postTitleText);
                # Find Post Image
                $postImage = $post->find('div.thumb', 0)->find('a', 0);
                $Image = '';

                if (!$postImage->find('source', 0) == null) {
                    $Image = $postImage->find('source', 0);
                    $Image = $Image->srcset;
                } else {
                    $Image = $postImage->find('img', 0);
                    $original = 'data-original';
                    $Image = $Image->$original;
                }

                $imageExp = explode('?', $Image);
                $Image = $imageExp[0];

                # Post Redirect lINK
                $postContent = '';
                $postBody = $init->load($postTitleLink);
                $postBodyContent = $postBody->find('div.content_text.row.description', 0);
                foreach ($postBodyContent->find('p') as $body) :
                    $postContent .= $body->outertext;
                endforeach;
            // $postBodyContent = $postBodyContent->innertext;

            endif;
            # Remove excesses from post contents

            $data[] = [
                'image' => $Image ?? '',
                'link' => $postTitleLink,
                'title' => $postTitleText ?? '',
                'meta_description' => $postTitleText,
                '_slug' => $slug ?? '',
                'post' => $postContent ?? '',
                'tag' => '',
                'category' => [],
                'type' => 'bot',
                'status' => Blog::DRAFT
            ];
        endforeach;

        // echo '<pre>';
        // echo print_r($data);
        // echo '</pre>';
        // return;

        $new = [];
        foreach ($data as $data) :
            $new[] = Blog::savePost($data);
        endforeach;
        echo json_encode($new);
        $this->current++;
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
            $this->scrape($count);
        endforeach;

        if($next == false) return;

        $next = implode(',', $next);
        $next = str_replace(',', ' ', $next);
        Blog::restoreOrLastPage(['opt' => 'set', 'last' => $next]);
        
        if(isset($_GET['page'])) return Res::send("<script>window.location='/site/scrape/page'</script>");
        header("refresh:6;url=?page=$this->current");
        return;
    }
}
