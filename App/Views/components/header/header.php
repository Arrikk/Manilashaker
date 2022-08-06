<?php

use App\Models\Settings;

function __header($template = false)
{
?>

  <!-- < ?php if($template): ?> -->
  <style>
    .nav-filter {
      display: flex;
      align-items: center;
      width: 100%;
      margin: 30px 0;
    }

    .nav-filter span.title {
      color: #8c8c8c;
      font-style: italic;
      font-size: 10px;
      text-transform: uppercase;
      flex: 1;
    }

    .nav-filter-item {
      flex: 8;
      /* display: flex; */
      align-items: center;
      color: #8c8c8c;
      font-weight: bolder;
      overflow: hidden;
    }

    .nav-filter-items {
      font-size: 12px;
      color: inherit;
      background-color: #f6f6f6;
      padding: 3px 15px;
      margin-right: 10px;
      border-radius: 50px;
    }

    .filter-nav {
      padding-left: 10px;
      flex: 2;
      display: flex;
      color: #8c8c8c;
      font-size: 15px;
      font-weight: bold;
      cursor: pointer;
    }

    .filter-nav span {
      border: 1px solid #8c8c8c;
      display: flex;
      height: 10px;
      width: 10px;
      border-radius: 50px;
      align-items: center;
      justify-content: center;
      padding: 10px;
    }

    .filter-nav .filter-left {
      margin-right: 5px;
    }

    .filter-right {
      margin-left: 5px;
    }

    .item {
      width: 3000px;
      display: flex;
      transition: 0.5s;
    }
  </style>

  <?php headerNew() ?>
  <header id="masthead" class="site-header header-v2">
    <div class="container">
      <div class="row ui-override-head-row">

        <!-- < ?php __header_logo() ?> -->
        <?php __primary_nav() ?>
        <!-- < ?php __header_support_info() ?> -->

      </div>
      <!-- /.row -->
      <!-- <div class="nav-filter">
        <span class="title">Popular Filter</span>
        <div class="nav-filter-item">
          <div class="item">
            <a href="/gadgets/xiaomi-phones?filter&from=46072&to=51190" class="nav-filter-items">Mobile Phones under 6000</a>
            <a href="/gadgets/hp-laptop?filter&from=63541&to=74130" class="nav-filter-items">Laptop under 75000</a>
            <a href="/gadgets/micromax-phones?filter&from=8250.5&to=9899.4" class="nav-filter-items">Mobile Phones under 74130</a>
            <a href="/gadgets/asus-laptop?filter&from=89701&to=104650" class="nav-filter-items">Laptop under 52000</a>
            <a href="/gadgets/Apple-Sm?filter&from=21561&to=26950" class="nav-filter-items">Smartwatch under 11111</a>
            <a href="/gadgets/Lenovo-Sm?filter&from=1750.5&to=2099.4" class="nav-filter-items">Smartwatch under 10000</a>
            <a href="/gadgets/daikin-ac?filter&from=25201&to=31500" class="nav-filter-items">Aircondition under 12000</a>
            <a href="/gadgets/Samsung-Fr?filter&from=71995&to=83993" class="nav-filter-items">Refrigerator under 43000</a>
            <a href="/gadgets/sony-tablet?filter&from=36583&to=42679" class="nav-filter-items">Tablet under 20000</a>
            <a href="/gadgets/samsung-ac?filter&from=35395&to=41293" class="nav-filter-items">Aircondition under 19000</a>
            <a href="/gadgets/apple-phones?filter&from=143911&to=159900" class="nav-filter-items">Mobile Phones under 160000</a>
          </div>
        </div>
        <div class="filter-nav">
          <span class="filter-left"><</span>
          <span class="filter-right">></span>
        </div>
      </div> -->
      <div class="ui-search-container">
        <div class="ui-nav-search">
          <input type="search" class="ui-search-nav" name="" id="" placeholder="Search" />
          <div class="ui-font-search">
            <i class="bi-search"></i>
          </div>
        </div>
      </div>
    </div>
  </header>
  <!-- #masthead -->
  <!-- <nav class="navbar navbar-primary navbar-full">
    <div class="container">
      < ?php __navbar__search() ?>
      < ?php __navbar__right() ?>
    </div>
  </nav> -->
  <script>
    let item = $('div.item')
    let start = 0
    $(document).on('click', 'span.filter-left', function() {
      start += 100
      item.css({
        transform: `translateX(${start}px)`
      })
    })
    $(document).on('click', 'span.filter-right', function() {
      start -= 100
      item.css({
        transform: `translateX(${start}px)`
      })
    })

    let menu = $('.menu-item.menu-item-has-children')
    menu.on('mouseenter', function() {
      menu.not(this).removeClass('open')
      let drop = $(this).addClass('open')
    })
    // menu.on('mouseleave', function() {
    //   let drop = $(this).removeClass('open')
    // })
  </script>
  <?php __ui_nav_bar() ?>
  <!-- < ?php else: ?> -->
  <!-- < ?php endif; ?> -->

<?php
}

function __header_admin()
{
?>
  <header class="top-header">
    <nav class="navbar navbar-expand">
      <div class="mobile-toggle-icon d-xl-none">
        <i class="bi bi-list"></i>
      </div>
      <div class="top-navbar d-none d-xl-block">
        <ul class="navbar-nav align-items-center">
          <li class="nav-item">
            <a class="nav-link" href="/auth/destroy">Logout</a>
          </li>
          <!-- <li class="nav-item">
            <a class="nav-link" href="">Email</a>
          </li> -->
          <li class="nav-item">
            <a class="nav-link" href="javascript:;">Posts</a>
          </li>
          <li class="nav-item d-none d-xxl-block">
            <a class="nav-link" href="javascript:;">Settings</a>
          </li>
        </ul>
      </div>
      <!-- <div class="search-toggle-icon d-xl-none ms-auto">
        <i class="bi bi-search"></i>
      </div>
      <form class="searchbar d-none d-xl-flex ms-auto">
        <div class="position-absolute top-50 translate-middle-y search-icon ms-3"><i class="bi bi-search"></i></div>
        <input class="form-control" type="text" placeholder="Type here to search">
        <div class="position-absolute top-50 translate-middle-y d-block d-xl-none search-close-icon"><i class="bi bi-x-lg"></i></div>
      </form> -->
    </nav>
  </header>
<?php
}

function headerNew()
{
  extract($GLOBALS['site']);
  $ad = Settings::wieSetting()->ads ?? '';
?>
  <div class="ui-top-container">
    <div class="ui-top-item">
      <div class="ui-ads-top-logo">
        <a href="/">
          <img src="<?=
                    $__site ?? $__site->site_logo !== '' ||  $__site->site_logo !== NULL
                      ? $__site->site_logo :  '/Public/assets/images/fav-icon.png'
                    ?>" alt="" class="ui-logo-top">
        </a>
      </div>
      <div class="ui-ads-top-banner">
        <?= $ad->rlg ?? '' ?>
      </div>
    </div>
  </div>
<?php
}
?>