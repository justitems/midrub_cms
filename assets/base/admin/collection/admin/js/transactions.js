/*
 * Transactions javascript file
*/

jQuery(document).ready( function ($) {
    'use strict';
    
    // Get home page url
    var url = $('.navbar-brand').attr('href');
    
    /*******************************
    METHODS
    ********************************/

    /*
     * Load payments transactions
     * 
     * @param integer page contains the page number
     * 
     * @since   0.0.8.0
     */    
    Main.load_payments_transactions = function (page) {

        var data = {
            action: 'load_payments_transactions',
            page: page,
            key: $('.admin-page .search-transactions').val()
        };
        
        // Set the CSRF field
        data[$('.admin-page .csrf-sanitize').attr('name')] = $('.admin-page .csrf-sanitize').val();
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/admin', 'POST', data, 'load_payments_transactions');
        
    };

    /*
     * Display transactions pagination
     */
    Main.show_transactions_pagination = function( id, total ) {
        
        // Empty pagination
        $( id + ' .pagination' ).empty();
        
        // Verify if page is not 1
        if ( parseInt(Main.pagination.page) > 1 ) {
            
            var bac = parseInt(Main.pagination.page) - 1;
            var pages = '<li><a href="#" data-page="' + bac + '">' + translation.mm128 + '</a></li>';
            
        } else {
            
            var pages = '<li class="pagehide"><a href="#">' + translation.mm128 + '</a></li>';
            
        }
        
        // Count pages
        var tot = parseInt(total) / 20;
        tot = Math.ceil(tot) + 1;
        
        // Calculate start page
        var from = (parseInt(Main.pagination.page) > 2) ? parseInt(Main.pagination.page) - 2 : 1;
        
        // List all pages
        for ( var p = from; p < parseInt(tot); p++ ) {
            
            // Verify if p is equal to current page
            if ( p === parseInt(Main.pagination.page) ) {
                
                // Display current page
                pages += '<li class="active"><a data-page="' + p + '">' + p + '</a></li>';
                
            } else if ( (p < parseInt(Main.pagination.page) + 3) && (p > parseInt(Main.pagination.page) - 3) ) {
                
                // Display page number
                pages += '<li><a href="#" data-page="' + p + '">' + p + '</a></li>';
                
            } else if ( (p < 6) && (Math.round(tot) > 5) && ((parseInt(Main.pagination.page) === 1) || (parseInt(Main.pagination.page) === 2)) ) {
                
                // Display page number
                pages += '<li><a href="#" data-page="' + p + '">' + p + '</a></li>';
                
            } else {
                
                break;
                
            }
            
        }
        
        // Verify if current page is 1
        if (p === 1) {
            
            // Display current page
            pages += '<li class="active"><a data-page="' + p + '">' + p + '</a></li>';
            
        }
        
        // Set the next page
        var next = parseInt( Main.pagination.page );
        next++;
        
        // Verify if next page should be displayed
        if (next < Math.round(tot)) {
            
            $( id + ' .pagination' ).html( pages + '<li><a href="#" data-page="' + next + '">' + translation.mm129 + '</a></li>' );
            
        } else {
            
            $( id + ' .pagination' ).html( pages + '<li class="pagehide"><a href="#">' + translation.mm129 + '</a></li>' );
            
        }
        
    };

    /*******************************
    ACTIONS
    ********************************/

    /*
     * Search transactions
     * 
     * @since   0.0.8.0
     */
    $(document).on('keyup', '.admin-page .search-transactions', function () {
        
        // Load all transactions
        Main.load_payments_transactions(1);
        
    });

    /*
     * Displays pagination by page click
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.0
     */    
    $( document ).on( 'click', 'body .pagination li a', function (e) {
        e.preventDefault();
        
        // Get the page number
        var page = $(this).attr('data-page');

        // Load all transactions
        Main.load_payments_transactions(page);
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });

    /*
     * Detect all transactions selection
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.0
     */ 
    $( document ).on( 'click', '.admin-page #admin-transactions-select-all', function (e) {

        setTimeout(function(){
            
            if ( $( '.admin-page #admin-transactions-select-all' ).is(':checked') ) {

                $( '.admin-page .list-transactions li input[type="checkbox"]' ).prop('checked', true);

            } else {

                $( '.admin-page .list-transactions li input[type="checkbox"]' ).prop('checked', false);

            }
        
        },500);
        
    });

    /*
     * Delete transactions
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.0
     */ 
    $( document ).on( 'click', '.admin-page .delete-transactions', function (e) {
        e.preventDefault();
    
        // Define the transactions ids variable
        var transactions_ids = [];
        
        // Get selected transactions ids
        $('.admin-page .list-transactions li input[type="checkbox"]:checkbox:checked').each(function () {
            transactions_ids.push($(this).attr('data-id'));
        });

        // Create an object with form data
        var data = {
            action: 'delete_transactions',
            transactions_ids: transactions_ids
        };
        
        // Set the CSRF field
        data[$('.admin-page .csrf-sanitize').attr('name')] = $('.admin-page .csrf-sanitize').val();
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/admin', 'POST', data, 'delete_transaction_response');

        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });

    /*
     * Delete transaction by id
     * 
     * @since   0.0.8.0
     */
    $(document).on('click', '.admin-page .list-transactions .delete-transaction', function (e) {
        e.preventDefault();
        
        // Get transaction's id
        var transaction_id = $(this).closest('.transactions-single').attr('data-id');

        var data = {
            action: 'delete_transaction',
            transaction_id: transaction_id
        };
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/admin', 'GET', data, 'delete_transaction_response');

        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
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
     * @since   0.0.8.0
     */
    Main.methods.load_payments_transactions = function ( status, data ) {

        // Uncheck all selected transactions
        $( '.admin-page #admin-transactions-select-all' ).prop('checked', false)

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Generate pagination
            Main.pagination.page = data.page;
            Main.show_transactions_pagination('.admin-page', data.total);

            // All transactions
            var all_transactions = '';
            
            // List all transactions
            for ( var c = 0; c < data.transactions.length; c++ ) {

                // Default status
                var status = '<span class="label label-default">'
                                + data.words.incomplete
                            + '</span>';

                // Verify if transaction was successfully
                if ( data.transactions[c].status === '1' ) {

                    status = '<span class="label label-primary">'
                                    + data.words.success
                                + '</span>';         
    
                } else if ( data.transactions[c].status > 1 ) {

                    status = '<span class="label label-danger">'
                                    + data.words.error
                                + '</span>';                        

                }

                // Set transaction
                all_transactions += '<li class="transactions-single" data-id="' + data.transactions[c].transaction_id + '">'
                    + '<div class="row">'
                        + '<div class="col-lg-10 col-md-8 col-xs-8">'
                            + '<div class="checkbox-option-select">'
                                + '<input id="admin-transactions-single-' + data.transactions[c].transaction_id + '" name="admin-transactions-single-' + data.transactions[c].transaction_id + '" data-id="' + data.transactions[c].transaction_id + '" type="checkbox">'
                                + '<label for="admin-transactions-single-' + data.transactions[c].transaction_id + '"></label>'
                            + '</div>'
                            + '<a href="' + url + 'admin/admin?p=transactions&transaction=' + data.transactions[c].transaction_id + '">'
                                + '#' + data.transactions[c].transaction_id
                            + '</a>'
                        + '</div>'
                        + '<div class="col-lg-1 col-md-2 col-xs-2">'
                            + status
                        + '</div>'
                        + '<div class="col-lg-1 col-md-2 col-xs-2 text-right">'
                            + '<div class="btn-group">'
                                + '<button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                                    + '<i class="icon-options-vertical"></i>'
                                + '</button>'
                                + '<ul class="dropdown-menu">'
                                    + '<li>'
                                        + '<a href="#" class="delete-transaction">'
                                            + '<i class="icon-trash"></i>'
                                            + data.words.delete
                                        + '</a>'
                                    + '</li>'
                                + '</ul>'
                            + '</div>'
                        + '</div>'
                    + '</div>'
                + '</li>';

            }

            // Get the page
            var page = ( (data.page - 1) < 1)?1:((data.page - 1) * 20);

            // Get results to
            var to = ((parseInt(page) * 20) < data.total)?(parseInt(data.page) * 20):data.total;

            // Display transactions
            $('.admin-page .list-transactions').html(all_transactions);

            // Display start listing
            $('.admin-page .pagination-from').text(page);  
            
            // Display end listing
            $('.admin-page .pagination-to').text(to);  

            // Display total items
            $('.admin-page .pagination-total').text(data.total);

            // Show Pagination
            $('.admin-page .pagination-area').show();  
            
        } else {

            // Hide Pagination
            $('.admin-page .pagination-area').hide();  
            
            // Set no data found message
            var no_data = '<li>'
                                + data.message
                            + '</li>';

            // Display transactions
            $('.admin-page .list-transactions').html(no_data);   
            
        }

    };

    /*
     * Display transaction deletion response
     * 
     * @param string status contains the response status
     * @param object data contains the response transaction
     * 
     * @since   0.0.8.0
     */
    Main.methods.delete_transaction_response = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
            // Load all transactions
            Main.load_payments_transactions(1);
            
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

    // Hide loading animation
    $('.page-loading').fadeOut('slow');

    // Load all transactions
    Main.load_payments_transactions(1);
 
});