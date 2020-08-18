<section class="section support-page">
    <div class="container-fluid">
        <div class="left-side">
            <?php md_include_component_file(MIDRUB_BASE_ADMIN_SUPPORT . 'views/menu.php'); ?>
        </div>
        <div class="right-side">
            <?php md_get_the_user_page_content(md_the_component_variable('component_display')); ?>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="categories-popup-manager" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3>
                    <?php echo $this->lang->line('categories'); ?>
                </h3>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-xs-6">
                        <a href="#add-new-category" class="new-category-link" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="add-new-category">
                            <?php echo $this->lang->line('support_new_category'); ?>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="collapse" id="add-new-category">
                            <div class="card card-body">
                                <?php echo form_open('admin/frontend', array('class' => 'create-category', 'data-csrf' => $this->security->get_csrf_token_name())) ?>
                                <div class="form-group">
                                    <div class="dropdown" data-option="settings_home_page">
                                        <button class="btn btn-secondary dropdown-toggle category-select-parent" type="button" data-toggle="dropdown" aria-expanded="false">
                                            <?php echo $this->lang->line('frontend_select_a_parent'); ?>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdown-items">
                                            <div class="card">
                                                <div class="card-body">
                                                    <ul class="list-group category-parents-list-ul">

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
                                                        . '<a data-toggle="tab" href="#category-' . $only_dir . '">'
                                                            . ucfirst($only_dir)
                                                        . '</a>'
                                                    . '</li>';
                                                }

                                                ?>
                                            </ul>
                                            <div class="tab-content tab-all-categories">
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
                                                    <div id="category-<?php echo $only_dir; ?>" class="tab-pane fade<?php echo $active; ?>" data-lang="<?php echo $only_dir; ?>">
                                                        <input type="text" class="form-control category-name" placeholder="<?php echo ucfirst($only_dir) . ' ' . $this->lang->line('category_name'); ?>" required>
                                                    </div>
                                                    <?php
                                                }

                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-6">

                                        </div>
                                        <div class="col-xs-6">
                                            <button type="submit" class="btn btn-success save-content">
                                                <?php echo $this->lang->line('save'); ?>
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