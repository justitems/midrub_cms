<div class="form-content">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-lg-2 col-md-12">
                    <?php echo get_option('auth_logo')?'<img src="' . get_option('auth_logo') . '" class="logo">':''; ?>
                </div>
                <div class="col-lg-4 offset-lg-2 col-md-12 offset-lg-0">
                    <?php echo form_open('', array('class' => 'form-change-password', 'autocomplete' => 'off', 'data-csrf' => $this->security->get_csrf_token_name())) ?>
                        <div class="text-center mb-5">
                            <h1 class="h3">
                                <?php echo (md_the_single_content_meta('auth_change_password_details_title'))?md_the_single_content_meta('auth_change_password_details_title'):$this->lang->line('auth_change_password_page_title'); ?>
                            </h1>
                            <p>
                                <?php
                                    echo (md_the_single_content_meta('auth_change_password_details_under_title'))?md_the_single_content_meta('auth_change_password_details_under_title'):$this->lang->line('auth_change_password_page_under_title');
                                    $sign_in = the_url_by_page_role('sign_in') ? the_url_by_page_role('sign_in') : site_url('auth/signin');
                                ?>                    
                                <a href="<?php echo $sign_in; ?>">
                                    <?php echo $this->lang->line('auth_change_password_signin_link'); ?>
                                </a>
                            </p>
                        </div>
                        <div class="form-group">
                            <label for="new-password">
                                <?php echo $this->lang->line('auth_change_new_password'); ?>
                            </label>
                            <input class="form-control new-password" id="new-password" type="password" placeholder="<?php echo $this->lang->line('auth_change_password_enter_password'); ?>" autocomplete="new-password" required>
                        </div>
                        <div class="form-group">
                            <label for="repeat-password">
                                <?php echo $this->lang->line('auth_change_repeat_password'); ?>
                            </label>
                            <input class="form-control repeat-password" id="repeat-password" type="password" placeholder="<?php echo $this->lang->line('auth_change_password_repeat_password'); ?>" autocomplete="new-password" required>
                        </div>                        
                        <div class="form-group">
                            <button class="btn btn-lg btn-primary btn-block submit-reset" type="submit">
                                <?php echo $this->lang->line('auth_change_password_btn'); ?>
                            </button>
                            <input class="form-control reset-code" type="hidden" value="<?php echo $this->input->get('reset', true); ?>">
                            <input class="form-control user-id" type="hidden" value="<?php echo $this->input->get('f', true); ?>">
                        </div>

                        <div class="form-group alerts-status">
                        </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>    
    </div>
</div>