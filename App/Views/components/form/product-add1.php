<?php

use App\Models\Product;

function __product_add_form_right($product = null, $is_edit = false)
{
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
    <div class="col-12 col-lg-4">
        <div class="card shadow-none bg-light border">
            <div class="card-body">
                <div class="row g-3">
                    <h3>Product</h3>
                    <div class="col-12">
                        <label class="form-label">Name</label>
                        <input type="text" value="<?= $product->product_name ?? '' ?>" name="name" class="form-control" placeholder="Name" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Price</label>
                        <input type="number" value="<?= $product->product_price ?? '' ?>" name="price" class="form-control" placeholder="Price" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Quantity</label>
                        <input type="number" value="<?= $product->product_quantity ?? '' ?>" name="quantity" class="form-control" placeholder="quantity">
                    </div>
                    <div class="col-6">
                        <label class="form-label">Featured</label>
                        <input type="checkbox" <?php if(isset($product->featured) && $product->featured == 'on') echo 'checked' ?> name="featured">
                    </div>
                    <div class="col-6">
                        <label class="form-label">In stock</label>
                        <input type="checkbox" <?php if(isset($product->in_stock) && $product->in_stock == 1) echo 'checked' ?> name="instock">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Category</label>
                        <select class="form-select" id="__product_category" required>
                            <option value="">Select</option>
                            <?php foreach(Product::categories() as $val): ?>
                                <option value="<?= $val->category_slug ?? '' ?>" <?php if(isset($product->product_category) && $val->category_slug == $product->product_category ?? '') echo 'selected'  ?? 'selected' ?>><?= $val->category_name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Sub Category</label>
                        <select class="form-select" name="category" id="__product_category_child" required>
                            <option value="">Select</option>
                          </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Featured Image</label>
                        <div class="feartured-image-wrapper" data-bs-toggle="modal" data-bs-target="#exampleFullScreenModal">
                            <img src="<?= $product->product_image ?? '' ?>" alt="" id="__image" class="<?= $is_edit ? '' : 'd-none' ?> featured-image-img">
                            <input type="hidden" value="<?= $product->product_image ?? '' ?>" name="image" id="__image" required>
                        </div>
                    </div>

                    <div>
                        <label class="form-label">Summary</label>
                        <textarea class="form-control" id="" name="summary" placeholder="Summary" rows="4" cols="4" required><?= $product->product_summary ?? ' ' ?></textarea>
                    </div>

                    <h3>Warranty</h3>
                    <div class="col-12">
                        <label class="form-label">Warranty</label>
                        <input type="text" name="warranty" class="form-control" placeholder="Warranty">
                    </div>

                </div>
                <!--end row-->
            </div>
        </div>
    </div>
<?php
}
