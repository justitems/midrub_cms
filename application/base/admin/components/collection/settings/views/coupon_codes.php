<section class="section settings-page">
    <div class="container-fluid">
        <div class="row theme-row-equal">
            <div class="col-xl-2 col-lg-3 col-md-4 theme-sidebar-menu">
                <?php md_include_component_file( CMS_BASE_ADMIN_COMPONENTS_SETTINGS . 'views/menu.php'); ?>
            </div>
            <div class="col-xl-10 col-lg-9 col-md-8 pt-3 pb-3 settings-view">
                <div class="row">
                    <div class="col-md-6">
                        <div class="p-3 theme-box-1">
                            <div class="row coupon-code">
                                <?php echo form_open('admin/settings?p=coupon-codes', array('class' => 'coupon-codes')) ?>
                                    <div class="form-group mb-3">
                                        <input type="number" name="value" max="100" placeholder="<?php echo $this->lang->line('settings_enter_discount'); ?>" class="theme-number-input-1" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <select name="type" class="theme-select">
                                            <option value="0">
                                                <?php echo $this->lang->line('settings_the_coupon_code_resused'); ?>
                                            </option>
                                            <option value="1">
                                                <?php echo $this->lang->line('settings_the_coupon_code_once'); ?>
                                            </option>
                                        </select>
                                    </div>                        
                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-primary theme-button-1">
                                            <?php echo $this->lang->line('settings_save_coupon'); ?>
                                        </button>
                                    </div>
                                <?php echo form_close() ?>
                            </div>
                            <?php if ( $alert ) { ?>
                            <script language="javascript">
                                setTimeout( function() {
                                    Main.show_alert( '<?php echo $alert[0]; ?>', '<?php echo $alert[1]; ?>', 1500, 2000);
                                    Main.get_coupon_codes(1);
                                }, 1500);
                            </script>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="theme-box-1">
                                        <nav class="navbar navbar-default theme-navbar-1">
                                            <div class="navbar-header ps-3 pe-3 pt-2 pb-2">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <?php echo $this->lang->line('settings_coupon_codes'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card theme-list mb-0">
                                        <div class="card-body p-0"></div>
                                        <div class="card-footer theme-box-1">
                                            <div class="row">
                                                <div class="col-md-5 col-12">
                                                    <h6 class="theme-color-black"></h6>
                                                </div>
                                                <div class="col-md-7 col-12 text-end">
                                                    <nav aria-label="codes">
                                                        <ul class="theme-pagination" data-type="codes">
                                                        </ul>
                                                    </nav>
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
        </div>
    </div>
</section>

<script language="javascript">

    // Words container
    let words = {
        icon_more: '<?php echo md_the_admin_icon(array('icon' => 'more', 'class' => 'ms-0')); ?>',
        icon_delete: '<?php echo md_the_admin_icon(array('icon' => 'delete')); ?>',
        icon_person: '<?php echo md_the_admin_icon(array('icon' => 'person')); ?>'
    }
    
</script>