<?php
function __upload_gallery_image(){
?>
    <div class="tab-pane fade" id="uploadgalleryimage" role="tabpanel">
        <form action="/site/gallery/add-gallery" id="upload-gallery-form" method="POST" enctype="multipart/form-data">
            <input type="file" name="image[]" id="gallery-upload" class="form-control" multiple>
            <input type="submit" value="Upload" class="btn btn-primary">
        </form>
    </div>
<?php
}