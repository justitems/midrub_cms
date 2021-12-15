<section class="section settings-page">
    <div class="container-fluid">
        <div class="row theme-row-equal">
            <div class="col-xl-2 col-lg-3 col-md-4 theme-sidebar-menu">
                <?php md_include_component_file( CMS_BASE_ADMIN_COMPONENTS_SETTINGS . 'views/menu.php'); ?>
            </div>
            <div class="col-xl-10 col-lg-9 col-md-8 pt-3 settings-view">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="theme-box-1">
                            <nav class="navbar navbar-default theme-navbar-1">
                                <div class="navbar-header ps-3 pe-3 pt-2 pb-2">
                                    <div class="row">
                                        <div class="col-12">
                                            <a href="#" class="btn-option theme-button-2 settings-new-api-app" data-bs-toggle="modal" data-bs-target="#settings-new-application">
                                                <?php echo md_the_admin_icon(array('icon' => 'api_add')); ?>
                                                <?php echo $this->lang->line('api_new_app'); ?>
                                            </a>
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
                            <div class="card-body p-0"></div>
                            <div class="card-footer theme-box-1">
                                <div class="row">
                                    <div class="col-md-5 col-12">
                                        <h6 class="theme-color-black"></h6>
                                    </div>
                                    <div class="col-md-7 col-12 text-end">
                                        <nav aria-label="applications">
                                            <ul class="theme-pagination" data-type="applications">
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

<?php md_get_the_file(CMS_BASE_ADMIN_COMPONENTS_SETTINGS . 'views/modals/new_application.php'); ?>
<?php md_get_the_file(CMS_BASE_ADMIN_COMPONENTS_SETTINGS . 'views/modals/update_application.php'); ?>

<script language="javascript">

    // Words container
    let words = {
        icon_more: '<?php echo md_the_admin_icon(array('icon' => 'more', 'class' => 'ms-0')); ?>',
        icon_delete: '<?php echo md_the_admin_icon(array('icon' => 'delete')); ?>',
        icon_person: '<?php echo md_the_admin_icon(array('icon' => 'person')); ?>'
    }
    
</script>