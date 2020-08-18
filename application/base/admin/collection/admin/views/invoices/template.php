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
                            <i class="fas fa-receipt"></i>
                            <?php echo $this->lang->line('admin_template'); ?>
                        </div>
                        <div class="panel-body">
                            <ul class="settings-list-options">
                                <li>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label for="template_title">
                                                <?php echo $this->lang->line('admin_invoice_title'); ?>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <input id="template_title" type="text" class="form-control admin-text-input" value="<?php echo get_template_field('template_title', 'default'); ?>" placeholder="<?php echo $this->lang->line('admin_enter_invoice_title'); ?>">
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label for="template_taxes">
                                                <?php echo $this->lang->line('admin_invoice_taxes'); ?>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <input id="template_taxes" type="text" class="form-control admin-text-input" value="<?php echo get_invoices_option('template_taxes', 'default'); ?>" placeholder="<?php echo $this->lang->line('admin_enter_invoice_taxes'); ?>">
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label for="template_body">
                                                <?php echo $this->lang->line('admin_html_code'); ?>
                                            </label>
                                        </div>
                                    </div>                                    
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="input-option">
                                                <textarea id="template_body" placeholder="<?php echo $this->lang->line('admin_enter_html_invoice_template'); ?>" class="form-control admin-textarea-input"><?php echo get_template_field('template_body', 'default'); ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row">
                                        <div class="col-lg-8 col-md-8 col-xs-12">
                                            <label for="menu-item-text-input">
                                                <?php
                                                    echo $this->lang->line('admin_generate_invoices');
                                                ?>
                                            </label>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-xs-12 text-right">
                                            <div class="checkbox-option pull-right">
                                                <input id="enable_invoices_generation" name="enable-invoices-generation" class="admin-option-checkbox" type="checkbox"<?php if ( get_invoices_option('enable_invoices_generation', 'default') ): echo ' checked'; endif; ?>>
                                                <label for="enable_invoices_generation"></label>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="settings-save-changes">
    <?php echo form_open('admin/frontend', array('class' => 'save-settings', 'data-csrf' => $this->security->get_csrf_token_name())) ?>
    <div class="col-xs-6">
        <p><?php echo $this->lang->line('frontend_settings_you_have_unsaved_changes'); ?></p>
    </div>
    <div class="col-xs-6 text-right">
        <button type="button" class="btn btn-default">
            <i class="far fa-save"></i>
            <?php echo $this->lang->line('frontend_settings_save_changes'); ?>
        </button>
    </div>
    <?php echo form_close() ?>
</div>