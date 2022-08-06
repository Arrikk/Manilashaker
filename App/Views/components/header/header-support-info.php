<?php
function __header_support_info(){
    extract($GLOBALS['site'])
    ?>
        <div class="header-support-info">
            <div class="media">
                <span class="media-left support-icon media-middle"><i class="ec ec-support"></i></span>
                <div class="media-body">
                    <span class="support-number"><strong>Support</strong> 
                    <?=
                        $__info ?? $__info->phone1 !== '' ||  $__info->phone1 !== NULL 
                        ? $__info->phone1 :  'Phone'
					?>
                </span><br/>    
                    <!-- <span class="support-email">Email:  -->
                    <?=
                        $__info ?? $__info->email !== '' ||  $__info->email !== NULL 
                        ? $__info->email :  'Email'
					?>
                    <!-- </span> -->
                </div>
            </div>
        </div>

    <?php
}