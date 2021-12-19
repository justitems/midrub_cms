<section class="section frontend-page">
    <div class="container-fluid">
        <div class="row theme-row-equal">
            <div class="col-xl-2 col-lg-3 col-md-4 theme-sidebar-menu">
                <?php md_include_component_file(CMS_BASE_ADMIN_COMPONENTS_FRONTEND . 'views/menu.php'); ?>
            </div>
            <div class="col-xl-10 col-lg-10 col-md-9 frontend-view">
                <?php md_get_the_frontend_page_content(md_the_data('component_display')); ?>
            </div>
        </div>
    </div>
</section>

<?php md_get_the_file(CMS_BASE_ADMIN_COMPONENTS_FRONTEND . 'views/modals/auth_logo.php'); ?>
<?php md_get_the_file(CMS_BASE_ADMIN_COMPONENTS_FRONTEND . 'views/modals/frontend_logo.php'); ?>

<?php md_get_admin_quick_guide(the_frontend_quick_guide()); ?>

<script language="javascript">

    // Words container
    let words = {
        delete: "<?php echo $this->lang->line('frontend_delete'); ?>",
        icon_arrow_down: '<?php echo md_the_admin_icon(array('icon' => 'arrow_down', 'class' => 'theme-dropdown-arrow-icon')); ?>',
        icon_delete: '<?php echo md_the_admin_icon(array('icon' => 'delete')); ?>'
    }
    
</script>