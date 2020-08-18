<div class="team-list theme-box">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="roles-header">
                <div class="row">
                    <div class="col-6">
                        <label>
                            <input type="checkbox" id="all-roles-select" />
                            <span class="checkmark"></span>
                        </label>
                        <div class="dropdown">
                            <a class="btn btn-secondary roles-actions dropdown-toggle" href="#" role="button" id="roles-action" data-name="<?php echo $this->security->get_csrf_token_name(); ?>" data-value="<?php echo $this->security->get_csrf_hash(); ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php echo $this->lang->line('actions'); ?>
                                <svg class="bi bi-chevron-down" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                                </svg>
                            </a>

                            <div class="dropdown-menu actions-roles" aria-labelledby="roles-action">
                                <a class="dropdown-item" href="#" data-id="2">
                                    <?php echo $this->lang->line('delete'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 text-right">
                        <a href="<?php echo site_url('user/team?p=roles&new-role=1'); ?>" class="btn btn-secondary theme-background-blue new-role">
                            <svg class="bi bi-person-check" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M11 14s1 0 1-1-1-4-6-4-6 3-6 4 1 1 1 1h10zm-9.995-.944v-.002.002zM1.022 13h9.956a.274.274 0 0 0 .014-.002l.008-.002c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664a1.05 1.05 0 0 0 .022.004zm9.974.056v-.002.002zM6 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zm6.854.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"></path>
                            </svg>
                            <?php echo $this->lang->line('new_role'); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="roles-list">

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