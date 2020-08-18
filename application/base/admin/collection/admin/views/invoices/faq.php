<div class="admin-settings">
    <div class="row">
        <div class="col-lg-2 col-lg-offset-1">
            <div class="row">
                <div class="col-lg-12">
                    <?php md_include_component_file(MIDRUB_BASE_ADMIN_ADMIN . 'views/invoices/menu.php'); ?>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="row">
                <div class="col-lg-12 settings-area">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="far fa-question-circle"></i>
                            <?php echo $this->lang->line('admin_faq'); ?>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="alert" role="alert">
                                        <h4 class="alert-heading"><?php echo $this->lang->line('admin_generate_invoices_steps'); ?>:</h4>
                                        <ol>
                                            <li><?php echo $this->lang->line('admin_create_invoice_template'); ?></li>
                                            <li><?php echo $this->lang->line('admin_use_labels_inside_invoice'); ?></li>
                                            <li><?php echo $this->lang->line('admin_generate_invoices_last_step'); ?></li>
                                        </ol>
                                        <h4 class="alert-heading"><?php echo $this->lang->line('admin_placeholders'); ?>:</h4>
                                        <ul>
                                            <li><?php echo $this->lang->line('admin_placeholders_transaction_id'); ?></li>
                                            <li><?php echo $this->lang->line('admin_placeholders_username'); ?></li>
                                            <li><?php echo $this->lang->line('admin_placeholders_first_name'); ?></li>
                                            <li><?php echo $this->lang->line('admin_placeholders_last_name'); ?></li>
                                            <li><?php echo $this->lang->line('admin_country'); ?></li>
                                            <li><?php echo $this->lang->line('admin_city'); ?></li>
                                            <li><?php echo $this->lang->line('admin_address'); ?></li>
                                            <li><?php echo $this->lang->line('admin_placeholders_email'); ?></li>
                                            <li><?php echo $this->lang->line('admin_placeholders_date'); ?></li>
                                            <li><?php echo $this->lang->line('admin_placeholders_amount'); ?></li>
                                            <li><?php echo $this->lang->line('admin_placeholders_total'); ?></li>
                                            <li><?php echo $this->lang->line('admin_placeholders_taxes'); ?></li>
                                        </ul>                                        
                                        <hr>
                                        <p class="mb-0">
                                            <?php echo $this->lang->line('admin_invoices_templates_info'); ?> <a href="https://www.midrub.com/articles/how-to-use-your-templates-for-invoices-in-midrub" target="_blank">
                                                https://www.midrub.com/articles/how-to-use-your-templates-for-invoices-in-midrub
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>