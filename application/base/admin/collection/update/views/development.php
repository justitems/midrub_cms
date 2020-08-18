<section class="section admin-page">
    <div class="container-fluid">
        <div class="update-page">
            <div class="row">
                <div class="col-lg-2 col-lg-offset-1">
                    <div class="row">
                        <div class="col-lg-12">
                            <?php md_include_component_file(MIDRUB_BASE_ADMIN_UPDATE . 'views/menu.php'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-12 update-area">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <i class="icon-cloud-download"></i>
                                    <?php echo $this->lang->line('update_available_updates'); ?>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <p><?php echo $this->lang->line('update_in_development'); ?></p>
                                        </div>
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

<?php md_include_component_file(MIDRUB_BASE_ADMIN_UPDATE . 'views/footer.php'); ?>