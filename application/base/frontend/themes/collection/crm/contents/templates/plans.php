<?php md_get_theme_part('header'); ?>
<?php md_get_theme_part('plans_header'); ?>
<?php

// Get the visible plans
$the_visible_plans = the_all_visible_plans(); 

    if ( $the_visible_plans ) {
    ?>
    <section class="py-3 theme-presentation-plans">
        <div class="container">
            <?php if ( md_the_content_meta('plans_text_above_plans_list') && (md_the_content_meta('plans_text_above_plans_list') !== '<p><br></p>') ) { ?>
            <div class="row">
                <div class="col-12">
                    <?php echo md_the_content_meta('plans_text_above_plans_list'); ?>                          
                </div>
            </div>
            <?php } ?>
            <?php

            // Verify if is a group
            if ( !empty($the_visible_plans[0]['plans']) ) {

                // Set nav start
                echo '<div class="row">'
                    . '<div class="col-12 text-center">'
                        . '<div class="btn-group theme-presentation-plans-periods">';

                        // List groups
                        foreach ( $the_visible_plans as $group ) {

                            // Nav active
                            $nav_active = ( $the_visible_plans[0]['plans'][0]['plans_group'] === $group['plans'][0]['plans_group'] )?' theme-presentation-plans-period-active':'';

                            // Display the period button
                            echo '<a href="#tab-plans-group-' . $group['plans'][0]['plans_group'] . '" class="btn btn-primary' . $nav_active . '">'
                                . $group['plans'][0]['group_name']
                            . '</a>';

                        }

                        echo '</div>'        
                        . '</div>'
                    . '</div>';

            }

            ?>             
            <div class="py-5 row">
                <div class="col-12">
                    <div class="theme-presentation-plans-list theme-tiny-shadow">
                        <?php

                        // Verify if is a group
                        if ( !empty($the_visible_plans[0]['plans']) ) {

                            // Set tabs
                            echo '<div class="tab-content" id="plans-tabs-parent">';

                            // Set groups
                            $groups = $the_visible_plans;

                            // List groups
                            foreach ( $groups as $group ) {

                                // Tab active
                                $tab_active = ( $groups[0]['group_id'] === $group['group_id'] )?' show active':'';

                                // Set Tab Start
                                echo '<div class="tab-pane fade' . $tab_active . '" id="tab-plans-group-' . $group['group_id'] . '" role="tabpanel" aria-labelledby="tab-plans-group-' . $group['group_id'] . '-tab">';

                                // Open row
                                echo '<div class="row">';

                                // Set plans
                                $plans = $group['plans'];

                                // Set url
                                $url = md_the_url_by_page_role('sign_up')?md_the_url_by_page_role('sign_up'):site_url('auth/signup');

                                // List all plans
                                foreach ( $plans as $plan ) {

                                    // Default title
                                    $title = '';

                                    // Default short description
                                    $short_description = '';

                                    // Default displayed price
                                    $displayed_price = '';  
                                    
                                    // Default features
                                    $features = '';                            

                                    // Verify if plan exists
                                    if ( !empty($plan['texts']) ) {

                                        // Texts container
                                        $texts = array();

                                        // List the texts
                                        foreach ( $plan['texts'] as $the_text ) {

                                            // Verify if name is title
                                            if ( $the_text['text_name'] === 'title' ) {

                                                // Set title
                                                $texts['title'] = $the_text['text_value'];

                                            } else if ( $the_text['text_name'] === 'short_description' ) {

                                                // Set short description
                                                $texts['short_description'] = $the_text['text_value'];

                                            } else if ( $the_text['text_name'] === 'displayed_price' ) {

                                                // Set displayed price
                                                $texts['displayed_price'] = $the_text['text_value'];

                                            } else {

                                                // Verify if features exists
                                                if ( !isset($texts['features']) ) {

                                                    // Set the features
                                                    $texts['features'] = array();

                                                }

                                                // Set the feature
                                                $texts['features'][] = $the_text['text_value'];

                                            }

                                        }

                                        // Verify if title exists
                                        if ( isset($texts['title']) ) {

                                            // Set title
                                            $title = $texts['title'];

                                        } 
                                        
                                        // Verify if short description exists
                                        if ( isset($texts['short_description']) ) {

                                            // Set short description
                                            $short_description = $texts['short_description'];

                                        }

                                        // Verify if displayed price exists
                                        if ( isset($texts['displayed_price']) ) {

                                            // Set displayed price
                                            $displayed_price = $texts['displayed_price'];

                                        }

                                        // Verify if features exists
                                        if ( isset($texts['features']) ) {
                                            
                                            // List features
                                            foreach ( $texts['features'] as $feature ) {

                                                // Set feature
                                                $features .= '<li>'
                                                    . '<span>'
                                                        . $feature
                                                    . '</span>'
                                                . '</li>';

                                            }

                                        }                                

                                    }

                                    // Display the plan
                                    echo '<div class="col theme-presentation-plans-list-plan">'
                                        . '<div class="row">'
                                            . '<div class="col-12">'
                                                . '<h1>'
                                                    . $title
                                                . '</h1>'
                                            . '</div>'
                                        . '</div>'
                                        . '<div class="row">'
                                            . '<div class="col-12">'
                                                . '<p>'
                                                    . $short_description
                                                . '</p>'
                                            . '</div>'
                                        . '</div>'                                   
                                        . '<div class="py-4 row">'
                                            . '<div class="col-12 text-center">'
                                                . $displayed_price
                                            . '</div>'
                                        . '</div>'
                                        . '<div class="row">'
                                            . '<div class="col-12">'
                                                . '<a href="' . $url . '?plan=' . $plan['plan_id'] . '" type="button" class="btn">'
                                                    . md_get_the_string('theme_get_started', true)
                                                . '</a>'
                                            . '</div>'
                                        . '</div>'                                   
                                        . '<div class="row">'
                                            . '<div class="col-12">'
                                                . '<ul>'
                                                    . $features
                                                . '</ul>'                                                
                                            . '</div>'
                                        . '</div>'                                                                                                                    
                                    . '</div>';

                                }

                                // End row
                                echo '</div>';

                                // Set Tab End
                                echo '</div>';

                            }

                            // Set Tabs End
                            echo '</div>';

                        } else {

                            // Prepare the url
                            $url = md_the_url_by_page_role('sign_up')?md_the_url_by_page_role('sign_up'):site_url('auth/signup');

                            // Open row
                            echo '<div class="row">';

                            // List the plans
                            foreach ( $the_visible_plans['data'] as $plan ) {

                                // Default title
                                $title = '';

                                // Default short description
                                $short_description = '';

                                // Default displayed price
                                $displayed_price = '';  
                                
                                // Default features
                                $features = '';                            

                                // Verify if plan exists
                                if ( !empty($the_visible_plans['texts'][$plan['plan_id']]) ) {

                                    // Texts container
                                    $texts = array();

                                    // List the texts
                                    foreach ( $the_visible_plans['texts'][$plan['plan_id']] as $the_text ) {

                                        // Verify if name is title
                                        if ( $the_text['text_name'] === 'title' ) {

                                            // Set title
                                            $texts['title'] = $the_text['text_value'];

                                        } else if ( $the_text['text_name'] === 'short_description' ) {

                                            // Set short description
                                            $texts['short_description'] = $the_text['text_value'];

                                        } else if ( $the_text['text_name'] === 'displayed_price' ) {

                                            // Set displayed price
                                            $texts['displayed_price'] = $the_text['text_value'];

                                        } else {

                                            // Verify if features exists
                                            if ( !isset($texts['features']) ) {

                                                // Set the features
                                                $texts['features'] = array();

                                            }

                                            // Set the feature
                                            $texts['features'][] = $the_text['text_value'];

                                        }

                                    }

                                    // Verify if title exists
                                    if ( isset($texts['title']) ) {

                                        // Set title
                                        $title = $texts['title'];

                                    } 
                                    
                                    // Verify if short description exists
                                    if ( isset($texts['short_description']) ) {

                                        // Set short description
                                        $short_description = $texts['short_description'];

                                    }

                                    // Verify if displayed price exists
                                    if ( isset($texts['displayed_price']) ) {

                                        // Set displayed price
                                        $displayed_price = $texts['displayed_price'];

                                    }

                                    // Verify if features exists
                                    if ( isset($texts['features']) ) {
                                        
                                        // List features
                                        foreach ( $texts['features'] as $feature ) {

                                            // Set feature
                                            $features .= '<li>'
                                                . '<span>'
                                                    . $feature
                                                . '</span>'
                                            . '</li>';

                                        }

                                    }                                

                                }

                                // Display the plan
                                echo '<div class="col theme-presentation-plans-list-plan">'
                                    . '<div class="row">'
                                        . '<div class="col-12">'
                                            . '<h1>'
                                                . $title
                                            . '</h1>'
                                        . '</div>'
                                    . '</div>'
                                    . '<div class="row">'
                                        . '<div class="col-12">'
                                            . '<p>'
                                                . $short_description
                                            . '</p>'
                                        . '</div>'
                                    . '</div>'                                   
                                    . '<div class="py-4 row">'
                                        . '<div class="col-12 text-center">'
                                            . $displayed_price
                                        . '</div>'
                                    . '</div>'
                                    . '<div class="row">'
                                        . '<div class="col-12">'
                                            . '<a href="' . $url . '?plan=' . $plan['plan_id'] . '" type="button" class="btn">'
                                                . md_get_the_string('theme_get_started', true)
                                            . '</a>'
                                        . '</div>'
                                    . '</div>'                                   
                                    . '<div class="row">'
                                        . '<div class="col-12">'
                                            . '<ul>'
                                                . $features
                                            . '</ul>'                                                
                                        . '</div>'
                                    . '</div>'                                                                                                                    
                                . '</div>';

                            }

                            // End row
                            echo '</div>';

                        }                         

                        ?>
                    </div>
                </div>
            </div> 
            <?php if ( md_the_content_meta('plans_text_below_plans_list') && (md_the_content_meta('plans_text_below_plans_list') !== '<p><br></p>') ) { ?>
            <div class="row">
                <div class="col-12">
                    <?php echo md_the_content_meta('plans_text_below_plans_list'); ?>                          
                </div>
            </div>
            <?php } ?>                                                                                           
        </div>
    </section>
<?php } ?>
<?php if ( md_the_content_meta('faq_enabled') ) { ?>
<section class="theme-faq-popular-questions-answers">
    <div class="py-5 container">
        <div class="row">
            <div class="col-xl-4">
                <h2>
                    <?php echo md_the_content_meta('faq_section_title'); ?>
                </h2>
                <h6>
                    <?php echo md_the_content_meta('faq_section_description'); ?>
                </h6>
            </div>
            <div class="col-xl-8">
                <div class="row">
                    <div class="col-12">
                        <div class="accordion" id="theme-faq-popular-questions-answers-list">
                            <?php

                            // Get questions
                            $the_faq_questions = md_the_content_meta_list('faq_questions');

                            // Verify if questions exists
                            if ( $the_faq_questions ) {

                                // List questions
                                for ( $q = 0; $q < count($the_faq_questions); $q++ ) {

                                    // Set question
                                    $question = isset($the_faq_questions[$q]['question'])?$the_faq_questions[$q]['question']:'';

                                    // Set answer
                                    $answer = isset($the_faq_questions[$q]['answer'])?$the_faq_questions[$q]['answer']:'';

                                    // Set active class
                                    $active = ($q < 1)?' show':'';

                                    // Set expanded class
                                    $expanded = ($q < 1)?'true':'false';                                    
                                    
                                    // Display the question
                                    echo '<div class="accordion-item">'
                                        . '<h2 class="accordion-header" id="theme-faq-question-and-answer-' . $q . '">'
                                            . '<button class="accordion-button d-flex justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#theme-faq-question-' . $q . '" aria-expanded="' . $expanded . '" aria-controls="theme-faq-question-' . $q . '">'
                                                . '<span>'
                                                    . $question
                                                . '</span>'
                                                . '<i class="fi fi-angle-down"></i>'
                                            . '</button>'
                                        . '</h2>'
                                        . '<div id="theme-faq-question-' . $q . '" class="accordion-collapse collapse' . $active . '" aria-labelledby="theme-faq-question-and-answer-' . $q . '">'
                                            . '<div class="accordion-body">'
                                                . $answer
                                            . '</div>'
                                        . '</div>'
                                    . '</div>';

                                }

                            }

                            ?>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php } ?>
<?php md_get_theme_part('newsletter'); ?>
<?php md_get_theme_part('footer'); ?>