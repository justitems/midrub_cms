/*
 * Main javascript file
*/

jQuery(document).ready( function ($) {
    'use strict';
    
    /*******************************
    METHODS
    ********************************/

    /*
     * Set progress bar
     *
     * @since   0.0.8.5
     */
    Main.set_progress_bar = function() {

        // Bar
        let bar = '<div class="theme-send-loading"></div>';

        // Insert bar
        $(bar).insertAfter('.wrapper');

    };

    /*
     * Remove progress bar
     *
     * @since   0.0.8.5
     */
    Main.remove_progress_bar = function() {

        // Remove the progress bar
        setTimeout(function () {

            $('body .theme-send-loading').remove();

        }, 1000);

    };

    /*
     * Display alert
     */
    Main.show_alert = function( cl, msg, ft, lt ) {

        // Add notification
        $('<div class="theme-popup-notification md-notification-' + cl + '"><i class="iconify" data-icon="fluent:alert-28-regular"></i> ' + msg + '</div>').insertAfter('section');

        // Display alert
        setTimeout(function () {

            $( document ).find( '.theme-popup-notification' ).animate({opacity: '0'}, 500);

        }, ft);

        // Hide alert
        setTimeout(function () {

            $( document ).find( '.theme-popup-notification' ).remove();

        }, lt);

    };

    /*
     * Display pagination
     *
     * @param string id contains the location
     * @param integer total contains the number of items
     * @param integer limit contains the limit
     * 
     * @since   0.0.8.5
     */
    Main.show_pagination = function( id, total, limit ) {
        
        // Empty pagination
        $( id + ' .theme-pagination' ).empty();

        // Set limit
        limit = limit?limit:10;
        
        // Verify if page is not 1
        if ( parseInt(Main.pagination.page) > 1 ) {
            
            // Get previous
            var previous = parseInt(Main.pagination.page) - 1;

            // Set link
            var pages = '<li class="page-item">'
                            + '<a href="#" class="page-link" data-page="' + previous + '">'
                                + Main.translation.theme_icon_arrow_ltr
                            + '</a>'
                        + '</li>';
            
        } else {
            
            // Set disabled link
            var pages = '<li class="page-item disabled">'
                            + '<a href="#" class="page-link" href="#" tabindex="-1">'
                                + Main.translation.theme_icon_arrow_ltr
                            + '</a>'
                        + '</li>';
            
        }
        
        // Count pages
        var tot = parseInt(total) / limit;
        tot = Math.ceil(tot) + 1;
        
        // Calculate start page
        var from = (parseInt(Main.pagination.page) > 2) ? parseInt(Main.pagination.page) - 2 : 1;
        
        // List all pages
        for ( var p = from; p < parseInt(tot); p++ ) {
            
            // Verify if p is equal to current page
            if ( p === parseInt(Main.pagination.page) ) {
                
                // Add current page
                pages += '<li class="page-item active">'
                            + '<a href="#" class="page-link" data-page="' + p + '">'
                                + p
                            + '</a>'
                        + '</li>';
                
            } else if ( (p < parseInt(Main.pagination.page) + 3) && (p > parseInt(Main.pagination.page) - 3) ) {
                
                // Add page number
                pages += '<li class="page-item">'
                            + '<a href="#" class="page-link" data-page="' + p + '">'
                                + p
                            + '</a>'
                        + '</li>';
                
            } else if ( (p < 6) && (Math.round(tot) > 5) && ((parseInt(Main.pagination.page) === 1) || (parseInt(Main.pagination.page) === 2)) ) {
                
                // Add page number
                pages += '<li class="page-item">'
                            + '<a href="#" class="page-link" data-page="' + p + '">'
                                + p
                            + '</a>'
                        + '</li>';
                
            } else {
                
                break;
                
            }
            
        }
        
        // Verify if current page is 1
        if (p === 1) {
            
            // Add current page
            pages += '<li class="page-item active">'
                        + '<a href="#" class="page-link" data-page="' + p + '">'
                            + p
                        + '</a>'
                    + '</li>';
            
        }
        
        // Set the next page
        var next = parseInt( Main.pagination.page );

        // Increase the next
        next++;
        
        // Verify if next page should be displayed
        if (next < Math.round(tot)) {

            // Add next page
            pages += '<li class="page-item">'
                        + '<a href="#" class="page-link" data-page="' + next + '">'
                            + Main.translation.theme_icon_arrow_rtl
                        + '</a>'
                    + '</li>';
            
            // Display pagination
            $( id + ' .theme-pagination' ).html( pages );
            
        } else {

            // Add next page
            pages += '<li class="page-item disabled">'
                        + '<a href="#" class="page-link" data-page="' + next + '">'
                            + Main.translation.theme_icon_arrow_rtl
                        + '</a>'
                    + '</li>';
            
            // Display pagination
            $( id + ' .theme-pagination' ).html( pages );
            
        }
        
    };

    /*
     * Reset field image
     */
    Main.reset_field_image = function(location) {
        
        // Reset field image
        $(location + ' .theme-image-field > .card-header').html('<span class="iconify" data-icon="fluent:image-copy-20-regular"></span>');

    };

    /*
     * Schedule event
     * 
     * @param funcion fun contains the function
     * @param integer interval contains time
     * 
     * @since   0.0.8.3
     */
    Main.schedule_event = function($fun, interval) {

        // Add to queue
        Main.queue = setTimeout($fun, interval);
        
    };
  
    /*******************************
    ACTIONS
    ********************************/

    /*
    * Load default content
    *
    * @since   0.0.8.5
    */
    $(function () {

        // Schedule
        setTimeout(function () {

            // Remove the page loading
            $('.theme-page-loading').remove();

        }, 500);

    });

    /*
     * Detect fields keyup
     */
    $(document).on('keyup', '.main .theme-settings-options .theme-text-input-1, .main .theme-settings-options .theme-textarea-1, .main .theme-settings-options .theme-password-input', function () {

        // Show the save button
        $('body .theme-save-changes').slideDown('slow');

    });    

    /*
     * Detect fields change
     */
    $(document).on('change', '.main .theme-settings-options .theme-checkbox-input-2 > input, .main .theme-settings-options .theme-text-input-1, .main .theme-settings-options .theme-textarea-1, .main .theme-settings-options .theme-password-input', function () {

        // Show the save button
        $('body .theme-save-changes').slideDown('slow');

    });  

    /*
     * Detect any click
     *
     * @param object e with global object
     */
    $(document).click(function(e) {

        var menu = $( '.sidebar-header > li > ul, .sidebar-bottom > li > ul' );

        if ( typeof e !== 'undefined' ) {

            if ( !menu.is(e.target) && menu.has(e.target).length === 0 ) {

                if ( !$(e.target).closest('li').hasClass('nav-active') ) {

                    // Hide submenu
                    $('.sidebar-header > li, .sidebar-bottom > li').each(function() {

                        if ( $(this).find('ul').length > 0 ) {
                            $(this).removeClass('nav-active');
                            $(this).find('ul').removeAttr('style');
                        }

                    });

                } 

            }

        }

    });

    /*
     * Detect dropdown show
     *
     * @param object e with global object
     */
    $(document).on('click', '.sidebar > ul > li > a', function (e) {

        // Verify if menu has submenu
        if ( $(this).closest('li').find('ul').length > 0 ) {
            e.preventDefault();

            // Verify if the menu is open
            if ( !$(e.target).closest('li').hasClass('nav-active') ) {

                // Open the submenu
                $(this).closest('li').addClass('nav-active');

                // Remove the focus
                $(this).blur();

                // Set top
                let top_drop = $(this).offset().top;

                // Set menu to open
                let ul = $(this).closest('li').find('ul');

                // Get submenu height
                let submenu_height = ul.outerHeight();
                
                // Verify if the submenu position
                if ( ($(window).height() - $(this).offset().top) < submenu_height ) {
                    top_drop = top_drop - ((submenu_height + 15) - ($(window).height() - $(this).offset().top));
                } else {
                    top_drop = $(this).offset().top;
                }

                setTimeout(function() {
                    
                    if ( ul.closest('.sidebar-header').length > 0 ) {

                        ul.css({
                            'display': 'block',
                            'transform': 'none',
                            'top': top_drop + 'px',
                            'opacity': 1
                        });

                    } else {

                        ul.css({
                            'display': 'block',
                            'transform': 'none',
                            'top': top_drop + 'px',
                            'opacity': 1
                        });

                    }

                }, 100);

            } else {

                // Hide the submenu
                $(this).closest('li').removeClass('nav-active');
                $(this).closest('li').find('ul').removeAttr('style');

            }

        }

    });

    /*
     * Show or hide the Quick Guide
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.5
     */ 
    $( document ).on( 'click', '.wrapper .theme-toggle-quick-guide', function (e) {
        e.preventDefault();

        // Show or hide the Quick Guide
        if ( $( '.wrapper .theme-quick-guide' ).hasClass( 'theme-quick-guide-show' ) ) {

            // Remove show class
            $( '.wrapper .theme-quick-guide' ).removeClass( 'theme-quick-guide-show' );

        } else {

            // Add show class
            $( '.wrapper .theme-quick-guide' ).addClass( 'theme-quick-guide-show' );
            
        }
        
    }); 

    /*
     * Detect dropdown selection
     * 
     * @param integer page contains the page number
     * 
     * @since   0.0.8.5
     */ 
    $( document ).on( 'click', '.main .theme-settings-options .dropdown .theme-dropdown-items-list a', function (e) {
        e.preventDefault();

        // Get item's ID
        let item = $(this).attr('data-id');

        // Get item's name
        let item_name = $(this).text();

        // Set item's ID
        $(this).closest('.dropdown').find('.btn-secondary').attr('data-id', item);

        // Set item's name
        $(this).closest('.dropdown').find('.btn-secondary > span').text(item_name);          
        
        // Show the save button
        $('body .theme-save-changes').slideDown('slow');      
        
    });
    
    /*
     * Hide the save button
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.5
     */ 
    $( document ).on( 'click', 'body .theme-save-changes .theme-cancel-changes-btn', function (e) {
        e.preventDefault();

        // Hide the save button
        $('body .theme-save-changes').slideUp('slow');
        
    });
   
    /*******************************
    RESPONSES
    ********************************/

    /*
     * Track progress ajax request
     *
     * @param integer loaded contains the loaded's data
     * @param integer total contains the total's legth
     * 
     */
    Main.methods.ajax_onprogress = function(loaded, total) {
        
        // Get percentage
        let percentage = ((loaded/total) * 100).toFixed(2);

        // Set progress bar width
        $('body .theme-send-loading').css('width', percentage + '%');

    };

});