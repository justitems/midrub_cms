/*
 * Tab Transactions JavaScript file
*/

jQuery(document).ready( function ($) {
    'use strict';
    
    /*
     * Get the website's url
     */
    var url = $('meta[name=url]').attr('content');
    
    /*******************************
    METHODS
    ********************************/

    /*
     * Load payments transactions
     * 
     * @param integer page contains the page number
     * @param integer progress contains the progress option
     * 
     * @since   0.0.8.3
     */    
    Main.load_payments_transactions = function (page, progress) {

        // Verify if is the member's page
        if ( $('.members-page .panel-member-information').length > 0 ) {

            // Prepare data to send
            var data = {
                action: 'load_payments_transactions',
                member_id: $('.members-page .panel-member-information').attr('data-member'),
                page: page
            };
            
            // Set CSRF
            data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');

            // Verify if progress exists
            if ( typeof progress !== 'undefined' ) {

                // Make ajax call
                Main.ajax_call(url + 'admin/ajax/members', 'POST', data, 'load_payments_transactions', 'ajax_onprogress');

                // Set progress bar
                Main.set_progress_bar();

            } else {

                // Make ajax call
                Main.ajax_call(url + 'admin/ajax/members', 'POST', data, 'load_payments_transactions');

            }

        }
        
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

        // Load all transactions
        Main.load_payments_transactions(1);

    });

    /*
     * Displays pagination by page click
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.3
     */    
    $( document ).on( 'click', 'body .theme-pagination li a', function (e) {
        e.preventDefault();
        
        // Get the page number
        var page = $(this).attr('data-page');

        // Display results
        switch ($(this).closest('ul').attr('data-type')) {

            case 'member-transactions':

                // Load all transactions
                Main.load_payments_transactions(page, 1);            

                break;

        }
        
    });
   
    /*******************************
    RESPONSES
    ********************************/ 

    /*
     * Display transactions
     * 
     * @param string status contains the response status
     * @param object data contains the response transaction
     * 
     * @since   0.0.8.3
     */
    Main.methods.load_payments_transactions = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();

        // Hide pagination
        $('.members-page .theme-list > .card-footer').hide(); 

        // Hide actions
        $('.members-page .card-actions').slideUp('slow');

        // Verify if the success response exists
        if ( status === 'success' ) {

            // All transactions
            var all_transactions = '';
            
            // List all transactions
            for ( var c = 0; c < data.transactions.length; c++ ) {

                // Default status
                let status = '<span class="theme-badge-1 bg-light">'
                                + data.words.incomplete
                            + '</span>';

                // Verify if transaction was successfully
                if ( data.transactions[c].status === '1' ) {

                    status = '<span class="theme-badge-1 bg-primary">'
                                    + data.words.success
                                + '</span>';         
    
                } else if ( data.transactions[c].status > 1 ) {

                    status = '<span class="theme-badge-1 bg-danger">'
                                    + data.words.error
                                + '</span>';                        

                }

                // Set transaction
                all_transactions += '<div class="card theme-box-1 card-transaction" data-transaction="' + data.transactions[c].transaction_id + '">'
                    + '<div class="card-header">'
                        + '<div class="row">'
                            + '<div class="col-lg-10 col-md-8 col-xs-8">'
                                + '<div class="media d-flex justify-content-start">'
                                    + '<div class="media-body">'
                                        + '<h5>'
                                            + '<a href="' + url + 'admin/members?p=all_members&member=' + data.members[m].user_id + '">'
                                                + '#' + data.transactions[c].transaction_id
                                            + '</a>'
                                        + '</h5>'
                                    + '</div>'
                                + '</div>'
                            + '</div>'
                            + '<div class="col-lg-2 col-md-4 col-xs-4 text-end">'
                                + status
                            + '</div>'
                        + '</div>'
                    + '</div>'
                + '</div>';

            }

            // Display templates
            $('.members-page .theme-list > .card-body').html(all_transactions);   
            
            // Set limit
            let limit = ((data.page * 10) < data.total)?(data.page * 10):data.total;

            // Set text
            $('.members-page .theme-list > .card-footer h6').html((((data.page - 1) * 10) + 1) + '-' + limit + ' ' + data.words.of + ' ' + data.total + ' ' + data.words.results);

            // Set page
            Main.pagination.page = data.page;

            // Display the pagination
            Main.show_pagination('.members-page .theme-list', data.total);

            // Show pagination
            $('.members-page .theme-list > .card-footer').show();   
            
        } else {

            // Set no data found message
            var no_data = '<p class="theme-box-1 theme-list-no-results-found">'
                                + data.message
                            + '</p>';

            // Display the no data found message
            $('.members-page .theme-list > .card-body').html(no_data);  
            
        }

    };
 
});