/*
 * Main Dashboard JavaScript file
*/
jQuery(document).ready( function ($) {
    'use strict';

    // Get website url
    var url =  $('meta[name=url]').attr('content');
    
    /*******************************
    METHODS
    ********************************/

    /*******************************
    ACTIONS
    ********************************/

    /*
     * Show or hide the Quick Guide
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.3
     */ 
    $( document ).on( 'click', '.main .theme-toggle-quick-guide', function (e) {
        e.preventDefault();

        // Show or hide the Quick Guide
        if ( $( '.main .theme-quick-guide' ).hasClass( 'theme-quick-guide-show' ) ) {

            // Remove show class
            $( '.main .theme-quick-guide' ).removeClass( 'theme-quick-guide-show' );

        } else {

            // Add show class
            $( '.main .theme-quick-guide' ).addClass( 'theme-quick-guide-show' );

            // Verify if categories or articles exists
            if ( ( $( '.main .theme-quick-guide .theme-quick-guide-categories > a' ).length < 1 ) && ( $( '.main .theme-quick-guide .theme-quick-guide-articles > div' ).length < 1 ) ) {

                // Prepare data to send
                var data = {
                    action: 'crm_dashboard_quick_guides_by_category',
                    slug: $('[data-quick-guide]').attr('data-quick-guide')
                };

                // Set CSRF
                data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');

                // Make ajax call
                Main.ajax_call(url + 'user/app-ajax/crm_dashboard', 'POST', data, 'crm_dashboard_quick_guides_by_category');                

            }
            
        }
        
    });

    /*
     * Show category in the Quick Guide
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.3
     */ 
    $( document ).on( 'click', '.main .theme-quick-guide .theme-quick-guide-categories > .list-group-item, .theme-quick-guide .theme-quick-guide-go-back', function (e) {
        e.preventDefault();

        // Get the category's slug
        let category_slug = $(this).attr('data-category');

        // Prepare data to send
        var data = {
            action: 'crm_dashboard_quick_guides_by_category',
            slug: category_slug
        };

		// Set CSRF
		data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');

        // Make ajax call
        Main.ajax_call(url + 'user/app-ajax/crm_dashboard', 'POST', data, 'crm_dashboard_quick_guides_by_category');
        
    });
   
    /*******************************
    RESPONSES
    ********************************/

    /*
     * Display the quick guides by category
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.3
     */
    Main.methods.crm_dashboard_quick_guides_by_category = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Verify if parent exists
            if ( data.response.parent_slug ) {

                // Display the go back button
                $('.theme-quick-guide .theme-quick-guide-go-back').fadeIn('slow');

                // Set item's slug
                $('.theme-quick-guide .theme-quick-guide-go-back').attr('data-category', data.response.parent_slug);

            } else {

                // Hide the go back button
                $('.theme-quick-guide .theme-quick-guide-go-back').fadeOut('slow');
                
            }

            // Verify if categories exists
            if ( data.response.categories.length > 0 ) {

                // Categories variable
                var categories = '';

                // List all categories
                for ( var c = 0; c < data.response.categories.length; c++ ) {

                    // Set category
                    categories += '<a href="#" class="list-group-item list-group-item-action" data-category="' + data.response.categories[c].item_slug + '">'
                                    + '<i class="' + data.response.categories[c].icon + '"></i>'
                                    + data.response.categories[c].classification_name
                                    + '<small>'
                                        + '<i class="ri-arrow-right-line"></i>'
                                    + '</small>'
                                + '</a>';

                }

                // Set categories
                $('.theme-quick-guide .theme-quick-guide-categories').html(categories);

            } else {

                // Empty categories
                $('.theme-quick-guide .theme-quick-guide-categories').empty();

            }

            // Verify if guides exists
            if ( data.response.guides.length > 0 ) {

                // Guides variable
                var guides = '';

                // List all guides
                for ( var g = 0; g < data.response.guides.length; g++ ) {

                    // Set guide
                    guides += '<div class="list-group-item list-group-item-action flex-column align-items-start">'
                                + '<div class="d-flex w-100 justify-content-between">'
                                    + '<h5 class="article-title">'
                                        + data.response.guides[g].content_title
                                    + '</h5>'
                                + '</div>'
                                + '<div class="article-content">'
                                    + data.response.guides[g].content_body
                                + '</div>'
                            + '</div>';

                }

                // Set guides
                $('.theme-quick-guide .theme-quick-guide-articles').html(guides);

            } else {

                // Empty guides
                $('.theme-quick-guide .theme-quick-guide-articles').empty();

            }
            
        }
        
    };
    
    /*******************************
    FORMS
    ********************************/
    
    /*******************************
    DEPENDENCIES
    ********************************/

});