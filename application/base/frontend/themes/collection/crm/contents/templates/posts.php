<?php md_get_theme_part('header'); ?>
<?php md_get_theme_part('posts_header'); ?>
<section class="py-3 theme-page-posts-body">
    <div class="container">
        <div class="row">
            <div class="col-12 theme-page-posts-list">                    
                <div class="row">
                    <?php

                    // Set page
                    $page = !empty(get_instance()->input->get('page', TRUE))?get_instance()->input->get('page', TRUE):1;

                    // Verify if the contents exists
                    if ( md_the_contents_list(array('contents_category' => 'posts', 'limit' => 12, 'page' => $page, 'content_metas' => array('short_description', 'content_body', 'cover'))) ) {

                        // List contents
                        foreach (md_the_contents_list(array('contents_category' => 'posts', 'limit' => 12, 'page' => $page, 'content_metas' => array('short_description', 'content_body', 'cover'))) as $item) {

                            ?>
                            <div class="col-xl-4 col-md-6 col-12">
                                <a href="<?php echo site_url($item['contents_slug']); ?>">
                                    <div class="card">
                                        <div class="card-header card-img-top">
                                            <?php echo '<img src="' . $item['cover'] . '" alt="' . $item['content_title'] . '" onerror="this.src=\'' . md_the_theme_uri() . 'img/post-cover.jpg\';">'; ?>
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
                            <?php

                        }
                        
                    } else {

                        ?>
                        <p class="theme-page-no-results-found">
                            <?php md_get_the_string('theme_no_integrations_were_found'); ?>
                        </p>
                        <?php

                    }

                    ?>                     
                </div>
            </div>                       
        </div>                            
        <div class="row">
            <div class="col-12 text-center">
                <?php md_get_pagination(array('contents_pagination_url' => md_the_content_url() . '?page=')); ?>                                                           
            </div>
        </div>                    
    </div>
</section>
<?php md_get_theme_part('newsletter'); ?>
<?php md_get_theme_part('footer'); ?>