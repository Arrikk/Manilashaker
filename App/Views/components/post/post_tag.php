<?php

function __post_tag(){
    ?>
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="card-body">
                            <div class="row g-3">
                                <?php __tag_table() ?>
                                <?php __form_tag() ?>
                            </div>

                        </div><!--end row-->
                    </div>
                </div>
            </div>
        </div>
    <?php
}