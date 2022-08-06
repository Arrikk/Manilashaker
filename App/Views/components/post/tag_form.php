<?php

use App\Models\Blog;

function __form_tag(){
    $edit = $GLOBALS['blog']['__edit_tag'];
    ?>
        <div class="col-12 col-lg-4">
            <div class="card shadow-none bg-light border">
                <div class="card-body">
                    <div class="row g-3">
                        <form action="" method="POST" >
                        <input type="hidden" name="__type" value="<?php if(isset($edit->slug)) echo 'update'; else echo'save' ?>">
                        <input type="hidden" name="__slug" value="<?= $edit->slug ?? '' ?>">
                            <div class="col-12">
                                <label class="form-label">Name</label>
                                <input value="<?= $edit->name ?? '' ?>" type="text" name="__name"class="form-control" placeholder="Name">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Slug</label>
                                <input value="<?= $edit->slug ?? '' ?>" type="text" name="_slug"class="form-control" placeholder="Slug">
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary save-category" >Save</button>
                            </div>

                        </form>

                    </div><!--end row-->
                </div>
            </div>  
        </div>
    <?php
}

?>