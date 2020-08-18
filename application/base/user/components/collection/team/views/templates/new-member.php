<div class="theme-box create-member">
    <div class="panel panel-default">
        <div class="panel-body">
            <?php echo form_open('user/teams', array('class' => 'new-member', 'data-csrf' => $this->security->get_csrf_token_name())) ?>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12">
                            <label for="member-role">
                                <?php echo $this->lang->line('member_role'); ?>
                            </label>                        
                            <div class="input-group">
                                <div class="dropdown input-group-append">
                                    <a class="btn btn-secondary selected-member-role dropdown-toggle" href="#" role="button" id="member-role" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <?php echo $this->lang->line('select_a_role'); ?>
                                        <svg class="bi bi-chevron-down" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                                        </svg>
                                    </a>

                                    <div class="dropdown-menu member-roles" aria-labelledby="member-role">
                                        <input class="form-control search-roles" id="search-roles" type="text" placeholder="<?php echo $this->lang->line('search_for_roles'); ?>">
                                        <div>
                                        </div>
                                    </div>
                                </div>
                                <a href="<?php echo site_url('user/team?p=members&new-member=1'); ?>" class="btn btn-secondary theme-background-blue new-role input-group-append">
                                    <svg class="bi bi-person-square" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                        <path fill-rule="evenodd" d="M2 15v-1c0-1 1-4 6-4s6 3 6 4v1H2zm6-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                    </svg>
                                    <?php echo $this->lang->line('new_role'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group new-member-role-create">
                    <div class="row">
                        <div class="col-12">
                            <label for="member-first-name">
                                <?php echo $this->lang->line('member_role_name'); ?>
                            </label>                    
                            <input type="text" class="form-control role-name" placeholder="<?php echo $this->lang->line('enter_role_name'); ?>" aria-describedby="role-name" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="button" class="btn theme-background-green btn-create-role">
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
                <div class="form-group">
                    <div class="row">
                        <div class="col-12">
                            <label for="member-first-name">
                                <?php echo $this->lang->line('member_first_name'); ?>
                            </label>
                            <input class="form-control first-name" id="member-first-name" type="text" placeholder="<?php echo $this->lang->line('enter_first_name'); ?>" autocomplete="first-name">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12">
                            <label for="member-last-name">
                                <?php echo $this->lang->line('member_last_name'); ?>
                            </label>
                            <input class="form-control last-name" id="member-last-name" type="text" placeholder="<?php echo $this->lang->line('enter_last_name'); ?>" autocomplete="last-name">
                        </div>
                    </div>
                </div>        
                <div class="form-group">
                    <div class="row">
                        <div class="col-12">
                            <label for="member-username">
                                <?php echo $this->lang->line('member_username'); ?>
                            </label>
                            <input class="form-control username" id="member-username" type="text" placeholder="<?php echo $this->lang->line('enter_username'); ?>" autocomplete="new-username" value="m_" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12">
                            <label for="member-username">
                                <?php echo $this->lang->line('member_email'); ?>
                            </label>                        
                            <input class="form-control email" id="member-email" type="email" placeholder="<?php echo $this->lang->line('enter_email'); ?>" autocomplete="email-address" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12">
                            <label for="member-password">
                                <?php echo $this->lang->line('member_password'); ?>
                            </label>                           
                            <input class="form-control password" id="member-password" type="password" placeholder="<?php echo $this->lang->line('enter_password'); ?>" autocomplete="new-password" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12">
                            <label for="member-status">
                                <?php echo $this->lang->line('member_status'); ?>
                            </label>                          
                            <div class="dropdown">
                                <a class="btn btn-secondary selected-member-status dropdown-toggle" href="#" role="button" id="member-status" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?php echo $this->lang->line('select_a_status'); ?>
                                    <svg class="bi bi-chevron-down" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                                    </svg>
                                </a>

                                <div class="dropdown-menu actions-members" aria-labelledby="member-status">
                                    <div>
                                        <a href="#" class="dropdown-item" data-id="0">
                                            <?php echo $this->lang->line('active'); ?>
                                        </a>
                                        <a href="#" class="dropdown-item" data-id="1">
                                            <?php echo $this->lang->line('inactive'); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-8">
                            <p>
                                <?php echo $this->lang->line('member_send_email'); ?>
                            </p>
                        </div>
                        <div class="col-4 text-right">
                            <div class="checkbox-option">
                                <input id="team-member-send-email" name="team-member-send-email" class="app-option-checkbox" type="checkbox">
                                <label for="team-member-send-email"></label>
                            </div>
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
                                <?php echo $this->lang->line('save_member'); ?>
                            </button>
                        </div>
                    </div>
                </div>
            <?php echo form_close() ?>                               
        </div>
    </div>
</div>