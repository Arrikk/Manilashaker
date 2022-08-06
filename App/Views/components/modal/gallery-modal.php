<?php
function __gallery_modal(){
    ?>
    <style>
        .modal{
            z-index: 12000 !important
        }
    </style>
        <div class="modal fade" id="exampleFullScreenModal" tabindex="-1" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <!-- <div class="modal-header">
                        <h5 class="modal-title">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div> -->
                    <div class="modal-body">
                        <?php __open_gallery() ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    <?php
}