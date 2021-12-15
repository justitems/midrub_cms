<div class="row mt-3">
    <div class="col-lg-12">
        <div class="theme-box-1">
            <nav class="navbar navbar-default theme-navbar-1">
                <div class="navbar-header ps-3 pe-3 pt-1 pb-1">
                    <div class="row">
                        <div class="col-12">
                            <div class="dropdown theme-dropdown-1 notifications-advanced-filters-users-btn" id="notifications-advanced-filters-users">
                                <button type="button" class="btn btn-secondary d-flex justify-content-between align-items-start frontend-menu-dropdown-btn" aria-expanded="false" data-bs-toggle="dropdown">
                                    <span>
                                        <?php echo $this->lang->line('notifications_all_users'); ?>
                                    </span>
                                    <?php echo md_the_admin_icon(array('icon' => 'arrow_down', 'class' => 'theme-dropdown-arrow-icon')); ?>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdown-items">
                                    <input type="text" class="notifications-search-errors-users" placeholder="<?php echo $this->lang->line('notifications_search_for_users'); ?>" />
                                    <div>
                                        <ul class="list-group notifications-errors-users-list"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>            
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card theme-list">
            <div class="card-body"></div>
            <div class="card-footer theme-box-1">
                <div class="row">
                    <div class="col-md-5 col-12">
                        <h6 class="theme-color-black"></h6>
                    </div>
                    <div class="col-md-7 col-12 text-end">
                        <nav aria-label="system-errors">
                            <ul class="theme-pagination" data-type="system-errors">
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>