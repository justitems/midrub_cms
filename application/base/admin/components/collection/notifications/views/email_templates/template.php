<div class="notifications-email-template">
    <?php echo form_open('admin/notifications', array('class' => 'notifications-update-email-template', 'data-template' => $this->input->get('template', true), 'data-csrf' => $this->security->get_csrf_token_name())) ?>
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

                    // Set template's title
                    $template_title = isset(md_the_data('template')[$only_dir]['template_title'])?md_the_data('template')[$only_dir]['template_title']:'';

                    // Set template's body
                    $template_body = isset(md_the_data('template')[$only_dir]['template_body'])?md_the_data('template')[$only_dir]['template_body']:'';

                    // Display the tab
                    echo '<div id="' . $only_dir . '" class="tab-pane fade' . $active . '">'
                        . '<div class="row">'
                            . '<div class="col-lg-12">'
                                . '<div class="theme-box-1">'
                                    . '<input type="text" class="form-control input-form article-title default-editor-title-input" placeholder="' . $this->lang->line('enter_article_title') . '" value="' . $template_title . '">'
                                . '</div>'
                            . '</div>'
                        . '</div>'
                        . '<div class="row mb-3">'
                            . '<div class="col-lg-12">'
                                . '<div class="theme-box-1">'
                                    . '<div class="summernote-body body-' . $only_dir . '" data-dir="body-' . $only_dir . '"></div>'
                                    . '<textarea class="article-body content-body-' . $only_dir . ' hidden">' . $template_body . '</textarea>'
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
                                            . the_admin_notifications_selected_template_placeholders(md_the_data('template')['template_slug'])
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
            <?php echo get_admin_notifications_selected_template(md_the_data('template')['template_slug']); ?>
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