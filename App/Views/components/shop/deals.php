<?php

use App\Models\Shop;

function __shop_deals()
{
    $product = Shop::recommended();
?>
    <div class="home-v1-deals-and-tabs deals-and-tabs row animate-in-view fadeIn animated" data-animation="fadeIn">
        <?php if(count($product) > 0): ?>
        <?php foreach($product as $p): ?>
        <div class="deals-block col-lg-4">
            <section class="section-onsale-product">
                <header>
                    <!-- <h3 class="h2">Offer</h3> -->
                    <div class="savings">
                        <span class="savings-text"><span class="amount"><?= SIGN.number_format($p->product_price) ?></span></span>
                    </div>
                </header><!-- /header -->

                <div class="onsale-products">
                    <div class="onsale-product">
                        <a href="/shop/gadgets?item=<?= $p->product_slug ?? '' ?>">
                            <div class="product-thumbnail">
                                <img class="wp-post-image" data-echo="<?= $p->product_image ?? '' ?>" src="/Public/assets/images/blank.gif" alt="">
                            </div>
                            <h3><?= $p->product_name ?? '' ?></h3>
                        </a>
                    </div><!-- /.onsale-product -->
                </div><!-- /.onsale-products -->
            </section><!-- /.section-onsale-product -->
        </div><!-- /.col -->
        <?php endforeach; ?>
        <?php endif; ?>
    </div><!-- /.deals-and-tabs -->

<?php
}
