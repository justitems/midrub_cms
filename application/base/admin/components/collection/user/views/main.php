<section class="section user-page">
    <div class="container-fluid">
        <div class="row theme-row-equal">
            <div class="col-xl-2 col-lg-3 col-md-4 theme-sidebar-menu">
                <?php md_include_component_file(CMS_BASE_ADMIN_COMPONENTS_USER . '/views/menu.php'); ?>
            </div>
            <div class="col-xl-10 col-lg-9 col-md-8 user-view">
                <?php md_get_the_user_page_content(md_the_data('component_display')); ?>
            </div>
        </div>
    </div>
</section>

<?php md_get_the_file(CMS_BASE_ADMIN_COMPONENTS_USER . 'views/modals/new_plan.php'); ?>
<?php md_get_the_file(CMS_BASE_ADMIN_COMPONENTS_USER . 'views/modals/new_item.php'); ?>
<?php md_get_the_file(CMS_BASE_ADMIN_COMPONENTS_USER . 'views/modals/manage_plan_text.php'); ?>
<?php md_get_the_file(CMS_BASE_ADMIN_COMPONENTS_USER . 'views/modals/user_logo.php'); ?>

<script language="javascript">

    // Words container
    let words = {
        icon_more: '<?php echo md_the_admin_icon(array('icon' => 'more', 'class' => 'ms-0')); ?>',
        icon_delete: '<?php echo md_the_admin_icon(array('icon' => 'delete')); ?>',
        icon_arrow_down: '<?php echo md_the_admin_icon(array('icon' => 'arrow_down', 'class' => 'theme-dropdown-arrow-icon')); ?>',
        delete: "<?php echo $this->lang->line('user_delete'); ?>",
        selected_items: '<?php echo $this->lang->line('user_selected_items'); ?>',
        feature_text_short: "<?php echo $this->lang->line('user_feature_text_short'); ?>"
    }
    
</script>