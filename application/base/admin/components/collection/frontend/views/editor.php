<section class="section editor-page">
    <div class="container-fluid">
        <div class="row theme-row-equal">
            <div class="col-xl-2 col-lg-3 col-md-4 theme-sidebar-menu">
                <?php md_include_component_file(CMS_BASE_ADMIN_COMPONENTS_FRONTEND . 'views/menu.php'); ?>
            </div>
            <div class="col-xl-10 col-lg-10 col-md-9 frontend-view">
                <?php echo form_open('admin/frontend', array('class' => 'form-editor', 'data-content-category' => md_the_data('contents_category_slug'), 'data-content-id' => md_the_data('content_id') ? md_the_data('content_id') : '0', 'data-csrf' => $this->security->get_csrf_token_name())) ?>
                <div class="row">
                    <div class="col-lg-9 theme-tabs">

                        <?php

                        // Get all languages
                        $languages = glob(APPPATH . 'language' . '/*', GLOB_ONLYDIR);
                        
                        // Verify if languages are more than 1
                        if ( count($languages) > 1 ) {

                        ?>

                        <ul class="nav nav-tabs nav-justified mb-3">
                            <?php

                            // List all languages
                            foreach ($languages as $language) {

                                // Get language dir name
                                $only_dir = str_replace(APPPATH . 'language' . '/', '', $language);

                                // Active variable
                                $active = '';

                                // Verify if is the configured language
                                if ($this->config->item('language') === $only_dir) {
                                    $active = ' active';
                                }

                                echo '<li class="nav-item">'
                                    . '<a href="#' . $only_dir . '" class="nav-link' . $active . '" data-bs-toggle="tab">'
                                        . ucfirst($only_dir)
                                    . '</a>'
                                . '</li>';
                            }

                            ?>
                        </ul>
                        <?php

                        }                   

                        ?>
                        <div class="tab-content tab-all-editors">
                            <?php

                            // List all languages
                            foreach ($languages as $language) {

                                // Get language dir name
                                $only_dir = str_replace(APPPATH . 'language' . '/', '', $language);

                                // Active variable
                                $active = '';

                                // Verify if is the configured language
                                if ($this->config->item('language') === $only_dir) {
                                    $active = ' show active';
                                }

                                ?>
                                <div id="<?php echo $only_dir; ?>" class="tab-pane fade<?php echo $active; ?>">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="position-relative theme-box-1">
                                                <input type="text" class="form-control input-form content-title default-editor-title-input" value="<?php md_get_single_content_meta('content_title', $only_dir); ?>" placeholder="<?php echo md_the_contents_category_word('enter_content_title'); ?>">
                                                <button type="button" class="frontend-compose-url" data-bs-toggle="modal" data-bs-target="#page-url-composer">
                                                    <?php echo md_the_admin_icon(array('icon' => 'link')); ?>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    if (md_the_data('contents_category')['editor']) {
                                        ?>
                                        <div class="row mb-3">
                                            <div class="col-lg-12">
                                                <div class="theme-box-1">
                                                    <div id="summernote" class="summernote-body body-<?php echo $only_dir; ?>" data-dir="body-<?php echo $only_dir; ?>"></div>
                                                    <textarea class="content-body content-body-<?php echo $only_dir; ?> d-none"><?php md_get_single_content_meta('content_body', $only_dir); ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <?php md_get_all_contents_categories_metas($only_dir); ?>
                                </div>
                            <?php
                            }

                            ?>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="theme-box-1">
                                    <div class="row">
                                        <div class="col-12 pt-3 pb-3 ps-4 pe-4 d-flex justify-content-between">
                                            <select class="content-status theme-select">
                                                <option value="1" <?php echo (md_the_data('content_status') > 0) ? ' selected' : ''; ?>>
                                                    <?php echo $this->lang->line('frontend_publish'); ?>
                                                </option>
                                                <option value="0" <?php echo (md_the_data('content_status') < 1) ? ' selected' : ''; ?>>
                                                    <?php echo $this->lang->line('frontend_draft'); ?>
                                                </option>
                                            </select>
                                            <button type="submit" class="btn btn-success theme-button-2">
                                                <?php echo $this->lang->line('frontend_save'); ?>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php md_get_all_contents_categories_options(); ?>
                    </div>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</section>

<?php md_get_the_file(CMS_BASE_ADMIN_COMPONENTS_FRONTEND . 'views/modals/page_url.php'); ?>
<?php md_get_the_file(CMS_BASE_ADMIN_COMPONENTS_FRONTEND . 'views/modals/upload_media.php'); ?>
<?php md_get_the_file(CMS_BASE_ADMIN_COMPONENTS_FRONTEND . 'views/modals/classification_manager.php'); ?>