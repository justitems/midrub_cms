<?php md_get_theme_part('header'); ?>
<?php md_get_theme_part('support_center_search'); ?>
<section class="py-3 theme-page-faq-article-body">
    <div class="container">                  
        <div class="row">
            <div class="col-xl-8">
                <div class="row">
                    <div class="col-12">
                        <?php

                        // Get the integrations categories
                        $categories = md_the_classification(array(
                            'classification_slug' => 'support_categories',
                            'fields' => array('icon', 'description'),
                            'subclassifications' => FALSE
                        ));

                        // Verify if the integrations categories exists
                        if ($categories) {

                        // Start list
                        echo '<div class="list-group theme-list">';

                        // List contents
                        foreach ($categories as $category) {
                                
                                ?>
                                <a href="<?php echo site_url('support_categories/' . $category['item_slug']); ?>" class="list-group-item list-group-item-action d-flex w-100 justify-content-start theme-tiny-shadow">
                                    <?php echo !empty($category['icon'])?'<i class="' . $category['icon'] . '"></i>':''; ?>
                                    <div>
                                        <h5>
                                            <?php echo $category['classification_name']; ?>
                                        </h5>
                                        <?php echo !empty($category['description'])?'<small>' . $category['description'] . '</small>':''; ?>
                                    </div>
                                </a>
                                <?php
                                
                            }

                            // End list
                            echo '</div>';
                            
                        }
                        ?>                           
                    </div>
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