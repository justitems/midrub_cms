<?php 
md_get_admin_fields(array(
    'header' => array(
        'title' => md_the_admin_icon(array('icon' => 'css'))
        . $this->lang->line('frontend_settings_header_code')
    ),
    'fields' => array(
        array(
            'field_slug' => 'frontend_header_code',
            'field_type' => 'textarea',
            'field_words' => array(
                'field_title' => $this->lang->line('frontend_header_code'),
                'field_description' => $this->lang->line('frontend_header_code_description')
            ),
            'field_params' => array(
                'placeholder' => $this->lang->line('frontend_enter_code_used_header'),
                'value' => md_the_option('frontend_header_code'),
                'disabled' => false
            )

        )

    )

)); 

?>