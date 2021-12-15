<!-- Modal -->
<div class="modal fade theme-modal" id="support-categories-popup-manager" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title theme-color-black">
                    <?php echo $this->lang->line('categories'); ?>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer d-inline">
                <div class="row">
                    <div class="col-12 text-start">
                        <a href="#support-new-category-link" role="button" class="support-new-category-link" aria-expanded="false" aria-controls="support-new-category-link" data-bs-toggle="collapse">
                            <?php echo $this->lang->line('support_new_category'); ?>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="collapse" id="support-new-category-link">
                            <div class="card card-body p-0 mt-3 border-0">
                                <?php echo form_open('admin/frontend', array('class' => 'create-category', 'data-csrf' => $this->security->get_csrf_token_name())) ?>
                                <div class="form-group">
                                    <div class="dropdown theme-dropdown-1">
                                        <button type="button" class="btn dropdown-toggle d-flex justify-content-between support-category-select-parent" aria-expanded="false" data-bs-toggle="dropdown">
                                            <span>
                                                <?php echo $this->lang->line('support_select_a_parent'); ?>
                                            </span>
                                            <?php echo md_the_admin_icon(array('icon' => 'arrow_down', 'class' => 'theme-dropdown-arrow-icon')); ?>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdown-items">
                                            <input type="text" class="search-dropdown-items support-search-for-categories-parents" placeholder="<?php echo $this->lang->line('support_search_for_parents'); ?>">
                                            <div>
                                                <ul class="list-group support-category-parents-list-ul">
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xs-12 theme-tabs">
                                            <ul class="nav nav-tabs nav-justified mt-3 mb-3">
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
                                                        $active = ' active';
                                                    }

                                                    echo '<li class="nav-item">'
                                                        . '<a href="#category-' . $only_dir . '" class="nav-link' . $active . '" data-toggle="tab">'
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
                                                        $active = ' show active';
                                                    }

                                                    ?>
                                                    <div id="category-<?php echo $only_dir; ?>" class="tab-pane fade<?php echo $active; ?>" data-lang="<?php echo $only_dir; ?>">
                                                        <input type="text" class="form-control theme-text-input-1 mb-3 category-name" placeholder="<?php echo ucfirst($only_dir) . ' ' . $this->lang->line('category_name'); ?>" required>
                                                    </div>
                                                    <?php
                                                }

                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary support-save-category">
                                                <?php echo $this->lang->line('support_save'); ?>
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