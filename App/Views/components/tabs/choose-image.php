<?php
function __choose_gallery_image(){
?>
<style>
    .gallery-preview-card{
        height: 200px;
    }
    .gallery-preview-img{
        width: 100%;
        height: 100%;
        object-fit: cover;
        cursor: pointer;
    }
</style>
    <div class="tab-pane fade active show" id="choosegalleryimage" role="tabpanel">
        <div class="row gallery-preview-image">
            <!-- <div class="col-12 col-lg-3">
                <div class="card gallery-preview-card">
                    <img src="/Public/assets/images/brands/5.png" alt="" class="gallery-preview-img">
                </div>
            </div> -->
        </div>
    </div>
<?php
}