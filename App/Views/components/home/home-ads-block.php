<?php

use App\Models\Product;

function __shop_ads_block()
{
    $categories = Product::categories();
?>
    <header>
        <h2>Categories</h2>
    </header>
    <div class="home-v2-ads-block animate-in-view fadeIn animated" data-animation=" animated fadeIn">
        <div class="ads-block row">
            <?php if (count($categories) > 0) : ?>
                <?php foreach ($categories as $c) : ?>
                    <div class="ad col-xs-12 col-sm-6" style="margin-top: 10px;">
                        <div class="media">
                            <div class="media-left media-middle"><img src="<?= $c->category_image ?? '' ?>" alt="" style="width:250px;height:200px;object-fit:cover" /></div>
                            <div class="media-body media-middle">
                                <div class="ad-text">
                                    <?= $c->category_name ?>
                                </div>
                                <div class="ad-action">
                                    <a href="/shop/product?category=<?= $c->category_slug ?>">Shop here</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

<?php
}
