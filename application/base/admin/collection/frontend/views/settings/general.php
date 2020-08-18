<div class="row">
    <div class="col-lg-12 settings-area">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="icon-login"></i>
                <?php echo $this->lang->line('frontend_settings_member_access'); ?>
            </div>
            <div class="panel-body">
                <ul class="settings-list-options">
                    <li>
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-xs-12">
                                <h4>
                                    <?php echo $this->lang->line('frontend_settings_home_page'); ?>
                                </h4>
                                <p>
                                    <?php echo $this->lang->line('frontend_settings_home_page_description'); ?>
                                </p>
                            </div>
                            <div class="col-lg-4 col-md-4 col-xs-12 text-right">
                                <?php
                                get_option_dropdown(
                                    'settings_home_page',
                                    array(
                                        'search' => true,
                                        'words' => array(
                                            'select_btn' => $this->lang->line('frontend_settings_select_page'),
                                            'search_text' => $this->lang->line('frontend_settings_search_page'),
                                        )
                                    )
                                );
                                ?>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-xs-12">
                                <h4>
                                    <?php echo $this->lang->line('frontend_settings_sign_in_page'); ?>
                                </h4>
                                <p>
                                    <?php echo $this->lang->line('frontend_settings_sign_in_page_description'); ?>
                                </p>
                            </div>
                            <div class="col-lg-4 col-md-4 col-xs-12 text-right">
                                <?php
                                get_option_dropdown(
                                    'settings_auth_sign_in_page',
                                    array(
                                        'search' => true,
                                        'words' => array(
                                            'select_btn' => $this->lang->line('frontend_settings_select_page'),
                                            'search_text' => $this->lang->line('frontend_settings_search_page'),
                                        )
                                    )
                                );
                                ?>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-xs-12">
                                <h4>
                                    <?php echo $this->lang->line('frontend_settings_sign_up_page'); ?>
                                </h4>
                                <p>
                                    <?php echo $this->lang->line('frontend_settings_sign_up_page_description'); ?>
                                </p>
                            </div>
                            <div class="col-lg-4 col-md-4 col-xs-12 text-right">
                                <?php
                                get_option_dropdown(
                                    'settings_auth_sign_up_page',
                                    array(
                                        'search' => true,
                                        'words' => array(
                                            'select_btn' => $this->lang->line('frontend_settings_select_page'),
                                            'search_text' => $this->lang->line('frontend_settings_search_page'),
                                        )
                                    )
                                );
                                ?>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-xs-12">
                                <h4>
                                    <?php echo $this->lang->line('frontend_settings_reset_password_page'); ?>
                                </h4>
                                <p>
                                    <?php echo $this->lang->line('frontend_settings_reset_password_page_description'); ?>
                                </p>
                            </div>
                            <div class="col-lg-4 col-md-4 col-xs-12 text-right">
                                <?php
                                get_option_dropdown(
                                    'settings_auth_reset_password_page',
                                    array(
                                        'search' => true,
                                        'words' => array(
                                            'select_btn' => $this->lang->line('frontend_settings_select_page'),
                                            'search_text' => $this->lang->line('frontend_settings_search_page'),
                                        )
                                    )
                                );
                                ?>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-xs-12">
                                <h4>
                                    <?php echo $this->lang->line('frontend_settings_change_password_page'); ?>
                                </h4>
                                <p>
                                    <?php echo $this->lang->line('frontend_settings_change_password_page_description'); ?>
                                </p>
                            </div>
                            <div class="col-lg-4 col-md-4 col-xs-12 text-right">
                                <?php
                                get_option_dropdown(
                                    'settings_auth_change_password_page',
                                    array(
                                        'search' => true,
                                        'words' => array(
                                            'select_btn' => $this->lang->line('frontend_settings_select_page'),
                                            'search_text' => $this->lang->line('frontend_settings_search_page'),
                                        )
                                    )
                                );
                                ?>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-xs-12">
                                <h4>
                                    <?php echo $this->lang->line('frontend_privacy_policy'); ?>
                                </h4>
                                <p>
                                    <?php echo $this->lang->line('frontend_privacy_policy_description'); ?>
                                </p>
                            </div>
                            <div class="col-lg-4 col-md-4 col-xs-12 text-right">
                                <?php
                                get_option_dropdown(
                                    'settings_auth_privacy_policy_page',
                                    array(
                                        'search' => true,
                                        'words' => array(
                                            'select_btn' => $this->lang->line('frontend_settings_select_page'),
                                            'search_text' => $this->lang->line('frontend_settings_search_page'),
                                        )
                                    )
                                );
                                ?>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-xs-12">
                                <h4>
                                    <?php echo $this->lang->line('frontend_cookies'); ?>
                                </h4>
                                <p>
                                    <?php echo $this->lang->line('frontend_cookies_description'); ?>
                                </p>
                            </div>
                            <div class="col-lg-4 col-md-4 col-xs-12 text-right">
                                <?php
                                get_option_dropdown(
                                    'settings_auth_cookies_page',
                                    array(
                                        'search' => true,
                                        'words' => array(
                                            'select_btn' => $this->lang->line('frontend_settings_select_page'),
                                            'search_text' => $this->lang->line('frontend_settings_search_page'),
                                        )
                                    )
                                );
                                ?>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-xs-12">
                                <h4>
                                    <?php echo $this->lang->line('frontend_terms_and_conditions'); ?>
                                </h4>
                                <p>
                                    <?php echo $this->lang->line('frontend_terms_and_conditions_description'); ?>
                                </p>
                            </div>
                            <div class="col-lg-4 col-md-4 col-xs-12 text-right">
                                <?php
                                get_option_dropdown(
                                    'settings_auth_terms_and_conditions_page',
                                    array(
                                        'search' => true,
                                        'words' => array(
                                            'select_btn' => $this->lang->line('frontend_settings_select_page'),
                                            'search_text' => $this->lang->line('frontend_settings_search_page'),
                                        )
                                    )
                                );
                                ?>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-xs-12">
                                <h4>
                                    <?php echo $this->lang->line('frontend_logo_for_sign_in'); ?>
                                </h4>
                                <p>
                                    <?php echo $this->lang->line('frontend_logo_for_sign_in_description'); ?>
                                </p>
                            </div>
                            <div class="col-lg-6 col-md-6 col-xs-12">
                                <?php
                                get_option_media(
                                    'auth_logo',
                                    array(
                                        'words' => array(
                                            'placeholder' => $this->lang->line('frontend_logo_for_sign_in_placeholder')
                                        )
                                    )
                                );
                                ?>
                            </div>
                        </div>
                    </li> 
                    <li>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-xs-12">
                                <h4>
                                    <?php echo $this->lang->line('frontend_enable_username'); ?>
                                </h4>
                                <p>
                                    <?php echo $this->lang->line('frontend_enable_username_description'); ?>
                                </p>
                            </div>
                            <div class="col-lg-6 col-md-6 col-xs-12">
                                <?php
                                get_option_checkbox(
                                    'auth_enable_username_input'
                                );
                                ?>
                            </div>
                        </div>
                    </li>                             
                </ul>
            </div>
        </div>
    </div>
</div>