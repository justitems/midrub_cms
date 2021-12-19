/*
 * Quick Guide JavaScript file
*/

jQuery(document).ready( function ($) {
    'use strict';

    /*
     * Creates a default quick guide template
     * 
     * @param string content contains the quick guide content
     * 
     * @since   0.0.8.5
     * 
     * @return string with template
     */
    Main.the_default_quick_guide_template = function (content) {

        // Return template by type
        if (content.content_type === 'category') {

            return '<div class="row">'
                + '<div class="col-12">'
                    + '<div class="list-group theme-quick-guide-categories">'
                        + '<a href="#" class="list-group-item list-group-item-action" data-category="' + content.content_slug + '">'
                            + Main.translation.theme_icon_plus
                            + content.content_title
                            + '<small>'
                                + Main.translation.theme_icon_arrow_right
                            + '</small>'
                        + '</a>'
                    + '</div>'                
                + '</div>'
            + '</div>';

        } else if (content.content_type === 'article') {

            let content_body = (typeof content.content_body !== 'undefined')?content.content_body:'';

            return '<div class="row">'
                + '<div class="col-12">'
                    + '<div class="list-group theme-quick-guide-articles">'
                        + '<div class="list-group-item list-group-item-action flex-column align-items-start">'
                            + '<div class="d-flex w-100 justify-content-between">'
                                + '<h5 class="theme-quick-guide-article-title">'
                                    + content.content_title
                                + '</h5>'
                            + '</div>'
                            + '<div class="theme-quick-guide-article-content">'
                                + content_body
                            + '</div>'
                        + '</div>'
                    + '</div>'        
                + '</div>'
            + '</div>';

        }

    };

    /*
     * Shows the quick guide contents
     * 
     * @param string content contains the quick guide content
     * 
     * @since   0.0.8.5
     * 
     * @return void
     */
    Main.get_default_quick_guide_contents = function (contents) {

        // Data container
        var data = '';

        // List all quick guides contents
        for ( var g = 0; g < contents.length; g++ ) {

            // Verify if the content has the required parameters
            if ( (typeof contents[g].content_slug !== 'undefined') && (typeof contents[g].content_title !== 'undefined') && (typeof contents[g].content_type !== 'undefined') ) {

                // Get template
                data += Main.the_default_quick_guide_template(contents[g]);

            }

        }

        // Display contents
        $('.main .theme-quick-guide .theme-quick-guide-contents').html(data);

    };

    /*
     * Load default content
     * 
     * @since   0.0.8.5
     */
    $(function () {

        // Verify if the_quick_guide_data exists
        if ( typeof the_quick_guide_data !== 'undefined' ) {

            // Display the contents
            Main.get_default_quick_guide_contents(the_quick_guide_data);

        }

    });

    /*
     * Detect quick guide go back click
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.5
    */
    $( document ).on( 'click', '.main .theme-quick-guide .theme-quick-guide-go-back', function (e) {
        e.preventDefault();     
    
        // Get the category slug
        let category_slug = $(this).attr('data-category');

        // Hide go back button
        $(this).fadeOut('slow');   

        // Remove category
        $(this).removeAttr('data-category');

        // Verify if the_quick_guide_data exists
        if ( typeof the_quick_guide_data !== 'undefined' ) {

            // Verify if category's slug exists
            if ( !category_slug ) {

                // Display the contents
                Main.get_default_quick_guide_contents(the_quick_guide_data);

            } else {

                function get_guide_contents(contents, category_slug, parent_level) {

                    // List all quick guides contents
                    for ( var g = 0; g < contents.length; g++ ) {

                        // Verify if the content has the required parameters
                        if ( (typeof contents[g].content_slug !== 'undefined') && (typeof contents[g].content_title !== 'undefined') && (typeof contents[g].content_type !== 'undefined') ) {

                            // Verify if the category slug was found
                            if ( (contents[g].content_slug === category_slug) && (contents[g].content_type === 'category') ) {

                                // Verify if content_childrens exists
                                if ( typeof contents[g].content_childrens !== 'undefined' ) {

                                    // Verify if the category is defined
                                    if ( parent_level ) {

                                        // Set category
                                        $('.main .theme-quick-guide .theme-quick-guide-go-back').attr('data-category', parent_level);                                 

                                    }

                                    // Show go back button
                                    $('.main .theme-quick-guide .theme-quick-guide-go-back').fadeIn('slow');

                                    // Display the contents
                                    Main.get_default_quick_guide_contents(contents[g].content_childrens);      

                                }

                            } else if ( typeof contents[g].content_childrens !== 'undefined' ) {

                                get_guide_contents(contents[g].content_childrens, category_slug, contents[g].content_slug);

                            }

                        }

                    }   

                }

                get_guide_contents(the_quick_guide_data, category_slug);

            }

        }

    });

    /*
     * Detect quick guide category click
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.5
    */
    $( document ).on( 'click', '.main .theme-quick-guide .theme-quick-guide-categories a', function (e) {
        e.preventDefault();
    
        // Get the category slug
        let category_slug = $(this).attr('data-category');

        // Remove category
        $('.main .theme-quick-guide .theme-quick-guide-go-back').removeAttr('data-category');

        // Verify if the_quick_guide_data exists
        if ( typeof the_quick_guide_data !== 'undefined' ) {

            function get_guide_contents(contents, category_slug, parent_level) {

                // List all quick guides contents
                for ( var g = 0; g < contents.length; g++ ) {

                    // Verify if the content has the required parameters
                    if ( (typeof contents[g].content_slug !== 'undefined') && (typeof contents[g].content_title !== 'undefined') && (typeof contents[g].content_type !== 'undefined') ) {

                        // Verify if the category slug was found
                        if ( (contents[g].content_slug === category_slug) && (contents[g].content_type === 'category') ) {

                            // Verify if content_childrens exists
                            if ( typeof contents[g].content_childrens !== 'undefined' ) {

                                // Verify if the category is defined
                                if ( parent_level ) {

                                    // Set category
                                    $('.main .theme-quick-guide .theme-quick-guide-go-back').attr('data-category', parent_level);

                                }

                                // Show go back button
                                $('.main .theme-quick-guide .theme-quick-guide-go-back').fadeIn('slow');                                

                                // Display the contents
                                Main.get_default_quick_guide_contents(contents[g].content_childrens);                            

                            }

                        } else if ( typeof contents[g].content_childrens !== 'undefined' ) {

                            get_guide_contents(contents[g].content_childrens, category_slug, contents[g].content_slug);

                        }

                    }

                }   

            }

            get_guide_contents(the_quick_guide_data, category_slug);

        }

    });

});