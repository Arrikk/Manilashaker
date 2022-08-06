<?php 
    function __author_render_view(){
        ?>
            <div class="row">
                <div class="col-lg-12 mx-auto">
                <div class="card">
                <div class="card-header py-3">
                  <h6 class="mb-0">Manage Authors</h6>
                </div>
                <div class="card-body">
                   <div class="row">
                       <?php __author_member_form() ?>
                       <?php __author_members_table() ?>
                   </div><!--end row-->
                </div>
              </div>
                </div>
            </div>
        <?php
    }
?>