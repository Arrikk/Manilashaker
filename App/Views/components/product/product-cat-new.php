<?php 
    function __product_category_new(){
        ?>
            <div class="row">
                <div class="col-lg-12 mx-auto">
                <div class="card">
                <div class="card-header py-3">
                  <h6 class="mb-0">Add Product Category</h6>
                </div>
                <div class="card-body">
                   <div class="row">
                       <?php __product_category_form() ?>
                       <?php __product_category_table() ?>
                   </div><!--end row-->
                </div>
              </div>
                </div>
            </div>
        <?php
    }

    function __product_category_desc(){
        ?>
            <div class="row">
                <div class="col-lg-12 mx-auto">
                <div class="card">
                <div class="card-header py-3">
                  <h6 class="mb-0">Compare Description</h6>
                </div>
                <div class="card-body">
                   <div class="row">
                       <?php __product_description_form() ?>
                    <?php __product_description_table() ?>
                   </div><!--end row-->
                </div>
              </div>
                </div>
            </div>
        <?php
    }
?>