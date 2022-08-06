<?php
function __blog_recent_widget($type = 'recent'){
    $recent = $GLOBALS['blog']['__recent_post'];
    $title = 'Recent Post';
    if($type == 'other'){
        $recent = $GLOBALS['blog']['__other_post'];
        $title = 'Also Read';
    }
    ?>
        <aside class="widget electro_recent_posts_widget"><h3 class="widget-title"> <?= $title ?> </h3>
            <ul>
                <?php if(isset($recent) && count($recent) > 0):  ?>
                    <?php foreach ($recent as $post): ?>
                        <li>
                            <a class="post-thumbnail" href="#"><img width="150" height="150" src="<?= $post->post_image ?>" class="wp-post-image" alt="1"/></a>
                            <div class="post-content">
                                <a class ="post-name" href="/<?= $post->post_slug?>"><?= $post->post_title ?></a>
                                <span class="post-date"><?= $post->date ?></span>
                            </div>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>
                        <a class="post-thumbnail" href="#"><img width="150" height="150" src="/Public/assets/images/blog/blog-s-1.jpg" class="wp-post-image" alt="1"/></a>
                        <div class="post-content">
                            <a class ="post-name" href="#">No Post</a>
                            <span class="post-date">No post 2021</span>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </aside>
        
    <?php
}