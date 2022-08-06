
<div class="ui-container">
    <div class="ui-content">
        <?php $__BLOG__ == 'MAIN' ? __ui_card_top() : '' ?>
        <?php
           $__BLOG__ !== 'SINGLE'
            ? __uiPost_list('', $__post_list ?? '', '')
            : __ui_post_single([
               'post' => $__POST__,
               'comments' => $__COMM__
            ]);

            $__BLOG__ !== 'SINGLE' && __ui_post_pagination([
                'type' => $__BLOG__,
                'current' => $__post__page,
                'total_post' => $__total_posts
            ]);
            

            
        ?>
    </div>

    <!-- ============== Side Bar ============= -->
    <div class="ui-sidebar">
        <?php
        use App\Models\Settings;
        $ad = Settings::wieSetting()->ads;
            __quickLinksSide();
            __ui_side_ads_sq($ad);
            __ui_popular();
            __ui_side_ads_rc($ad);
            __ui_compare();
            __ui_social_links();
            __ui_gadgets_side();
        ?>
    </div>
</div>