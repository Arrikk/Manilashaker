<?php

use App\Models\Blog;

function __shop_single_summary($product, $rating)
{
?>
    <div class="summary entry-summary">

        <span class="loop-product-categories">
            <a href="/gadgets/product?category=<?= $product->category_name ?>" rel="tag"><?= $product->category_name ?></a>
        </span><!-- /.loop-product-categories -->

        <h1 itemprop="name" class="product_title entry-title"><?= $product->product_name ?></h1>

        <div class="woocommerce-product-rating">
            <div class="star-rating" title="Rated <?= $rating['rating'] ?> out of 5">
                <span style="width:<?= $rating['rating'] * 20 ?>%">
                    <strong itemprop="ratingValue" class="rating"><?= $rating['rating'] ?></strong>
                    out of <span itemprop="bestRating">5</span> based on
                    <span itemprop="ratingCount" class="rating"><?= count($rating['comment']) ?></span>
                    customer ratings
                </span>
            </div>

            <a href="#reviews" class="woocommerce-review-link">
                (<span itemprop="reviewCount" class="count"><?= count($rating['comment']) ?></span> customer reviews)
            </a>
        </div><!-- .woocommerce-product-rating -->

        <div class="brand">
            <a href="#">
                <img src="<?= $product->product_image ?>" alt="<?= $product->product_name ?>" />
            </a>
        </div><!-- .brand -->

        <div class="availability in-stock">
            Availablity: <span class="text-<?php if(isset($product->in_stock) && $product->in_stock == 1) echo "success"; else echo "danger"; ?>" ><?php if(isset($product->in_stock) && $product->in_stock == 1) echo "In stock"; else echo "Out of stock" ?></span>
        </div><!-- .availability -->

        <hr class="single-product-title-divider" />

        <div class="action-buttons">

            <!-- <a href="#" class="add_to_wishlist">
                Wishlist
            </a> -->


            <!-- <a href="#" class="add-to-compare-link" data-product_id="2452">Compare</a> -->
        </div><!-- .action-buttons -->

        <div itemprop="description">
            <?php
              $u = str_replace('amp;', '',$product->product_summary) ?? '';
            //   $u = str_replace('span', 'li', $u);
              echo html_entity_decode($u);
              ?>
        </div><!-- .description -->

        <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">

            <p class="price"><span class="electro-price"><ins><span class="amount"><?= SIGN.' '. number_format($product->product_price, 2) ?></span></p>

            <meta itemprop="price" content="<?= $product->product_price ?>" />
            <meta itemprop="priceCurrency" content="PHP" />
        </div><!-- /itemprop -->
        <!-- <table>
            <tr>
                <td>
                    <div class="quantity buttons_added"><input type="button" class="minus btn-minus" value="-">
                        <label>Quantity:</label>
                        <input type="number" size="4" data-item="" class="input-text qty text" title="Qty" value="1" name="order[< ?= Blog::enc($product->product_id) ?>]quantity[]" max="30" min="0" step="1">
                        <input type="button" class="plus btn-plus" value="+">
                    </div>
                </td>
                <td>
                    <div class="single_variation_wrap">
                        <div class="woocommerce-variation-add-to-cart variations_button">
                            <button type="submit" class="single_add_to_cart_button button">Add to cart</button>
                        </div>
                    </div>
                </td>
            </tr>
        </table> -->

        <!-- < ?php require_once 'inc/blocks/single-product/variations-form.php'; ?> -->


    </div><!-- .summary -->
<?php
}
