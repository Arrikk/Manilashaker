<?php

use App\Models\Blog;

function __ui_post_single($data)
{
    $post = $data['post'];
    __ui_single_top($data);
    __ui_single_body($post);
    __ui_post_tag($post->post_tag);
    __ui_social_share([
        'share_link' => $post->post_slug,
        'share_img' => $post->post_image,
        'share_title' => $post->post_title
    ]);
    __ui_single_author($post);
    __ui_related($post->post_id);
    __ui_comment_field();
}

function __ui_single_top($data)
{
    extract($data);
    $comm =  count($comments);
?>
    <img src="<?= $post->post_image ?>" alt="" class="ui-article-img">
    <div class="ui-article-others">
        <div class="ui-article-other">
            <div class="ui-article-icon">
                <i class="bi-calendar-event"></i>
            </div> &nbsp;
            <?= $post->date ?>
        </div>
        <div class="ui-article-other">
            <div class="ui-article-icon">
                <i class="bi-person-fill"></i>
            </div>
            <?= $post->author ?>
        </div>
        <div class="ui-article-other">
            <div class="ui-article-icon">
                <i class="bi-chat-right-fill"></i>
            </div><?= $comm ?> &nbsp;
            <span class="ui-in-text">
                <?= $comm > 1 ? 'comments' : 'comment' ?>
            </span>
        </div>
        <div class="ui-article-other">
            <div class="ui-article-icon">
                <i class="bi-eye-fill"></i>
            </div><?= $post->views ?> &nbsp;
            <span class="ui-in-text">views</span>
        </div>
    </div>
<?php
return;
}

function __ui_single_body($data)
{
?>
    <div class="ui-post-content">
        <h2><?= html_entity_decode($data->post_title) ?></h2>
        <div class="ui-post-article">
            <?= html_entity_decode($data->post_body) ?>
        </div>
    </div>
<?php
return;
}

function __ui_post_tag($ptag)
{
    $tags = explode(',', $ptag);
?>
    <div class="ui-article-tag">
        <div class="ui-article-tab-i">
            <div class="ui-tag-icon">
                <i class="bi-tag"></i>
            </div>
            Tags:
        </div>
        <div class="ui-article-tags">
            <?php if (count($tags) > 0 && $tags[0] !== '') : ?>
                <?php foreach ($tags as $tag) : if ($tag == '') continue; ?>
                    <a href="" class="ui ui-tag"><?= $tag ?></a>
                <?php endforeach; ?>
            <?php else : ?>
                <a href="javascript:;" class="ui ui-tag">No tag</a>
            <?php endif; ?>
        </div>
    </div>
<?php
return;
}

function __ui_single_author($data)
{
?>
    <!-- Author -->
    <div class="ui-article-author">
        <!-- <img src="< ?= $data->author_img ?>" class="ui-article-author-img" alt=""> -->
        <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" class="ui-article-author-img" alt="">
        <div class="ui-article-data">
            <a href="/author/post/<?= $data->username ?>">
                <h3 class="ui-article-name"><?= $data->author ?></h3>
            </a>
            <p><?= $data->author_desc !== NULL ? html_entity_decode($data->author_desc ) : '' ?></p>
        </div>
    </div>
<?php
return;
}

function __ui_related($id)
{
    $blog = Blog::relatedPosts($id);
    $color = ['--purple', '--red', '--black', '--brown'];
?>
    <?php if (count($blog) > 0) : ?>
        <div class="ui-related-title">
            Other related posts
        </div>

        <div class="ui-side ui-grid ui-grid-4">
            <?php foreach ($blog as $other) : ?>
                <?php $col = $color[rand(0, count($color) - 1)] ?>
                <div class="ui-item-side-card ui-4">
                    <a href="/" class="ui ui-card-badge" style="background-color: var(<?= $col ?>);"><?= $other->cat_name ?></a>
                    <img src="<?= $other->post_image ?>" alt="">
                    <div class="ui-card-gradient">
                        <h3 class="">
                            <a href="/<?= $other->post_slug ?>" class="ui">
                                <?= html_entity_decode($other->post_title) ?>
                        </a>
                            <span><?= $other->date ?></span>
                        </h3>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
<?php
return;
}

function __ui_comment_field()
{
?>
    <div class="ui-form-title">
        Leave a comment
    </div>
    <form method="post" id="commentform">
        <div class="ui-form-container">
            <textarea required name="comment" id="comment" cols="30" rows="10" class="ui-form-text" placeholder="What's in your mind"></textarea>
            <div class="ui-form-group">
                <div class="ui-form-icon">
                    <i class="bi-envelope-fill"></i>
                </div>
                <input type="text" name="email" id="email" class="ui-form-input" placeholder="Email">
            </div>
            <div class="ui-form-group">
                <div class="ui-form-icon">
                    <i class="bi-person-fill"></i>
                </div>
                <input type="text" name="author" id="author" class="ui-form-input" placeholder="Name">
            </div>
            <button type="submit" class="ui-form-button comment-submit"> <span><i class="bi bi-plus"></i></span> Comment</button>
        </div>
    </form>
<?php
return;
}
