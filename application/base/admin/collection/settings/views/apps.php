<section>
    <div class="container-fluid settings">
        <div class="row">
            <div class="col-lg-2 col-lg-offset-1">
                <div class="row">
                    <div class="col-lg-12">
                        <?php md_include_component_file(MIDRUB_BASE_ADMIN_SETTINGS . 'views/menu.php'); ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-12 settings-area">
                        <div class="panel panel-default" id="api-applications">
                            <div class="panel-heading">
                                <i class="fab fa-microsoft"></i>
                                <?php echo $this->lang->line('apps'); ?>
                                <a href="#" data-toggle="modal" data-target="#new-application">
                                    <?php echo $this->lang->line('api_new_app'); ?>
                                </a>
                            </div>
                            <div class="panel-body">
                                <ul class="api-apps-list">
                                </ul>
                            </div>
                            <div class="panel-footer">
                                <ul class="pagination" data-type="all-applications">
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="new-application" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?php echo form_open('admin/settings?q=api-apps', array('class' => 'api-create-new-app', 'method' => 'post', 'data-csrf' => $this->security->get_csrf_token_name())); ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <?php echo $this->lang->line('api_new_app'); ?>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <input type="text" class="application_name" placeholder="<?php echo $this->lang->line('api_enter_app_name'); ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <h3>
                            <?php echo $this->lang->line('api_app_redirect'); ?>
                        </h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <input type="text" class="application_redirect_url" placeholder="<?php echo $this->lang->line('api_enter_redirect_url'); ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <h3>
                            <?php echo $this->lang->line('application_app_cancel_redirect'); ?>
                        </h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <input type="text" class="application_app_cancel_redirect" placeholder="<?php echo $this->lang->line('api_enter_redirect_url'); ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <h3>
                            <?php echo $this->lang->line('api_application_permissions'); ?>
                        </h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <ul class="application-list-permissions">
                            <?php

                            // List all permissions
                            settings_list_permissions_for_apps();

                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success"><?php echo $this->lang->line('save'); ?></button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="update-application" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?php echo form_open('admin/settings?q=api-apps', array('class' => 'api-update-app', 'method' => 'post', 'data-csrf' => $this->security->get_csrf_token_name())); ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <?php echo $this->lang->line('api_new_app'); ?>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <input type="text" class="application_name" placeholder="<?php echo $this->lang->line('api_enter_app_name'); ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <h3>
                            <?php echo $this->lang->line('api_app_redirect'); ?>
                        </h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <input type="text" class="application_redirect_url" placeholder="<?php echo $this->lang->line('api_enter_redirect_url'); ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <h3>
                            <?php echo $this->lang->line('application_app_cancel_redirect'); ?>
                        </h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <input type="text" class="application_app_cancel_redirect" placeholder="<?php echo $this->lang->line('api_enter_redirect_url'); ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <h3>
                            <?php echo $this->lang->line('api_app_id'); ?>
                        </h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <input type="text" class="application_app_id">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <h3>
                            <?php echo $this->lang->line('api_app_secret'); ?>
                        </h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <input type="text" class="application_app_secret">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <h3>
                            <?php echo $this->lang->line('api_application_permissions'); ?>
                        </h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <ul class="application-list-permissions">
                            <?php

                            // List all permissions
                            settings_list_permissions_for_apps();

                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success"><?php echo $this->lang->line('save'); ?></button>
            </div>
            <?php
            echo form_close();
            ?>
        </div>
    </div>
</div>

<?php md_include_component_file(MIDRUB_BASE_ADMIN_SETTINGS . 'views/footer.php'); ?>