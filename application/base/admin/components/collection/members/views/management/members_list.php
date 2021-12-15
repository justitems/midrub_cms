<div class="row">
    <div class="col-12">
        <div class="card theme-list">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-9 col-12">
                        <div class="theme-box-1">
                            <div class="row">
                                <div class="col-12">
                                    <?php echo md_the_admin_icon(array('icon' => 'search')); ?>
                                    <input type="text" class="form-control theme-search-for-members" id="theme-search-for-members" placeholder="<?php echo $this->lang->line('members_search_for_members'); ?>" />
                                    <?php echo md_the_admin_icon(array('icon' => 'sync', 'class' => 'theme-list-loader-icon')); ?>
                                    <a href="#" class="theme-cancel-search">
                                        <?php echo md_the_admin_icon(array('icon' => 'cancel')); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="btn-group theme-box-1 theme-button-new" role="group" aria-label="New Member">
                            <a href="<?php echo site_url('admin/members?p=all_members'); ?>&new=1" class="btn btn-secondary theme-background-new theme-font-2">
                                <?php echo md_the_admin_icon(array('icon' => 'member_add')); ?>
                                <?php echo $this->lang->line('members_new_member'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-actions theme-box-1">
                <div class="row">
                    <div class="col theme-list-selected-items" data-total="1">
                        <p></p>
                    </div>
                    <div class="col text-end">
                        <div class="btn-group card-actions-advaced" role="group" aria-label="Actions buttons">
                            <button type="button" class="btn btn-secondary theme-button-1 members-delete-members">
                                <?php echo md_the_admin_icon(array('icon' => 'delete')); ?>
                                <?php echo $this->lang->line('members_delete'); ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body"></div>
            <div class="card-footer theme-box-1">
                <div class="row">
                    <div class="col-md-5 col-12">
                        <h6 class="theme-color-black"></h6>
                    </div>
                    <div class="col-md-7 col-12 text-end">
                        <nav aria-label="members">
                            <ul class="theme-pagination" data-type="members">
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>