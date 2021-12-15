<div class="frontend-settings pt-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-2 col-sm-6">
                <?php md_get_the_file(CMS_BASE_ADMIN_COMPONENTS_FRONTEND . 'views/settings/menu.php'); ?>
            </div>
            <div class="col-xl-10 col-sm-6">
                <?php md_get_the_frontend_settings_page_content(md_the_data('frontend_settings_page')); ?>
            </div>
        </div>
    </div>
</div>