<?php
function __script()
{
?>

    </div><!-- #page -->

    <script src="/Public/custom/jquery-2.0.2.min.js"></script>
    <script type="text/javascript" src="/Public/assets/js/tether.min.js"></script>
    <script type="text/javascript" src="/Public/assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/Public/assets/js/bootstrap-hover-dropdown.min.js"></script>
    <script type="text/javascript" src="/Public/assets/js/owl.carousel.min.js"></script>
    <script type="text/javascript" src="/Public/assets/js/echo.min.js"></script>
    <script type="text/javascript" src="/Public/assets/js/wow.min.js"></script>
    <script type="text/javascript" src="/Public/assets/js/jquery.easing.min.js"></script>
    <script type="text/javascript" src="/Public/assets/js/jquery.waypoints.min.js"></script>
    <script type="text/javascript" src="/Public/assets/js/electro.js"></script>
    <script type="text/javascript" src="/Public/custom/comment.js"></script>
    <script type="text/javascript" src="/Public/asset/plugins/select2/js/select2.min.js"></script>
    <script type="text/javascript" src="/Public/custom/cart.js?v=<?= time() ?>"></script>
    <script src="/Public/custom/auth.js"></script>
    <script>
        // $("#product-compare-select").select2()
    </script>

    </body>

    </html>

<?php
}

function __script_admin()
{
?>

    </div>
    <!--end wrapper-->


    <!-- Bootstrap bundle JS -->
    <script src="/Public/asset/js/bootstrap.bundle.min.js"></script>
    <!--plugins-->
    <script src="/Public/asset/js/jquery.min.js"></script>
    <script src="/Public/asset/plugins/simplebar/js/simplebar.min.js"></script>
    <!-- <script src="/Public/asset/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script> -->
    <script src="/Public/asset/js/pace.min.js"></script>
    <script src="/Public/asset/plugins/vectormap/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="/Public/asset/plugins/vectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- <script src="/Public/asset/plugins/apexcharts-bundle/js/apexcharts.min.js"></script> -->
    <script src="/Public/asset/plugins/select2/js/select2.min.js"></script>
    <script src="/Public/asset/js/form-select2.js"></script>
    <!--app-->
    <script src="/Public/asset/js/app.js"></script>
    <script src="/Public/asset/js/index.js"></script>
    <script src="/Public/ckeditor/ckeditor.js"></script>
    <script src="/Public/custom/settings.js?v=<?= time() ?>"></script>
    <script>
        $(document).ready(function(){
            $('#upload-gallery-form').on('submit', function(e){
                e.preventDefault()
                let btn =  $('[type="submit"]')
                btn.attr('disabled', 'disabled').val('Please Wait')
                // ths = $(this)
                $.ajax({
                    url: '/site/gallery/add-gallery',
                    method: 'POST',
                    data: new FormData(this),
                    processData: false,
                    cache: false,
                    contentType: false,
                    success: function(e){
                        btn.attr('disabled', false)
                        location.reload()
                    },
                    error: function(e){
                        btn.attr('disabled', false)
                        alert('Please select an image');
                    }
                })
            })
        })
    </script>

    <script>
        // CKEDITOR ACTIVATION FOR MAIL REPLY
        if (typeof CKEDITOR !== 'undefined') {
            CKEDITOR.disableAutoInline = true;
            if ($('#ckeditorEmail').length) {
                CKEDITOR.config.uiColor = '#ffffff';
                CKEDITOR.config.toolbar = [
                    ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', '-', 'About']
                ];
                CKEDITOR.config.height = 110;
                CKEDITOR.replace('ckeditor1');
            }
        }
        if ($('#ckeditor1').length) {
            CKEDITOR.replace('ckeditor1');
        }
        if ($('#ckeditor2').length) {
            CKEDITOR.replace('ckeditor2');
        }
    </script>

    <script>
        // new PerfectScrollbar(".best-product")
        // new PerfectScrollbar(".top-sellers-list")
    </script>


    </body>

    </html>
<?php
}
