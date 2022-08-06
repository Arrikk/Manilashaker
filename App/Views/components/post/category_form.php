<?php

use App\Models\Blog;

function __form_category(){
    $edit = $GLOBALS['blog']['__edit_category'];
    ?>
        <div class="col-12 col-lg-4">
            <div class="card shadow-none bg-light border">
                <div class="card-body">
                    <div class="row g-3">
                        <form action="" method="POST" name="_category_form">
                        <input type="hidden" name="__type" value="<?php if(isset($edit->category_name)) echo 'update'; else echo'save' ?>">
                        <input type="hidden" name="__category" value="<?= $edit->category_id ?? '' ?>">
                            <div class="col-12">
                                <label class="form-label">Name</label>
                                <input value="<?= $edit->category_name ?? '' ?>" type="text" name="__name"class="form-control" placeholder="Name">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Parent Category</label>
                                <select name="__parent" class="form-control" id="">
                                    <option value="0">None</option>
                                    <?php foreach(Blog::categories() as $cat): ?>
                                        <option <?php if(isset($edit->parent_category) && $edit->parent_category == $cat->category_id) echo 'selected' ?>  value="<?= $cat->category_id ?>"><?= $cat->category_name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <input value="<?= $edit->category_description ?? '' ?>" type="text" name="__description"class="form-control" placeholder="Description">
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