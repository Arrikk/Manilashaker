<?php

function __post_categories()
{
?>
    <div class="row">
        <div class="col-lg-12 mx-auto">
            <div class="card">
                <div class="card-body">
                    <div class="row g-3">
                        <?php __category_table() ?>
                        <?php __form_category() ?>
                    </div>
                </div>
                <!--end row-->
            </div>
        </div>
    </div>
<?php
}
