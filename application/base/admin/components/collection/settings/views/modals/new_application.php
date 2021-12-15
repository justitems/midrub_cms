<!-- Modal -->
<div class="modal fade theme-modal" id="settings-new-application" tabindex="-1" role="dialog" aria-labelledby="settings-new-application">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?php echo form_open('admin/settings?q=api-apps', array('class' => 'settings-api-create-new-app', 'method' => 'post', 'data-csrf' => $this->security->get_csrf_token_name())); ?>
            <div class="modal-header">
                <h5 class="modal-title theme-color-black">
                    <?php echo $this->lang->line('api_new_app'); ?>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label class="theme-label" for="settings-api-application-name">
                        <?php echo $this->lang->line('settings_app_name'); ?>
                    </label>
                    <input type="text" class="form-control theme-text-input-1 settings-application-name" id="settings-api-application-name" placeholder="<?php echo $this->lang->line('settings_api_enter_app_name'); ?>" required>
                </div>
                <div class="form-group mb-3">
                    <label class="theme-label" for="settings-api-application-redirect">
                        <?php echo $this->lang->line('settings_api_app_redirect'); ?>
                    </label>
                    <input type="text" class="form-control theme-text-input-1 settings-application-redirect" id="settings-api-application-redirect" placeholder="<?php echo $this->lang->line('settings_api_enter_redirect_url'); ?>">
                    <small class="form-text text-muted theme-small"><?php echo $this->lang->line('settings_api_app_redirect_description'); ?></small>
                </div>
                <div class="form-group mb-3">
                    <label class="theme-label" for="settings-api-application-redirect-cancel">
                        <?php echo $this->lang->line('settings_application_app_cancel_redirect'); ?>
                    </label>
                    <input type="text" class="form-control theme-text-input-1 settings-application-redirect-cancel" id="settings-api-application-redirect-cancel" placeholder="<?php echo $this->lang->line('settings_api_enter_redirect_url'); ?>">
                    <small class="form-text text-muted theme-small"><?php echo $this->lang->line('settings_application_app_cancel_redirect_description'); ?></small>
                </div>
                <div class="form-group">
                    <label class="theme-label">
                        <?php echo $this->lang->line('api_application_permissions'); ?>
                    </label>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <ul class="settings-application-list-permissions">
                            <?php

                            // Get the permissions
                            $the_permissions = the_settings_list_permissions();

                            // Verify if permissions exists
                            if ( $the_permissions ) {

                                // List the permissions
                                foreach ( $the_permissions as $the_permission ) {

                                    // Display permission
                                    echo '<li>'
                                        . '<button class="btn btn-default settings-select-app-permission theme-button-2" type="button" data-permission="' . $the_permission['permission_slug'] . '">'
                                            . $the_permission['permission_name']
                                        . '</button>'
                                    . '</li>';

                                }

                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">
                    <?php echo $this->lang->line('settings_cancel'); ?>
                </button>
                <button type="submit" class="btn btn-primary">
                    <?php echo $this->lang->line('settings_create'); ?>
                </button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>