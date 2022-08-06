<?php

use App\Models\Blog;

function __form_post_right()
{
    extract($GLOBALS['blog']);
    $editing = $GLOBALS['post_edit'] ?? '';
    $d_none = '';
    if ($editing)
        $d_none = '';
    else
        $d_none = 'd-none';
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

    <?php
    $current_cat = (Blog::postCategory($editing->category_id ?? '')) ?? [];
    $initial = $__blog_category;
    $filtered = [];
    foreach ($initial as $key => $value) {
        $filtered[$value->category_id] = [
            'category_id' => $value->category_id,
            'category_name' => $value->category_name,
            'selected' => ''
        ];
    }
    foreach ($current_cat as $key => $value) {
        $filtered[$value->category_id] = [
            'category_id' => $value->category_id,
            'category_name' => $value->category_name,
            'selected' => 'selected'
        ];
    }
    ?>
    <div class="col-12 col-lg-4">
        <div class="card shadow-none bg-light border">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Title</label>
                        <input type="hidden" id="__edit_id" name="edit" value="<?= $editing->post_id ?? 'draft'  ?>">
                        <input type="text" id="__title" name="title" value="<?= $editing->post_title ?? '' ?>" class="form-control" placeholder="Title">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Featured Image</label>
                        <div class="feartured-image-wrapper" data-bs-toggle="modal" data-bs-target="#exampleFullScreenModal">
                            <!-- <span class="choose-featured <?= $d_none ?? '' ?>">Tap to Choose</span> -->
                            <img src="<?= $editing->post_image ?? '' ?>" alt="" id="__image" class="<?= $d_none ?? '' ?> featured-image-img">
                            <input type="hidden" value="<?= $editing->post_image ?? '' ?>" name="image" id="__image">
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Category <a href="javascript:;" class="_add_category_toggle"> <u>+Add new category</u> </a></label>
                        <!-- <input type="text" name="__new_category" placeholder="Category" class="form-control"> -->
                        <select class="multiple-select" id="__category" name="category[]" data-placeholder="Choose anything" multiple="multiple">
                            <?php $i = 0;
                            foreach ($filtered as $cat) : ?>
                                <option <?= $cat['selected'] ?> value="<?= $cat['category_id'] ?>"><?= $cat['category_name'] ?></option>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Tags</label>
                        <input name="tag" type="text" value="<?= str_replace('-',' ',ucfirst($editing->post_tag ?? '')) ?>" class="form-control" id="__tag" placeholder="Tags">
                        <p>Seperate tags with comma</p>
                    </div>

                </div>
                <!--end row-->
            </div>
        </div>
    </div>
<?php
}
