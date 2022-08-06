<?php
namespace App\Controllers;

use Core\Controller;
use App\Models\Blog;
use simplehtmldom\HtmlWeb;

class FoneScrap extends Controller{

    public $current = 1;
    
    public function scrape($page = 1)
    {
        // return;
        $init = new HtmlWeb;
        $html = $init->load("https://www.fonearena.com/blog/page/$page");
        $posts = $html->find('article.type-post.status-publish.format-standard.hentry');
        $i = 0;
        $data = [];

        foreach ($posts as $post):
            // if($i == 1) break;
            $i++;
            # Find Post Title and link
            $postTitle = $post->find('header.entry-header', 0)->find('a', 0);
            $postTitleText = $postTitle->plaintext;
            $postTitleLink = $postTitle->href;
            // $slug = str_replace('_', '', $postTitleText);

            # creat slug
            $slug = preg_replace('/[_+.\s]+/i', '-', $postTitleText);
            # Find Post Image
            $postImage = $post->find('div.entry-content', 0)->find('img', 0);
            $Image = $postImage->src;

            # Post Redirect lINK
            $postBody = $init->load($postTitleLink);
            $postBodyContent = $postBody->find('div.entry-content', 0);
            $postBodyContent = $postBodyContent->innertext;


            # Remove excesses from post contents
                
                $data[] = [
                    'image' => $Image ?? '',
                    'link' => $postTitleLink,
                    'title' => $postTitleText ?? '',
                    'meta_description' => $postTitleText,
                    '_slug' => $slug ?? '',
                    'post' => $postBodyContent ?? '',
                    'tag' => '',
                    'category' => [],
                    'type' => 'bot',
                    'status' => Blog::DRAFT
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
        $this->current++;
        
    }
    public function page()
    {
        $pages = Blog::restoreOrLastPage(['opt' => 'get'])->last;
        $pages = explode(' ', $pages);

        $next = [];
        foreach ($pages as $page) :
            $count = $page + count($pages);
            $next[] = (int) $count;
            $this->scrape($count);
        endforeach;

        $next = implode(',', $next);
        $next = str_replace(',', ' ', $next);
        Blog::restoreOrLastPage(['opt' => 'set', 'last' => $next]);
        header( "refresh:6;url=?page=$this->current" );
        return;
    }
}