<?php

use App\Models\Product;

function __product_add_form_right_deprecated($product = null, $is_edit = false)
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
                        <input type="text" value="<?= $product->product_name ?? '' ?>" name="name" class="form-control" placeholder="Name">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Price</label>
                        <input type="number" value="<?= $product->product_price ?? '' ?>" name="price" class="form-control" placeholder="Price">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Quantity</label>
                        <input type="number" value="<?= $product->product_quantity ?? '' ?>" name="quantity" class="form-control" placeholder="quantity">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Featured</label>
                        <input type="checkbox" <?php if(isset($product->featured) && $product->featured == 'on') echo 'checked' ?> name="featured">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Category</label>
                        <select class="form-select" name="category">
                            <option value="">Select</option>
                            <?php foreach(Product::categories() as $val): ?>
                                <option value="<?= $val->category_slug ?>" <?php if($val->category_slug == $product->product_category) echo 'selected'  ?? 'selected' ?>><?= $val->category_name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Featured Image</label>
                        <div class="feartured-image-wrapper" data-bs-toggle="modal" data-bs-target="#exampleFullScreenModal">
                            <img src="<?= $product->product_image ?? '' ?>" alt="" id="__image" class="<?= $is_edit ? '' : 'd-none' ?> featured-image-img">
                            <input type="hidden" value="<?= $product->product_image ?? '' ?>" name="image" id="__image">
                        </div>
                    </div>

                    <h3>Battery</h3>
                    <div class="col-12 col-lg-6">
                        <label class="form-label">Capacity</label>
                        <input type="text" value="<?= $product->battery->battery_capacity ?? '' ?>" name="battery_capacity" class="form-control" placeholder="Capacity">
                    </div>
                    <div class="col-12 col-lg-6">
                        <label class="form-label">Type</label>
                        <input type="text" value="<?= $product->battery->battery_type ?? '' ?>" name="battery_type" class="form-control" placeholder="Type">
                    </div>
                    <div class="col-12 col-lg-6">
                        <label class="form-label">Talk Time</label>
                        <input type="text" value="<?= $product->battery->battery_talk_time ?? '' ?>" name="battery_talk_time" class="form-control" placeholder="Talk Time">
                    </div>
                    <div class="col-12 col-lg-6">
                        <label class="form-label">Standby Time</label>
                        <input type="text" value="<?= $product->battery->battery_standby_time ?? '' ?>" name="battery_standby_time" class="form-control" placeholder="Standby Time">
                    </div>
                    <div class="col-12 col-lg-6">
                        <label class="form-label">Quick Charging</label>
                        <input type="text" value="<?= $product->battery->battery_quick_charging ?? '' ?>" name="battery_quick_charging" class="form-control" placeholder="Quick Charging">
                    </div>
                    <div class="col-12 col-lg-6"></div>
                    <div class="col-12 col-lg-6">
                        <label class="form-label">User Replacable</label>
                        <input type="checkbox" <?php if(isset($product->battery->battery_user_replacable) && $product->battery->battery_user_replacable == 'Yes') echo 'checked' ?>" name="battery_user_replacable">
                    </div>
                    <div class="col-12 col-lg-6">
                        <label class="form-label">Usb Typec</label>
                        <input type="checkbox" <?php if(isset($product->battery->battery_usb_typec) && $product->battery->battery_usb_typec == 'Yes') echo 'checked' ?>" name="battery_usb_typec">
                    </div>
                    <h3>Storage</h3>
                    <div class="col-12">
                        <label class="form-label">Internal Memory</label>
                        <input value="<?= $product->storage->storage_internal_memory ?? '' ?>" type="text" name="storage_internal_memory" class="form-control" placeholder="Internal Memory">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Expandable Memory</label>
                        <input value="<?= $product->storage->storage_expandable_memory ?? '' ?>" type="text" name="storage_expandable_memory" class="form-control" placeholder="Expandable Memory">
                    </div>
                    <h3>Multimedia</h3>
                    <div class="col-12">
                        <label class="form-label">Loudspeaker</label>
                        <input value="<?= $product->multimedia->multimedia_loudspeaker ?? '' ?>" <?php if($product->multimedia->multimedia_loudspeaker == 'Yes') echo 'checked' ?> type="checkbox" name="multimedia_loudspeaker">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Audio Jack</label>
                        <input value="<?= $product->multimedia->multimedia_audio_jack ?? '' ?>" type="text" name="multimedia_audio_jack" class="form-control" placeholder="Audio Jack">
                    </div>

                    <h3>Special Features</h3>
                    <div class="col-12">
                        <label class="form-label">Fingerprint Sensor Position</label>
                        <input value="<?= $product->special_features->special_sp_fingerprint_sensor_position ?? '' ?>" type="text" name="special_sp_fingerprint_sensor_position" class="form-control" placeholder="Fingerprint Sensor Position">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Other Sensor</label>
                        <input value="<?= $product->special_features->special_other_sensor ?? '' ?>" type="text" name="special_other_sensor" class="form-control" placeholder="Other Sensor">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Fingerprint Sensor</label>
                        <input value="<?= $product->special_features->special_fingerprint_sensor ?? '' ?>" <?php if(isset( $product->special_features->special_fingerprint_sensor) &&  $product->special_features->special_fingerprint_sensor == 'Yes') echo 'checked' ?> type="checkbox" name="special_fingerprint_sensor">
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
