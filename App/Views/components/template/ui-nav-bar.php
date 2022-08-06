<?php

use App\Models\Blog;
use App\Models\Settings;

function __ui_nav_bar()
{
    $social = Settings::socialSetting();
?>
    <div class="ui-nav-menu ui-mobile-menu">
        <div class="ui-show-sm">
            <div class="ui-menu-social-icons">
                <?php if(!$social == null) : ?>
                    <?php foreach ($social as $key => $social) : ?>
                        <?php if ($key == 'pinterest') : ?>
                            <a href="<?= $social ?>" class="ui ui-menu-social-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pinterest" viewBox="0 0 16 16">
                                    <path d="M8 0a8 8 0 0 0-2.915 15.452c-.07-.633-.134-1.606.027-2.297.146-.625.938-3.977.938-3.977s-.239-.479-.239-1.187c0-1.113.645-1.943 1.448-1.943.682 0 1.012.512 1.012 1.127 0 .686-.437 1.712-.663 2.663-.188.796.4 1.446 1.185 1.446 1.422 0 2.515-1.5 2.515-3.664 0-1.915-1.377-3.254-3.342-3.254-2.276 0-3.612 1.707-3.612 3.471 0 .688.265 1.425.595 1.826a.24.24 0 0 1 .056.23c-.061.252-.196.796-.222.907-.035.146-.116.177-.268.107-1-.465-1.624-1.926-1.624-3.1 0-2.523 1.834-4.84 5.286-4.84 2.775 0 4.932 1.977 4.932 4.62 0 2.757-1.739 4.976-4.151 4.976-.811 0-1.573-.421-1.834-.919l-.498 1.902c-.181.695-.669 1.566-.995 2.097A8 8 0 1 0 8 0z" />
                                </svg>
                            </a>
                        <?php else: ?>
                            <a href="<?= $social ?>" class="ui ui-menu-social-icon">
                                <i class="bi-<?= $key ?>"></i>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="ui-menu">
            <?php __ui_nav_list1() ?>
            <?php __ui_nav_list2() ?>
            <?php __ui_nav_list3() ?>
        </div>
        <div class="ui-search-container">
            <div class="ui-nav-search">
                <input type="search" class="ui-search-nav" name="" id="" placeholder="Search" />
                <div class="ui-font-search">
                    <i class="bi-search"></i>
                </div>
            </div>
        </div>
        <div class="ui-show-sm ui-sm-nav-component " style="">
            <div class="ui-side ui-grid ui-grid-sm-2">
                <?php __ui_nav_item_list() ?>
            </div>
        </div>
    </div>
<?php
    __ui_nav_script();
}

function __ui_nav_list1()
{
?>

    <ul class="ui-nav-ul">
        <li class="ui-nav-list">
        <a class="ui" href="/">Home</a>
        </li>
        <li class="ui-nav-list"><a class="ui" href="/category/reviews">Review</a></li>
        <li class="ui-nav-list"><a class="ui" href="/category/automotive">Automotive</a></li>
        <li class="ui-nav-list"><a class="ui" href="/category/tech">Tech</a></li>
        <li class="ui-nav-list"><a class="ui" href="/compare/phones/">Compare</a></li>
        <li class="ui-nav-list"><a class="ui" href="/mobile-phones/">Gadgets</a></li>
        <li class="ui-nav-list"><a class="ui" href="/category/guides">Guides</a></li>
    </ul>
<?php
}
function __ui_nav_list2()
{
    $menu = [
        'Phones' => '/mobile-phones/',
        'Laptops' => '/laptops/',
        'Tablet' => '/tablet/',
        'Television' => '/Television/',
        'Smartwatch' => '/smartwatch/',
        'Fitnessband' => '/fitnessband/',
        'Powerbank' => '/powerbank/',
        'Cameras' => '/cameras/',
    ];
?>
    <ul class="ui-nav-ul ui-show-sm">
        <?php foreach ($menu as $key => $value) : ?>
            <li class="ui-nav-list"><a class="ui" href="<?= $value ?>"><?= $key ?></a></li>
        <?php endforeach; ?>
    </ul>
<?php
}

function __ui_nav_list3()
{
    $menu = [
        'Miromax' => '/mobile-phones/',
        'Laptops' => '/gadgets/htc-phones',
        'HTC Tablet' => '/gadgets/htc-tabs',
        'LG Television' => '/gadgets/lg-television',
        // 'HTC Smartwatch' => '/gadget/htc-smart',
        'Acer Laptop' => '/gadgets/acer-laptop/',
        'Powerbank' => '/gadgets/Samsung-Pb',
        'HTC Cameras' => '/gadgets/htc-camera',
    ];
?>
    <ul class="ui-nav-ul ui-show-sm">
        <?php foreach ($menu as $key => $value) : ?>
            <li class="ui-nav-list"><a class="ui" href="<?= $value ?>"><?= $key ?></a></li>
        <?php endforeach; ?>
    </ul>
<?php
}

function __ui_nav_item_list()
{
    $page = rand(1, 20);
    $list = Blog::blogPosts(Blog::PUBLISHED, $page, false, true, 10);

?>

    <?php if (isset($list) && count($list) > 0) : ?>
        <?php foreach ($list as $link) : ?>
            <div class="ui-media-item" style="display: flex">
                <img src="<?= $link->post_image ?>" alt="" class="ui-footer-media-img" />
                <a href="/<?= $link->post_slug ?>" class="ui">
                    <p class="ui-footer-media-title">
                        <?= $link->post_title ?>
                    </p>
                    <small style="font-size: x-small"><?= date('M, d Y', strtotime($link->createdAt)) ?></small>
                </a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

<?php
}

function __ui_nav_script()
{
?>
    <script>
        // let toggl = document.querySelector('.ui-toggl-nav')
        // let nav = document.querySelector('.ui-mobile-menu')
        // toggl.onclick = (e) => {
        //     let parent = e.target.parentNode
        //     if (parent.classList.contains('show')) {
        //         nav.classList.remove('show')
        //         parent.classList.remove('show')
        //         parent.innerHTML = '<i class="bi-list"></i>'
        //     } else {
        //         nav.classList.add('show')
        //         parent.classList.add('show')
        //         parent.innerHTML = '<i class="bi-x"></i>'
        //     }
        // }
        let toggl = $('.ui-toggl-nav')
        let nav = $('.ui-mobile-menu')
        $(toggl).on('click', function() {
            let here = $(this);
            nav.fadeToggle()
            $(here).toggleClass('show')
            if ($(here).hasClass('show')) {
                here.html('<i class="bi-x"></i>')
            } else {
                here.html('<i class="bi-list"></i>')
            }
        })
    </script>
<?php
}
