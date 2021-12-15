<div class="notifications-new-email-template">
    <?php echo form_open('admin/notifications', array('class' => 'notifications-create-email-template', 'data-csrf' => $this->security->get_csrf_token_name())) ?>
    <div class="row">
        <div class="col-lg-9 theme-editor">
            <?php

            // Get languages
            $languages = glob(APPPATH . 'language' . '/*', GLOB_ONLYDIR);

            // Verify if there are more than a language
            if (count($languages) > 1) {

                // Display the list start
                echo '<ul class="nav nav-tabs nav-justified">';

                // List all languages
                foreach ($languages as $lang) {

                    // Set directory
                    $only_dir = str_replace(APPPATH . 'language' . '/', '', $lang);                    

                    // Active variable
                    $active = '';

                    // Verify if is the configured language
                    if ($this->config->item('language') === $only_dir) {
                        $active = ' class="active"';
                    }

                    // Display the link
                    echo '<li' . $active . '>'
                            . '<a data-toggle="tab" href="#' . $only_dir . '">'
                                . ucfirst($only_dir)
                            . '</a>'
                        . '</li>';

                }

                // Display the list end
                echo '</ul>';

            }

            ?>
            <div class="tab-content tab-all-editors">
                <?php

                // List languages
                foreach ($languages as $lang) {

                    // Get dir
                    $only_dir = str_replace(APPPATH . 'language' . '/', '', $lang);

                    // Active variable
                    $active = '';

                    // Verify if is the configured language
                    if ($this->config->item('language') === $only_dir) {
                        $active = ' show active';
                    }                    

                    // Display the tab
                    echo '<div id="' . $only_dir . '" class="tab-pane fade' . $active . '">'
                        . '<div class="row">'
                            . '<div class="col-lg-12">'
                                . '<div class="theme-box-1">'
                                    . '<input type="text" class="form-control input-form article-title default-editor-title-input" placeholder="' . $this->lang->line('enter_article_title') . '">'
                                . '</div>'
                            . '</div>'
                        . '</div>'
                        . '<div class="row mb-3">'
                            . '<div class="col-lg-12">'
                                . '<div class="theme-box-1">'
                                    . '<div class="summernote-body body-' . $only_dir . ' theme-box-1" data-dir="body-' . $only_dir . '"></div>'
                                    . '<textarea class="article-body content-body-' . $only_dir . ' hidden"></textarea>'
                                . '</div>'
                            . '</div>'
                        . '</div>'
                        . '<div class="row">'
                            . '<div class="col-lg-12">'
                                . '<div class="card theme-card-box notifications-emails-template-placeholders-area">'
                                    . '<div class="card-header">'
                                        . '<button class="btn btn-link">'
                                            . md_the_admin_icon(array('icon' => 'placeholders'))
                                            . $this->lang->line('notifications_placeholders')
                                        . '</button>'
                                    . '</div>'
                                    . '<div class="card-body">'
                                        . '<ul class="theme-card-box-list notifications-emails-template-placeholders">'
                                            . '<li class="default-card-box-no-items-found">'
                                                . $this->lang->line('notifications_no_placeholders_found')
                                            . '</li>'
                                        . '</ul>'
                                    . '</div>'
                                . '</div>'
                            . '</div>'
                        . '</div>'
                    . '</div>';

                }
                ?>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="row">
                <div class="col-lg-12">
                    <div class="theme-box-1 mb-3">
                        <div class="col-12 pt-3 pb-3 ps-4 pe-4 text-end">
                            <button type="submit" class="btn btn-success w-100 notifications-save-email-template theme-button-2">
                                <?php echo $this->lang->line('notifications_save'); ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="theme-box-1">
                        <div class="card theme-card-box notifications-email-templates">
                            <div class="card-header">
                                <button class="btn btn-link">
                                    <?php echo md_the_admin_icon(array('icon' => 'email_template')); ?>
                                    <?php echo $this->lang->line('notifications_email_template'); ?>
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <select class="form-control w-100 theme-select notifications-email-template-select">
                                        <option disabled selected>
                                            <?php echo $this->lang->line('notifications_select_template'); ?>
                                        </option>
                                        <?php
                                        
                                        // Get email's templates
                                        $email_templates = the_admin_notifications_email_templates();

                                        // Get all templates
                                        $get_templates = $this->base_model->the_data_where('notifications_templates', '*');

                                        // Set all templates
                                        $all_templates = !empty($get_templates)?array_column($get_templates, 'template_slug'):array();

                                        // Verify if email's templates exists
                                        if ( $email_templates ) {

                                            // List email's templates
                                            foreach ( $email_templates as $email_template ) {

                                                // Get key
                                                $key = key($email_template);

                                                // Verify if array already exists
                                                if ( in_array($key, $all_templates ) ) {
                                                    continue;
                                                }

                                                // Display option
                                                echo '<option value="' . $key . '">'
                                                        . $email_template[$key]['template_name']
                                                    . '</option>';

                                            }

                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo form_close() ?>
</div>

<script language="javascript">
    
    // Words list
    var words = {
        "no_placeholders_found": "<?php echo $this->lang->line('notifications_no_placeholders_found'); ?>"
    };
</script>