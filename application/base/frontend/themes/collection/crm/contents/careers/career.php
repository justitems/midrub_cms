<?php md_get_theme_part('header'); ?>
<?php md_get_theme_part('career_header'); ?>
<section class="theme-feature">
    <div class="container">
        <div class="row">
            <div class="col-12">  
                <article>
                    <?php echo md_the_replacers(htmlspecialchars_decode(md_the_content_meta('content_body'), ENT_NOQUOTES)); ?>
                </article>
            </div>
        </div>            
    </div>
</section>
<?php md_get_theme_part('newsletter'); ?>
<?php md_get_theme_part('footer'); ?>