<?php
function __group_modal(){
    $groupTitle = [
        'General', 'Design', 'Display', 'Storage', 'Camera', 'Battery', 'Network Connectivity',
        'Multimedia', 'Special Features', 'Connectivityports', 'Power Supply', 'Physical Design',
        'Video', 'Audio', 'Remote', 'Smart Tv Features', 'Previewing', 'Lens', 'Other Features', 'Connectivity', 'Compatibility', 'Additional Features', 'Notifications', 'Sensors', 'Activity Tracker', 'Networking', 'Key Specs'
    ];
    ?>
        <div class="modal fade" id="groupModal" tabindex="-1" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <!-- <div class="modal-header">
                        <h5 class="modal-title">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div> -->
                    <div class="modal-body">
                        <select name="" id="groupTitleSelect" class="groupTitleSelect form-control">
                            <?php foreach ($groupTitle as $group): ?>
                                <option name="<?= strtolower($group) ?>" id=""><?= $group ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    <?php
}
function __key_modal(){
    $keyTitle = [
        'General', 'Design', 'Display', 'Storage', 'Camera', 'Battery', 'Network Connectivity',
        'Multimedia', 'Special Features', 'Connectivityports', 'Power Supply', 'Physical Design',
        'Video', 'Audio', 'Remote', 'Smart Tv Features', 'Previewing', 'Lens', 'Other Features', 'Connectivity', 'Compatibility', 'Additional Features', 'Notifications', 'Sensors', 'Activity Tracker', 'Networking', 'Key Specs'
    ];
    ?>
        <div class="modal fade" id="keyModal" tabindex="-1" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <!-- <div class="modal-header">
                        <h5 class="modal-title">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div> -->
                    <div class="modal-body">
                        <select name="" id="keyTitleModal" class="keyTitleModal form-control">
                            <?php foreach ($keyTitle as $value): ?>
                                <option name="<?= strtolower($value) ?>" id=""><?= $value ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    <?php
}