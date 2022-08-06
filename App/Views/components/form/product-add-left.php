<?php
function __product_add_form_left_deprecated($product = null){
    ?>
    
    <div class="col-12 col-lg-8">
        <div class="card shadow-none bg-light border">
            <div class="card-body">
            <div class="row g-3">
                <h3>General</h3>
                <div class="col-12 col-lg-4">
                <label class="form-label">Launch Date</label>
                <input value="<?=$product->general->general_launch_date ?? '' ?>" type="date" name="general_launch_date" class="form-control" placeholder="Lauch date">
                </div>
                <div class="col-12 col-lg-4">
                <label class="form-label">Price in India</label>
                <input value="<?=$product->general->general_price_in_india ?? '' ?>" type="text"  name="general_price_in_india" class="form-control" placeholder="Price in india">
                </div>
                <div class="col-12 col-lg-4">
                <label class="form-label">Model</label>
                <input value="<?=$product->general->general_model ?? '' ?>" type="text" name="general_model" class="form-control" placeholder="Model">
                </div>
                <div class="col-12 col-lg-4">
                <label class="form-label">Operating System</label>
                <input value="<?=$product->general->general_oprtating_system ?? '' ?>" type="text" name="general_oprtating_system" class="form-control" placeholder="Operating System">
                </div>
                <div class="col-12 col-lg-4">
                <label class="form-label">Custom UI</label>
                <input value="<?=$product->general->general_custom_ui ?? '' ?>" type="text" name="general_custom_ui" class="form-control" placeholder="Custom UI">
                </div>
                <div class="col-12 col-lg-4">
                <label class="form-label">Sim slot</label>
                <input value="<?=$product->general->general_sim_slot ?? '' ?>" type="text" name="general_sim_slot" class="form-control" placeholder="Sim Slot">
                </div>
                <div class="col-12 col-lg-4">
                <label class="form-label">Sim Size</label>
                <input value="<?=$product->general->general_sim_size ?? '' ?>" type="text" name="general_sim_size" class="form-control" placeholder="Sim size">
                </div>
                <div class="col-12 col-lg-4">
                <label class="form-label">Network</label>
                <input value="<?=$product->general->general_network ?? '' ?>" type="text" name="general_network" class="form-control" placeholder="Network">
                </div>
                <div class="col-12 col-lg-4">
                </div>
                <div class="col-12 col-lg-4">
                <label class="form-label">Finger print sensor</label>
                <input <?php if($product->general->general_fingerprint_sensor == 'Yes') echo 'checked' ?> type="checkbox" name="general_fingerprint_sensor">
                </div>
                <div class="col-12 col-lg-4">
                <label class="form-label">Quick Charging</label>
                <input <?php if($product->general->general_quick_charging == 'Yes') echo 'checked' ?> type="checkbox" name="general_quick_charging" >
                </div>

                <h3>Designs</h3>
                <div class="col-12 col-lg-4">
                    <label class="form-label">Height</label>
                    <input value="<?=$product->design->design_height ?? '' ?>" type="text" name="design_height" class="form-control" placeholder="Height">
                </div>
                <div class="col-12 col-lg-4">
                    <label class="form-label">Width</label>
                    <input value="<?=$product->design->design_width ?? '' ?>" type="text" name="design_width" class="form-control" placeholder="Width">
                </div>
                <div class="col-12 col-lg-4">
                    <label class="form-label">Thickness</label>
                    <input value="<?=$product->design->design_thickness ?? '' ?>" type="text" name="design_thickness" class="form-control" placeholder="Thickness">
                </div>
                <div class="col-12 col-lg-4">
                    <label class="form-label">Weight</label>
                    <input value="<?=$product->design->design_weight ?? '' ?>" type="text" name="design_weight" class="form-control" placeholder="Weight">
                </div>
                <div class="col-12 col-lg-4">
                    <label class="form-label">Colours</label>
                    <input value="<?=$product->design->design_colours ?? '' ?>" type="text" name="design_colours" class="form-control" placeholder="Colours">
                </div>
                <div class="col-12 col-lg-4">
                    <label class="form-label">Waterproof</label>
                    <input value="<?=$product->design->design_water_proof ?? '' ?>" type="text" name="design_water_proof" class="form-control" placeholder="Waterproof">
                </div>

                <h3>Display</h3>
                <div class="col-12 col-lg-4">
                    <label class="form-label">Screen Size</label>
                    <input value="<?=$product->display->display_screen_size ?? '' ?>" type="text" name="display_screen_size" class="form-control" placeholder="Screen Size">
                </div>
                <div class="col-12 col-lg-4">
                    <label class="form-label">Screen Resolution</label>
                    <input value="<?=$product->display->display_screen_resolution ?? '' ?>" type="text" name="display_screen_resolution" class="form-control" placeholder="Screen Resolution">
                </div>
                <div class="col-12 col-lg-4">
                    <label class="form-label">Display Type</label>
                    <input value="<?=$product->display->general_launch_date ?? '' ?>" type="text" name="display_type" class="form-control" placeholder="Aspect Ratio">
                </div>
                <div class="col-12 col-lg-4">
                    <label class="form-label">Refresh Rate</label>
                    <input value="<?=$product->display->display_refresh_rate ?? '' ?>" type="text" name="display_refresh_rate" class="form-control" placeholder="Refresh Rate">
                </div>
                <div class="col-12 col-lg-4">
                    <label class="form-label">Screen Protection</label>
                    <input value="<?=$product->display->display_screen_protection ?? '' ?>" type="text" name="display_screen_protection" class="form-control" placeholder="Screen Protection">
                </div>
                <div class="col-12 col-lg-4">
                    <label class="form-label">Aspect Ratio</label>
                    <input value="<?=$product->display->display_aspect_ratio ?? '' ?>" type="text" name="display_aspect_ratio" class="form-control" placeholder="Aspect Ratio">
                </div>
                <div class="col-12 col-lg-4">
                    <label class="form-label">Bezelles Display</label>
                    <input value="<?=$product->display->bezelles_dispplay ?? '' ?>" type="text" name="bezelles_dispplay" class="form-control" placeholder="Bezelles Display">
                </div>
                <div class="col-12 col-lg-4">
                    <label class="form-label">Touch Screen</label>
                    <input value="<?=$product->display->display_touch_screen ?? '' ?>" type="text" name="display_touch_screen" class="form-control" placeholder="Touch Screen">
                </div>
                <div class="col-12 col-lg-4">
                    <label class="form-label">Screen To Body Ratio Calculated</label>
                    <input value="<?=$product->display->display_s_t_b_r_c ?? '' ?>" type="text" name="display_s_t_b_r_c" class="form-control" placeholder="Screen To Body Ratio Calculated">
                </div>

                <h3>Camera</h3>
                <div class="col-12 col-lg-4">
                    <label class="form-label">Camera Setup</label>
                    <input value="<?=$product->camera->camera_setup ?? '' ?>" type="text" name="camera_setup" class="form-control" placeholder="Camera Setup">
                </div>
                <div class="col-12 col-lg-4">
                    <label class="form-label">Resolution</label>
                    <input value="<?=$product->camera->camera_resolution ?? '' ?>" type="text" name="camera_resolution" class="form-control" placeholder="Resolution">
                </div>
                <div class="col-12 col-lg-4">
                    <label class="form-label">Auto Focus</label>
                    <input value="<?=$product->camera->camera_auto_focus ?? '' ?>" type="text" name="camera_auto_focus" class="form-control" placeholder="Auto Focus">
                </div>
                <div class="col-12 col-lg-4">
                    <label class="form-label">Physical Aperture</label>
                    <input value="<?=$product->camera->camera_physical_aperture ?? '' ?>" type="text" name="camera_physical_aperture" class="form-control" placeholder="Physical Aperture">
                </div>
                <div class="col-12 col-lg-4">
                    <label class="form-label">Flash</label>
                    <input value="<?=$product->camera->camera_flash ?? '' ?>" type="text" name="camera_flash" class="form-control" placeholder="Flash">
                </div>
                <div class="col-12 col-lg-4">
                    <label class="form-label">Image Resolution</label>
                    <input value="<?=$product->camera->camera_image_resolution ?? '' ?>" type="text" name="camera_image_resolution" class="form-control" placeholder="Image Resolution">
                </div>
                <div class="col-12 col-lg-4">
                    <label class="form-label">Sensor</label>
                    <input value="<?=$product->camera->camera_sensor ?? '' ?>" type="text" name="camera_sensor" class="form-control" placeholder="Sensor">
                </div>
                <div class="col-12 col-lg-4">
                    <label class="form-label">Settings</label>
                    <input value="<?=$product->camera->camera_settings ?? '' ?>" type="text" name="camera_settings" class="form-control" placeholder="Settings">
                </div>
                <div class="col-12 col-lg-4">
                    <label class="form-label">Shooting Modes</label>
                    <input value="<?=$product->camera->camera_shooting_modes ?? '' ?>" type="text" name="camera_shooting_modes" class="form-control" placeholder="Shooting Modes">
                </div>
                <div class="col-12 col-lg-4">
                    <label class="form-label">Camera Features</label>
                    <input value="<?=$product->camera->camera_features ?? '' ?>" type="text" name="camera_features" class="form-control" placeholder="Camera Features">
                </div>
                <div class="col-12 col-lg-4">
                    <label class="form-label">Video Recording</label>
                    <input value="<?=$product->camera->camera_video_recording ?? '' ?>" type="text" name="camera_video_recording" class="form-control" placeholder="Video Recording">
                </div>
                <div class="col-12 col-lg-4">
                    <label class="form-label">Front Camera Resolution</label>
                    <input value="<?=$product->camera->front_camera_resolution ?? '' ?>" type="text" name="front_camera_resolution" class="form-control" placeholder="Front Camera Resolution">
                </div>

                <h3>Network Connectivity</h3>
                <div class="col-12 col-lg-4">
                    <label class="form-label">Sim Size</label>
                    <input value="<?=$product->network_connectivity->network_sim_size ?? '' ?>" type="text" name="network_sim_size" class="form-control" placeholder="Sim Size">
                </div>
                <div class="col-12 col-lg-4">
                    <label class="form-label">Network Support</label>
                    <input Network Support="text" name="network_support" class="form-control" placeholder="Type">
                </div>
                <div class="col-12 col-lg-4">
                    <label class="form-label">Vollte</label>
                    <input <?php if($product->network_connectivity->network_volte) echo 'checked' ?> type="checkbox" name="network_volte" >
                </div>
                <div class="col-12 col-lg-4">
                    <label class="form-label">Sim 1</label>
                    <input value="<?=$product->network_connectivity->network_sim_1 ?? '' ?>" type="text" name="network_sim_1" class="form-control" placeholder="Sim 1">
                </div>
                <div class="col-12 col-lg-4">
                    <label class="form-label">Sim 2</label>
                    <input value="<?=$product->network_connectivity->network_sim_2 ?? '' ?>" type="text" name="network_sim_2" class="form-control" placeholder="Sim 2">
                </div>
                <div class="col-12 col-lg-4">
                    <label class="form-label">Wifi</label>
                    <input value="<?=$product->network_connectivity->network_wifi ?? '' ?>" type="text" name="network_wifi" class="form-control" placeholder="Wifi">
                </div>
                <div class="col-12 col-lg-4">
                    <label class="form-label">Wifi Features</label>
                    <input value="<?=$product->network_connectivity->network_wifi_features ?? '' ?>" type="text" name="network_wifi_features" class="form-control" placeholder="Wifi Features">
                </div>
                <div class="col-12 col-lg-4">
                    <label class="form-label">Bluetooth</label>
                    <input value="<?=$product->network_connectivity->network_bluetooth ?? '' ?>" type="text" name="network_bluetooth" class="form-control" placeholder="Bluetooth">
                </div>

                <div>
                <label class="form-label">Full description</label>
                <textarea class="form-control" id="ckeditor1" name="description" placeholder="Full description" rows="4" cols="4"></textarea>
                </div>
            </div>
            </div>
        </div>
    </div>
    <?php
}