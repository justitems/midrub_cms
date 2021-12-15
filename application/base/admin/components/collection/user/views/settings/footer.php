<div class="user-settings pt-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-2 col-sm-6">
                <?php md_include_component_file(CMS_BASE_ADMIN_COMPONENTS_USER . '/views/settings/menu.php'); ?>
            </div>
            <div class="col-xl-10 col-sm-6">
                <?php md_get_admin_fields(array(
                    'header' => array(
                        'title' => md_the_admin_icon(array('icon' => 'js'))
                        . $this->lang->line('user_settings_footer_code')
                    ),
                    'fields' => array(
                        array(
                            'field_slug' => 'user_footer_code',
                            'field_type' => 'textarea',
                            'field_words' => array(
                                'field_title' => $this->lang->line('user_footer_code'),
                                'field_description' => $this->lang->line('user_footer_code_description')
                            ),
                            'field_params' => array(
                                'placeholder' => $this->lang->line('user_enter_code_used_footer'),
                                'value' => md_the_option('user_footer_code'),
                                'disabled' => false
                            )

                        )

                    )

                )); ?>
            </div>
        </div>
    </div>
</div>