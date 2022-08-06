<?php

use App\Models\Product;

function __sidebar_latest_product()
{
    $product = Product::latestProduct();
?>
    <aside class="widget widget_products">
        <h3 class="widget-title">Latest Products</h3>
        <ul class="product_list_widget">
            <?php if(count($product) > 0): ?>
                <?php foreach($product as $p): ?>
                    <li>
                        <a href="/<?= $p->category ?>/<?= $p->slug ?? '' ?>" title="<?= $p->name ?? '__' ?>">
                            <img width="180" height="180" src="<?= $p->image ?>" alt="" class="wp-post-image"><span class="product-title"><?= $p->name ?? '__' ?></span>
                        </a>
                        <span class="electro-price"><span class="amount"><?= SIGN.number_format($p->price, 2) ?></span></span>
                    </li>
                <?php endforeach; ?>
                <?php else: ?>
                <li>
                   No product Yet
                </li>
            <?php endif; ?>
        </ul>
    </aside>
<?php
}
