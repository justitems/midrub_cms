<div class="social-page">
    <div class="row">
        <div class="col-lg-12">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <div class="row">
                            <div class="col-lg-10 col-xs-6">
                                <h3>
                                    <i class="fas fa-share-alt"></i>
                                    <?php echo $this->lang->line('frontend_social_access'); ?>
                                </h3>
                            </div>
                            <div class="col-lg-2 col-xs-6">
                                <div class="checkbox-option pull-right">
                                    <input id="enable_auth_social_access" name="enable-auth-social-access" class="auth-social-option-checkbox" type="checkbox" <?php echo (get_option('enable_auth_social_access')) ? ' checked' : ''; ?>>
                                    <label for="enable_auth_social_access"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 show-auth-socials">
            <?php

            // Set the sign in page
            $sign_in = the_url_by_page_role('sign_in')?the_url_by_page_role('sign_in'):site_url('auth/signin');

            // Set the sign up page
            $sign_up = the_url_by_page_role('sign_up')?the_url_by_page_role('sign_up'):site_url('auth/signup');

            // Verify if social classes exists
            if ( glob(MIDRUB_BASE_AUTH . 'social/*.php') ) {

                // List auth social classes
                foreach (glob(MIDRUB_BASE_AUTH . 'social/*.php') as $filename) {

                    // Call the class
                    $className = str_replace(array(MIDRUB_BASE_AUTH . 'social/', '.php'), '', $filename);

                    // Create an array
                    $array = array(
                        'MidrubBase',
                        'Auth',
                        'Social',
                        ucfirst($className)
                    );

                    // Implode the array above
                    $cl = implode('\\', $array);

                    // Get class info
                    $class = (new $cl())->get_info();

                    ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default single-social">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <ul class="nav nav-tabs nav-justified">
                                                <li class="active">
                                                    <a data-toggle="tab" href="#<?php echo $className; ?>">
                                                        <?php
                                                        echo ucwords(str_replace(array('_', '-'), ' ', $className));
                                                        ?>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="tab-content tab-all-editors">
                                        <div id="<?php echo $className; ?>" class="tab-pane fade in active">
                                            <?php
                                            if ($class->api) {

                                                foreach ($class->api as $api) {

                                                    ?>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <label for="auth-text-input">
                                                                    <?php
                                                                    echo ucwords(str_replace(array('_', '-'), ' ', $api));
                                                                    ?>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <input type="text" class="form-control auth-text-input" id="<?php echo strtolower($className); ?>_auth_<?php echo $api; ?>" value="<?php echo (get_option(strtolower($className) . '_auth_' . $api)) ? get_option(strtolower($className) . '_auth_' . $api) : ''; ?>" placeholder="<?php echo $this->lang->line('frontend_enter_the'); ?> <?php echo str_replace(array('_', '-'), ' ', $api); ?>">
                                                                <small class="form-text text-muted">
                                                                    <?php echo $this->lang->line('frontend_the_field_is_required'); ?>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php

                                                }
                                            }
                                            ?>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <label for="menu-item-text-input">
                                                            <?php
                                                            echo $this->lang->line('frontend_sign_in_redirect') . ':';
                                                            ?>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <?php
                                                        echo $sign_in . '/' . $className;
                                                        ?>
                                                    </div>                                                
                                                </div>
                                            </div> 
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <label for="menu-item-text-input">
                                                            <?php
                                                            echo $this->lang->line('frontend_sign_up_redirect') . ':';
                                                            ?>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <?php
                                                        echo $sign_up . '/' . $className;
                                                        ?>
                                                    </div>                                                
                                                </div>
                                            </div>                                      
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-10 col-xs-6">
                                                        <label for="menu-item-text-input">
                                                            <?php
                                                            echo $this->lang->line('frontend_enable') . ' ' . ucwords(str_replace(array('_', '-'), ' ', $className));
                                                            ?>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-2 col-xs-6">
                                                        <div class="checkbox-option pull-right">
                                                            <input id="enable_auth_<?php echo strtolower($className); ?>" name="enable-auth-<?php echo strtolower($className); ?>" class="auth-social-option-checkbox" type="checkbox" <?php echo (get_option('enable_auth_' . strtolower($className))) ? ' checked' : ''; ?>>
                                                            <label for="enable_auth_<?php echo strtolower($className); ?>"></label>
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
                <?php
                }

            } else {
            ?>
                <div class="row">
                    <div class="col-lg-12">
                        <nav class="navbar navbar-default">
                            <div class="container-fluid">
                                <div class="navbar-header">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <p>
                                                <?php
                                                echo $this->lang->line('frontend_no_data_found_to_show');
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php echo form_open('admin/frontend', array('class' => 'save-settings', 'data-csrf' => $this->security->get_csrf_token_name())) ?>
<?php echo form_close() ?>

<div class="auth-social-save-changes">
    <div class="col-xs-6">
        <p><?php echo $this->lang->line('frontend_settings_you_have_unsaved_changes'); ?></p>
    </div>
    <div class="col-xs-6 text-right">
        <button type="button" class="btn btn-default">
            <i class="far fa-save"></i>
            <?php echo $this->lang->line('frontend_settings_save_changes'); ?>
        </button>
    </div>
</div>