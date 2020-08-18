<section class="settings-page">
    <div class="row">
        <div class="col-xl-8 offset-xl-2">
            <h1 class="settings-title">
                <?php echo $this->lang->line('settings'); ?>
                <button class="btn btn-primary settings-save-changes">
                    <i class="far fa-save"></i>
                    <?php echo $this->lang->line('save_changes'); ?>
                </button>
            </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-2 offset-xl-2">
            <div class="settings-menu-group">
                <?php
                get_the_file(MIDRUB_BASE_USER_COMPONENTS_SETTINGS . 'views/menu.php');
                ?>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="settings-list theme-box">
                <div class="tab-content">
                    <div class="tab-pane container fade active show" id="invoices">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="icon-settings"></i>
                                <?php echo $this->lang->line('invoices'); ?>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-12">
                                        <ul class="settings-list-invoices">
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <div class="row">
                                    <div class="col-12">
                                        <ul class="pagination" data-type="settings-invoices"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>