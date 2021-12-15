<section class="section settings-page">
    <div class="container-fluid">
        <div class="row theme-row-equal">
            <div class="col-xl-2 col-lg-3 col-md-4 theme-sidebar-menu">
                <?php md_include_component_file( CMS_BASE_ADMIN_COMPONENTS_SETTINGS . 'views/menu.php'); ?>
            </div>
            <div class="col-xl-10 col-lg-9 col-md-8 pt-3 settings-view">
                <?php md_get_admin_fields(array(
                    'header' => array(
                        'title' => md_the_admin_icon(array('icon' => 'storage'))
                        . $this->lang->line('settings_storage')
                    ),
                    'fields' => array(
                        array(
                            'field_slug' => 'upload_limit',
                            'field_type' => 'text',
                            'field_words' => array(
                                'field_title' => $this->lang->line('settings_upload_limit'),
                                'field_description' => $this->lang->line('settings_upload_limit_description')
                            ),
                            'field_params' => array(
                                'placeholder' => $this->lang->line('settings_enter_number_megabytes'),
                                'value' => md_the_option('upload_limit')?md_the_option('upload_limit'):0,
                                'disabled' => false
                            )

                        )

                    )

                )); ?>
                <?php md_get_admin_fields(array(
                    'header' => array(
                        'title' => md_the_admin_icon(array('icon' => 'notifications'))
                        . $this->lang->line('settings_notifications')
                    ),
                    'fields' => array(
                        array(
                            'field_slug' => 'enable_new_user_notification',
                            'field_type' => 'checkbox',
                            'field_words' => array(
                                'field_title' => $this->lang->line('settings_receive_notification_about_new_users'),
                                'field_description' => $this->lang->line('settings_receive_notification_about_new_users_description')
                            ),
                            'field_params' => array(
                                'checked' => md_the_option('enable_new_user_notification')?md_the_option('enable_new_user_notification'):0
                            )

                        )

                    )

                )); ?>                
            </div>
        </div>
    </div>
</section>