<?php md_get_theme_part('header'); ?>
<?php md_get_theme_part('posts_header'); ?>
<section class="py-3 theme-page-posts-body">
    <div class="container">
        <div class="row">
            <div class="col-12 theme-page-post">                    
                <article>
                    <h3 class="theme-published-time">
                        <?php md_get_the_string('theme_published_on'); ?> <?php echo md_the_content_created_time(); ?>
                    </h3>
                    <h1 class="theme-title">
                        <?php echo md_the_content_meta('content_title'); ?>
                    </h1>
                    <?php echo md_the_replacers(htmlspecialchars_decode(md_the_content_meta('content_body'), ENT_NOQUOTES)); ?>
                </article>
            </div>                       
        </div>                
    </div>
</section>
<?php

// Get similar posts
$the_similar_posts = the_similar_posts(md_the_content_id());

// Verify if similar posts exists
if ( $the_similar_posts ) {
?>
<section class="py-3 theme-posts-similar-posts">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>
                    <?php md_get_the_string('theme_you_might_also_be_interested_in'); ?>
                </h2>                            
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <span class="theme-separator"></span>
            </div>
        </div>
        <div class="py-5 row">
            <div class="col-12">
                <div class="theme-posts-similar-posts-list">
                    <ul class="row theme-posts-similar-posts-list-items">
                        <?php

                        // List contents
                        foreach ($the_similar_posts as $item) {
                        ?>
                        <li class="col theme-posts-similar-posts-list-item">
                            <div>
                                <a href="<?php echo site_url($item['contents_slug']); ?>">
                                    <div class="card">
                                        <div class="card-header card-img-top">
                                            <?php echo '<img src="' . $item['content_cover'] . '" alt="' . $item['content_title'] . '" onerror="this.src=\'' . md_the_theme_uri() . 'img/post-cover.jpg\';">'; ?>
                                        </div>
                                        <div class="card-body">
                                            <span>
                                                <?php echo md_the_date(array('time' => $item['created'], 'format' => '1')); ?>
                                            </span>
                                            <h5 class="card-title">
                                                <?php echo md_trim_content($item['content_title'], 60); ?>
                                            </h5>
                                            <p class="card-text">
                                                <?php echo !empty($item['short_description'])?md_trim_content($item['short_description'], 130):md_trim_content($item['content_body'], 130); ?>
                                            </p>
                                        </div>
                                    </div>
                                </a>                                           
                            </div>
                        </li>
                        <?php
                        }

                        ?>
                    </ul>                                 
                </div>
            </div>
        </div>                                                                                            
    </div>
</section>
<?php } ?>
<?php md_get_theme_part('footer'); ?>