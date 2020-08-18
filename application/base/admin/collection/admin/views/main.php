<section class="section admin-page">
    <div class="container-fluid">
        <div class="left-side">
            <?php md_include_component_file(MIDRUB_BASE_ADMIN_ADMIN . 'views/menu.php'); ?>
        </div>
        <div class="right-side">
            <?php md_get_the_admin_page_content(md_the_component_variable('component_display')); ?>
        </div>
    </div>
</section>

<!-- Loader -->
<div class="page-loading">
    <div class="loading-animation-area">
        <div class="loading-center-absolute">
            <div class="object object_four"></div>
            <div class="object object_three"></div>
            <div class="object object_two"></div>
            <div class="object object_one"></div>
        </div>
    </div>
</div>