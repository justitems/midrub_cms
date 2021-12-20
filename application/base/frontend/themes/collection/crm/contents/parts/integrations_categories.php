<div class="theme-page-integrations-categories">
    <div class="row">
        <div class="col-12">
            <h2>
                <?php md_get_the_string('theme_categories'); ?>
            </h2>                            
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <?php

            // Get the integrations categories
            $categories = md_the_classification(array(
                'classification_slug' => 'integrations_categories',
                'subclassifications' => FALSE
            ));

            // Verify if the integrations categories exists
            if ($categories) {

                // Start categories list
                echo '<ul class="list-group">';

                // List all integrations categories
                foreach ($categories as $category) {

                    // Display category
                    echo '<li class="list-group-item">'
                        . '<a href="' . site_url('integrations_categories/' . $category['item_slug']) . '" class="list-group-item-action">'
                            . $category['classification_name']
                        . '</a>'
                    . '</li>';

                }

                // End categories list
                echo '</ul>';

            }
            ?>                              
        </div>
    </div>                                                                
</div>