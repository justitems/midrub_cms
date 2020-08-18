<?php

// Get role's data
$role_data = md_the_component_variable('role_data');

?>
<div class="theme-box role">
    <div class="panel panel-default">
        <div class="panel-body">
            <?php echo form_open('user/teams', array('class' => 'update-role', 'data-csrf' => $this->security->get_csrf_token_name())) ?>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12">
                            <label for="member-role-name">
                                <?php echo $this->lang->line('member_role_name'); ?>
                            </label>                    
                            <input type="text" class="form-control role-name" value="<?php echo $role_data['role']; ?>" placeholder="<?php echo $this->lang->line('enter_role_name'); ?>" aria-describedby="role-name" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <?php echo the_member_permissions($role_data['role_id']); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php echo form_close() ?>                               
        </div>
    </div>
</div>