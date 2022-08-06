<?php
function __blog_category_widget(){
    $categories = $GLOBALS['blog']['__blog_category'];
    ?>
        <aside class="widget widget_categories">
            <h3 class="widget-title">Categories</h3>
            <ul>
                <?php if(isset($categories) && count($categories) > 0 ): ?>
                    <?php foreach ($categories as $key): ?>
                        <li class="cat-item"><a href="/news/<?= $key->slug?>/<?= \App\Models\Blog::enc($key->category_id)?>" ><?= $key->category_name; ?></a></li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="cat-item"><a href="#" >No category</a></li>
                <?php endif; ?>
            </ul>
        </aside>

    <?php
}

function __blog_must_read() {
    $post = $GLOBALS['blog']['__blog_post'];
    ?>
        <aside class="widget widget_categories">
            <h3 class="widget-title">Must Read</h3>
            <ul>
                <?php if(isset($post) && count($post) > 0 ): ?>
                    <?php foreach ($post as $key): ?>
                        <li class="cat-item"><a href="/<?= $key->post_slug ?>" ><?= $key->post_title; ?></a></li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="cat-item"><a href="#" ><h6>No post to</h6></a></li>
                <?php endif; ?>
            </ul>
        </aside>

    <?php
}