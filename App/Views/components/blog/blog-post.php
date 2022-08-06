<?php
function __blog_post($type, $ctPost = [], $style = ''){
    $posts = [];
    if($type == "MAIN"):
        $posts = $GLOBALS['blog']['__blog_post'];
    elseif($type == 'CATEGORY'):
        $posts = $ctPost;
    endif;

    ?>
    <?php if(isset($posts) && count($posts) > 0):  ?>
        <?php foreach ($posts as $post): ?>
            
            <article class="post format-standard hentry">
                <div class="media-attachment"><a href="/<?= $post->post_slug?>"><img width="870" height="460" src="<?= $post->post_image ?>" class="wp-post-image" alt="8" style="<?= $style ?>"></a></div>
                <div class="content-body">
                    <header class="entry-header">
                        <h1 class="entry-title" itemprop="name headline"><a href="/<?= $post->post_slug?>" rel="bookmark"><?= $post->post_title ?></a></h1>
                        <div class="entry-meta">
                            <span class="cat-links">
                                <?php
                                    $categories = \App\Models\Blog::postCategory($post->category_id);
                                    if(count($categories) > 0):
                                        foreach ($categories as $value):
                                            echo '<a href="/'.$value->category_name.'/'.\App\Models\Blog::enc($value->category_id).'" rel="category tag">'.$value->category_name.'</a>, ';
                                        endforeach;
                                    else:
                                        echo '<a href="#" rel="category tag">Uncategorized</a>';
                                    endif;

                                ?>
                            </span>
                            <span class="posted-on"><a href="#" rel="bookmark"><time class="entry-date published" datetime="2016-03-01T07:40:25+00:00"><?= $post->date ?></time> <time class="updated" datetime="2016-03-04T18:46:11+00:00" itemprop="datePublished"><?= $post->date ?></time></a></span>
                        </div>
                    </header><!-- .entry-header -->

                    <div class="entry-content" itemprop="articleBody">
                        <!-- < ?php $bd =  substr($post->post_body, 0, 50); echo html_entity_decode(str_replace('\\n', '', $bd)); ?> -->
                    </div><!-- .post-excerpt -->

                    <div class="post-readmore"><a href="/<?= $post->post_slug?>" class="btn btn-primary">Read More</a></div>
                    <span class="comments-link"><a href="#">Leave a comment</a></span>
                </div>

            </article>
        <?php endforeach; ?>
    <?php else: ?>
        <article class="post format-standard hentry">
        <div class="entry-content" itemprop="articleBody">
            <p>No Post to show</p>
        </div><!-- .post-excerpt -->
        </article>
    <?php endif; ?>

   
    <?php
}

function __blogPostREUSE() {
?>
     
     <article class="post format-video hentry post_format-post-format-video">

    <div class="media-attachment"><div class="video-container"><div class="embed-responsive embed-responsive-16by9"><iframe src="https://player.vimeo.com/video/153747736" width="870" height="490" allowfullscreen></iframe></div></div></div>
    <div class="content-body">
        <header class="entry-header">
            <h1 class="entry-title" itemprop="name headline"><a href="#" rel="bookmark">Robot Wars &#8211; Now Closed &#8211; Post with Video</a></h1>
            <div class="entry-meta">
                <span class="cat-links"><a href="#" rel="category tag">Videos</a></span>
                <span class="posted-on"><a href="#" rel="bookmark"><time class="entry-date published" datetime="2016-03-03T13:28:24+00:00">March 3, 2016</time> <time class="updated" datetime="2016-03-31T14:32:27+00:00" itemprop="datePublished">March 31, 2016</time></a></span>
            </div>
        </header><!-- .entry-header -->

        <div class="entry-content" itemprop="articleBody">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tincidunt, erat in malesuada aliquam, est erat faucibus purus, eget viverra nulla sem vitae neque. Quisque id sodales libero. In nec enim nisi, in ultricies quam. Sed lacinia feugiat velit, cursus molestie lectus.</p>
        </div><!-- .post-excerpt -->

        <div class="post-readmore"><a href="#" class="btn btn-primary">Read More</a></div>
        <span class="comments-link"><a href="##comments">Leave a comment</a></span>
    </div>

    </article>

    <article id="post-2409" class=" post-2409 post type-post status-publish format-standard has-post-thumbnail hentry category-design">

    <div class="media-attachment"><a href="#"><img width="870" height="460" src="assets/images/blog/blog-3.jpg" class="wp-post-image" alt="6"></a></div>
    <div class="content-body">
        <header class="entry-header">
            <h1 class="entry-title" itemprop="name headline"><a href="#" rel="bookmark">The first flowers in space</a></h1>
            <div class="entry-meta">
                <span class="cat-links"><a href="#" rel="category tag">Design</a>, <a href="#" rel="category tag">Technology</a></span>
                <span class="posted-on"><a href="#" rel="bookmark"><time class="entry-date published" datetime="2016-03-01T07:23:07+00:00">March 1, 2016</time> <time class="updated" datetime="2016-03-04T18:46:11+00:00" itemprop="datePublished">March 4, 2016</time></a></span>
            </div>
        </header><!-- .entry-header -->

        <div class="entry-content" itemprop="articleBody">
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s, when an unknown printer took</p>
        </div><!-- .post-excerpt -->

        <div class="post-readmore"><a href="#" class="btn btn-primary">Read More</a></div>
        <span class="comments-link"><a href="##comments">Leave a comment</a></span>
    </div>
    </article>
    <article class="post format-audio hentry post_format-post-format-audio">

    <div class="media-attachment"><iframe width="870" height="165" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/229791977&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&visual=true"></iframe></div>
    <div class="content-body">
        <header class="entry-header">
            <h1 class="entry-title" itemprop="name headline"><a href="#" rel="bookmark">Robot Wars &#8211; Now Closed &#8211; Post with Audio</a></h1>

            <div class="entry-meta">
                <span class="cat-links"><a href="#" rel="category tag">Design</a>, <a href="#" rel="category tag">Uncategorized</a></span>
                <span class="posted-on"><a href="#" rel="bookmark"><time class="entry-date published" datetime="2016-03-03T13:32:08+00:00">March 3, 2016</time> <time class="updated" datetime="2016-03-31T14:38:00+00:00" itemprop="datePublished">March 31, 2016</time></a></span>
            </div>
        </header><!-- .entry-header -->

        <div class="entry-content" itemprop="articleBody">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tincidunt, erat in malesuada aliquam, est erat faucibus purus, eget viverra nulla sem vitae neque. Quisque id sodales libero. In nec enim nisi, in ultricies quam. Sed lacinia feugiat velit, cursus molestie lectus.</p>
        </div><!-- .post-excerpt -->
    </div>
    </article>

<?php
}

