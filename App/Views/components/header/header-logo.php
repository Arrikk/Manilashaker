<?php
function __header_logo(){
    extract($GLOBALS['site'])
    ?>
    <!-- ============================================================= Header Logo ============================================================= -->
        <div class="header-logo">
            <a href="/" class="header-logo-link">
                <img style="width:100px" src="<?=
               $__site ?? $__site->site_logo !== '' ||  $__site->site_logo !== NULL 
                ? $__site->site_logo :  '/Public/assets/images/fav-icon.png'
            ?>" alt="" srcset="">               
            </a>
        </div>
<!-- ============================================================= Header Logo : End============================================================= -->

    <?php
}