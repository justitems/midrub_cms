<section class="section support-page">
    <div class="container-fluid">
        <div class="row theme-row-equal">
            <div class="col-xl-2 col-lg-3 col-md-4 theme-sidebar-menu">
                <?php md_include_component_file(CMS_BASE_ADMIN_COMPONENTS_SUPPORT . 'views/menu.php'); ?>
            </div>
            <div class="col-xl-10 col-lg-9 col-md-8 support-view">
                <?php md_get_the_user_page_content(md_the_data('component_display')); ?>
            </div>
        </div>
    </div>
</section>

<?php md_get_the_file(CMS_BASE_ADMIN_COMPONENTS_SUPPORT . 'views/modals/categories_manager.php'); ?>

<script language="javascript">

    // Words container
    let words = {
        icon_more: '<?php echo md_the_admin_icon(array('icon' => 'more', 'class' => 'ms-0')); ?>',
        icon_delete: '<?php echo md_the_admin_icon(array('icon' => 'delete')); ?>',
        icon_close: '<?php echo md_the_admin_icon(array('icon' => 'close')); ?>',
        selected_items: '<?php echo $this->lang->line('support_selected_items'); ?>',
        select_a_parent: '<?php echo $this->lang->line('support_select_a_parent'); ?>'
    }
    
</script>