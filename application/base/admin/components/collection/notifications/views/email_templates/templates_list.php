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
                                    <input type="text" class="form-control theme-search-for-emails" id="theme-search-for-emails" placeholder="<?php echo $this->lang->line('notifications_search_for_templates'); ?>" />
                                    <?php echo md_the_admin_icon(array('icon' => 'sync', 'class' => 'theme-list-loader-icon')); ?>
                                    <a href="#" class="theme-cancel-search">
                                        <?php echo md_the_admin_icon(array('icon' => 'cancel')); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="btn-group theme-box-1 theme-button-new" role="group" aria-label="New Email Template">
                            <a href="<?php echo site_url('admin/notifications?p=email_templates'); ?>&new=1" class="btn btn-secondary theme-background-new theme-font-2">
                                <?php echo md_the_admin_icon(array('icon' => 'email_template')); ?>
                                <?php echo $this->lang->line('notifications_new_template'); ?>
                            </a>
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
                        <nav aria-label="emails">
                            <ul class="theme-pagination" data-type="templates">
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>