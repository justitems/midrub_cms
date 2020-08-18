<section class="section user-page">
    <div class="container-fluid">
        <div class="left-side">
            <?php md_include_component_file(MIDRUB_BASE_ADMIN_USER . '/views/menu.php'); ?>
        </div>
        <div class="right-side">
            <?php md_get_the_user_page_content(md_the_component_variable('component_display')); ?>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="new-plan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?php echo form_open('admin/plans', array('class' => 'create-plan', 'method' => 'post', 'data-csrf' => $this->security->get_csrf_token_name())); ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('user_new_plan'); ?></h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>
                        <?php echo $this->lang->line('user_plan_name'); ?>
                    </label>
                    <input type="text" class="plan_name" class="form-control" placeholder="<?php echo $this->lang->line('user_enter_plan_name'); ?>" required>
                </div>
                <div class="form-group">
                    <label>
                        <?php echo $this->lang->line('user_plan_group'); ?>
                    </label>
                    <div class="input-group">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-default dropdown-toggle select-plans-group" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php echo $this->lang->line('user_select_plan_group'); ?>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdown-items">
                                <div class="card">
                                    <div class="card-head">
                                        <input type="text" class="plans-search-groups" placeholder="<?php echo $this->lang->line('user_search_for_groups'); ?>" />
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group plans-groups-list">
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-default manage-plan-groups collapsed" type="button" data-toggle="collapse" data-target="#manage-plan-groups-list" aria-expanded="false">
                            <i class="icon-settings"></i>
                        </button>
                    </div>
                </div>
                <div class="form-group manage-plan-groups-list collapse" aria-expanded="false" id="manage-plan-groups-list">
                    <div class="input-group">
                        <input type="text" class="form-control enter-group-name" placeholder="<?php echo $this->lang->line('user_enter_plan_group_name'); ?>" aria-describedby="enter-group-name">
                        <span class="input-group-addon">
                            <button class="btn btn-primary save-plan-group" type="button">
                                <?php echo $this->lang->line('user_create_plan_group'); ?>
                            </button>
                        </span>
                    </div>
                    <ul class="list-group plans-groups-by-page">
                    </ul>
                    <nav aria-label="Page navigation">
                        <ul class="pagination" data-type="plans-groups">
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <?php echo $this->lang->line('user_cancel'); ?>
                </button>
                <button type="submit" class="btn btn-primary">
                    <?php echo $this->lang->line('user_create'); ?>
                </button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="create-menu-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?php echo form_open('admin/user', array('class' => 'create-menu-item', 'data-csrf' => $this->security->get_csrf_token_name())) ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('user_new_menu_item'); ?></h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="frontend-select-menu-item-parent-list">
                        <?php echo $this->lang->line('user_select_menu_item_parent'); ?>
                    </label>
                    <select class="form-control" id="frontend-select-menu-item-parent-list">
                        <option value="" disabled selected>
                            <?php echo $this->lang->line('user_select_menu_item'); ?>
                        </option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <?php echo $this->lang->line('user_cancel'); ?>
                </button>
                <button type="submit" class="btn btn-primary">
                    <?php echo $this->lang->line('user_save'); ?>
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