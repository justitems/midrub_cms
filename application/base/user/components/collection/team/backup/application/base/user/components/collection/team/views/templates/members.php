<div class="team-list theme-box">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="members-header">
                <div class="row">
                    <div class="col-6">
                        <label>
                            <input type="checkbox" id="all-members-select" />
                            <span class="checkmark"></span>
                        </label>
                        <div class="dropdown">
                            <a class="btn btn-secondary members-actions dropdown-toggle" href="#" role="button" id="members-action" data-name="<?php echo $this->security->get_csrf_token_name(); ?>" data-value="<?php echo $this->security->get_csrf_hash(); ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php echo $this->lang->line('actions'); ?>
                                <svg class="bi bi-chevron-down" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                                </svg>
                            </a>

                            <div class="dropdown-menu actions-members" aria-labelledby="members-action">
                                <a class="dropdown-item" href="#" data-id="0">
                                    <?php echo $this->lang->line('active'); ?>
                                </a>
                                <a class="dropdown-item" href="#" data-id="1">
                                    <?php echo $this->lang->line('inactive'); ?>
                                </a>
                                <a class="dropdown-item" href="#" data-id="2">
                                    <?php echo $this->lang->line('delete'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 text-right">
                        <a href="<?php echo site_url('user/team?p=members&new-member=1'); ?>" class="btn btn-secondary theme-background-blue new-member">
                            <svg class="bi bi-person-plus" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M11 14s1 0 1-1-1-4-6-4-6 3-6 4 1 1 1 1h10zm-9.995-.944v-.002.002zM1.022 13h9.956a.274.274 0 00.014-.002l.008-.002c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664a1.05 1.05 0 00.022.004zm9.974.056v-.002.002zM6 7a2 2 0 100-4 2 2 0 000 4zm3-2a3 3 0 11-6 0 3 3 0 016 0zm4.5 0a.5.5 0 01.5.5v2a.5.5 0 01-.5.5h-2a.5.5 0 010-1H13V5.5a.5.5 0 01.5-.5z" clip-rule="evenodd"/>
                                <path fill-rule="evenodd" d="M13 7.5a.5.5 0 01.5-.5h2a.5.5 0 010 1H14v1.5a.5.5 0 01-1 0v-2z" clip-rule="evenodd"/>
                            </svg>
                            <?php echo $this->lang->line('new_team_member'); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="members-list">
                
            </div>
        </div>
        <div class="panel-footer">
            <div class="pagination-area">
                <div class="row">
                    <div class="col-6">
                        <h6>
                        </h6>
                    </div>
                    <div class="col-6 text-right">
                        <nav>
                            <ul class="pagination" data-type="roles">
                                <li class="pagehide page-item">
                                    <a href="#" class="page-link">
                                        <span></span>
                                    </a>
                                </li>
                                <li class="page-item pagehide">
                                    <a href="#" class="page-link" data-page="2">
                                        <span></span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>