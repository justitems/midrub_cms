<div class="row">
    <div class="col-lg-12 settings-area">
        <?php md_get_admin_fields(array(
            'header' => array(
                'title' => md_the_admin_icon(array('icon' => 'news'))
                . $this->lang->line('frontend_basic')
            ),
            'fields' => array(

                array(
                    'field_slug' => 'settings_home_page',
                    'field_type' => 'dynamic_list',
                    'field_words' => array(
                        'field_title' => $this->lang->line('frontend_settings_home_page'),
                        'field_description' => $this->lang->line('frontend_settings_home_page_description')
                    ),
                    'field_params' => array(
                        'button_text' => $this->lang->line('frontend_settings_select_page'),
                        'button_value' => 0,
                        'placeholder' => $this->lang->line('frontend_settings_search_page')
                    )

                )                                     

            )

        )); ?>        
        <?php md_get_admin_fields(array(
            'header' => array(
                'title' => md_the_admin_icon(array('icon' => 'door'))
                . $this->lang->line('frontend_members_access')
            ),
            'fields' => array(

                array(
                    'field_slug' => 'settings_auth_sign_in_page',
                    'field_type' => 'dynamic_list',
                    'field_words' => array(
                        'field_title' => $this->lang->line('frontend_settings_sign_in_page'),
                        'field_description' => $this->lang->line('frontend_settings_sign_in_page_description')
                    ),
                    'field_params' => array(
                        'button_text' => $this->lang->line('frontend_settings_select_page'),
                        'button_value' => 0,
                        'placeholder' => $this->lang->line('frontend_settings_search_page')
                    )

                ),   
                array(
                    'field_slug' => 'settings_auth_sign_up_page',
                    'field_type' => 'dynamic_list',
                    'field_words' => array(
                        'field_title' => $this->lang->line('frontend_settings_sign_up_page'),
                        'field_description' => $this->lang->line('frontend_settings_sign_up_page_description')
                    ),
                    'field_params' => array(
                        'button_text' => $this->lang->line('frontend_settings_select_page'),
                        'button_value' => 0,
                        'placeholder' => $this->lang->line('frontend_settings_search_page')
                    )

                ), 
                array(
                    'field_slug' => 'settings_auth_reset_password_page',
                    'field_type' => 'dynamic_list',
                    'field_words' => array(
                        'field_title' => $this->lang->line('frontend_settings_reset_password_page'),
                        'field_description' => $this->lang->line('frontend_settings_reset_password_page_description')
                    ),
                    'field_params' => array(
                        'button_text' => $this->lang->line('frontend_settings_select_page'),
                        'button_value' => 0,
                        'placeholder' => $this->lang->line('frontend_settings_search_page')
                    )

                ),
                array(
                    'field_slug' => 'settings_auth_change_password_page',
                    'field_type' => 'dynamic_list',
                    'field_words' => array(
                        'field_title' => $this->lang->line('frontend_settings_change_password_page'),
                        'field_description' => $this->lang->line('frontend_settings_change_password_page_description')
                    ),
                    'field_params' => array(
                        'button_text' => $this->lang->line('frontend_settings_select_page'),
                        'button_value' => 0,
                        'placeholder' => $this->lang->line('frontend_settings_search_page')
                    )

                ),
                array(
                    'field_slug' => 'auth_logo',
                    'field_type' => 'image',
                    'field_words' => array(
                        'field_title' => $this->lang->line('frontend_logo_for_sign_in'),
                        'field_description' => $this->lang->line('frontend_logo_for_sign_in_description')
                    ),
                    'field_params' => array(
                        'button_text' => $this->lang->line('frontend_settings_select_page'),
                        'button_value' => 0,
                        'placeholder' => $this->lang->line('frontend_settings_search_page')
                    )

                ),
                array(
                    'field_slug' => 'auth_enable_username_input',
                    'field_type' => 'checkbox',
                    'field_words' => array(
                        'field_title' => $this->lang->line('frontend_enable_username'),
                        'field_description' => $this->lang->line('frontend_enable_username_description')
                    ),
                    'field_params' => array(
                        'checked' => 0
                    )

                )                                       

            )

        )); ?>
        <?php md_get_admin_fields(array(
            'header' => array(
                'title' => md_the_admin_icon(array('icon' => 'law'))
                . $this->lang->line('frontend_legal_agreements')
            ),
            'fields' => array(

                array(
                    'field_slug' => 'settings_auth_privacy_policy_page',
                    'field_type' => 'dynamic_list',
                    'field_words' => array(
                        'field_title' => $this->lang->line('frontend_privacy_policy'),
                        'field_description' => $this->lang->line('frontend_privacy_policy_description')
                    ),
                    'field_params' => array(
                        'button_text' => $this->lang->line('frontend_settings_select_page'),
                        'button_value' => 0,
                        'placeholder' => $this->lang->line('frontend_settings_search_page')
                    )

                ), 
                array(
                    'field_slug' => 'settings_auth_cookies_page',
                    'field_type' => 'dynamic_list',
                    'field_words' => array(
                        'field_title' => $this->lang->line('frontend_cookies'),
                        'field_description' => $this->lang->line('frontend_cookies_description')
                    ),
                    'field_params' => array(
                        'button_text' => $this->lang->line('frontend_settings_select_page'),
                        'button_value' => 0,
                        'placeholder' => $this->lang->line('frontend_settings_search_page')
                    )

                ), 
                array(
                    'field_slug' => 'settings_auth_terms_and_conditions_page',
                    'field_type' => 'dynamic_list',
                    'field_words' => array(
                        'field_title' => $this->lang->line('frontend_terms_and_conditions'),
                        'field_description' => $this->lang->line('frontend_terms_and_conditions_description')
                    ),
                    'field_params' => array(
                        'button_text' => $this->lang->line('frontend_settings_select_page'),
                        'button_value' => 0,
                        'placeholder' => $this->lang->line('frontend_settings_search_page')
                    )

                ),                                     

            )

        )); ?>        
    </div>
</div>