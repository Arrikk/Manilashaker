<?php

namespace App\Controllers;

use App\Models\Blog;
use Core\Controller;
use simplehtmldom\HtmlWeb;

class ImportBlog extends Controller
{
    protected $client;
    protected $html;
    public $page = 1;

    public static function load()
    {
        $page = $_GET['page'] ?? '';
        $blog = new ImportBlog((int) $page);
        return $blog;
    }

    public function scrape($pg = 3)
    {
        $page = $_GET['page'] ?? '';
        $link = "https://www.autoblog.com/news/pg-$pg/";
        $this->client = new HtmlWeb;
        $this->html = $this->client->load($link);

        $data = [];

        $i = 0;
        foreach ($this->html->find('article[class=list_record]') as $item) :
            // if ($i == 3) break;
            $i++;
            // echo $i;

            # Main Record
            // if($item->find('div.record_details', 0)->class = 'list_record btf-native') continue;
            $record = $item->find('div[class=record_details]', 0);
            // $featured = $imgCont->find('img[class=lazy]');

            $image = $record->find('a[class=thumb record_image]', 0);
            # Featured Image
            $src = 'data-original';
            $featured = $image->find('img', 0)->$src;
            $featured = explode('https://', $featured);
            $featured = 'https://' . $featured[count($featured) - 1];

            # Redirect Link
            $link = $image->href;

            # Title
            $title = $record->find('h6.record-heading', 0)->find('span', 0);
            $title = $title->innertext;

            # Slug
            $slug = explode('/', $link);
            $slug = $slug[count($slug) - 2];

            # Categories
            $categories = [];

            # Post Body
            $pbody = '';
            $body = $this->client->load($link);
            if ( $body === null) {
                continue;
            }else{
                $wrapper = $body->find('div.post-contents', 0)->find('div.post-body');
                foreach ($wrapper as $body) :
                    $pbody .= $body->innertext;
                endforeach;
            }

            // echo '<pre>';
            // echo print_r($wrapper);
            // echo '</pre>';

            $data[] = [
                'image' => $featured ?? '',
                'link' => $link,
                'title' => $title ?? '',
                'meta_description' => $title,
                '_slug' => $slug ?? '',
                'post' => $pbody ?? '',
                'tag' => '',
                'category' => $categories,
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
        $page++;
        // header('refresh:5;url=?page=' . $page);
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
        header( "refresh:6;url=?page=3" );
        return;
    }
}
