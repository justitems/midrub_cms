<div class="form-content<?php echo the_content_meta('auth_signin_slider_enable')?' has-slider':''; ?>">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-lg-2 col-md-12">
                    <?php echo get_option('auth_logo')?'<img src="' . get_option('auth_logo') . '" class="logo">':''; ?>
                </div>
                <div class="col-lg-4 offset-lg-2 col-md-12 offset-lg-0">
                    <?php echo form_open('', array('class' => 'form-signin', 'autocomplete' => 'off', 'data-csrf' => $this->security->get_csrf_token_name())) ?>
                        <div class="text-center mb-5">
                            <h1 class="h3">
                            <?php echo (md_the_single_content_meta('auth_signin_details_title')) ? md_the_single_content_meta('auth_signin_details_title') : $this->lang->line('auth_signin_sign_in_title'); ?>
                            </h1>
                            <p>
                                <?php
                                    echo (md_the_single_content_meta('auth_signin_details_under_title')) ? md_the_single_content_meta('auth_signin_details_under_title') : $this->lang->line('auth_signin_forgot_your_password');
                                ?>
                                <a href="<?php echo base_url('auth/reset'); ?>">
                                    <?php
                                        echo $this->lang->line('auth_signin_reset_it');
                                    ?>
                                </a>
                            </p>
                        </div>
                        <?php if ( get_option('auth_enable_username_input') ) { ?>
                        <div class="form-group">
                            <label for="email-address">
                                <?php echo $this->lang->line('auth_signin_email_or_username'); ?>
                            </label>
                            <input type="text" class="form-control email" id="email-address" name="email-address" placeholder="<?php echo $this->lang->line('auth_signin_enter_username_email_address'); ?>" autocomplete="email-address" required />
                        </div>
                        <?php } else { ?>
                        <div class="form-group">
                            <label for="email-address">
                                <?php echo $this->lang->line('auth_signin_email'); ?>
                            </label>
                            <input type="email" class="form-control email" id="email-address" name="email-address" placeholder="<?php echo $this->lang->line('auth_signin_enter_email_address'); ?>" autocomplete="email-address" required />
                        </div>
                        <?php } ?>
                        <div class="form-group">
                            <label for="password">
                                <?php echo $this->lang->line('auth_signin_password'); ?>
                            </label>
                            <input type="password" class="form-control password" id="password" name="email-address" placeholder="<?php echo $this->lang->line('auth_signin_enter_password'); ?>" autocomplete="new-password" required />
                        </div>                            
                    
                        <div class="form-group">
                            <div class="row">
                                <div class="col-6">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="remember-me" id="remember-me" name="remember-me">
                                            <span class="checkmark"></span>
                                        </label>
                                        <?php echo $this->lang->line('auth_signin_remember_me'); ?>
                                    </div>
                                </div>
                                <div class="col-6 text-right">
                                <?php
                                // Verify if signup is disabled
                                if (get_option('enable_registration')) {

                                    // Get the Sign Up url
                                    $url = the_url_by_page_role('sign_up') ? the_url_by_page_role('sign_up') : site_url('auth/signup');

                                    // Display the link
                                    echo '<p class="m-0 mt-1">'
                                            . '<a href="' . $url . '">'
                                                . $this->lang->line('auth_signin_or_sign_up')
                                            . '</a>'
                                        . '</p>';

                                }
                                ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <button class="btn btn-lg btn-primary btn-block" type="submit">
                                <?php echo $this->lang->line('auth_signin_sign_in_btn'); ?>
                            </button>
                        </div>

                        <div class="form-group alerts-status">
                            <?php
                            if ( isset($message) ) {

                                // Display message
                                echo '<div class="alert alert-danger" role="alert">'
                                        . $message
                                    . '</div>';

                            }
                            ?>
                        </div>

                        <?php
                        if ( md_auth_social_access_options() ) {

                            echo '<div class="form-group">'
                                    . '<p class="or-social">'
                                        . '<span>'
                                            . $this->lang->line('auth_signin_or')
                                        . '</span>'
                                    . '</p>'
                                . '</div>'

                                . '<div class="form-group">';

                            // Set the sign in page
                            $sign_in = the_url_by_page_role('sign_in') ? the_url_by_page_role('sign_in') : site_url('auth/signin');

                            // List available sign in options
                            foreach (md_auth_social_access_options() as $option) {

                                //  Display social option
                                echo '<div class="row">'
                                        . '<div class="col-12">'
                                            . '<a href="' . $sign_in . '/' . strtolower($option->name) . '" class="sign-in-btn sign-in-' . strtolower($option->name) . '-btn" style="background-color: ' . $option->color . ';">'
                                                . $option->icon
                                                . $this->lang->line('auth_signin_continue_with') . ' ' . ucwords(str_replace(array('_', '-'), ' ', $option->name))
                                            . '</a>'
                                        . '</div>'
                                    . '</div>';
                            }
                        }
                        ?>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>    
    </div>
</div>

<?php if ( the_content_meta('auth_signin_slider_enable') ) { ?>
<div id="carousel-signin" class="carousel slide" data-ride="carousel">
    <?php 

    // Get the slider's items
    $slider_items = the_content_meta_list('auth_signin_slider_items');

    // Verify if the slider has items
    if ( $slider_items ) {
    
    ?>
    <ol class="carousel-indicators">
        <?php

        // List the slider's items
        for ( $t = 0; $t < count($slider_items); $t++ ) {

            // Active class
            $active = ($t < 1)?' class="active"':'';

            // Display the link
            echo '<li data-target="#carousel-signin" data-slide-to="' . $t . '"' . $active . '></li>';

        }

        ?>
    </ol>
    <div class="carousel-inner" role="listbox">
        <?php

        // List the slider's items
        for ( $p = 0; $p < count($slider_items); $p++ ) {

            // Active class
            $active = ($p < 1)?' active':'';

            // Display the photo
            echo '<div class="carousel-item' . $active . '">'
                    . '<img src="' . $slider_items[$p]['auth_signin_slider_image'] . '" alt="' . $slider_items[$p]['auth_signin_settings_enter_image_title'] . '" />'
                . '</div>';

        }

        ?>        
    </div>
    <?php
    }
    ?>
</div>
<?php } ?>