<?php
use App\Models\Product;

function __product_category_form()
{
    $edit = $GLOBALS['edit_product_cat'];
?>
    <style>
        .feartured-image-wrapper {
            background: #eee;
            height: 200px;
            width: 100%;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer
        }

        .feartured-image-wrapper img {
            height: 100%;
            width: 100%;
            object-fit: contain;
        }

        .d-none {
            display: none;
        }
    </style>
    <div class="col-12 col-lg-4 d-flex">
        <div class="card border shadow-none w-100">
            <div class="card-body">
                <form class="row g-3" method="POST">
                    <div class="col-12">
                        <label class="form-label">Name</label>
                        <input value="<?= $edit->category_name ?? '' ?>" type="text" class="form-control" name="name" placeholder="Category name">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Parent</label>
                        <select class="form-select" name="parent">
                            <option value="0">None</option>
                            <?php foreach (Product::categories() as $cat) : ?>
                                <option <?php if(isset($edit->category_parent) && $edit->category_parent == $cat->category_id ) echo 'selected' ?> value="<?= $cat->category_id ?>"><?= $cat->category_name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Featured Image</label>
                        <div class="feartured-image-wrapper" data-bs-toggle="modal" data-bs-target="#exampleFullScreenModal">
                            <img src="<?= $edit->category_image ?? '' ?>" alt="" id="__image" class="<?= isset($edit->category_image) ? '' : 'd-none' ?> featured-image-img">
                            <input type="hidden" value="<?= $edit->category_image ?? '' ?>" name="image" id="__image">
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" placeholder="Product Description">
                        <?= $edit->category_desc ?? '' ?>
                        </textarea>
                    </div>
                    <div class="col-12">
                        <div class="d-grid">
                            <input type="hidden" name="type" value="<?php if(isset($edit->category_name)) echo 'update'; else echo'save' ?>">
                            <input type="hidden" name="category" value="<?= $edit->category_id ?? '' ?>">
                            <button type="submit" class="btn btn-primary">
                            <?php if(isset($edit->category_name)) echo 'Update Category'; else echo 'Add Category' ?>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
}
function __product_description_form()
{
    $edit = $GLOBALS['edit_product_category_desc'];
?>
    <div class="col-12 col-lg-8 d-flex">
        <div class="card border shadow-none w-100">
            <div class="card-body">
                <form class="row g-3" method="POST" >
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea style="min-height: 500px;" <?= !$edit ? 'disabled' : '' ?> class="form-control" id="ckeditor2" name="description" placeholder="Compare Description">
                        <?= $edit->note ?? '' ?>
                        </textarea>
                    </div>
                    <div class="col-12">
                        <div class="d-grid">
                            <input type="hidden" name="type" value="<?php if(isset($edit->category_id)) echo 'update'; else echo'save' ?>">
                            <input type="hidden" name="category" value="<?= $edit->category_id ?? '' ?>">
                            <button type="submit" class="btn btn-primary" <?= !$edit ? 'disabled' : '' ?>  > Update Description
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
}
