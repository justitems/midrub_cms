<section class="section frontend-page" data-display="<?php echo md_the_data('component_display'); ?>" data-order="<?php echo md_the_data('component_order_data'); ?>">
    <div class="container-fluid">
        <div class="row theme-row-equal">
            <div class="col-xl-2 col-lg-3 col-md-4 theme-sidebar-menu">
                <?php md_include_component_file(CMS_BASE_ADMIN_COMPONENTS_FRONTEND . 'views/menu.php'); ?>
            </div>
            <div class="col-xl-10 col-lg-9 col-md-8 frontend-view">
                <?php md_include_component_file(CMS_BASE_ADMIN_COMPONENTS_FRONTEND . 'views/contents_list.php'); ?>
            </div>
        </div>
    </div>
</section>

<?php md_get_the_file(CMS_BASE_ADMIN_COMPONENTS_FRONTEND . 'views/modals/components_selector.php'); ?>
<?php md_get_the_file(CMS_BASE_ADMIN_COMPONENTS_FRONTEND . 'views/modals/templates_selector.php'); ?>

<script language="javascript">

    // Words container
    let words = {
        icon_more: '<?php echo md_the_admin_icon(array('icon' => 'more', 'class' => 'ms-0')); ?>',
        icon_delete: '<?php echo md_the_admin_icon(array('icon' => 'delete')); ?>',
        selected_items: '<?php echo $this->lang->line('frontend_selected_items'); ?>'
    }
    
</script>