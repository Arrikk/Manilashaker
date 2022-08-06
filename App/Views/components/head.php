<?php
function head($data = [], $default = array(
    'title' => 'Title', 
    'author' => 'Bruiz, Code Hart, Adeyemi Ademola PHP, NODE',
    'description' => '',
    'keywords' => ''
) )
{
    extract($default);
    extract($data);
    $seo = \App\Models\Settings::seoSetting();
    $site = \App\Models\Settings::siteSetting();

    ?>

    <head>
    <title><?= $title ?></title>
    <meta charset="utf-8">
    <meta content="ie=edge" http-equiv="x-ua-compatible">
    <meta content="<?= $seo->meta_keyword ?? 'Data, Recharge. TopUp' ?>" name="keywords">
    <meta content="<?= $author ?>" name="author">
    <meta content="<?= $seo->meta_description ?? "Reliable and fast Data Hub" ?>" name="description">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="theme-color" content="#1b55e2">
    <link href="<?= $site->favicon ?? "/Public/favicon.png" ?>" rel="shortcut icon">
    <link href="/Public/apple-touch-icon.png" rel="apple-touch-icon">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="/Public/assets/custom/loader.css">
    <link href="/Public/bower_components/select2/dist/css/select2.min.css" rel="stylesheet">
    <link href="/Public/bower_components/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="/Public/bower_components/dropzone/dist/dropzone.css" rel="stylesheet">
    <link href="/Public/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="/Public/bower_components/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">
    <link href="/Public/bower_components/perfect-scrollbar/css/perfect-scrollbar.min.css" rel="stylesheet">
    <link href="/Public/bower_components/slick-carousel/slick/slick.css" rel="stylesheet">
    <link href="/Public/assets/plugins/snackbar/snackbar.min.css" rel="stylesheet">
    <link href="/Public/css/main.css?version=4.4.0" rel="stylesheet">
    <link href="/Public/css/quick.css?version=4.4.0" rel="stylesheet">
  </head>

    <?php
}
function mainHead($data = [], $default = array(
    'title' => 'Title', 
    'author' => 'Bruiz, Code Hart, Adeyemi Ademola PHP, NODE',
    'description' => '',
    'keywords' => ''
) )
{
    extract($default);
    extract($data);
    $seo = \App\Models\Settings::seoSetting();
    $site = \App\Models\Settings::siteSetting();

    ?>

    <head>
    <title><?= $title ?></title>
    <meta charset="utf-8">
    <meta content="ie=edge" http-equiv="x-ua-compatible">
    <meta content="<?= $seo->meta_keyword ?? 'Data, Recharge. TopUp' ?>" name="keywords">
    <meta content="<?= $author ?>" name="author">
    <meta content="<?= $seo->meta_description ?? "Reliable and fast Data Hub" ?>" name="description">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="theme-color" content="#1b55e2">
    <link href="<?= $site->favicon ?? "/Public/favicon.png" ?>" rel="shortcut icon">
    <link href="/Public/apple-touch-icon.png" rel="apple-touch-icon">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500" rel="stylesheet" type="text/css">
    <link href="/Public/bower_components/select2/dist/css/select2.min.css" rel="stylesheet">
    <link href="/Public/bower_components/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="/Public/bower_components/dropzone/dist/dropzone.css" rel="stylesheet">
    <link href="/Public/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="/Public/bower_components/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">
    <link href="/Public/bower_components/perfect-scrollbar/css/perfect-scrollbar.min.css" rel="stylesheet">
    <link href="/Public/bower_components/slick-carousel/slick/slick.css" rel="stylesheet">
    <link href="/Public/assets/plugins/snackbar/snackbar.min.css" rel="stylesheet">
    <link href="/Public/css/main.css?version=4.4.0" rel="stylesheet">
    <link href="/Public/css/quick.css?version=4.4.0" rel="stylesheet">
  </head>

    <?php
}



function landingHead(){
  $seo = \App\Models\Settings::seoSetting() ?? '';
  $site = \App\Models\Settings::siteSetting() ?? '';
?>
<head>
  <meta charset="utf-8">
  <meta content="ie=edge" http-equiv="x-ua-compatible">
  <meta content="<?= $seo->meta_keyword ?? 'Data, Recharge. TopUp' ?>" name="keywords">
  <meta content="Bruiz, Code Hart, Adeyemi Ademola PHP, NODE" name="author">
  <meta content="<?= $seo->meta_description ?? "Reliable and fast Data Hub" ?>" name="description">
  <meta content="width=device-width, initial-scale=1" name="viewport">
  <meta name="theme-color" content="#1b55e2">
  <link href="<?= $site->favicon ?? "/Public/favicon.png" ?>" rel="shortcut icon">
  <link href="/Public/apple-touch-icon.png" rel="apple-touch-icon">
  <!-- bootstrap css -->
  <link rel="stylesheet" href="/Public/assets/css/bootstrap.min.css" type="text/css" media="all" />
  <!-- animate css -->
  <link rel="stylesheet" href="/Public/assets/css/animate.min.css" type="text/css" media="all" />
  <!-- owl carousel css -->
  <link rel="stylesheet" href="/Public/assets/css/owl.carousel.min.css"  type="text/css" media="all" />
  <link rel="stylesheet" href="/Public/assets/css/owl.theme.default.min.css"  type="text/css" media="all" />
  <!-- meanmenu css -->
  <link rel="stylesheet" href="/Public/assets/css/meanmenu.min.css" type="text/css" media="all" />
  <!-- magnific popup css -->
  <link rel="stylesheet" href="/Public/assets/css/magnific-popup.min.css" type="text/css" media="all" />
  <!-- boxicons css -->
  <link rel='stylesheet' href='/Public/assets/css/boxicons.min.css' type="text/css" media="all" />
  <!-- Line Awesome CSS -->
  <link rel='stylesheet' href='/Public/assets/css/line-awesome.min.css' type="text/css" media="all" />
  <!-- flaticon css -->
  <link rel='stylesheet' href='/Public/assets/css/flaticon.css' type="text/css" media="all" />
  <!-- style css -->
  <link rel="stylesheet" href="/Public/assets/css/style.css" type="text/css" media="all" />
  <!-- responsive css -->
  <link rel="stylesheet" href="/Public/assets/css/responsive.css" type="text/css" media="all" />
  <!--[if IE]>
      <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
</head>
<?php
}
