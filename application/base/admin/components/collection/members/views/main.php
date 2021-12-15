<section class="section members-page">
    <div class="container-fluid">
        <div class="row theme-row-equal">
            <div class="col-xl-2 col-lg-3 col-md-4 theme-sidebar-menu">
                <?php md_include_component_file(CMS_BASE_ADMIN_COMPONENTS_MEMBERS . 'views/menu.php'); ?>
            </div>
            <div class="col-xl-10 col-lg-9 col-md-8 members-view">
                <?php md_get_the_members_page_content(md_the_data('component_display')); ?>
            </div>
        </div>
    </div>
</section>

<script language="javascript">

    // Words container
    let words = {
        icon_more: '<?php echo md_the_admin_icon(array('icon' => 'more', 'class' => 'ms-0')); ?>',
        icon_delete: '<?php echo md_the_admin_icon(array('icon' => 'delete')); ?>',
        selected_items: '<?php echo $this->lang->line('members_selected_items'); ?>'
    }
    
</script>