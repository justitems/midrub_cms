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
                                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                        <?php if ( $update ) { ?>
                                            <div class="panel panel-default">
                                                <div class="panel-heading" role="tab" id="headingOne">
                                                    <h4 class="panel-title">
                                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                            <?php echo $update['name'] . ' ' . $update['version']; ?>
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                                    <div class="panel-body">
                                                        <?php echo $update['body']; ?>
                                                    </div>
                                                    <div class="panel-footer">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <?php echo form_open('admin/update', array('class' => 'update-midrub', 'data-csrf' => $this->security->get_csrf_token_name() ) ) ?>
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <?php if ($update['update_code']) { ?>
                                                                            <input type="text" class="form-control code-input" placeholder="<?php echo $this->lang->line('update_enter_update_code'); ?>" required>
                                                                                <?php if ( isset($update['update_code_url']) ) { ?>
                                                                                <button type="button" class="btn btn-primary generate-new-update-code" data-url="<?php echo $update['update_code_url']; ?>">
                                                                                    <?php echo $this->lang->line('update_new_code'); ?>
                                                                                </button>
                                                                                <?php } ?>
                                                                            <?php } ?>
                                                                            <button type="submit" class="btn btn-primary">
                                                                                <?php echo $this->lang->line('update_update_btn'); ?>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                <?php echo form_close() ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } else { ?>
                                            <p><?php echo $this->lang->line('update_updates_available'); ?></p>
                                        <?php } ?>
                                        <?php if ( $restore ) { ?>
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingTwo">
                                                <h4 class="panel-title">
                                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-restore" aria-expanded="false" aria-controls="collapse-restore">
                                                        <?php echo $this->lang->line('update_last_update'); ?>
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapse-restore" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                                <div class="panel-footer">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <form class="form-inline">
                                                                <div class="form-group">
                                                                    <button type="submit" class="btn btn-primary restore-backup pull-right">
                                                                        <?php echo $this->lang->line('update_restore'); ?>
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
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