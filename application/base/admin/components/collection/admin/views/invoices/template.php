<div class="admin-settings mt-3">
    <div class="row">
        <div class="col-xl-2 col-sm-6">
            <div class="row">
                <div class="col-lg-12">
                    <?php md_include_component_file(CMS_BASE_ADMIN_COMPONENTS_ADMIN . 'views/invoices/menu.php'); ?>
                </div>
            </div>
        </div>
        <div class="col-xl-10 col-sm-6">
            <?php md_get_admin_fields(array(
                'header' => array(
                    'title' => md_the_admin_icon(array('icon' => 'fields'))
                    . $this->lang->line('admin_template_fields')
                ),
                'fields' => array(

                    array(
                        'field_slug' => 'template_title',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => $this->lang->line('admin_invoice_title'),
                            'field_description' => $this->lang->line('admin_invoice_title_description')
                        ),
                        'field_params' => array(
                            'placeholder' => $this->lang->line('admin_enter_invoice_title'),
                            'value' => get_template_field('template_title', 'default'),
                            'disabled' => false
                        )
            
                    ),
                    array(
                        'field_slug' => 'template_taxes',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => $this->lang->line('admin_invoice_taxes'),
                            'field_description' => $this->lang->line('admin_invoice_taxes_description')
                        ),
                        'field_params' => array(
                            'placeholder' => $this->lang->line('admin_enter_invoice_taxes'),
                            'value' => get_invoices_option('template_taxes', 'default'),
                            'disabled' => false
                        )
            
                    ),
                    array(
                        'field_slug' => 'template_body',
                        'field_type' => 'textarea',
                        'field_words' => array(
                            'field_title' => $this->lang->line('admin_html_code'),
                            'field_description' => $this->lang->line('admin_html_code_description')
                        ),
                        'field_params' => array(
                            'placeholder' => $this->lang->line('admin_enter_html_invoice_template'),
                            'value' => get_template_field('template_body', 'default'),
                            'disabled' => false
                        )
            
                    ),   
                    array(
                        'field_slug' => 'enable_invoices_generation',
                        'field_type' => 'checkbox',
                        'field_words' => array(
                            'field_title' => $this->lang->line('admin_generate_invoices'),
                            'field_description' => $this->lang->line('admin_generate_invoices_description')
                        ),
                        'field_params' => array(
                            'checked' => get_invoices_option('enable_invoices_generation', 'default')?1:0
                        )
    
                    )             

                )

            )); ?>
        </div>
    </div>
</div>