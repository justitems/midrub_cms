<section class="section editor-page">
    <div class="container-fluid">
        <div class="left-side">
            <?php md_include_component_file(MIDRUB_BASE_ADMIN_FRONTEND . 'views/menu.php'); ?>
        </div>
        <div class="right-side">
            <?php echo form_open('admin/frontend', array('class' => 'form-editor', 'data-content-category' => md_the_component_variable('contents_category_slug'), 'data-content-id' => md_the_component_variable('content_id') ? md_the_component_variable('content_id') : '0', 'data-csrf' => $this->security->get_csrf_token_name())) ?>
            <div class="row">
                <div class="col-lg-7 col-lg-offset-1">
                    <ul class="nav nav-tabs nav-justified">
                        <?php

                        // Get all languages
                        $languages = glob(APPPATH . 'language' . '/*', GLOB_ONLYDIR);

                        // List all languages
                        foreach ($languages as $language) {

                            // Get language dir name
                            $only_dir = str_replace(APPPATH . 'language' . '/', '', $language);

                            // Active variable
                            $active = '';

                            // Verify if is the configured language
                            if ($this->config->item('language') === $only_dir) {
                                $active = ' class="active"';
                            }

                            echo '<li' . $active . '>'
                                . '<a data-toggle="tab" href="#' . $only_dir . '">'
                                . ucfirst($only_dir)
                                . '</a>'
                                . '</li>';
                        }

                        ?>
                    </ul>
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
                                $active = ' in active';
                            }

                            ?>
                            <div id="<?php echo $only_dir; ?>" class="tab-pane fade<?php echo $active; ?>">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input type="text" class="form-control input-form content-title" value="<?php md_get_single_content_meta('content_title', $only_dir); ?>" placeholder="<?php echo md_the_contents_category_word('enter_content_title'); ?>">
                                        <button type="button" class="frontend-compose-url" data-toggle="modal" data-target="#page-url-composer">
                                            <i class="icon-link"></i>
                                        </button>
                                    </div>
                                </div>
                                <?php
                                if (md_the_component_variable('contents_category')['editor']) {
                                    ?>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div id="summernote" class="summernote-body body-<?php echo $only_dir; ?>" data-dir="body-<?php echo $only_dir; ?>"></div>
                                            <textarea class="content-body content-body-<?php echo $only_dir; ?> hidden"><?php md_get_single_content_meta('content_body', $only_dir); ?></textarea>
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
                            <div class="row">
                                <div class="col-lg-6">
                                    <select class="content-status">
                                        <option value="1" <?php echo (md_the_component_variable('content_status') > 0) ? ' selected' : ''; ?>>
                                            <?php echo $this->lang->line('frontend_publish'); ?>
                                        </option>
                                        <option value="0" <?php echo (md_the_component_variable('content_status') < 1) ? ' selected' : ''; ?>>
                                            <?php echo $this->lang->line('frontend_draft'); ?>
                                        </option>
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <button type="submit" class="btn btn-success save-content">
                                        <?php echo $this->lang->line('frontend_save'); ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    md_get_all_contents_categories_options();
                    ?>
                </div>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="page-url-composer" tabindex="-1" role="dialog" aria-labelledby="page-url-composer-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?php echo form_open('admin/frontend', array('class' => 'update-content-url', 'data-csrf' => $this->security->get_csrf_token_name())) ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="theme-templates-selector-label">
                    <?php echo $this->lang->line('frontend_url_builder'); ?>
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" class="form-control url-slug-input" placeholder="<?php echo $this->lang->line('frontend_enter_url_builder'); ?>" required>
                        <span class="input-group-btn">
                            <button type="submit" class="input-group-addon btn-default">
                                <?php echo $this->lang->line('frontend_save'); ?>
                            </button>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group url-preview">
                        <?php
                        if (md_the_component_variable('content_slug')) {
                            ?>
                            <?php echo base_url(); ?><?php echo md_the_component_variable('contents_category')['slug_in_url'] ? '<span class="category-slug" data-slug="' . md_the_component_variable('contents_category_slug') . '">' . md_the_component_variable('contents_category_slug') . '</span>/' : ''; ?><span class="url-slug" data-slug="<?php echo str_replace(md_the_component_variable('contents_category_slug') . '/', '', md_the_component_variable('content_slug')); ?>"><?php echo str_replace(md_the_component_variable('contents_category_slug') . '/', '', md_the_component_variable('content_slug')); ?></span>
                        <?php
                        } else {
                            ?>
                            <?php echo base_url(); ?><?php echo md_the_component_variable('contents_category')['slug_in_url'] ? '<span class="category-slug" data-slug="' . md_the_component_variable('contents_category_slug') . '">' . md_the_component_variable('contents_category_slug') . '</span>/' : ''; ?><span class="url-slug">(content-id)</span>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="multimedia-manager" tabindex="-1" role="dialog" aria-labelledby="multimedia-manager-label">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <ul class="nav nav-tabs nav-justified">
                    <li class="active">
                        <a data-toggle="tab" href="#multimedia-gallery">
                            <i class="fas fa-photo-video"></i>
                            <?php echo $this->lang->line('frontend_multimedia_gallery'); ?>
                        </a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#multimedia-upload">
                            <i class="fas fa-upload"></i>
                            <?php echo $this->lang->line('frontend_multimedia_upload'); ?>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="modal-body">
                <div class="tab-content tab-all-editors">
                    <div id="multimedia-gallery" class="tab-pane fade in active">
                        <div class="row multimedia-gallery-items">
                        </div>
                        <div class="row multimedia-pagination">
                            <div class="col-xs-12">
                                <a href="#" class="btn-option btn-load-old-media">
                                    <i class="icon-refresh"></i>
                                    <?php echo $this->lang->line('frontend_load_more_files'); ?>
                                </a>
                            </div>
                        </div>                        
                    </div>
                    <div id="multimedia-upload" class="tab-pane fade">
                        <div class="drag-and-drop-files">
                            <div>
                                <i class="icon-cloud-upload"></i><br>
                                <?php echo $this->lang->line('frontend_drag_files_here'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer hidden">
                <?php
                $attributes = array('class' => 'upim hidden', 'id' => 'upim', 'method' => 'post', 'data-csrf' => $this->security->get_csrf_token_name());
                echo form_open_multipart('admin/frontend', $attributes);
                ?>
                <input type="hidden" name="type" id="type" value="video">
                <input type="file" name="file[]" id="file" accept=".gif,.jpg,.jpeg,.png,.mp4,.avi" multiple>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="classification-popup-manager" tabindex="-1" role="dialog" aria-labelledby="classification-popup-manager-label">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <input type="text" class="form-control search-for-classifications">
            </div>
            <div class="modal-body">
                <ul class="classifications-list">
                </ul>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-xs-6">
                        <a href="#add-new-classification" class="new-classification-link" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="add-new-classification">
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="collapse" id="add-new-classification">
                            <div class="card card-body">
                                <?php echo form_open('admin/frontend', array('class' => 'create-classification', 'data-csrf' => $this->security->get_csrf_token_name())) ?>
                                <div class="form-group">
                                    <div class="dropdown" data-option="settings_home_page">
                                        <button class="btn btn-secondary dropdown-toggle classification-select-parent" type="button" data-toggle="dropdown" aria-expanded="false">
                                            <?php echo $this->lang->line('frontend_select_a_parent'); ?>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdown-items">
                                            <div class="card">
                                                <div class="card-head">
                                                    <input type="text" class="search-dropdown-items search-classifications-parents" placeholder="<?php echo $this->lang->line('frontend_search_for_parents'); ?>">
                                                </div>
                                                <div class="card-body">
                                                    <ul class="list-group classification-parents-list-ul">
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <ul class="nav nav-tabs nav-justified">
                                                <?php

                                                // Get all languages
                                                $languages = glob(APPPATH . 'language' . '/*', GLOB_ONLYDIR);

                                                // List all languages
                                                foreach ($languages as $language) {

                                                    // Get language dir name
                                                    $only_dir = str_replace(APPPATH . 'language' . '/', '', $language);

                                                    // Active variable
                                                    $active = '';

                                                    // Verify if is the configured language
                                                    if ($this->config->item('language') === $only_dir) {
                                                        $active = ' class="active"';
                                                    }

                                                    echo '<li' . $active . '>'
                                                        . '<a data-toggle="tab" href="#classification-' . $only_dir . '">'
                                                            . ucfirst($only_dir)
                                                        . '</a>'
                                                    . '</li>';
                                                }

                                                ?>
                                            </ul>
                                            <div class="tab-content tab-all-classifications">
                                                <?php

                                                // List all languages
                                                foreach ($languages as $language) {

                                                    // Get language dir name
                                                    $only_dir = str_replace(APPPATH . 'language' . '/', '', $language);

                                                    // Active variable
                                                    $active = '';

                                                    // Verify if is the configured language
                                                    if ($this->config->item('language') === $only_dir) {
                                                        $active = ' in active';
                                                    }

                                                    ?>
                                                    <div id="classification-<?php echo $only_dir; ?>" class="tab-pane fade<?php echo $active; ?>">
                                                    </div>
                                                <?php
                                                }

                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <input type="text" class="form-control enter-category-slug" required>
                                        </div>
                                        <div class="col-xs-6">
                                            <button type="submit" class="btn btn-success save-content">
                                                Save
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loader -->
<div class="page-loading">
    <div class="loading-animation-area">
        <div class="loading-center-absolute">
            <div class="object object_four"></div>
            <div class="object object_three"></div>
            <div class="object object_two"></div>
            <div class="object object_one"></div>
        </div>
    </div>
</div>