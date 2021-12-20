<?php md_get_theme_part('header'); ?>
<?php md_get_theme_part('integrations_search'); ?>
<section class="py-3 theme-page-integrations-body">
    <div class="container">                  
        <div class="row">
            <div class="col-xl-3">
                <?php md_get_theme_part('integrations_categories'); ?>
            </div>            
            <div class="col-xl-9 theme-page-integration">
                <article>
                    <h1 class="theme-title mt-0">
                        <?php echo md_the_content_meta('content_title'); ?>
                    </h1>
                    <?php echo md_the_replacers(htmlspecialchars_decode(md_the_content_meta('content_body'), ENT_NOQUOTES)); ?>
                </article>
            </div>
        </div>
    </div>
</section>
<?php md_get_theme_part('newsletter'); ?>
<?php md_get_theme_part('footer'); ?>