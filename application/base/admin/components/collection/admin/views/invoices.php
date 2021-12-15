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
                                    <input type="text" class="form-control admin-search-for-invoices" id="admin-search-for-invoices" placeholder="<?php echo $this->lang->line('admin_search_for_invoices'); ?>" />
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
                            <a href="<?php echo site_url('admin/admin?p=invoices&template=1'); ?>" class="btn btn-secondary theme-background-new theme-font-2">
                                <?php echo md_the_admin_icon(array('icon' => 'print')); ?>
                                <?php echo $this->lang->line('admin_template'); ?>
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
                            <button type="button" class="btn btn-secondary theme-button-1 admin-delete-invoices">
                                <?php echo md_the_admin_icon(array('icon' => 'delete')); ?>
                                <?php echo $this->lang->line('admin_delete'); ?>
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
                        <nav aria-label="invoices">
                            <ul class="theme-pagination" data-type="invoices">
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>