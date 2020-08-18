/*
 * Referrals javascript file
*/

jQuery(document).ready( function ($) {
    'use strict';
    
    // Get home page url
    var url = $('.navbar-brand').attr('href');
    
    /*******************************
    METHODS
    ********************************/

    /*
     * Load referrals reports
     * 
     * @param integer page contains the page number
     * 
     * @since   0.0.7.6
     */
    Main.load_referrals_reports = function (page) {
        
        var data = {
            action: 'load_referrals_reports',
            page: page
        };
        
        if ( $('.settings .from-date').val() ) {
            
            var from = Date.parse($('.settings .from-date').val());
            
            if ( !isNaN(from) ) {
                data['date_from'] = from/1000;
            }
            
        }
        
        if ( $('.settings .to-date').val() ) {
            
            var to = Date.parse($('.settings .to-date').val());
            
            if ( !isNaN(to) ) {
                data['date_to'] = to/1000;
            }
            
        }
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/settings', 'GET', data, 'load_referrals_reports');
        
    };
    
    /*
     * Load referrers list
     * 
     * @param integer page contains the page number
     * 
     * @since   0.0.7.6
    */
    Main.load_referrers_list = function (page) {
        
        var data = {
            action: 'load_referrers_list',
            page: page
        };
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/settings', 'GET', data, 'load_referrers_list');
        
    };    

   
    /*******************************
    ACTIONS
    ********************************/
        
    /*
     * Displays pagination by page click
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.6
     */    
    $( document ).on( 'click', 'body .pagination li a', function (e) {
        e.preventDefault();
        
        // Get the page number
        var page = $(this).attr('data-page');
        
        // Display results
        switch ( $(this).closest('ul').attr('data-type') ) {
            
            case 'referral-reports':
                Main.load_referrals_reports(page);
                break; 
            
            case 'referral-referrers':
                Main.load_referrers_list(page);
                break;             
            
        }
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });
    
    /*
     * Displays referrals based on date click
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.6
     */    
    $( document ).on( 'click', 'body .btn-show-referrals', function (e) {
        e.preventDefault();
        
        // Load referrals
        Main.load_referrals_reports(1);
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });
    
    /*
     * Detect pay button click
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.6
     */    
    $( document ).on( 'click', 'body .referral-pay-gains', function (e) {
        e.preventDefault();
        
        // Get the user's id
        var user_id = $(this).attr('data-id');
        
        var data = {
            action: 'referral_pay_gains',
            user_id: user_id
        };
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/settings', 'GET', data, 'referral_pay_gains');
        
    });    
   
    /*******************************
    RESPONSES
    ********************************/
   
    /*
     * Display referrals reports response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.6
     */
    Main.methods.load_referrals_reports = function ( status, data ) { 

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Show footer
            $('.settings #reports tfoot').show();   
            
            Main.pagination.page = data.page;
            Main.show_pagination('#reports', data.referrals[0].total);
            
            var all_referrals = '';
            
            // List all referrals
            for ( var r = 0; r < data.referrals.length; r++ ) {
                
                var paid = '<span class="span-closed">' + data.words.free + '</span>';
                
                if ( parseInt(data.referrals[r].earned) ) {
                    paid = '<span class="span-active">' + data.words.paid + '</span>';
                }

                all_referrals += '<tr>'
                                    + '<td>'
                                        + '<a href="' + url + 'admin/users#' + data.referrals[r].user_id + '">'
                                            + data.referrals[r].username
                                        + '</a>'
                                    + '</td>'
                                    + '<td>'
                                        + Main.calculate_time(data.referrals[r].created, data.time)
                                    + '</td>'
                                    + '<td class="text-right">'
                                        + paid
                                    + '</td>'
                                + '</tr>';
                
            }
            
            $('.settings #reports tbody').html(all_referrals);
            
        } else {
            
            var no_referrals = '<tr>'
                                + '<td>'
                                    + data.message
                                + '</td>'
                            + '</tr>';
            
            $('.settings #reports tbody').html(no_referrals);
            
            // Hide footer
            $('.settings #reports tfoot').hide();   
            
        }
        
    };
    
    /*
     * Load referrers list response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.6
     */
    Main.methods.load_referrers_list = function ( status, data ) { 

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Show footer
            $('.settings #payments tfoot').show();   
            
            Main.pagination.page = data.page;
            Main.show_pagination('#payments', data.referrals[0].total);
            
            var all_referrals = '';
            
            // List all referrals
            for ( var r = 0; r < data.referrals.length; r++ ) {

                var pay = '';
                var paid = data.words.dont_has_non_paid_gains;
                
                if ( parseInt(data.referrals[r].paid) < parseInt(data.referrals[r].total) ) {
                    pay = '<a href="#" class="referral-pay-gains" data-id="' + data.referrals[r].user_id + '">' + data.words.pay + '</a>';
                    paid = data.words.has_non_paid_gains + ': ' + data.referrals[r].earned + ' ' + data.referrals[r].currency_code;
                } else {
                    pay = '<span class="span-unactive">' + data.referrals[r].earned + ' ' + data.referrals[r].currency_code + '</a>';
                }

                all_referrals += '<tr>'
                                    + '<td>'
                                        + '<a href="' + url + 'admin/users#' + data.referrals[r].user_id + '">'
                                            + data.referrals[r].username
                                        + '</a>'
                                    + '</td>'
                                    + '<td>'
                                        + paid
                                    + '</td>'
                                    + '<td class="text-right">'
                                        + pay
                                    + '</td>'
                                + '</tr>';
                
            }
            
            $('.settings #payments tbody').html(all_referrals);
            
        } else {
            
            var no_referrals = '<tr>'
                                + '<td>'
                                    + data.message
                                + '</td>'
                            + '</tr>';
            
            $('.settings #payments tbody').html(no_referrals);
            
            // Hide footer
            $('.settings #payments tfoot').hide();  
            
        }
        
    };
    
    /*
     * Display pay button response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.6
     */
    Main.methods.referral_pay_gains = function ( status, data ) { 

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
            // Reload referrers list
            Main.load_referrers_list(1);
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }
        
    };    
   
    /*******************************
    FORMS
    ********************************/
    

    
    /*******************************
    DEPENDENCIES
    ********************************/
   
    /*
     * Load referrals reports
     * 
     * @since   0.0.7.6
     */
    Main.load_referrals_reports(1);
    
    /*
     * Load referrers list
     * 
     * @since   0.0.7.6
     */
    Main.load_referrers_list(1);
    
    $('.from-date').datepicker();
    $('.to-date').datepicker();
    
});