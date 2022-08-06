<?php

use App\Models\Product;

function __navbar__search(){
    ?>
    <form class="navbar-search" method="get" action="">
        <label class="sr-only screen-reader-text" for="search">Search for:</label>
        <div class="input-group">
            <input type="text" id="search" class="form-control search-field" dir="ltr" value="" name="s" placeholder="Search for products" />
            <div class="input-group-addon search-categories">
                <select name='product_cat' id='product_cat' class='postform resizeselect' >
                    <option value='' selected='selected'>All Categories</option>
                    <?php if(count(Product::categories()) > 0): ?>
                        <?php foreach(Product::categories() as $cat): ?>
                            <option class="level-0" value="<?= $cat->category_slug ?>"><?= $cat->category_name ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div class="input-group-btn">
                <input type="hidden" id="search-param" name="post_type" value="product" />
                <button type="submit" class="btn btn-secondary"><i class="ec ec-search"></i></button>
            </div>
        </div>
    </form>
    <?php
}