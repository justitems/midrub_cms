<section class="section frontend-page" data-display="<?php echo md_the_component_variable('component_display'); ?>" data-order="<?php echo md_the_component_variable('component_order_data'); ?>">
    <div class="container-fluid">
        <div class="left-side">
            <?php md_include_component_file(MIDRUB_BASE_ADMIN_FRONTEND . 'views/menu.php'); ?>
        </div>
        <div class="right-side">
            <?php
            if (md_the_contents_categories()) {
                ?>
                <div class="row">
                    <div class="col-lg-12">
                        <nav class="navbar navbar-default">
                            <div class="container-fluid">
                                <div class="navbar-header">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-xs-8">
                                            <div class="checkbox-option-select">
                                                <input id="frontent-contents-select-all" name="frontent-contents-select-all" type="checkbox">
                                                <label for="frontent-contents-select-all"></label>
                                            </div>
                                            <a href="#" class="btn-option delete-contents">
                                                <i class="icon-trash"></i>
                                                <?php echo $this->lang->line('frontend_delete'); ?>
                                            </a>
                                            <a href="#" class="btn-option" data-toggle="modal" data-target="#<?php echo (md_the_component_variable('component_order_data') === 'auth') ? 'default-components-selector' : 'theme-templates-selector'; ?>">
                                                <i class="icon-doc"></i>
                                                <?php md_get_contents_category_word('new_content'); ?>
                                            </a>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-xs-4">
                                            <div class="input-group">
                                                <span class="input-group-addon" id="basic-addon1">
                                                    <i class="icon-magnifier"></i>
                                                </span>
                                                <input type="text" class="form-control search-contents" placeholder="<?php md_get_contents_category_word('search_content'); ?>">
                                                <input type="hidden" class="csrf-sanitize" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <ul class="list-contents">
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="pagination-area">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-xs-6">
                                    <ul class="pagination">
                                    </ul>
                                </div>
                                <div class="col-lg-6 col-md-6 col-xs-6 text-right">
                                    <p>
                                        <span>
                                            <span class="pagination-from"></span>
                                            –
                                            <span class="pagination-to"></span>
                                        </span>
                                        <?php
                                        echo $this->lang->line('frontend_of');
                                        ?>
                                        <span class="pagination-total"></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php

            } else {

                ?>
                <div class="row">
                    <div class="col-lg-12">
                        <nav class="navbar navbar-default">
                            <div class="container-fluid">
                                <div class="navbar-header">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <p>
                                                <?php
                                                echo $this->lang->line('frontend_no_data_found_to_show');
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
            <?php

            }
            ?>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="default-components-selector" tabindex="-1" role="dialog" aria-labelledby="default-components-selector-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?php echo form_open('admin/frontend?p=editor&category=auth', array('class' => 'create-content', 'data-csrf' => $this->security->get_csrf_token_name())) ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="default-components-selector-label">
                    <?php echo $this->lang->line('frontend_set_auth_components'); ?>
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="contents-option-field-auth_components">
                        <?php echo $this->lang->line('frontend_select_auth_component'); ?>
                    </label>
                    <select class="form-control" id="contents-option-field-auth_components" required>
                        <?php
                        $auth_components = md_the_auth_components();
                        if ($auth_components) {

                            foreach ($auth_components as $component) {

                                echo '<option value="' . $component['slug'] . '">' . $component['name'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <?php echo $this->lang->line('frontend_cancel'); ?>
                </button>
                <button type="submit" class="btn btn-primary">
                    <?php echo $this->lang->line('frontend_create'); ?>
                </button>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="theme-templates-selector" tabindex="-1" role="dialog" aria-labelledby="theme-templates-selector-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?php echo form_open('admin/frontend?p=editor&category=' . md_the_component_variable('component_order_data'), array('class' => 'create-content', 'data-csrf' => $this->security->get_csrf_token_name())) ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="theme-templates-selector-label">
                    <?php echo $this->lang->line('frontend_templates'); ?>
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="contents-option-field-theme-template">
                        <?php echo $this->lang->line('frontend_select_templates'); ?>
                    </label>
                    <select class="form-control" id="contents-option-field-theme-template" required>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <?php echo $this->lang->line('frontend_cancel'); ?>
                </button>
                <button type="submit" class="btn btn-primary">
                    <?php echo $this->lang->line('frontend_create'); ?>
                </button>
            </div>
            <?php echo form_close() ?>
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