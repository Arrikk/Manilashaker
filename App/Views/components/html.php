<?php
function __html($templete = false)
{
    extract($GLOBALS['site']);
    extract($GLOBALS['blog']);
    $productTitle = $GLOBALS['product'];

    // echo $__versus;  

    $meta_description = "";
    if (isset($__post_details->post_description) && $__post_details->post_description !== '') {
        $meta_description =  htmlspecialchars_decode(html_entity_decode($__post_details->post_description));
        $meta_description = str_replace('&nbsp;', '', $meta_description);
    } elseif (isset($__seo) &&  $__seo->meta_description !== NULL) {
        $meta_description =  htmlspecialchars_decode(html_entity_decode($__seo->meta_description));
    } elseif (isset($__compare_category) && $__compare_category !== '') {
        $meta_description = "Compare $__versus $__compare_category";
    } else {
        $meta_description = 'Ecommerce, Blog Coded with love by CodeHart Dev (Bruiz)';
    }
?>
    <!DOCTYPE html>
    <html lang="en-US" itemscope="itemscope" itemtype="http://schema.org/WebPage">

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="<?= $meta_description ?>">
        <meta name="keywords" content="<?=
                                        $__seo ?? $__seo->meta_keyword !== '' ||  $__seo->meta_keyword !== NULL
                                            ? htmlspecialchars_decode(html_entity_decode($__seo->meta_keyword)) :  'Ecommerce, Blog Coded with love by CodeHart Dev (Bruiz), PHP, Shop, Buy, Blog, News'
                                        ?>
            ">


        <title>
            <?php
            if (isset($__post_details->post_title) && $__post_details->post_title !== '') {
                echo  $__post_details->post_title;
            } elseif (isset($productTitle) && $productTitle !== '') {
                echo $productTitle;
            } elseif (isset($__compare_category) && $__compare_category !== '') {
                echo "Compare $__versus $__compare_category";
            } else {
                // if(isset($site)){
                if ($__site->title !== '' ||  $__site->title !== NULL)
                    echo $__site->title;
                else
                    echo 'CodeHart Dev (Bruiz)';

                // }
            }

            ?>
        </title>

        <!-- < ?php if (!$templete) : ?> -->

            <link rel="stylesheet" type="text/css" href="/Public/assets/css/bootstrap.min.css" media="all" />
            <link href="/Public/asset/plugins/select2/css/select2.min.css" rel="stylesheet" />
            <link href="/Public/asset/plugins/select2/css/select2-bootstrap4.css" rel="stylesheet" />
            <link rel="stylesheet" type="text/css" href="/Public/assets/css/font-awesome.min.css" media="all" />
            <link rel="stylesheet" type="text/css" href="/Public/assets/css/animate.min.css" media="all" />
            <!-- <link rel="stylesheet" type="text/css" href="/Public/assets/css/font-electro.css" media="all" /> -->
            <link rel="stylesheet" type="text/css" href="/Public/assets/css/owl-carousel.css" media="all" />
            <link rel="stylesheet" type="text/css" href="/Public/assets/css/style.css" media="all" />
            <link rel="stylesheet" type="text/css" href="/Public/assets/css/colors/green.css" media="all" />
            <link rel="stylesheet" href="/Public/css/css/sidebar.css?v=<?= time() ?>">
            <link rel="stylesheet" href="/Public/css/css/app.css?v=<?= time() ?>">
        <!-- < ?php else : ?>
        < ?php endif; ?> -->

        <link href="/Public/asset/icon/bootstrap-icons.css" rel="stylesheet" />
        <!-- <link href="/Public/asset/css/style.css" rel="stylesheet" /> -->
        <!-- <link href="/Public/asset/css/icons.css" rel="stylesheet"> -->

        <script src="/Public/asset/js/jquery.min.js"></script>

        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,700italic,800,800italic,600italic,400italic,300italic' rel='stylesheet' type='text/css'>

        <link rel="shortcut icon" href="<?=
                                        $__site ?? $__site->favicon !== '' ||  $__site->favicon !== NULL
                                            ? $__site->favicon :  '/Public/assets/images/fav-icon.png'
                                        ?>">

        <?=
        $__seo ?? $__seo && $__seo->google_analytics !== '' ||  $__seo->google_analytics !== NULL
            ? $__seo->google_analytics :  ''
        ?>


    </head>

    <body class="<?= $__class ?>">
    
        <div class="ui-top-nav">
            <div class="ui-top-date ui-flex ">
                <img src="<?= $__site ?? $__site->site_logo !== '' ||  $__site->site_logo !== NULL
                                ? $__site->site_logo :  '/Public/assets/images/fav-icon.png'
                            ?>" class="ui-mr5" width="40" alt="">
                <a href="#" class="ui"><?= date('M, d Y') ?></a>
            </div>
            <div class="ui-top-icons">
                <div class="ui-show-sm">
                    <span class="ui-icon-top ui-icon-lg ui-toggl-nav">
                        <i class="bi-list"></i>
                    </span>
                </div>
                <div class="ui-show-lg">
                    <a href="#" class="ui ui-icon-top">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="#" class="ui ui-icon-top">
                        <i class="bi bi-twitter"></i>
                    </a>
                    <a href="#" class="ui ui-icon-top">
                        <i class="bi bi-instagram"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <?php __primary_nav_cat() ?>
    <?php
}

function __html_admin()
{
    ?>
        <!doctype html>
        <html lang="en" class="semi-dark">

        <head>
            <!-- Required meta tags -->
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="icon" href="/Public/asset/images/favicon-32x32.png" type="image/png" />
            <!--plugins-->
            <link href="/Public/asset/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
            <link href="/Public/asset/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
            <link href="/Public/asset/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
            <link href="/Public/asset/plugins/select2/css/select2.min.css" rel="stylesheet" />
            <link href="/Public/asset/plugins/select2/css/select2-bootstrap4.css" rel="stylesheet" />
            <!-- Bootstrap CSS -->
            <link href="/Public/asset/css/bootstrap.min.css" rel="stylesheet" />
            <link href="/Public/asset/css/bootstrap-extended.css" rel="stylesheet" />
            <!-- <link rel="stylesheet" type="text/css" href="/Public/assets/css/font-awesome.min.css" media="all" /> -->
            <link href="/Public/asset/icon/bootstrap-icons.css" rel="stylesheet" />
            <link href="/Public/asset/css/style.css" rel="stylesheet" />
            <link href="/Public/asset/css/icons.css" rel="stylesheet">
            <!-- <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet"> -->
            <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css"> -->

            <!-- loader-->
            <link href="/Public/asset/css/pace.min.css" rel="stylesheet" />


            <!--Theme Styles-->
            <link href="/Public/asset/css/dark-theme.css" rel="stylesheet" />
            <link href="/Public/asset/css/light-theme.css" rel="stylesheet" />
            <link href="/Public/asset/css/semi-dark.css" rel="stylesheet" />
            <link href="/Public/asset/css/header-colors.css" rel="stylesheet" />
            <script src="/Public/asset/js/jquery.min.js"></script>

            <title>Manila shaker Admin</title>
        </head>

        <body>

        <?php
    }
