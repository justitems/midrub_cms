<?php md_get_theme_part('header'); ?>
<?php md_get_theme_part('support_center_search'); ?>
<section class="py-3 theme-page-faq-article-body">
    <div class="container">                  
        <div class="row">
            <div class="col-xl-8">
                <div class="row">
                    <div class="col-12 breadcrumb-area">
                        <div class="row">
                            <div class="col-xl-12">
                                <nav class="theme-breadcrumb" aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="<?php echo site_url(); ?>">
                                                <?php md_get_the_string('theme_home'); ?>
                                            </a>
                                        </li>
                                        <?php

                                        // Get breadcrumb's items
                                        $items = md_the_classification_breadcrumb();

                                        // List breadcrumb's items if exists
                                        if ($items) {

                                            foreach ($items as $item) {

                                                if (isset($item['url'])) {

                                                    echo '<li class="breadcrumb-item">'
                                                        . '<a href="' . $item['url'] . '">'
                                                        . $item['name']
                                                        . '</a></li>';
                                                } else {

                                                    echo '<li class="breadcrumb-item active">'
                                                        . $item['name']
                                                        . '</li>';
                                                }
                                            }
                                        }
                                        ?>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <?php

                        // Get the integrations categories
                        $categories = md_the_classification(array(
                            'classification_slug' => 'support_categories',
                            'fields' => array('icon', 'description'),
                            'item_id' => md_the_data('classification_item_id')
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
                <div class="row">
                    <div class="col-12">
                        <div class="theme-page-faq-articles<?php echo !$categories?' mt-0':''; ?>">
                            <div class="row">
                                <div class="col-12">
                                    <h3>
                                        <?php echo md_the_data('classification_item_name') . ' ' . md_get_the_string('theme_articles', true); ?>
                                    </h3>                            
                                </div>
                            </div>   
                            <div class="row">
                                <div class="col-12">
                                    <span class="theme-separator"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <?php

                                    // Verify if contents exists
                                    if ( md_the_contents_list() ) {

                                        // Start the list
                                        echo '<ul class="list-group theme-articles-list">';

                                        // List the articles
                                        foreach (md_the_contents_list() as $item) {

                                            ?>
                                            <li class="list-group-item">
                                                <a href="<?php echo site_url($item['contents_slug']); ?>" class="list-group-item-action">
                                                    <?php echo $item['content_title']; ?>
                                                </a>
                                            </li>
                                            <?php

                                        }

                                        // End the list
                                        echo '</ul>';
                                        
                                    } else {

                                        ?>
                                        <p>
                                            <?php get_the_string('no_articles_found'); ?>
                                        </p>
                                        <?php

                                    }
                                    ?>                               
                                </div>
                            </div>                                                                
                        </div>                           
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