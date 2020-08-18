<div class="form-content">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-lg-2 col-md-12">
                    <?php echo get_option('auth_logo')?'<img src="' . get_option('auth_logo') . '" class="logo">':''; ?>
                </div>
                <div class="col-lg-4 offset-lg-2 col-md-12 offset-lg-0">
                    <?php echo form_open('', array('class' => 'form-reset', 'autocomplete' => 'off', 'data-csrf' => $this->security->get_csrf_token_name())) ?>
                        <div class="text-center mb-5">
                            <h1 class="h3">
                            <?php echo (md_the_single_content_meta('auth_reset_details_title'))?md_the_single_content_meta('auth_reset_details_title'):$this->lang->line('auth_reset_page_title'); ?>
                            </h1>
                            <p>
                                <?php
                                    echo (md_the_single_content_meta('auth_reset_details_under_title'))?md_the_single_content_meta('auth_reset_details_under_title'):$this->lang->line('auth_reset_page_under_title');
                                    $sign_in = the_url_by_page_role('sign_in') ? the_url_by_page_role('sign_in') : site_url('auth/signin');
                                ?>                    
                                <a href="<?php echo $sign_in; ?>">
                                    <?php echo $this->lang->line('auth_reset_signin_link'); ?>
                                </a>
                            </p>
                        </div>
                        <div class="form-group">
                            <label for="email-address">
                                <?php echo $this->lang->line('auth_reset_email'); ?>
                            </label>
                            <input class="form-control email" id="email-address" type="email" placeholder="<?php echo $this->lang->line('auth_reset_enter_email'); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <button class="btn btn-lg btn-primary btn-block submit-reset" type="submit">
                                <?php echo $this->lang->line('auth_reset_btn'); ?>
                            </button>
                        </div>

                        <div class="form-group alerts-status">
                        </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>    
    </div>
</div>