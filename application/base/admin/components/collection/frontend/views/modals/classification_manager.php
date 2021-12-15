<!-- Modal -->
<div class="modal fade theme-modal" id="classification-popup-manager" tabindex="-1" role="dialog" aria-labelledby="classification-popup-manager-label">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content overflow-visible">
            <div class="modal-header">
                <input type="text" class="search-for-classifications theme-text-input-1 w-75 border-0 p-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="classifications-list">
                </ul>
            </div>
            <div class="modal-footer d-inline">
                <div class="row">
                    <div class="col-12 text-start">
                        <a href="#add-new-classification" role="button" class="new-classification-link" aria-expanded="false" aria-controls="add-new-classification" data-bs-toggle="collapse"></a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="collapse" id="add-new-classification">
                            <div class="card card-body p-0 mt-3 border-0">
                                <?php echo form_open('admin/frontend', array('class' => 'create-classification', 'data-csrf' => $this->security->get_csrf_token_name())) ?>
                                <div class="form-group">
                                    <div class="dropdown theme-dropdown-1">
                                        <button type="button" class="btn dropdown-toggle classification-select-parent d-flex justify-content-between" aria-expanded="false" data-bs-toggle="dropdown">
                                            <span>
                                                <?php echo $this->lang->line('frontend_select_a_parent'); ?>
                                            </span>
                                            <?php echo md_the_admin_icon(array('icon' => 'arrow_down', 'class' => 'theme-dropdown-arrow-icon')); ?>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdown-items">
                                            <input type="text" class="search-dropdown-items search-classifications-parents" placeholder="<?php echo $this->lang->line('frontend_search_for_parents'); ?>">
                                            <div>
                                                <ul class="list-group classification-parents-list-ul">
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
                                                        . '<a href="#classification-' . $only_dir . '" class="nav-link' . $active . '" data-bs-toggle="tab" data-bs-target="#classification-' . $only_dir . '">'
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
                                                        $active = ' show active';
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
                                            <input type="text" class="form-control enter-category-slug theme-text-input-1 mb-3" required>
                                        </div>
                                        <div class="col-xs-6">
                                            <button type="submit" class="btn btn-success save-content">
                                                <?php echo $this->lang->line('frontend_save'); ?>
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