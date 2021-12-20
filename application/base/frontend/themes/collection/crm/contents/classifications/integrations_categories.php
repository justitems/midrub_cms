<?php md_get_theme_part('header'); ?>
<?php md_get_theme_part('integrations_search'); ?>
<section class="py-3 theme-page-integrations-body">
    <div class="container">                  
        <div class="row">
            <div class="col-xl-3">
                <?php md_get_theme_part('integrations_categories'); ?>
            </div>            
            <div class="col-xl-9">
                <div class="theme-page-integrations">
                    <div class="row">
                        <div class="col-12">
                            <?php

                            // Set page
                            $page = !empty(get_instance()->input->get('page', TRUE))?get_instance()->input->get('page', TRUE):1;

                            // Verify if the contents exists
                            if ( md_the_contents_list(array('contents_category' => 'integrations', 'limit' => 20, 'page' => $page, 'content_metas' => array('short_description', 'image'))) ) {

                                // Start list
                                echo '<ul class="theme-page-integrations-list">';

                                // List contents
                                foreach (md_the_contents_list(array('contents_category' => 'integrations', 'limit' => 20, 'page' => $page, 'content_metas' => array('short_description', 'image'))) as $item) {
                                    ?>
                                    <li>
                                        <div>
                                            <a href="<?php echo site_url($item['contents_slug']); ?>" class="theme-tiny-shadow d-flex justify-content-between">
                                                <div>
                                                    <h3>
                                                        <?php echo $item['content_title']; ?>
                                                    </h3>
                                                    <p>
                                                        <?php echo $item['short_description']; ?>
                                                    </p>
                                                </div>
                                                <?php echo $item['image']?'<img src="' . $item['image'] . '" alt="' . $item['content_title'] . '">':''; ?>
                                            </a>
                                        </div>
                                    </li>
                                <?php
                                }

                                // End list
                                echo '</ul>';
                                
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
                    <div class="row">
                        <div class="col-12 text-center">
                            <?php md_get_pagination(array('contents_pagination_url' => md_the_content_url() . '?page=')); ?>                                     
                        </div>
                    </div>                                
                </div>                                          
            </div>            
        </div>
    </div>
</section> 

<?php md_get_theme_part('footer'); ?>