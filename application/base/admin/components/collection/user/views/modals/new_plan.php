<!-- Modal -->
<div class="modal fade theme-modal" id="new-plan" tabindex="-1" role="dialog" aria-labelledby="new-plan-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?php echo form_open('admin/plans', array('class' => 'create-plan', 'method' => 'post', 'data-csrf' => $this->security->get_csrf_token_name())); ?>
            <div class="modal-header">
                <h5 class="modal-title theme-color-black">
                    <?php echo $this->lang->line('user_new_plan'); ?>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> 
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label class="theme-label">
                        <?php echo $this->lang->line('user_plan_name'); ?>
                    </label>
                    <input type="text" placeholder="<?php echo $this->lang->line('user_enter_plan_name'); ?>" class="plan_name form-control theme-text-input-1" required>
                </div>
                <div class="form-group">
                    <label class="theme-label">
                        <?php echo $this->lang->line('user_plan_group'); ?>
                    </label>

                    <div class="input-group">
                        <div class="dropdown theme-dropdown-1">
                            <button type="button" class="btn btn-default dropdown-toggle d-flex justify-content-between align-items-start select-plans-group" aria-haspopup="true" aria-expanded="false" data-bs-toggle="dropdown">                                
                                <span>
                                    <?php echo $this->lang->line('user_select_plan_group'); ?>
                                </span>
                                <?php echo md_the_admin_icon(array('icon' => 'arrow_down', 'class' => 'theme-dropdown-arrow-icon')); ?>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdown-items">
                                <input type="text" placeholder="<?php echo $this->lang->line('user_search_for_groups'); ?>" class="plans-search-groups">
                                <div>
                                    <ul class="list-group plans-groups-list">
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-default manage-plan-groups collapsed input-group-text theme-button-1" aria-expanded="false" data-bs-toggle="collapse" data-bs-target="#manage-plan-groups-list">
                            <?php echo md_the_admin_icon(array('icon' => 'settings')); ?>
                        </button>
                    </div>
                </div>
                <div class="form-group manage-plan-groups-list collapse" aria-expanded="false" id="manage-plan-groups-list">
                    <div class="input-group mt-3">
                        <input type="text" class="form-control theme-text-input-1 enter-group-name" placeholder="<?php echo $this->lang->line('user_enter_plan_group_name'); ?>" aria-describedby="enter-group-name">
                        <button class="btn btn-primary theme-button-1 input-group-text save-plan-group" type="button">
                            <?php echo $this->lang->line('user_create_plan_group'); ?>
                        </button>
                    </div>
                    <div class="card theme-card-box">
                        <div class="card-body ps-0 pe-0">
                            <ul class="list-group theme-card-box-list plans-groups-by-page"></ul>
                        </div>
                        <div class="card-footer">
                            <nav aria-label="Page navigation">
                                <ul class="theme-pagination" data-type="plans-groups">
                                </ul>
                            </nav>
                        </div>                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">
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