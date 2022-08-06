<?php

use App\Model\Products;
use App\Models\Blog;

function __ui_footer_widget_1()
{
    $phones = Products::footerGadgets('phones', 3);
?>
    <div class="ui-footer-wdg">
        <div class="ui-footer-title">Smart Phones</div>
        <?php if (count($phones) > 0) : ?>
            <?php $i = 1;
            foreach ($phones as $phone) : ?>
                <?php if ($i > 5) continue; ?>
                <div class="ui-footer-media-item">
                    <img src="<?= $phone->product_image ?>" alt="" class="ui-footer-media-img">
                    <a href="/<?= $phone->product_category ?>/<?= $phone->product_slug ?>" class="ui">
                        <p class="ui-footer-media-title"><?= $phone->product_name ?></p>
                        <small><?= SIGN . number_format($phone->product_price, 2); ?></small>
                    </a>
                </div>
            <?php $i++;
            endforeach; ?>
        <?php endif; ?>
    </div>
<?php
}

function __ui_footer_widget_2()
{
    $posts = Blog::footerPostWidget();
?>
    <div class="ui-footer-wdg">
        <div class="ui-footer-title">Popular Posts</div>
        <?php if (count($posts) > 0) : ?>
            <?php $i = 1;
            foreach ($posts as $post) : ?>
                <?php if ($i > 5) continue; ?>
                <div class="ui-footer-media-item">
                    <img src="<?= $post->post_image ?>" alt="" class="ui-footer-media-img">
                    <a href="/<?= $post->post_slug ?>" class="ui">
                        <p class="ui-footer-media-title"><?= $post->post_title ?></p>
                        <small style="font-size: x-small;"><?= $post->date; ?></small>
                    </a>
                </div>
            <?php $i++;
            endforeach; ?>
        <?php endif; ?>
    </div>
<?php
}

function __ui_footer_widget_3()
{
    $posts = Blog::footerPostWidget(Blog::PUBLISHED, 8);
?>
    <div class="ui-footer-wdg">
        <div class="ui-footer-title">Also Read</div>
        <?php if (count($posts) > 0) : ?>
            <?php $i = 1;
            foreach ($posts as $post) : ?>
                <?php if ($i > 5) continue; ?>
                <div class="ui-footer-link" style="margin-bottom: 15px;">
                    <div class="ui-icon-link">></div>
                    <a href="/<?= $post->post_slug ?>" class="ui">
                        <p class="ui"><?= $post->post_title ?></p>
                        <small style="font-size: x-small;"><?= $post->date; ?></small>
                    </a>
                </div>
            <?php $i++;
            endforeach; ?>
        <?php endif; ?>
    </div>
<?php
}

function __ui_footer_widget_4()
{
?>

    <div class="ui-footer-wdg">
        <div class="ui-footer-title">Quick Menu</div>
        <div class="ui-footer-link">
            <div class="ui-icon-link">></div>
            <a href="#" class="ui">
                <p>News</p>
            </a>
        </div>
        <div class="ui-footer-link">
            <div class="ui-icon-link">></div>
            <a href="#" class="ui">
                <p>Gadgets</p>
            </a>
        </div>
        <div class="ui-footer-link">
            <div class="ui-icon-link">></div>
            <a href="#" class="ui">
                <p>Comparison</p>
            </a>
        </div>
    </div>
<?php
}
