<?php md_get_theme_part('header'); ?>

<section class="theme-presentation-section">
    <div class="py-5 container">
        <div class="theme-presentation-section-box">
            <div class="row">
                <div class="col-xl-6">
                    <div>
                        <div class="row">
                            <div class="col-12">
                                <?php
                                if ( md_the_content_meta('theme_top_section_slogan') ) {

                                    echo '<h1>' . md_the_content_meta('theme_top_section_slogan') . '</h1>';

                                } else {

                                    echo '<h1>' . md_get_the_string('theme_universal_crm_for_business', TRUE) . '</h1>';

                                }
                                ?>                                      
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <?php
                                if ( md_the_content_meta('theme_top_section_text_below_slogan') ) {

                                    echo '<h2>' . md_the_content_meta('theme_top_section_text_below_slogan') . '</h2>';

                                } else {

                                    echo '<h2>' . md_get_the_string('theme_get_new_original_tools', TRUE) . '</h2>';

                                }
                                ?>                                                                               
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="theme-presentation-section-short-description">
                                    <?php
                                    if ( md_the_content_meta('theme_top_section_short_description') ) {

                                        echo '<p>' . md_the_content_meta('theme_top_section_short_description') . '</p>';

                                    } else {

                                        echo '<p>' . md_get_the_string('theme_provides_large_number_of_original_tools_for_business', TRUE) . '</p>';

                                    }
                                    ?>                                            
                                </div>                                 
                            </div>
                        </div>                                
                        <div class="row mt-3">
                            <div class="col-12">
                                <?php

                                // Set get started button text
                                $get_started_button_text = md_the_content_meta('theme_top_section_get_started_button_text')?md_the_content_meta('theme_top_section_get_started_button_text'):md_get_the_string('theme_get_started_now', TRUE);

                                // Set get started button link
                                $get_started_button_link = md_the_content_meta('theme_top_section_get_started_button_link')?site_url(md_the_content_meta('theme_top_section_get_started_button_link')):site_url();
                                
                                // Display the get started button
                                echo '<a href="' . $get_started_button_link . '" role="button" class="btn btn-lg btn-primary">' . $get_started_button_text . '</a>';

                                // Set get learn more text
                                $learn_more_button_text = md_the_content_meta('theme_top_section_learn_more_button_text')?md_the_content_meta('theme_top_section_learn_more_button_text'):md_get_the_string('theme_learn_more', TRUE);

                                // Set get learn more link
                                $learn_more_button_link = md_the_content_meta('theme_top_section_learn_more_button_link')?site_url(md_the_content_meta('theme_top_section_learn_more_button_link')):site_url();

                                // Display the learn more button
                                echo '<a href="' . $learn_more_button_link . '" role="button" class="btn btn-lg btn-secondary">'
                                    . $learn_more_button_text
                                    . '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">'
                                        . '<path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z"/>'
                                    . '</svg>'
                                . '</a>';

                                ?>                                                                                                                    
                            </div>
                        </div>                               
                        <div class="row">
                            <div class="col-12">
                                <?php
                                if ( md_the_content_meta('theme_top_section_text_below_buttons') ) {

                                    echo '<h6>' . md_the_content_meta('theme_top_section_text_below_buttons') . '</h6>';

                                } else {

                                    echo '<h6>' . md_get_the_string('theme_no_credit_card_required', TRUE) . '</h6>';

                                }
                                ?>                                                                                                                  
                            </div>
                        </div>
                    </div>                            
                </div>
                <div class="col-xl-6">
                    <?php if ( md_the_content_meta('theme_top_section_video_enabled') ) { ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="theme-presentation-section-browser">
                                <div class="theme-presentation-section-browser-bar">
                                    <div class="row">
                                        <div class="col-3">
                                            <span></span>
                                            <span></span>
                                            <span></span>                                                                                                       
                                        </div>
                                        <div class="col-6">
                                            <div class="theme-presentation-section-browser-url d-flex justify-content-between">
                                                <div class="theme-presentation-section-browser-secured">
                                                    <i class="fi fi-locked"></i>
                                                </div>
                                                <div class="theme-presentation-section-browser-domain text-center">
                                                    <?php

                                                    // Get url
                                                    $url = parse_url(current_url());

                                                    // Display domain
                                                    echo str_replace('www.', '', $url['host']);

                                                    ?>
                                                </div>  
                                                <div class="theme-presentation-section-browser-reload">
                                                    <i class="fi fi-undo"></i>
                                                </div>                                                                                                                       
                                            </div>                                                                                                 
                                        </div>
                                        <div class="col-3 text-end">
                                            <div class="btn-group theme-presentation-section-browser-navigation" role="group" aria-label="Basic example">
                                                <button type="button" class="btn btn-secondary">
                                                    <i class="fi fi-angle-left"></i>
                                                </button>
                                                <button type="button" class="btn btn-secondary">
                                                    <i class="fi fi-angle-right"></i>
                                                </button>
                                            </div>                                                                                                                                                       
                                        </div>
                                    </div>
                                </div>
                                <div class="theme-presentation-section-browser-body"<?php echo md_the_content_meta('theme_top_section_video_cover')?' style="background-image: url(' . md_the_content_meta('theme_top_section_video_cover') . ');"':''; ?>>
                                    <div class="theme-presentation-section-browser-cover">
                                        <button type="button" class="theme-presentation-section-browser-btn" data-bs-toggle="modal" data-bs-target="#theme-presentation-video-play">
                                            <i class="fi fi-play"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>              
                        </div>
                    </div> 
                    <?php } ?>
                    <?php if ( md_the_content_meta('theme_top_section_image_enabled') ) { ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="theme-presentation-section-image">
                                <?php echo md_the_content_meta('theme_top_section_image_url')?'<img src="' . md_the_content_meta('theme_top_section_image_url') . '" alt="Image Presentation">':''; ?>
                            </div>              
                        </div>
                    </div> 
                    <?php } ?>
                </div>
            </div>                        
        </div>
    </div>
</section>

<?php if ( md_the_content_meta('theme_home_statistics_enabled') ) { ?>
<section class="theme-integrations-stats">
    <div class="py-4 container">
        <div class="row">
            <?php

            // Verify if statistics exists
            if ( md_the_content_meta('theme_home_statistics') ) {

                // Set statistics
                $statistics = md_the_content_meta_list('theme_home_statistics');

                // List all statistics
                for ( $s = 0; $s < count($statistics); $s++ ) {

                    ?>
                    <div class="col d-flex align-items-center">
                        <div class="d-inline-block">
                            <div class="theme-integrations-stats-value">
                                <h4>
                                    <?php echo $statistics[$s]['theme_home_statistics_stats_value']; ?>
                                </h4>
                            </div>
                        </div>
                        <div class="d-inline-block">
                            <div class="theme-integrations-stats-label">
                                <h4>
                                    <?php echo $statistics[$s]['theme_home_statistics_stats_description']; ?>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <?php

                }

            }
            ?>
        </div>
    </div>
</section>
<?php } ?>

<?php if ( md_the_content_meta('integrations_home_page_enabled') ) { ?>
<section class="theme-integrations-section">
    <div class="py-4 container">
        <div class="row">
            <div class="col-12">
                <?php
                if ( md_the_content_meta('integrations_home_page_text') ) {
                    echo '<h2>' . md_the_content_meta('integrations_home_page_text') . '</h2>';
                } else {
                    echo '<h2>' . md_get_the_string('theme_get_more_value_from_your_tools', TRUE) . '</h2>';
                }
                ?> 
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 text-center">
            <?php

                // Get featured interactions
                $featured_interactions = the_featured_interactions();

                // Verify if featured interactions exists
                if ( $featured_interactions ) {

                    // List all interactions
                    foreach ($featured_interactions as $featured_interaction) {

                        // Display interaction
                        echo '<a href="' . site_url($featured_interaction['contents_slug']) . '" class="ms-4 me-4 theme-integrations-section-integration">'
                            . '<img src="' . $featured_interaction['meta_value'] . '" />'
                        . '</a>';

                    }

                }

                ?>
            </div>
        </div>
        <?php if ( md_the_content_meta('integrations_home_page_directory_link_text') ) { ?>
        <div class="row py-5">
            <div class="col-12">
                <p class="text-center">
                    <?php
                    
                    // Set get learn more link
                    $learn_more_button_link = md_the_content_meta('integrations_home_page_directory_link_url')?site_url(md_the_content_meta('integrations_home_page_directory_link_url')):site_url();
                    
                    ?>
                    <a href="<?php echo $learn_more_button_link; ?>" class="theme-integrations-section-all-integrations">
                        <?php echo md_the_content_meta('integrations_home_page_directory_link_text'); ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z" />
                        </svg>
                    </a>
                </p>
            </div>
        </div>
        <?php } ?>
    </div>
</section>
<?php } ?>

<?php if ( md_the_content_meta('theme_quick_preview_enabled') ) { ?>
<section class="py-5 theme-short-features">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>
                    <?php echo md_the_content_meta('quick_preview_header_text'); ?>
                </h2>
            </div>
        </div>   
        <div class="row">
            <div class="col-12">
                <h3>
                    <?php echo md_the_content_meta('quick_preview_header_description'); ?>
                </h3>
            </div>
        </div> 
        <div class="row">
            <div class="col-12">
                <span class="theme-separator"></span>
            </div>
        </div> 
        <?php if ( md_the_content_meta('quick_preview_videos') ) { ?>
        <div class="row">
            <div class="col-12">
                <div class="d-flex align-items-start theme-short-features-list">
                    <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <?php

                    // Get preview videos
                    $the_preview_videos = md_the_content_meta_list('quick_preview_videos');

                    // Verify if preview videos exists
                    if ( $the_preview_videos ) {

                        // List preview videos
                        for ( $b = 0; $b < count($the_preview_videos); $b++ ) {

                            // Set video icon
                            $theme_video_icon = isset($the_preview_videos[$b]['theme_video_icon'])?'<i class="' . $the_preview_videos[$b]['theme_video_icon'] . '"></i>':'';                                

                            // Set video title
                            $theme_video_title = isset($the_preview_videos[$b]['theme_video_title'])?$the_preview_videos[$b]['theme_video_title']:'';

                            // Set video description
                            $theme_video_description = isset($the_preview_videos[$b]['theme_video_description'])?$the_preview_videos[$b]['theme_video_description']:'';                                

                            // Set active btn
                            $active_btn = ($b < 1)?' active':'';

                            // Set selected status
                            $selected = ($b < 1)?'true':'false';

                            // Display the video's button
                            echo '<button class="nav-link' . $active_btn . '" id="quick-preview-video-' . $b . '-tab" data-bs-toggle="pill" data-bs-target="#quick-preview-video-' . $b . '" type="button" role="tab" aria-controls="quick-preview-video-' . $b . '" aria-selected="' . $selected . '">'
                                . '<div>'
                                    . $theme_video_icon
                                    . $theme_video_title
                                . '</div>'
                                . '<span>'
                                    . $theme_video_description
                                . '</span>'
                            . '</button>';

                        }

                    }

                    ?>
                    </div>
                    <div class="tab-content" id="quick-preview-videos">
                        <?php

                        // Verify if preview videos exists
                        if ( $the_preview_videos ) {

                            // List preview videos
                            for ( $b = 0; $b < count($the_preview_videos); $b++ ) {

                                // Set video iframe
                                $video = isset($the_preview_videos[$b]['theme_video_url'])?'<iframe src="' . $the_preview_videos[$b]['theme_video_url'] . '" width="640" height="360" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>':'';                              

                                // Set active video
                                $active_video = ($b < 1)?' show active':'';

                                // Display the video's button
                                echo '<div class="tab-pane fade' . $active_video . ' text-center" id="quick-preview-video-' . $b . '" role="tabpanel" aria-labelledby="quick-preview-video-' . $b . '-tab">'
                                    . $video
                                . '</div>';

                            }

                        }

                        ?>
                    </div>
                </div>                            
            </div>
        </div>
        <?php } ?>                                                                         
    </div>
</section>
<?php } ?>

<?php if ( md_the_content_meta('features_enabled') ) { ?>
<section class="py-3 theme-features">
    <div class="py-5 container">
        <div class="row">
            <div class="col-xl-4">
                <h2>
                    <?php echo md_the_content_meta('features_section_title'); ?>
                </h2>
                <h6>
                    <?php echo md_the_content_meta('features_section_description'); ?>
                </h6>
                <?php if ( md_the_content_meta('features_section_link_text') ) { ?>
                <p>
                    <a href="<?php echo md_the_content_meta('features_section_link_url'); ?>" class="theme-see-all-items theme-see-all-benefits">
                        <?php echo md_the_content_meta('features_section_link_text'); ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z"/>
                        </svg>
                    </a>
                </p>
                <?php } ?>
            </div>
            <div class="col-xl-8">
                <div class="row">
                <?php

                // Get featured features
                $featured_features = the_featured_features();

                // Verify if featured features exists
                if ( $featured_features ) {

                    // List all features
                    foreach ($featured_features as $featured_feature) {

                        ?>
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header">
                                    <?php echo $featured_feature['content_icon']?'<i class="' . $featured_feature['content_icon'] . '"></i>':''; ?>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <?php echo $featured_feature['meta_value']; ?>
                                    </h5>
                                    <p class="card-text">
                                        <?php echo $featured_feature['content_description']; ?>
                                    </p>
                                    <a href="<?php echo site_url($featured_feature['contents_slug']); ?>" class="card-link">
                                        <?php md_get_the_string('theme_read_more'); ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>                                    
                        </div>
                        <?php

                    }

                }

                ?>
                </div>
            </div>
        </div>                                                                        
    </div>
</section>
<?php } ?>

<?php if ( md_the_content_meta('reviews_model_1_enabled') ) { ?>
    <section class="py-3 theme-presentation-reviews">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2>
                        <?php echo md_the_content_meta('reviews_model_1_title'); ?>
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
                    <div class="theme-presentation-reviews-list">
                        <ul class="theme-presentation-reviews-list-items">
                            <?php

                            // Get reviews
                            $the_model_1_reviews = md_the_content_meta_list('reviews_model_1_reviews');

                            // Verify if reviews exists
                            if ( $the_model_1_reviews ) {

                                // List reviews
                                for ( $r = 0; $r < count($the_model_1_reviews); $r++ ) {

                                    // Set author's name
                                    $author_name = isset($the_model_1_reviews[$r]['review_author_name'])?$the_model_1_reviews[$r]['review_author_name']:'';
                                    
                                    // Set author's comment
                                    $author_comment = isset($the_model_1_reviews[$r]['review_author_comment'])?$the_model_1_reviews[$r]['review_author_comment']:'';

                                    // Set selected status
                                    $selected = '';        

                                    // Verify if there are more than 1 review
                                    if ( count($the_model_1_reviews) > 1 ) {

                                        // Verify if is the second review
                                        if ( $r === 1 ) {

                                            // Set selected status
                                            $selected = ' theme-presentation-reviews-list-item-active';

                                        }            

                                    } else {

                                        // Verify if is the first review
                                        if ( $r < 1 ) {

                                            // Set selected status
                                            $selected = ' theme-presentation-reviews-list-item-active';

                                        }

                                    }

                                    // Display the review
                                    echo '<li class="theme-presentation-reviews-list-item' . $selected . '">'
                                        . '<div>'
                                            . '<p>'
                                                . '<i class="fi fi-quote-a-right me-1"></i>'
                                                . $author_comment
                                                . '<i class="fi fi-quote-a-left ms-1"></i>'
                                            . '</p>'
                                            . '<h5 class="mt-3">'
                                                . $author_name
                                            . '</h5>'
                                        . '</div>'
                                    . '</li>';

                                }

                            }

                            ?>                              
                        </ul>
                    </div>
                    <nav>
                        <div class="nav nav-tabs d-flex justify-content-center" id="nav-tab" role="tablist">
                        <?php

                        // Get reviews
                        $the_model_1_reviews = md_the_content_meta_list('reviews_model_1_reviews');

                        // Verify if reviews exists
                        if ( $the_model_1_reviews ) {

                            // List reviews
                            for ( $r = 0; $r < count($the_model_1_reviews); $r++ ) {

                                // Set author's name
                                $author_name = isset($the_model_1_reviews[$r]['review_author_name'])?$the_model_1_reviews[$r]['review_author_name']:'';
                                
                                // Set author's position
                                $author_position = isset($the_model_1_reviews[$r]['review_author_position'])?$the_model_1_reviews[$r]['review_author_position']:'';
                                
                                // Set author's photo
                                $author_photo = isset($the_model_1_reviews[$r]['review_author_photo'])?'<img class="mr-3" src="' . $the_model_1_reviews[$r]['review_author_photo'] . '" alt="' . $author_name . '" />':'';        

                                // Set active btn
                                $active_btn = '';

                                // Set selected status
                                $selected = 'false';        

                                // Verify if there are more than 1 review
                                if ( count($the_model_1_reviews) > 1 ) {

                                    // Verify if is the second review
                                    if ( $r === 1 ) {

                                        // Set active btn
                                        $active_btn = ' active';

                                        // Set selected status
                                        $selected = 'true';

                                    }            

                                } else {

                                    // Verify if is the first review
                                    if ( $r < 1 ) {

                                        // Set active btn
                                        $active_btn = ' active';

                                        // Set selected status
                                        $selected = 'true';

                                    }

                                }

                                // Display the button
                                echo '<button type="button" role="tab" class="nav-link' . $active_btn . '" id="nav-home-tab" aria-selected="' . $selected . '" data-bs-toggle="tab" data-review="' . $r . '">'
                                    . '<div class="media">'
                                        . $author_photo
                                        . '<div class="media-body">'
                                            . '<h5 class="mt-0">'
                                                . $author_name
                                            . '</h5>'
                                            . '<p>'
                                                . $author_position
                                            . '</p>'
                                        . '</div>'
                                    . '</div>'                                  
                                . '</button>';

                            }

                        }

                        ?>                                
                        </div>
                    </nav> 
                </div>                       
            </div>                                                                        
        </div>
    </section>
<?php } ?>

<?php if ( md_the_content_meta('reviews_model_2_enabled') ) { ?>
    <section class="py-3 theme-presentation-reviews-2">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>
                    <?php echo md_the_content_meta('reviews_model_2_title'); ?>
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
                <div class="theme-presentation-reviews-2-list">
                    <ul class="row theme-presentation-reviews-2-list-items">
                        <?php

                        // Get reviews
                        $the_model_2_reviews = md_the_content_meta_list('reviews_model_2_reviews');

                        // Verify if reviews exists
                        if ( $the_model_2_reviews ) {

                            // List reviews
                            for ( $r = 0; $r < count($the_model_2_reviews); $r++ ) {

                                // Set author's name
                                $author_name = isset($the_model_2_reviews[$r]['review_author_name'])?$the_model_2_reviews[$r]['review_author_name']:'';
                                
                                // Set author's position
                                $author_position = isset($the_model_2_reviews[$r]['review_author_position'])?$the_model_2_reviews[$r]['review_author_position']:'';
                                
                                // Set author's photo
                                $author_photo = isset($the_model_2_reviews[$r]['review_author_photo'])?'<img class="mr-3" src="' . $the_model_2_reviews[$r]['review_author_photo'] . '" alt="' . $author_name . '" />':'';        

                                // Set author's comment
                                $author_comment = isset($the_model_2_reviews[$r]['review_author_comment'])?$the_model_2_reviews[$r]['review_author_comment']:'';

                                // Stars container
                                $stars = '';

                                // Verify if stars exists
                                if ( !empty($the_model_2_reviews[$r]['review_stars']) ) {

                                    // Verify if stars is number
                                    if ( is_numeric($the_model_2_reviews[$r]['review_stars']) ) {

                                        // Verify if the number is supported
                                        if ( ($the_model_2_reviews[$r]['review_stars'] === '1') || ($the_model_2_reviews[$r]['review_stars'] === '2') || ($the_model_2_reviews[$r]['review_stars'] === '3') || ($the_model_2_reviews[$r]['review_stars'] === '4') || ($the_model_2_reviews[$r]['review_stars'] === '5') ) {

                                            // List stars
                                            for ( $s = 0; $s < $the_model_2_reviews[$r]['review_stars']; $s++ ) {

                                                // Add star to the container
                                                $stars .= '<i class="fi fi-star"></i> ';

                                            }                                   

                                        }

                                    }

                                }
                                
                                // Display the review
                                echo '<li class="col theme-presentation-reviews-2-list-item">'
                                    . '<div>'
                                        . '<div class="row">'
                                            . '<div class="col-12">'
                                                . '<div class="theme-presentation-reviews-2-stars">'
                                                    . $stars
                                                . '</div>'
                                            . '</div>'
                                        . '</div>'
                                        . '<div class="row">'
                                            . '<div class="col-12">'
                                                . '<p>'
                                                    . '<i class="fi fi-quote-a-right me-1"></i>'
                                                    . $author_comment
                                                    . '<i class="fi fi-quote-a-left ms-1"></i>'
                                                . '</p>'
                                            . '</div>'
                                        . '</div>'
                                        . '<div class="row">'
                                            . '<div class="col-12">'
                                                . '<div class="media">'
                                                    . $author_photo
                                                    . '<div class="media-body">'
                                                        . '<h5 class="mt-0">'
                                                            . $author_name
                                                        . '</h5>'
                                                        . '<p>'
                                                            . $author_position
                                                        . '</p>'
                                                    . '</div>'
                                                . '</div>'
                                            . '</div>'
                                        . '</div>'
                                    . '</div>'
                                . '</li>';

                            }

                        }

                        ?>
                    </ul>
                </div>
            </div>
        </div>
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
                <?php if ( md_the_content_meta('faq_section_link_text') ) { ?>
                    <p>
                        <a href="<?php echo md_the_content_meta('faq_section_link_url'); ?>" class="theme-see-all-items theme-see-crm-faq-center">
                            <?php echo md_the_content_meta('faq_section_link_text'); ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z" />
                            </svg>
                        </a>
                    </p>
                <?php } ?>
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

<?php if ( md_the_content_meta('blog_posts_enabled') ) { ?>
<section class="py-3 theme-presentation-blog-posts">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>
                    <?php echo md_the_content_meta('blog_posts_title'); ?>
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
                <div class="theme-presentation-reviews-2-list">
                    <ul class="row theme-presentation-reviews-2-list-items">
                        <?php 
                        
                        // Get the featured posts
                        $the_featured_posts = the_featured_posts(); 
                        
                        // Verify if featured posts exists
                        if ( $the_featured_posts ) {

                            // List featured posts
                            foreach ($the_featured_posts as $item) {
                                ?>
                                <li class="col theme-posts-similar-posts-list-item">
                                    <div>
                                        <a href="<?php echo site_url($item['contents_slug']); ?>">
                                            <div class="card">
                                                <div class="card-header card-img-top">
                                                    <?php echo '<img src="' . $item['content_cover'] . '" alt="' . $item['meta_value'] . '" onerror="this.src=\'' . md_the_theme_uri() . 'img/post-cover.jpg\';">'; ?>
                                                </div>
                                                <div class="card-body">
                                                    <span>
                                                        <?php echo md_the_date(array('time' => $item['created'], 'format' => '1')); ?>
                                                    </span>
                                                    <h5 class="card-title">
                                                        <?php echo md_trim_content($item['meta_value'], 60); ?>
                                                    </h5>
                                                    <p class="card-text">
                                                        <?php echo !empty($item['content_description'])?md_trim_content($item['content_description'], 130):md_trim_content($item['content_body'], 130); ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </a>                                           
                                    </div>
                                </li>
                                <?php

                            }

                        }
                        
                        ?>                          
                    </ul>                                 
                </div>
            </div>
        </div>                                                                                            
    </div>
</section>
<?php } ?>

<?php if ( md_the_content_meta('plans_enabled') ) { ?>
<?php

// Get the featured plans
$the_featured_plans = the_all_featured_plans(); 

    if ( $the_featured_plans ) {
    ?>
    <section class="py-3 theme-presentation-plans">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2>
                        <?php echo md_the_content_meta('plans_title'); ?>
                    </h2>                            
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <span class="theme-separator"></span>
                </div>
            </div>
            <?php

            // Verify if is a group
            if ( !empty($the_featured_plans[0]['plans']) ) {

                // Set nav start
                echo '<div class="row">'
                    . '<div class="col-12 text-center">'
                        . '<div class="btn-group theme-presentation-plans-periods">';

                        // List groups
                        foreach ( $the_featured_plans as $group ) {

                            // Nav active
                            $nav_active = ( $the_featured_plans[0]['plans'][0]['plans_group'] === $group['plans'][0]['plans_group'] )?' theme-presentation-plans-period-active':'';

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
                        if ( !empty($the_featured_plans[0]['plans']) ) {

                            // Set tabs
                            echo '<div class="tab-content" id="plans-tabs-parent">';

                            // Set groups
                            $groups = $the_featured_plans;

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
                            foreach ( $the_featured_plans['data'] as $plan ) {

                                // Default title
                                $title = '';

                                // Default short description
                                $short_description = '';

                                // Default displayed price
                                $displayed_price = '';  
                                
                                // Default features
                                $features = '';                            

                                // Verify if plan exists
                                if ( !empty($the_featured_plans['texts'][$plan['plan_id']]) ) {

                                    // Texts container
                                    $texts = array();

                                    // List the texts
                                    foreach ( $the_featured_plans['texts'][$plan['plan_id']] as $the_text ) {

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
        </div>
    </section>
    <?php } ?>
<?php } ?>

<?php md_get_theme_part('newsletter'); ?>

<?php if ( md_the_content_meta('theme_top_section_video_url') ) { ?>

<!-- Modal -->
<div class="modal fade theme-modal" id="theme-presentation-video-play" tabindex="-1" aria-labelledby="theme-presentation-video-play-label" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-body p-0">
                <iframe src="<?php echo md_the_content_meta('theme_top_section_video_url'); ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="w-100 h-50"></iframe>
            </div>
        </div>
    </div>
</div>

<?php } ?>

<?php md_get_theme_part('footer'); ?>