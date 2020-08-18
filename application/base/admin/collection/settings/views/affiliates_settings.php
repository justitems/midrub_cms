<section>
    <div class="container-fluid settings">
        <div class="row">
            <div class="col-lg-2 col-lg-offset-1">
                <div class="row">
                    <div class="col-lg-12">  
                        <?php md_include_component_file( MIDRUB_BASE_ADMIN_SETTINGS . 'views/menu.php' ); ?>
                    </div>
                </div>                        
            </div>
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-12 settings-area">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a data-toggle="tab" href="#referral-settings">
                                            <i class="fas fa-wrench"></i>
                                            <?php echo $this->lang->line('settings'); ?>
                                        </a>
                                    </li>                                    
                                </ul>
                            </div>
                            <div class="panel-body affiliates-reports">
                                <div class="tab-content">
                                    <div id="referral-settings" class="tab-pane fade in active">
                                        <?php settings_load_options('referrals'); ?>
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

<?php md_include_component_file( MIDRUB_BASE_ADMIN_SETTINGS . 'views/footer.php' ); ?>