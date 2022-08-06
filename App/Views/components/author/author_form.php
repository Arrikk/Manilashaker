<?php

use App\Models\Admin;
use App\Models\Product;

function __author_member_form()
{
    $edit = $GLOBALS['is_author'];
    $types = [
        'Master' => Admin::MASTER,
        'Writer' => Admin::WRITER
    ]
?>
    <div class="col-12 col-lg-4 d-flex">
        <div class="card border shadow-none w-100">
            <div class="card-body">
                <form class="row g-3" method="POST">
                    <div class="col-12">
                        <label class="form-label">Name</label>
                        <input value="<?= $edit->firstName ?? '' ?>" type="text" class="form-control" name="name" placeholder="John Doe">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Email</label>
                        <input value="<?= $edit->email ?? '' ?>" type="email" class="form-control" name="email" placeholder="JohnDoe@gmail.com">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Role</label>
                        <select class="form-select" name="role">
                            <option value="">Select</option>

                            <?php foreach($types as $key => $type): ?>
                                <option <?php if(isset($edit->type) && $edit->type == $type) echo 'selected' ?> value="<?= $type ?>"><?= $key ?></option>
                            <?php endforeach; ?>

                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" placeholder="About Author"><?= $edit->desc ?? '' ?></textarea>
                    </div>
                    <div class="col-12">
                        <div class="d-grid">
                            <input type="hidden" name="type" value="<?= $edit ? 'edit' : 'save' ?>">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
}
