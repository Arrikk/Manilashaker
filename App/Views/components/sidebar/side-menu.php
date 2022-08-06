<?php

use App\Models\Product;

function __sidebar_menu_category()
{
?>
    <aside class="widget woocommerce widget_product_categories electro_widget_product_categories">
        <ul class="product-categories category-single">
            <li class="product_cat">
                <?php foreach(Product::categories() as $cat): ?>
                <ul class="show-all-cat">
                    <li class="product_cat"><span class="show-all-cat-dropdown"><?= $cat->category_name ?></span>
                        <ul style="display: none;">
                            <?php foreach(Product::childCategory($cat->category_id) as $cat): ?>
                                <li class="cat-item"><a href="/shop/product/<?= $cat->category_slug ?>"><span class="no-child"></span><?= $cat->category_name ?></a> <span class="count">(<?= Product::productCategory($cat->category_slug) ?>)</span></li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                </ul>
                <?php endforeach; ?>
            </li>
        </ul>
    </aside>
<?php
}
