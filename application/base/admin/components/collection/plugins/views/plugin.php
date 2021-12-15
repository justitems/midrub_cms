<section class="section plugins-page" data-csrf="<?php echo $this->security->get_csrf_token_name(); ?>" data-csrf-value="<?php echo $this->security->get_csrf_hash(); ?>">
    <div class="container-fluid">
        <div class="left-side">
            <?php md_get_the_file(CMS_BASE_ADMIN_COMPONENTS_PLUGINS . 'views/menu.php'); ?>
        </div>
        <div class="right-side">
            <?php get_the_admin_plugins_plugin_page_content(md_the_data('component_display')); ?>
        </div>
    </div>
</section>