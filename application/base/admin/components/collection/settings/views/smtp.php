<section class="section settings-page">
    <div class="container-fluid">
        <div class="row theme-row-equal">
            <div class="col-xl-2 col-lg-3 col-md-4 theme-sidebar-menu">
                <?php md_include_component_file( CMS_BASE_ADMIN_COMPONENTS_SETTINGS . 'views/menu.php'); ?>
            </div>
            <div class="col-xl-10 col-lg-9 col-md-8 pt-3 settings-view">
                <?php md_get_admin_fields(array(
                    'header' => array(
                        'title' => md_the_admin_icon(array('icon' => 'settings'))
                        . $this->lang->line('settings_configuration')
                    ),
                    'fields' => array(
                        array(
                            'field_slug' => 'smtp_enabled',
                            'field_type' => 'checkbox',
                            'field_words' => array(
                                'field_title' => $this->lang->line('settings_enable_smtp'),
                                'field_description' => $this->lang->line('settings_enable_smtp_description')
                            ),
                            'field_params' => array(
                                'checked' => md_the_option('smtp_enabled')?md_the_option('smtp_enabled'):0
                            )

                        ),
                        array(
                            'field_slug' => 'smtp_protocol',
                            'field_type' => 'text',
                            'field_words' => array(
                                'field_title' => $this->lang->line('settings_smtp_protocol'),
                                'field_description' => $this->lang->line('settings_smtp_protocol_description')
                            ),
                            'field_params' => array(
                                'placeholder' => $this->lang->line('settings_enter_smtp_protocol'),
                                'value' => md_the_option('smtp_protocol')?md_the_option('smtp_protocol'):'',
                                'disabled' => false
                            )

                        ),
                        array(
                            'field_slug' => 'smtp_host',
                            'field_type' => 'text',
                            'field_words' => array(
                                'field_title' => $this->lang->line('settings_smtp_host'),
                                'field_description' => $this->lang->line('settings_smtp_host_description')
                            ),
                            'field_params' => array(
                                'placeholder' => $this->lang->line('settings_enter_smtp_host'),
                                'value' => md_the_option('smtp_host')?md_the_option('smtp_host'):'',
                                'disabled' => false
                            )

                        ),
                        array(
                            'field_slug' => 'smtp_port',
                            'field_type' => 'text',
                            'field_words' => array(
                                'field_title' => $this->lang->line('settings_smtp_port'),
                                'field_description' => $this->lang->line('settings_smtp_port_description')
                            ),
                            'field_params' => array(
                                'placeholder' => $this->lang->line('settings_enter_smtp_port'),
                                'value' => md_the_option('smtp_port')?md_the_option('smtp_port'):'',
                                'disabled' => false
                            )

                        ),
                        array(
                            'field_slug' => 'smtp_username',
                            'field_type' => 'text',
                            'field_words' => array(
                                'field_title' => $this->lang->line('settings_smtp_username'),
                                'field_description' => $this->lang->line('settings_smtp_username_description')
                            ),
                            'field_params' => array(
                                'placeholder' => $this->lang->line('settings_enter_smtp_username'),
                                'value' => md_the_option('smtp_username')?md_the_option('smtp_username'):'',
                                'disabled' => false
                            )

                        ), 
                        array(
                            'field_slug' => 'smtp_password',
                            'field_type' => 'text',
                            'field_words' => array(
                                'field_title' => $this->lang->line('settings_smtp_password'),
                                'field_description' => $this->lang->line('settings_smtp_password_description')
                            ),
                            'field_params' => array(
                                'placeholder' => $this->lang->line('settings_enter_smtp_password'),
                                'value' => md_the_option('smtp_password')?md_the_option('smtp_password'):'',
                                'disabled' => false
                            )

                        ),
                        array(
                            'field_slug' => 'smtp_ssl',
                            'field_type' => 'checkbox',
                            'field_words' => array(
                                'field_title' => $this->lang->line('settings_smtp_ssl'),
                                'field_description' => $this->lang->line('settings_smtp_ssl_description')
                            ),
                            'field_params' => array(
                                'checked' => md_the_option('smtp_ssl')?md_the_option('smtp_ssl'):0
                            )

                        ),
                        array(
                            'field_slug' => 'smtp_tls',
                            'field_type' => 'checkbox',
                            'field_words' => array(
                                'field_title' => $this->lang->line('settings_smtp_tls'),
                                'field_description' => $this->lang->line('settings_smtp_tls_description')
                            ),
                            'field_params' => array(
                                'checked' => md_the_option('smtp_tls')?md_the_option('smtp_tls'):0
                            )

                        )                                                                                      

                    )

                )); ?>       
            </div>
        </div>
    </div>
</section>