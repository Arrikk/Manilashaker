<?php

use App\Models\Shop;

function __shop_home_featured(){
    $featured = Shop::featured();
?>
<section class="home-v2-categories-products-carousel section-products-carousel animate-in-view fadeIn animated animation" data-animation="fadeIn">


<header>

    <h2 class="h1">Laptops &amp; Computers</h2>

    <div class="owl-nav">
        <a href="#products-carousel-prev" data-target="#products-carousel-57176fb2c4230" class="slider-prev"><i class="fa fa-angle-left"></i></a>
        <a href="#products-carousel-next" data-target="#products-carousel-57176fb2c4230" class="slider-next"><i class="fa fa-angle-right"></i></a>
    </div>

</header>


<div id="products-carousel-57176fb2c4230">
    <div class="woocommerce">
        <div class="products owl-carousel home-v2-categories-products products-carousel columns-6">
            <?php if(count($featured) > 0): ?>
                <?php foreach($featured as $f): ?>
                    <div class="product-outer">
    <div class="product-inner">
        <span class="loop-product-categories"><a href="/shop/product?category=<?= $f->category_slug ?? '' ?>" rel="tag"><?= $f->category_name ;?></a></span>
        <a href="/shop/gadgets?item=<?= $f->product_slug ?? '' ?>">
            <h3><?= $f->product_name ?? '__';?></h3>
            <div class="product-thumbnail">
                <img src="/Public/assets/images/blank.gif" data-echo="<?= $f->product_image ?? '';?>" class="img-responsive" alt="">
            </div>
        </a>

        <div class="price-add-to-cart">
            <span class="price">
                <span class="electro-price">
                    <ins><span class="amount"> <?= $f->product_price ?? '__' ;?></span></ins>
                    <span class="amount"> <?= $f->product_price ?? '__' ;?></span>
                </span>
            </span>
        </div><!-- /.price-add-to-cart -->
    </div><!-- /.product-inner -->
</div><!-- /.product-outer -->
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
</section>

    <?php
}