<div class="menu-page">
    <div class="row">
        <div class="col-lg-12">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <div class="row">
                            <div class="col-lg-6 col-xs-6">
                                <div class="dropdown">
                                    <button class="btn btn-secondary menu-dropdown-btn dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                        <?php
                                        echo $this->lang->line('frontend_select_menu');
                                        ?>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdown-items">
                                        <div class="card">
                                            <div class="card-body">
                                                <ul class="list-group menu-dropdown-list-ul">
                                                    <?php
                                                    if (md_the_frontend_menu_list()) {

                                                        foreach (md_the_frontend_menu_list() as $menu) {

                                                            // Get slug
                                                            $slug = array_keys($menu);

                                                            echo '<li class="list-group-item">'
                                                                . '<a href="#" data-slug="' . $slug[0] . '">'
                                                                . $menu[$slug[0]]['name']
                                                                . '</a>'
                                                                . '</li>';
                                                        }
                                                    } else {

                                                        echo '<li class="list-group-item no-results-found">'
                                                            . $this->lang->line('frontend_no_menu_found')
                                                            . '</li>';
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-xs-6">
                                <button type="submit" class="btn btn-success new-menu-item">
                                    <?php
                                    echo $this->lang->line('frontend_new_menu_item');
                                    ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 show-menu-items">
            
        </div>
    </div>
</div>

<?php echo form_open('admin/frontend', array('class' => 'save-settings', 'data-csrf' => $this->security->get_csrf_token_name())) ?>
<?php echo form_close() ?>

<div class="theme-menu-save-changes">
    <div class="col-xs-6">
        <p><?php echo $this->lang->line('frontend_settings_you_have_unsaved_changes'); ?></p>
    </div>
    <div class="col-xs-6 text-right">
        <button type="button" class="btn btn-default">
            <i class="far fa-save"></i>
            <?php echo $this->lang->line('frontend_settings_save_changes'); ?>
        </button>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="create-menu-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?php echo form_open('admin/frontend', array('class' => 'create-menu-item', 'data-csrf' => $this->security->get_csrf_token_name())) ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('frontend_new_menu_item'); ?></h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="frontend-select-menu-item-parent-list">
                        <?php echo $this->lang->line('frontend_select_menu_item_parent'); ?>
                    </label>
                    <select class="form-control" id="frontend-select-menu-item-parent-list">
                        <option value="" disabled selected>
                            <?php echo $this->lang->line('frontend_select_menu_item'); ?>
                        </option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <?php echo $this->lang->line('frontend_cancel'); ?>
                </button>
                <button type="submit" class="btn btn-primary">
                    <?php echo $this->lang->line('frontend_save'); ?>
                </button>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>