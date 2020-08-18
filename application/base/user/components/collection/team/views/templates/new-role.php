<div class="theme-box create-role">
    <div class="panel panel-default">
        <div class="panel-body">
            <?php echo form_open('user/teams', array('class' => 'new-role', 'data-csrf' => $this->security->get_csrf_token_name())) ?>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12">
                            <label for="member-role-name">
                                <?php echo $this->lang->line('member_role_name'); ?>
                            </label>                    
                            <input type="text" class="form-control role-name" placeholder="<?php echo $this->lang->line('enter_role_name'); ?>" aria-describedby="role-name" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 text-right">
                            <button type="submit" class="btn theme-background-green">
                                <svg class="bi bi-file-arrow-up" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M4 1h8a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H4z"/>
                                    <path fill-rule="evenodd" d="M4.646 7.854a.5.5 0 0 0 .708 0L8 5.207l2.646 2.647a.5.5 0 0 0 .708-.708l-3-3a.5.5 0 0 0-.708 0l-3 3a.5.5 0 0 0 0 .708z"/>
                                    <path fill-rule="evenodd" d="M8 12a.5.5 0 0 0 .5-.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 0 .5.5z"/>
                                </svg>
                                <?php echo $this->lang->line('save_role'); ?>
                            </button>
                        </div>
                    </div>
                </div>
            <?php echo form_close() ?>                               
        </div>
    </div>
</div>