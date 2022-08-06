<?php

use App\Models\Shop;

function __sidebar_shop_latest_cat($c = '')
{
    $product = Shop::latestProduct();
?>
    <div class="deals-block <?= $c ?>">
        <section class="section-onsale-product">
            <header>
                <h2 class="h1">Recommended</h2>
                <!-- <div class="savings">
                    <span class="savings-text">Save <span class="amount">$20.00</span></span>
                </div> -->
            </header><!-- /header -->

            <div class="onsale-products">
                <div class="onsale-product">
                    <a href="/shop/gadgets/<?= $product->product_slug ?? '' ?>">
                        <div class="product-thumbnail">
                            <img class="wp-post-image" data-echo="<?= $product->product_image ?>" src="/Public/assets/images/blank.gif" alt="">
                        </div>

                        <h3><?= $product->product_name ?? '' ?></h3>
                    </a>
                </div><!-- /.onsale-product -->
            </div><!-- /.onsale-products -->
        </section><!-- /.section-onsale-product -->
    </div><!-- /.col -->
    </div>
<?php
}
