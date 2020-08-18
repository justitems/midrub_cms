<div class="form-content<?php echo the_content_meta('auth_signup_slider_enable')?' has-slider':''; ?>">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-lg-2 col-md-12">
                    <?php echo get_option('auth_logo')?'<img src="' . get_option('auth_logo') . '" class="logo">':''; ?>
                </div>
                <div class="col-lg-4 offset-lg-2 col-md-12 offset-lg-0">
                    <?php echo form_open('', array('class' => 'form-signup', 'data-csrf' => $this->security->get_csrf_token_name())) ?>
                        <div class="text-center mb-5">
                            <h1 class="h3">
                            <?php echo (md_the_single_content_meta('auth_signup_details_title')) ? md_the_single_content_meta('auth_signup_details_title') : $this->lang->line('auth_signup_page_title'); ?>
                            </h1>
                            <p>
                                <?php
                                echo (md_the_single_content_meta('auth_signup_details_under_title')) ? md_the_single_content_meta('auth_signup_details_under_title') : $this->lang->line('auth_signup_page_under_title');
                                $sign_in = the_url_by_page_role('sign_in') ? the_url_by_page_role('sign_in') : site_url('auth/signin');
                                ?>
                                <a href="<?php echo $sign_in; ?>">
                                    <?php echo $this->lang->line('auth_signup_signin_link'); ?>
                                </a>
                            </p>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-xl-6 col-md-12">
                                <label for="first-name">
                                    <?php echo $this->lang->line('auth_signup_first_name'); ?>
                                </label>
                                <input type="text" class="form-control first-name" id="first-name"<?php if ( isset($first_name) ): echo ' value="' . $first_name . '"'; endif; ?> placeholder="<?php echo $this->lang->line('auth_signup_enter_first_name'); ?>" autocomplete="first-name" required />
                            </div>
                            <div class="form-group col-xl-6 col-md-12">
                                <label for="last-name">
                                    <?php echo $this->lang->line('auth_signup_last_name'); ?>
                                </label>
                                <input type="text" class="form-control last-name" id="last-name"<?php if ( isset($last_name) ): echo ' value="' . $last_name . '"'; endif; ?> placeholder="<?php echo $this->lang->line('auth_signup_enter_last_name'); ?>" autocomplete="last-name" required />
                            </div>
                        </div>
                        <?php if ( get_option('auth_enable_username_input') ) { ?>
                        <div class="form-group">
                            <label for="username">
                                <?php echo $this->lang->line('auth_signup_user_name'); ?>
                            </label>
                            <input type="text" class="form-control username" id="username" placeholder="<?php echo $this->lang->line('auth_signup_enter_username'); ?>" autocomplete="username" required />
                        </div>
                        <?php } ?>
                        <div class="form-group">
                            <label for="email-address">
                                <?php echo $this->lang->line('auth_signup_email'); ?>
                            </label>
                            <input type="email" class="form-control email" id="email-address"<?php if ( isset($email) ): echo ' value="' . $email . '"'; endif; ?> placeholder="<?php echo $this->lang->line('auth_signup_enter_email_address'); ?>" autocomplete="email-address" required />
                        </div>
                        <div class="form-group">
                            <label for="password">
                                <?php echo $this->lang->line('auth_signup_password'); ?>
                            </label>
                            <input type="password" class="form-control password" id="password" placeholder="<?php echo $this->lang->line('auth_signup_enter_password'); ?>" autocomplete="new-password" required />
                        </div>                            
                    
                        <div class="form-group">
                            <div class="checkbox mb-3">
                                <label>
                                    <input type="checkbox" id="agre-terms" name="agre-terms" required>
                                    <span class="checkmark"></span>
                                </label>
                                <?php

                                // Diplay terms agree
                                echo (md_the_single_content_meta('auth_signup_details_accept_terms')) ? md_the_single_content_meta('auth_signup_details_accept_terms') : $this->lang->line('auth_signup_page_approve_terms');

                                // Verify and display the terms and condition link
                                if ( the_url_by_page_role('terms_and_conditions') ) {
                                    echo ' <a href="' . the_url_by_page_role('terms_and_conditions') . '">' . $this->lang->line('auth_signup_terms_of_service') . '</a>';
                                }

                                // Verify and display the privacy policy link
                                if ( the_url_by_page_role('privacy_policy') ) {
                                    echo ' ' . $this->lang->line('auth_signup_and') . ' <a href="' . the_url_by_page_role('privacy_policy') . '">' . $this->lang->line('auth_signup_privacy_policy') . '</a>';
                                }                

                                ?>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <button class="btn btn-lg btn-primary btn-block" type="submit">
                                <?php echo $this->lang->line('auth_signup_btn'); ?>
                            </button>
                        </div>

                        <div class="form-group alerts-status">
                            <?php
                            if ( isset($error_message) ) {

                                // Display error's message
                                echo '<div class="alert alert-danger" role="alert">'
                                        . $error_message
                                    . '</div>';

                            }
                            if ( isset($success_message) ) {

                                // Display success's message
                                echo '<div class="alert alert-primary" role="alert">'
                                        . $success_message
                                    . '</div>';

                            }
                            ?>
                        </div>

                        <?php
                        if (md_auth_social_access_options()) {

                            echo '<div class="form-group">'
                                    . '<p class="or-social">'
                                        . '<span>'
                                            . $this->lang->line('auth_signup_or')
                                        . '</span>'
                                    . '</p>'
                                . '</div>'

                                . '<div class="form-group">';

                            // Set the sign up page
                            $sign_up = the_url_by_page_role('sign_up')?the_url_by_page_role('sign_up'):site_url('auth/signup');

                            // List available signup options
                            foreach (md_auth_social_access_options() as $option) {

                                //  Display social option
                                echo '<div class="row">'
                                    . '<div class="col-12">'
                                        . '<a href="' . $sign_up . '/' . strtolower($option->name) . '" class="sign-up-btn sign-up-' . strtolower($option->name) . '-btn" style="background-color: ' . $option->color . ';">'
                                            . $option->icon
                                            . $this->lang->line('auth_signup_continue_with') . ' ' . ucwords(str_replace(array('_', '-'), ' ', $option->name))
                                        . '</a>'
                                    . '</div>'
                                . '</div>';

                            }

                            echo '</div>';

                        }
                        ?>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>    
    </div>
</div>


<?php if ( the_content_meta('auth_signup_slider_enable') ) { ?>
<div id="carousel-signin" class="carousel slide" data-ride="carousel">
    <?php 

    // Get the slider's items
    $slider_items = the_content_meta_list('auth_signup_slider_items');

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
                    . '<img src="' . $slider_items[$p]['auth_signup_slider_image'] . '" alt="' . $slider_items[$p]['auth_signup_settings_enter_image_title'] . '" />'
                . '</div>';

        }

        ?>        
    </div>
    <?php
    }
    ?>
</div>
<?php } ?>