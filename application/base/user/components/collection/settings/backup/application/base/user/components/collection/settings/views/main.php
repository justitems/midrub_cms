<section class="settings-page">
    <div class="row">
        <div class="col-xl-8 offset-xl-2">
            <h1 class="page-title">
                <?php echo $this->lang->line('settings'); ?>
                <button class="btn btn-primary settings-save-changes">
                    <i class="far fa-save"></i>
                    <?php echo $this->lang->line('save_changes'); ?>
                </button>
            </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-2 offset-xl-2">
            <div class="settings-menu-group">
                <?php get_the_file(MIDRUB_BASE_USER_COMPONENTS_SETTINGS . 'views/menu.php'); ?>
            </div>
        </div>
        <div class="col-xl-6">
            <?php get_the_user_settings_page_content($template); ?>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="change-password" tabindex="-1" role="dialog" aria-labelledby="change-password-tab" aria-hidden="true">
    <?php echo form_open('user/settings', ['class' => 'form-settings-save-changes', 'data-csrf' => $this->security->get_csrf_token_name()]) ?>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <?php
                    echo $this->lang->line('change_password');
                    ?>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="password" class="form-control current-password" id="current-password" maxlength="50" placeholder="<?php echo $this->lang->line('enter_current_password'); ?>" name="current-password" autocomplete="off" required="required">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control new-password" id="new-password" maxlength="50" placeholder="<?php echo $this->lang->line('enter_new_password'); ?>" name="new-password" autocomplete="off" required="required">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control repeat-password" id="repeat-password" maxlength="50" placeholder="<?php echo $this->lang->line('repeat_password'); ?>" name="repeat-password" autocomplete="off" required="required">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" data-type="main" class="btn btn-primary pull-right"><?php echo $this->lang->line('change'); ?></button>
            </div>
        </div>
    </div>
    <?php echo form_close() ?>
</div>

<!-- Modal -->
<div class="modal fade" id="delete-account" tabindex="-1" role="dialog" aria-labelledby="delete-account-tab" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <?php
                    echo $this->lang->line('delete_account');
                    ?>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group text-center">
                    <button type="button" data-type="main" class="btn btn-danger delete-user-account"><?php echo $this->lang->line('yes_delete_my_account'); ?></button>
                </div>
            </div>
        </div>
    </div>
</div>