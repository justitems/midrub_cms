<section class="section plugins-page">
    <div class="container-fluid">
        <div class="row theme-row-equal">
            <div class="col-xl-2 col-lg-3 col-md-4 theme-sidebar-menu">
                <?php md_get_the_file(CMS_BASE_ADMIN_COMPONENTS_PLUGINS . 'views/menu.php'); ?>
            </div>
            <div class="col-xl-10 col-lg-9 col-md-8 plugins-view">
                <?php get_the_admin_plugins_page_content(md_the_data('component_display')); ?>
            </div>
        </div>
    </div>
</section>