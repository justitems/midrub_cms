<div class="user-settings pt-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-2 col-sm-6">
                <?php md_include_component_file(CMS_BASE_ADMIN_COMPONENTS_USER . '/views/settings/menu.php'); ?>
            </div>
            <div class="col-xl-10 col-sm-6">
                <?php md_get_admin_fields(array(
                    'header' => array(
                        'title' => md_the_admin_icon(array('icon' => 'language'))
                        . $this->lang->line('user_languages')
                    ),
                    'fields' => array(
                        array(
                            'field_slug' => 'user_multilanguage',
                            'field_type' => 'checkbox',
                            'field_words' => array(
                                'field_title' => $this->lang->line('user_enable_multilanguage'),
                                'field_description' => $this->lang->line('user_enable_multilanguage_description')
                            ),
                            'field_params' => array(
                                'checked' => md_the_option('user_multilanguage')?md_the_option('user_multilanguage'):0
                            )
        
                        )  

                    )
                    
                )); ?>
                <?php md_get_admin_fields(array(
                    'header' => array(
                        'title' => md_the_admin_icon(array('icon' => 'signup'))
                        . $this->lang->line('user_registration')
                    ),
                    'fields' => array(
                        
                        array(
                            'field_slug' => 'enable_registration',
                            'field_type' => 'checkbox',
                            'field_words' => array(
                                'field_title' => $this->lang->line('user_enable_user_signup'),
                                'field_description' => $this->lang->line('user_enable_user_signup_description')
                            ),
                            'field_params' => array(
                                'checked' => md_the_option('enable_registration')?md_the_option('enable_registration'):0
                            )
        
                        ),
                        array(
                            'field_slug' => 'signup_confirm',
                            'field_type' => 'checkbox',
                            'field_words' => array(
                                'field_title' => $this->lang->line('user_enable_confirmation_email'),
                                'field_description' => $this->lang->line('user_enable_confirmation_email_description')
                            ),
                            'field_params' => array(
                                'checked' => md_the_option('signup_confirm')?md_the_option('signup_confirm'):0
                            )
        
                        ),
                        array(
                            'field_slug' => 'signup_limit',
                            'field_type' => 'checkbox',
                            'field_words' => array(
                                'field_title' => $this->lang->line('user_restrict_signup_by_ip_description'),
                                'field_description' => $this->lang->line('user_restrict_signup_by_ip_description')
                            ),
                            'field_params' => array(
                                'checked' => md_the_option('signup_limit')?md_the_option('signup_limit'):0
                            )
        
                        )                    

                    )
                    
                )); ?>
                <?php 
                
                // Get the user's logo
                $user_logo = md_the_option('user_logo')?$this->base_model->the_data_where('medias', '*', array('media_id' => md_the_option('user_logo'))):'';
                
                md_get_admin_fields(array(
                    'header' => array(
                        'title' => md_the_admin_icon(array('icon' => 'appearance'))
                        . $this->lang->line('user_appearance')
                    ),
                    'fields' => array(
                        
                        array(
                            'field_slug' => 'user_logo',
                            'field_type' => 'image',
                            'field_words' => array(
                                'field_title' => $this->lang->line('user_logo'),
                                'field_description' => $this->lang->line('user_logo_description')
                            ),
                            'field_params' => array(
                                'modal' => '#user-upload-logo-modal',
                                'src' => $user_logo?$user_logo[0]['body']:''
                            )

                        )             

                    )
                    
                )); ?>
            </div>
        </div>
    </div>
</div>