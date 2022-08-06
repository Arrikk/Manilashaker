<?php
function __open_gallery(){
?>
<div class="card">
    <div class="card-body">
        <ul class="nav nav-tabs nav-primary" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" data-bs-toggle="tab" href="#choosegalleryimage" role="tab" aria-selected="false">
                    <div class="d-flex align-items-center">
                        <div class="tab-icon"><i class="bx bx-user-pin font-18 me-1"></i>
                        </div>
                        <div class="tab-title">Gallery</div>
                    </div>
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" data-bs-toggle="tab" href="#uploadgalleryimage" role="tab" aria-selected="true">
                    <div class="d-flex align-items-center">
                        <div class="tab-icon"><i class="bx bx-home font-18 me-1"></i>
                        </div>
                        <div class="tab-title">Upload</div>
                    </div>
                </a>
            </li>
        </ul>
        <div class="tab-content py-3">
            <?php __choose_gallery_image() ?>
            <?php __upload_gallery_image() ?>
        </div>
    </div>
</div>
<?php
}