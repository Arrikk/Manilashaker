<?php

use App\Models\Blog;

function  __uiPost_list($type, $posts = [], $style = '')
{

    $color = ['--deepGreen', '--red', '--purple', '--brown', '--black'];
    // $posts = $GLOBALS['blog']['__blog_post'];

?>
    <?php if (isset($posts) && count($posts) > 0) :  ?>
        <?php foreach ($posts as $post) : ?>

            <div class="ui-post-item">
                <img src="<?= $post->post_image ?>" alt="" class="ui-post-img">
                <div class="ui-post-detail">
                    <?php
                    $categories = \App\Models\Blog::postCategory($post->category_id);
                    $col = $color[rand(0, count($color) - 1)];
                    if (count($categories) > 0) :
                    ?>
                        <?php foreach ($categories as $category) : ?>
                            <a href="/category/<?= $category->slug ?>" class="ui ui-post-category" style="background-color: var(<?= $col ?>);"><?= $category->category_name ?? 'Uncategorised' ?></a>
                        <?php endforeach; ?>
                    <?php
                    else :
                        echo '<a href="#" class="ui ui-post-category" style="background: var(' . $col . ')" rel="category tag">Uncategorized</a>';
                    endif;
                    ?>
                    <a href="/<?= $post->post_slug ?>" class="ui">
                        <h3 class="ui-post-title"><?= $post->post_title  ?? '' ?></h3>
                    </a>
                    <p class="ui-post-preview">
                        <?= $post->post_description ?? '' ?>
                    </p>
                    <div class="ui-post-actions">
                        <p class="ui-post-other">
                            By <span class="ui-post-author"><?= $post->firstName ?></span>
                            <?= $post->date ?>
                        </p>

                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <article class="post format-standard hentry">
            <div class="entry-content" itemprop="articleBody">
                <p>No Post to show</p>
            </div><!-- .post-excerpt -->
        </article>
    <?php endif; ?>


<?php
}

function __ui_card_top()
{

    $card = Blog::blogPostCard();
    $color = ['--deepGreen', '--red', '--purple', '--brown', '--black'];

?>
    <?php if (count($card) > 0) : ?>
        <!-- <div class="ui-top-card-grid"> -->
            <div class="ui-card-grid-container ui-grid-1-sm">

                <div class="ui-card">
                    <div class="ui-side ui-sm-mg ui-grid ui-no-gap" style="margin-top:0;">
                        <?php $i = 0;
                        foreach ($card as $item) : ?>
                            <?php
                            if ($i <= 1) {
                            ?>

                                <div class="ui-item-side-card ui-4">
                                    <?php
                                    $categories = \App\Models\Blog::postCategory($item->category_id);
                                    $col = $color[rand(0, count($color) - 1)];
                                    if (count($categories) > 0) {
                                        foreach ($categories as $category) {
                                            echo '<a href="/category/' . $category->slug . '" class="ui ui-card-badge" style="background-color: var(' . $col . ');">' .  $category->category_name . '</a>';
                                        }
                                    } else {
                                        echo '<a href="#" class="ui ui-card-badge" style="background-color: var(--purple);">Uncategorized</a>';
                                    }
                                    ?>
                                    <img src="<?= $item->post_image ?>" alt="">
                                    <div class="ui-card-gradient">
                                        <h3 style="font-size: larger;" class="">
                                            <a href="/<?= $item->post_slug ?>" class="ui">
                                                <?= $item->post_title ?>
                                            </a>
                                            <span><?= $item->date  ?></span>
                                        </h3>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        <?php $i++;
                        endforeach; ?>
                    </div>
                </div>
                <div class="ui-card ui-sm-mg ui-grid ui-grid-2 ui-no-gap">

                    <div class="ui-side ui-grid ui-no-gap" style="margin-top:0;">
                        <?php $i = 0;
                        foreach ($card as $item) : ?>
                            <?php
                            if ($i > 1 && $i <= 3) {
                            ?>

                                <div class="ui-item-side-card ui-4">
                                    <?php
                                    $categories = \App\Models\Blog::postCategory($item->category_id);
                                    $col = $color[rand(0, count($color) - 1)];
                                    if (count($categories) > 0) {
                                        foreach ($categories as $category) {
                                            echo '<a href="/category/'.$category->slug.'" class="ui ui-card-badge" style="background-color: var(' . $col . ');">' .  $category->category_name . '</a>';
                                        }
                                    } else {
                                        echo '<a href="#" class="ui ui-card-badge" style="background-color: var(--purple);">Uncategorized</a>';
                                    }
                                    ?>
                                    <img src="<?= $item->post_image ?>" alt="">
                                    <div class="ui-card-gradient">
                                        <h3 class="">
                                            <a href="/<?= $item->post_slug ?>" class="ui">
                                                <?= $item->post_title ?>
                                            </a>
                                            <span><?= $item->date  ?></span>
                                        </h3>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        <?php $i++;
                        endforeach; ?>
                    </div>
                    <div class="ui-side ui-grid ui-no-gap" style="margin-top:0;">
                        <?php $i = 0;
                        foreach ($card as $item) : ?>
                            <?php
                            if ($i > 3 && $i <= 5) {
                            ?>

                                <div class="ui-item-side-card ui-4">
                                    <?php
                                    $categories = \App\Models\Blog::postCategory($item->category_id);
                                    $col = $color[rand(0, count($color) - 1)];
                                    if (count($categories) > 0) {
                                        foreach ($categories as $category) {
                                            echo '<a href="/category/' . $category->slug . '" class="ui ui-card-badge" style="background-color: var(' . $col . ');">' .  $category->category_name . '</a>';
                                        }
                                    } else {
                                        echo '<a href="#" class="ui ui-card-badge" style="background-color: var(--purple);">Uncategorized</a>';
                                    }
                                    ?>
                                    <img src="<?= $item->post_image ?>" alt="">
                                    <div class="ui-card-gradient">
                                        <h3 class="">
                                            <a href="/<?= $item->post_slug ?>" class="ui">
                                                <?= $item->post_title ?>
                                            </a>
                                            <span><?= $item->date  ?></span>
                                        </h3>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        <?php $i++;
                        endforeach; ?>
                    </div>
                </div>
            </div>
        <!-- </div> -->
    <?php endif; ?>
<?php
}

function __ui_post_pagination($prop)
{
    extract($prop);

    // $total_post = Blog::blogPosts(Blog::PUBLISHED, 1, true);
?>
    <div class="ui-post-pagination">

        <input type="hidden" id="totalPage" value="<?= round($total_post / Blog::POST_LIMIT) ?>">
        <input type="hidden" id="type" value="<?= $type ?>">
        <input type="hidden" id="currentPage" value="<?= $current ?? 1 ?>">
        <ul class="ui-pagination-items">
        </ul>
    </div>
<?php
    __ui_pagination_script();
}

function __ui_pagination_script()
{
?>
    <script>
        let page = 1;
        let totalPage = $('#totalPage').val()
        let currentPage = $('#currentPage')
        let pageNumbers = $('ul.ui-pagination-items')
        let type = $('input#type').val()
        let Url = ''
        if (type == 'MAIN') {
            Url = '/page/'
        } else if (type == 'CATEGORY') {
            let currLoc = location.pathname
            currLoc = currLoc.split('/')
            Url = `/${currLoc[1]}/${currLoc[2]}/`
        }else if(type == 'AUTHOR'){
            Url = location.pathname+'?page='
        }

        let listTag = ''

        let crtPage = currentPage.val();

        if (crtPage > page) {
            crtPage--
            pageNumbers.append(`<a class="prev ui ui-pagination-item" href="${Url}${crtPage}">Prev</a>`)
        }

        if (crtPage > 2) {
            if (page > 3) {
                listTag += `<a class='ui ui-pagination-item' href='javasctipt:;'>...</a>`
            }
            listTag += `<a class='ui ui-pagination-item' href='${Url}1'>1</a>`
        }

        let pagePrevious = +crtPage - 2;
        if (pagePrevious < 1) pagePrevious = 1;
        let pageNext = +crtPage + 2;
        if (pageNext >= totalPage) pageNext = totalPage - 1;

        // if(page > 0 && !pagePrevious < 0)

        for (let i = pagePrevious; i <= pageNext; i++) {
            listTag += `
            <a href="${Url}${i}" class='ui ui-pagination-item ${i == crtPage ? 'active' : ''}'>${i}</a>
            `
        }

        if (crtPage < totalPage - 1) {
            if (page < totalPage - 3) {
                listTag += `<a class='ui ui-pagination-item' href='javasctipt:;'>...</a>`
            }
            listTag += `<a class='ui ui-pagination-item' href='${Url}${totalPage}'>${totalPage}</a>`
        }

        if (crtPage < totalPage) {
            crtPage++
            listTag += `<a class="next ui ui-pagination-item" href="${Url}${crtPage+=1}">Load More</a>`
        }

        pageNumbers.html(listTag)
    </script>
<?php
}
