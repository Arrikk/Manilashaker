<?php
function __product_add_form_left($product = null, $edit = false)
{
?>
    <style>
        .form-title {
            border: none;
            font-size: x-large;
            color: #4c5258;
        }

        .form-key-title {
            border: none;
            font-weight: 400;
            color: #4c5258;
        }

        .btn-grey {
            color: #fff;
            background-color: #e0e0e0;
            border-color: #e0e0e0;
        }
    </style>
    <div class="col-12 col-lg-8">
        <div class="card shadow-none bg-light border">
            <div class="card-body">
                <div class="row g-3">

                    <div class="row col-12 mt-2 append-group">
                        <h4>Add Product Specification</h4>
                        <div class="row col-12 mt-3">
                            <div class="col-12">
                                <a class="btn btn-primary add-group">+Add New Group</a>
                            </div>

                            <!-- if updating specification -->
                            <?php
                            if ($edit) {
                                if ($product->specification !== '' && !$product->specification == null) {
                                    $nameAttr = 'product_specification';
                                    $i= 0;
                                    foreach ($product->specification as $key => $specification) :
                                        $i++;
                                        $title = rtrim(str_replace('_', ' ', $key));
                                        $name = str_replace(' ', '_', $title);
                            ?>
                                        <div class="row col-12 mt-4 append-group" id="group-<?= $product->product_id.$i ?>">
                                            <input class="form-control form-title" placeholder="Title" type="text" value="<?= $title ?>" name="<?= $nameAttr ?>[<?= $name ?>]" />
                                            <a href="javascript:;" class="openGroupModal"><i class="bi bi-arrow-up-right-square"></i></a>
                                            <div class="row col-12 col-lg-12 mt-3">
                                                <?php
                                                if (!$specification == '' && !$specification == null) {
                                                    foreach ($specification as $key => $val) :

                                                        $KeyTitle = rtrim(str_replace('_', ' ', $key));

                                                        if ($key == '0') continue;
                                                ?>
                                                        <div class="col-12 col-lg-4 col-md-4 mt-3">
                                                            <!-- <label class="mb-2"> -->
                                                                <input class="form-control form-key-title mb-2" placeholder="key" type="text" value="<?= $KeyTitle ?>" name="<?= $nameAttr.'['. $name .']['.$KeyTitle.']' ?>" />
                                                                <a href="javascript:;" class="openKeyModal"><i class="bi bi-arrow-up-right-square"></i></a>
                                                            <!-- </label> -->
                                                            <input class="form-control form-val-title" placeholder="value" type="text" value="<?= $val ?>" name="<?= $nameAttr.'['. $name .']['.$KeyTitle.']val' ?>" />
                                                        </div>
                                                <?php
                                                    endforeach;
                                                }
                                                ?>
                                                <div class="col-12 col-lg-3 mt-3">
                                                    <a class="btn btn-primary add-group">+Group</a>
                                                </div>
                                                <div class="col-12 col-lg-3 mt-3">
                                                    <a class="btn btn-warning add-item">+item</a>
                                                </div>
                                                <div class="col-12 col-lg-3 mt-3">
                                                    <a class="btn btn-danger remove-item" id=<?= $product->product_id.$i ?>>xGroup</a>
                                                </div>
                                            </div>
                                        </div>
                            <?php
                                    endforeach;
                                }
                            }
                            ?>
                            <!-- If updating specification -->
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Full description</label>
                        <textarea class="form-control" id="ckeditor2" name="description" placeholder="Full description" rows="4" cols="4">
                            <?= $product->product_description ?? '' ?>
                        </textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- < ?php __product_add_script() ?> -->
<?php
}
