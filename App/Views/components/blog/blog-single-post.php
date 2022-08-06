<?php
function __blog_single_post(){
    extract($GLOBALS['blog']);
    ?>
<article class="post type-post status-publish format-gallery has-post-thumbnail hentry" >
    <div class="media-attachment">
        <div class="media-attachment-gallery">
            <div class=" ">
                <div class="item" style="width: unset;">
                    <figure>
                        <img src="<?= $__post_details->post_image ?? '/Public/assets/images/blog/blog-1.jpg' ?>" class="attachment-post-thumbnail size-post-thumbnail" alt="1" />
                    </figure>
                </div><!-- /.item -->
            </div>
        </div><!-- /.media-attachment-gallery -->
    </div>

    <header class="entry-header">
        <h1 class="entry-title" itemprop="name headline"><?= $__post_details->post_title ?? '_No Title Found For Post' ?><span class="comments-link"><a href="#comments">Leave a comment</a></span></h1>

        <div class="entry-meta">
            <span class="cat-links"><a href="#" rel="category tag">Design</a>, <a href="#" rel="category tag">Technology</a></span>
            <span class="posted-on"><a href="#" rel="bookmark"><time class="entry-date published" datetime="2016-03-04T07:34:20+00:00"><?= $__post_details->date ?? 'Jan 01 2021' ?></time> <time class="updated" datetime="2016-03-04T18:46:11+00:00" itemprop="datePublished"><?= $__post_details->date ?? 'Jan 01 2021' ?></time></a></span>
        </div>
    </header><!-- .entry-header -->

    <div class="entry-content" itemprop="articleBody">
        <?= htmlspecialchars_decode(html_entity_decode($__post_details->post_body ?? '' ))?>
</article>

    <?php
}