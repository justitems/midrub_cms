<?php md_get_theme_part('header'); ?>
<?php md_get_theme_part('support_center_search'); ?>
<section class="py-3 theme-page-faq-article-body">
    <div class="container">                  
        <div class="row">
            <div class="col-xl-8">
                <div class="theme-page-faq-article">
                    <article>
                        <h1 class="theme-title mt-0 text-start">
                            <?php echo md_the_content_meta('content_title'); ?>
                        </h1>
                        <?php echo md_the_replacers(htmlspecialchars_decode(md_the_content_meta('content_body'), ENT_NOQUOTES)); ?>
                    </article>
                </div>
            </div>
            <div class="col-xl-4">
                <?php md_get_theme_part('support_center_last_articles'); ?>                                     
            </div> 
        </div>
    </div>
</section>
<?php md_get_theme_part('newsletter'); ?>
<?php md_get_theme_part('footer'); ?>