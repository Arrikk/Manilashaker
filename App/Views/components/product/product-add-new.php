<?php
function __product_add_new($product = null, $is_edit = false)
{
?>
  <div class="row">
    <div class="col-lg-12 mx-auto">
      <div class="card">
        <div class="card-header py-3 bg-transparent">
          <div class="d-sm-flex align-items-center">
            <h5 class="mb-2 mb-sm-0"><?= $is_edit ? 'Modify product' : 'Add New Product' ?></h5>
            <div class="ms-auto">
              <button type="submit" class="btn btn-primary"><?= $is_edit ? 'Update Product' : 'Publish Now' ?></button>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="row g-3">
            <?php __product_add_form_right($product, $is_edit) ?>
            <?php __product_add_form_left($product, $is_edit) ?>
          </div>
          <!--end row-->
        </div>
      </div>
      <div class="card-header py-3 bg-transparent">
        <div class="d-sm-flex align-items-center">
          <div class="ms-auto">
            <button type="submit" class="btn btn-primary"><?= $is_edit ? 'Update Product' : 'Publish Now' ?></button>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php
}
?>