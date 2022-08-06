<?php

use App\Controllers\Compare as ControllersCompare;
use App\Model\Compare;
use App\Model\Products;
use App\Models\Blog;
use App\Models\Product;
use App\Models\Settings;
use App\Models\Shop;

function __quickLinksSide()
{

    $cat = Settings::wieSetting()->quickLink;
    $quickLinks = Blog::postByCategory($cat->category, rand(3, 8), false, $cat->limit);
    // $quickLinks = Blog::blogPosts(Blog::PUBLISHED, 2, false, true);
?>
    <div class="ui-side-title-bar">
        Quick Links
    </div>

    <div class="ui-side ui-grid-sm">
        <?php if (isset($quickLinks) && count($quickLinks) > 0) : ?>
            <?php foreach ($quickLinks as $link) : ?>
                <div class="ui-media-item" style="display:flex">
                    <img src="<?= $link->post_image ?>" alt="" class="ui-footer-media-img">
                    <a href="/<?= $link->post_slug ?>" class="ui">
                        <p class="ui-footer-media-title"><?= $link->post_title ?></p>
                        <small style="font-size: x-small;"><?= $link->date ?></small>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <li class="cat-item"><a href="#">No Quick Link</a></li>
        <?php endif; ?>
    </div>
<?php
}

function __ui_latest_post()
{
    $recent = $GLOBALS['blog']['__recent_post'];

?>
    <div class="ui-side-title-bar">
        Latest Post
    </div>

    <div class="ui-side ui-grid ui-grid-2">
        <?php if (isset($recent) && count($recent) > 0) :  ?>
            <?php foreach ($recent as $post) : ?>
                <div class="ui-item-side-card">
                    <a href="/<?= $post->post_slug ?>" class="ui">
                        <img src="<?= $post->post_image ?>" alt="">
                        <div class="ui-card-gradient">
                            <h3 class=""><?= $post->post_title ?></h3>
                            <span><?= $post->date ?></span>
                        </div>

                    </a>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <li>
                <a class="post-thumbnail" href="#"><img width="150" height="150" src="/Public/assets/images/blog/blog-s-1.jpg" class="wp-post-image" alt="1" /></a>
                <div class="post-content">
                    <a class="post-name" href="#">No Post</a>
                    <span class="post-date">No post 2021</span>
                </div>
            </li>
        <?php endif; ?>
    </div>
<?php
}

function __ui_gadgets_side()
{
    $product = Product::latestProduct();
?>
    <div class="ui-side-title-bar">
        Gadgets
    </div>

    <?php if (count($product) > 0) : ?>
        <div class="ui-side">
        <?php foreach ($product as $p) : ?>

                <div class="ui-detail-items">
                        <img src="<?= $p->image ?>" alt="" class="ui-side-detail-img" style="
                            object-fit: contain;">
                        <h3 style="height: unset;
                            display: flex;
                            flex-direction: column;
                            font-size:70%!important"><a href="/<?= $p->category ?>/<?= $p->slug ?? '' ?>" class="ui"><?= $p->name ?? '__' ?></a>
                            <span class="amount"><?= SIGN . number_format($p->price, 2) ?></span>
                        </h3>
                    </div>
                    <?php endforeach; ?>
                </div>
    <?php else : ?>
        <li>
            No product Yet
        </li>
    <?php endif; ?>
<?php
}

function __ui_social_links()
{
?>
    <div class="ui-side-title-bar" style="background: var(--purple);">
        Social Links
    </div>

    <!-- Social Link -->
    <div class="ui-side ui-grid ui-grid-2">
        <div class="ui-social-item ui-fb">
            <div class="ui-social-">
                <div class="ui-social-icon">
                    <i class="bi-facebook"></i>
                </div>
                <p>Facebook</p>
            </div>
            <span>1k</span>
        </div>
        <div class="ui-social-item ui-tt">
            <div class="ui-social-">
                <div class="ui-social-icon">
                    <i class="bi-twitter"></i>
                </div>
                <p>Twitter</p>
            </div>
            <span>1k</span>
        </div>
        <div class="ui-social-item ui-gp">
            <div class="ui-social-">
                <div class="ui-social-icon">
                    <i class="bi-google"></i>
                </div>
                <p>Google +</p>
            </div>
            <span>1k</span>
        </div>
        <div class="ui-social-item ui-ig">
            <div class="ui-social-">
                <div class="ui-social-icon">
                    <i class="bi-instagram"></i>
                </div>
                <p>Instagram</p>
            </div>
            <span>1k</span>
        </div>
    </div>
<?php
}

function __ui_popular()
{
    $color = ['--deepGreen', '--red', '--purple', '--brown', '--black'];
    $product = Products::popuLarProducts();

    // echo json_encode($product[0]);
    // return;

?>
    <div class="ui-side-title-bar">
        Popular Products
    </div>

    <div class="ui-side ui-grid-sm">
        <?php if (isset($product) && count($product) > 0) : ?>
            <?php foreach ($product as $product) : ?>
                <div class="ui-media-item" style="display:flex">
                    <img src="<?= $product->product_image ?>" alt="" class="ui-footer-media-img">
                    <a href="/<?= $product->product_category ?>/<?= $product->product_slug ?>" class="ui">
                        <p class="ui-footer-media-title"><?= $product->product_name ?></p>
                        <small style="font-size: x-small;"><?= SIGN . number_format($product->product_price, 2) ?></small>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <span></span>
        <?php endif; ?>
    </div>
<?php

}

function __ui_compare()
{
    $item = __formatLink();
?>
    <div class="ui-side-title-bar">
        Popular Compare
    </div>
    <div class="ui-side ui-grid-sm">
        <?php if (count($item) > 0) : ?>
            <?php foreach ($item as $link) : ?>
                <div class="ui-side-link">
                    <div class="ui-icon-link">></div>
                    <a href="/compare/<?= $link['url'] ?>" class="ui">
                        <p><?= $link['name'] ?></p>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <li class="cat-item"><a href="#">No Quick Link</a></li>
        <?php endif; ?>
    </div>
<?php
}

function __formatLink()
{

    $com = Compare::comparedProducts();
    $recent = format($com['recent']);
    $popular = format($com['popular']);

    return array_merge($popular, $recent);
}
function format($item){
    $return = [];
    foreach ($item as $key => $value) {
        $data = json_decode($value->product);
        $url = compareUrl($data);
        $name = Shop::productCompare($data, 'product_name');
        $nm = [];
        foreach ($name as $names) {
            $nm[] = $names->product_name;
        }
        $name = formatName($nm);

        $return[$key]['name'] = $name;
        $return[$key]['url'] = $url;
    }
    return $return;
}

function compareUrl($data)
{
    $url = '';
    foreach ($data as $key => $value) :
        if ($key == 'compare_category') continue;
        if ($value == '') continue;
        $url .= $value . '-VS-';
    endforeach;

    $url = preg_replace('/[-VS-]+$/i', '', $url);
    return $url;
}

function formatName($data)
    {
        $url = '';
        foreach ($data as $key => $value) :
            if ($value == '') continue;
            $url .= $value . ' VS ';
        endforeach;

        $url = preg_replace('/[ VS ]+$/i', '', $url);
        return $url;
    }
