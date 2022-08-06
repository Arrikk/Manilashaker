<?php

use App\Models\Blog;

function __new_post()
{
    $status = [
        'draft' => Blog::DRAFT,
        'publish' => Blog::PUBLISHED
    ];
    $editing = $GLOBALS['post_edit'] ?? '';
?>
    <div class="row">
        <div class="col-lg-12 mx-auto">
            <div class="card">
                <div class="card-header py-3">
                    <div class="row align-items-center m-0">
                        <div class="col-md-3 col-12 me-auto mb-md-0 mb-3">
                            <label for="">URL</label>
                            <input type="text" name="_slug" id="" placeholder="Url" class="form-control __permalink_edit" value="<?= $editing->post_slug ?? '' ?>">
                        </div>
                        <div class="col-md-5 col-12">
                            <label for="">Permalink</label>
                            <span>
                                <p class="text-primary"><strong><?= URL ?>news/</strong><strong class="__permalink_view"><?= $editing->post_slug ?? '' ?></strong></p>
                            </span>
                        </div>
                        <div class="col-md-2 col-6">
                            <select name="status" id="" class="form-select">
                                <?php foreach ($status as $key => $name) : ?>
                                    <option <?php if ($editing && $editing->post_status == $name)  echo 'selected' ?> value="<?= $name ?>"><?= ucfirst($key) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2 col-6">
                            <button type="submit" id="__new_post" class="btn btn-primary"><?= $editing ? 'Save' : 'Save' ?></button>
                            <input type="hidden" id="hidden_type" name="type" value="<?= $editing ? 'edit' : 'save' ?>">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <?php __form_post_left() ?>
                        <?php __form_post_right() ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--end row-->
<?php
}
