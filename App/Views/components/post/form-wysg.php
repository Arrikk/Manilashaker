<?php
function __form_post_left(){
    $post = $GLOBALS['post_edit'] ?? '';
    ?>
        <div class="col-12 col-lg-8">
            <div class="card shadow-none bg-light border">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label" for="">Meta Description</label>
                            <textarea name="meta_description" id="" class="form-control"><?= $post->post_description ?? '' ?> </textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="">Post Body</label>
                            <textarea id="ckeditor1" name="post" style="width:100%;">
                            <?= html_entity_decode($post->post_body ?? '') ?>
                        </textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
}