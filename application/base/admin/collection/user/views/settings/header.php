<div class="user-settings">
    <div class="row">
        <div class="col-lg-2 col-lg-offset-1">
            <div class="row">
                <div class="col-lg-12">
                    <?php md_include_component_file(MIDRUB_BASE_ADMIN_USER . '/views/settings/menu.php'); ?>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="row">
                <div class="col-lg-12 settings-area">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fab fa-css3"></i>
                            <?php echo $this->lang->line('user_settings_header_code'); ?>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="input-option">
                                        <textarea placeholder="<?php echo $this->lang->line('user_enter_code_used_header'); ?>" class="form-control settings-textarea-value" data-option="user_header_code"><?php echo get_option('user_header_code'); ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo form_open('admin/user', array('class' => 'save-settings', 'data-csrf' => $this->security->get_csrf_token_name())) ?>
<?php echo form_close() ?>

<div class="settings-save-changes">
    <div class="col-xs-6">
        <p><?php echo $this->lang->line('user_settings_you_have_unsaved_changes'); ?></p>
    </div>
    <div class="col-xs-6 text-right">
        <button type="button" class="btn btn-default">
            <i class="far fa-save"></i>
            <?php echo $this->lang->line('user_settings_save_changes'); ?>
        </button>
    </div>
</div>