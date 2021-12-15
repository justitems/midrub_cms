<div class="user-settings pt-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-2 col-sm-6">
                <?php md_include_component_file(CMS_BASE_ADMIN_COMPONENTS_USER . '/views/settings/menu.php'); ?>
            </div>
            <div class="col-xl-10 col-sm-6">
                <?php md_get_admin_fields(array(
                    'header' => array(
                        'title' => md_the_admin_icon(array('icon' => 'css'))
                        . $this->lang->line('user_settings_header_code')
                    ),
                    'fields' => array(
                        array(
                            'field_slug' => 'user_header_code',
                            'field_type' => 'textarea',
                            'field_words' => array(
                                'field_title' => $this->lang->line('user_header_code'),
                                'field_description' => $this->lang->line('user_header_code_description')
                            ),
                            'field_params' => array(
                                'placeholder' => $this->lang->line('user_enter_code_used_header'),
                                'value' => md_the_option('user_header_code'),
                                'disabled' => false
                            )

                        )

                    )

                )); ?>
            </div>
        </div>
    </div>
</div>