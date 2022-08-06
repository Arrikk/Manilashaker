<?php
function __shop_home_banner($image = '/Public/assets/images/bg/08.jpg', $image2 = '/Public/assets/images/bg/09.jpg')
{
?>

    <div class="home-v1-banner-block animate-in-view fadeIn animated" data-animation="fadeIn">

        <div class="row">
            <div class="col-lg-6">
                <div class="home-v1-fullbanner-ad fullbanner-ad" style="margin-bottom: 70px">

                    <a href="#">
                        <img src="/Public/assets/images/blank.gif" data-echo="<?= $image ?>" class="img-responsive" alt="">

                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="home-v1-fullbanner-ad fullbanner-ad" style="margin-bottom: 70px">

                    <a href="#">
                        <img src="/Public/assets/images/blank.gif" data-echo="<?= $image2 ?>" class="img-responsive" alt="">

                    </a>
                </div>
            </div>
        </div>
    </div><!-- /.home-v1-banner-block -->



<?php
}
