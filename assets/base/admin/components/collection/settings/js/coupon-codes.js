/*
 * Coupon Codes JavaScript file
*/

jQuery(document).ready(function () {
    'use strict';
    
    /*
     * Get the website's url
     */
    var url = $('meta[name=url]').attr('content');

    /*
     * Get coupon codes by page
     * 
     * @param integer page contains the page number
     * @param integer progress contains the progress option
     * 
     * @since   0.0.8.4
     */
    Main.get_coupon_codes = function (page, progress) {
        
        // Prepare data to send
        var data = {
            action: 'get_coupon_codes',
            page: page
        };

        // Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');

        // Verify if progress exists
        if ( typeof progress !== 'undefined' ) {

            // Make ajax call
            Main.ajax_call(url + 'admin/ajax/settings', 'POST', data, 'display_coupon_codes_response', 'ajax_onprogress');

            // Set progress bar
            Main.set_progress_bar();

        } else {

            // Make ajax call
            Main.ajax_call(url + 'admin/ajax/settings', 'POST', data, 'display_coupon_codes_response');

        }
        
    };

    /*******************************
    ACTIONS
    ********************************/

    /*
     * Load default content
     * 
     * @since   0.0.8.4 
     */
    $(function () {

        // Get coupon codes by page
        Main.get_coupon_codes(1);

    });

    /*
     * Detect pagination click
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.4
     */    
    $( document ).on( 'click', '.settings-page .theme-pagination li a', function (e) {
        e.preventDefault();
        
        // Get the page number
        var page = $(this).attr('data-page');
        
        // Display results
        switch ( $(this).closest('ul').attr('data-type') ) {
            
            case 'codes':
                
                // Get coupon codes by page
                Main.get_coupon_codes(page, 1);

                break;          
            
        }
        
    });  

    /*
     * Detect coupon code deletion
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.4
     */    
    $( document ).on( 'click', '.settings-page .settings-delete-code', function (e) {
        e.preventDefault();
        
        // Prepare data to send
        var data = {
            action: 'delete_coupon_code',
            code: $(this).closest('.card-code').attr('data-code')
        };

        // Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/settings', 'POST', data, 'delete_coupon_code_response', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
    });

    /*******************************
    RESPONSES
    ********************************/

    /*
     * Display coupon codes response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.4
     */
    Main.methods.display_coupon_codes_response = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();

        // Hide pagination
        $('.settings-page .theme-list > .card-footer').hide(); 

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Set current page
            Main.pagination.page = data.page;

            // Set total number of coupons
            Main.show_pagination('.settings-page', data.total);
            
            // All coupons container
            var all_coupons = '';

            // List all coupons
            for ( var c = 0; c < data.coupons.length; c++ ) {

                // Add coupon to the container
                all_coupons += '<div class="card theme-box-1 card-code" data-code="' + data.coupons[c].coupon_id + '">'
                    + '<div class="card-header">'
                        + '<div class="row">'
                            + '<div class="col-lg-7 col-md-5 col-xs-5">'
                                + '<div class="media d-flex justify-content-start">'
                                    + '<div class="media-body ps-0">'
                                        + '<h5>'
                                            + data.coupons[c].code
                                        + '</h5>'
                                    + '</div>'
                                + '</div>'
                            + '</div>'
                            + '<div class="col-lg-4 col-md-4 col-xs-4">'
                                + '<span>'
                                    + data.coupons[c].value + ' %'
                                + '</span>'
                            + '</div>'
                            + '<div class="col-lg-1 col-md-2 col-xs-2 text-end">'
                                + '<div class="btn-group theme-dropdown-2">'
                                    + '<button type="button" class="btn dropdown-toggle text-end" aria-haspopup="true" aria-expanded="false" data-bs-toggle="dropdown">'
                                        + words.icon_more
                                    + '</button>'
                                    + '<ul class="dropdown-menu">'
                                        + '<li>'
                                            + '<a href="#" class="settings-delete-code">'
                                                + words.icon_delete
                                                + data.words.delete
                                            + '</a>'
                                        + '</li>'
                                    + '</ul>'
                                + '</div>'
                            + '</div>'
                        + '</div>'
                    + '</div>'
                + '</div>';

            }

            // Display coupons codes
            $('.settings-page .theme-list > .card-body').html(all_coupons);   
            
            // Set limit
            let limit = ((data.page * 10) < data.total)?(data.page * 10):data.total;

            // Set text
            $('.settings-page .theme-list > .card-footer h6').html((((data.page - 1) * 10) + 1) + '-' + limit + ' ' + data.words.of + ' ' + data.total + ' ' + data.words.results);

            // Set page
            Main.pagination.page = data.page;

            // Display the pagination
            Main.show_pagination('.settings-page .theme-list', data.total);

            // Show pagination
            $('.settings-page .theme-list > .card-footer').show();  
            
        } else {

            // Set no data found message
            var no_data = '<p class="theme-box-1 theme-list-no-results-found">'
                                + data.message
                            + '</p>';

            // Display the no data found message
            $('.settings-page .theme-list > .card-body').html(no_data);    
            
        }
        
    };

    /*
     * Display deletion coupon codes response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.4
     */
    Main.methods.delete_coupon_code_response = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);

            // Get coupon codes by page
            Main.get_coupon_codes(1);
            
        } else {
            
            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);
            
        }
        
    };
    
});