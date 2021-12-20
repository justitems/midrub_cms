<?php md_get_theme_part('header'); ?>
<?php md_get_theme_part('careers_header'); ?>
<section class="py-3 theme-careers-page">
    <div class="py-5 container">
        <?php

        // Get the careers categories
        $categories = md_the_classification(array(
            'classification_slug' => 'careers_categories',
            'subclassifications' => FALSE
        ));

        // Verify if the careers categories exists
        if ($categories) {

        ?>
        <div class="row">
            <div class="col-12">
                <h3 class="mb-3 text-center">
                    <?php

                    // List all careers categories
                    foreach ($categories as $category) {

                        // Display category
                        echo '<button type="button" class="btn btn-light theme-careers-category theme-careers-selected-category ms-1 me-1" data-category="' . $category['item_slug'] . '">'
                            . $category['classification_name']
                        . '</button>';

                    }

                    ?>
                </h3>                            
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-12">
                <span class="theme-separator"></span>
            </div>
        </div>
        <?php            

        }
        ?>
        <div class="row theme-careers-list"></div>                                                                    
    </div>
    </section>
<?php md_get_theme_part('newsletter'); ?>
<?php md_get_theme_part('footer'); ?>