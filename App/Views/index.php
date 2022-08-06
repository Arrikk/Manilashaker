<style>
    *:focus {
        outline: none;
    }
</style>
<?php

use App\Models\Blog;
use App\Models\Shop;
use Router\ApiUrl;

$GLOBALS['site'] = array(
    '__site' => \App\Models\Site::__site(),
    '__seo' => \App\Models\Site::__seo(),
    '__info' => \App\Models\Site::__info(),
    '__class' =>  $__class  ?? 'page home page-template-default',
    '__versus' => $__versus ?? '',
    '__compare_category' => $__compare_category ?? ''
);

$GLOBALS['product'] = isset($__product) ? $__product->product_name : '';
$GLOBALS['edit_product_cat'] = $__edit_category ?? [];
$GLOBALS['edit_product_category_desc'] = $edit_product_category_desc ?? null;
$GLOBALS['footer_widget'] = Shop::getRandomCategory();
$GLOBALS['products'] = array(
    '__prices_f' => isset($__prices) ? $__prices : [],
    '__category_f' => isset($__filtered) ? $__filtered['category'] : [],
    '__slug_f' => isset($__filtered) ? $__filtered['slug'] : '',
    '__filter_list' => $__filterList ?? [],
    '__filter_ranges' => $__filterRange ?? []
);

$GLOBALS['blog'] = array(
    '__blog_category' => \App\Models\Blog::categories(),
    '__recent_post' => \App\Models\Blog::recentPost(),
    // '__other_post' => \App\Models\Blog::otherPost(),
    // '__post_tags' => \App\Models\Blog::tags(),
    // '__blog_post' => \App\Models\Blog::blogPosts(Blog::PUBLISHED, $__post__page ?? 1),
    '__current_page' => $__post__page ?? 1,
    '__total_posts' => $__total_posts ?? 1,
    '__post_details' => $__POST__ ?? [],
    '__comments' => $__COMM__ ?? [],
    '__edit_category' => $__editing_category ?? [],
    '__edit_tag' => $__editing_tag ?? [],
    '__post_top_count' => $__post_stat ?? []
);

$__is_admin = $__is_admin ?? false;
$__appUrl = json_encode(ApiUrl::$url);
// 
?>


<script>
    window.money = {
        money: (money) => {
            return (parseInt(money)).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')
        },
        sign: '₱'
    }
    window.url = JSON.parse('<?= $__appUrl ?>');
</script>
<?php if ($__is_admin) : ?>
    <?php

    __html_admin();
    __header_admin();
    __sidebar_admin();
    require_once dirname(__FILE__) . '/Admin/' . $__page . '.php';
    __gallery_modal();
    __script_admin();
    __gallery_show_case(); ?>
<?php else : ?>
    <?php
    __html($__template ?? false);
    __header($__template ?? false);
    require_once dirname(__FILE__) . $__page . '.php';
    __footer($__template ?? false);
    __script();
    ?>

    <script>
        $(document).on('change', '#filter_brand', function() {
            let url = $(this).data('category')
            let split = location.pathname.split('/')
            // alert(split[1])
            window.location = `/${split[1]}/${url}/`
            // alert('/gadget/'+url)
        })
        $(document).on('change', '#price_range', function() {
            let from = $(this).data('left'),
                to = $(this).data('right')

            let url = `?filter&from=${from}&to=${to}`
            window.location = url
        })
        $(document).on('click', '.href-link', function() {
            let link = $(this).attr('href')
            window.location = link
        })
    </script>
<?php endif; ?>