/*
 * Transactions JavaScript file
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
     * @since   0.0.8.0
     */    
    Main.load_payments_transactions = function (page, progress) {

        // Verify if is the transactions page
        if ( $('.admin-page .admin-search-for-transactions').length > 0 ) {

            // Set data to pass
            var data = {
                action: 'load_payments_transactions',
                page: page,
                key: $('.admin-page .admin-search-for-transactions').val()
            };
            
            // Set CSRF
            data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');    
      
            // Verify if progress exists
            if ( typeof progress !== 'undefined' ) {

                // Make ajax call
                Main.ajax_call(url + 'admin/ajax/admin', 'POST', data, 'load_payments_transactions', 'ajax_onprogress');

                // Set progress bar
                Main.set_progress_bar();

            } else {

                // Make ajax call
                Main.ajax_call(url + 'admin/ajax/admin', 'POST', data, 'load_payments_transactions');

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
     * Search transactions
     * 
     * @since   0.0.8.0
     */
    $(document).on('keyup', '.admin-page .admin-search-for-transactions', function () {

        // Set this
        let $this = $(this);

        // Verify if input has a value
        if ( $(this).val() !== '' ) {

            // Verify if an event was already scheduled
            if ( typeof Main.queue !== 'undefined' ) {

                // Clear previous timout
                clearTimeout(Main.queue);

            }
            
            // Verify if loader icon has style
            if ( !$this.closest('div').find('.theme-list-loader-icon').attr('style') ) {

                // Set opacity
                $this.closest('div').find('.theme-list-loader-icon').fadeTo( 'slow', 1.0);

            }

            Main.schedule_event(function() {

                // Set opacity
                $this.closest('div').find('.theme-list-loader-icon').removeAttr('style');         

                // Set opacity
                $this.closest('div').find('a').fadeTo( 'slow', 1.0);

                // Load all transactions
                Main.load_payments_transactions(1, 1);

            }, 1000);

        } else {

            // Set opacity
            $this.closest('div').find('a').removeAttr('style');

            // Load all transactions
            Main.load_payments_transactions(1, 1);
            
        }
        
    });

    /*
     * Cancel the search for transactions
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.5
     */ 
    $( document ).on( 'click', '.admin-page .theme-cancel-search', function (e) {
        e.preventDefault();

        // Empty search input
        $('.admin-page .admin-search-for-transactions').val('');

        // Set opacity
        $(this).closest('div').find('a').removeAttr('style');

        // Load all transactions
        Main.load_payments_transactions(1, 1);
        
    });

    /*
     * Displays pagination by page click
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.0
     */    
    $( document ).on( 'click', 'body .theme-pagination li a', function (e) {
        e.preventDefault();
        
        // Get the page number
        var page = $(this).attr('data-page');

        // Load all transactions
        Main.load_payments_transactions(page, 1);
        
    });

    /*
     * Delete transactions
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.0
     */ 
    $( document ).on( 'click', '.admin-page .admin-delete-transactions', function (e) {
        e.preventDefault();
    
        // Define the transactions ids variable
        var transactions_ids = [];
        
        // Get selected transactions ids
        $('.admin-page .theme-list > .card-body input[type="checkbox"]:checkbox:checked').each(function () {
            transactions_ids.push($(this).attr('data-transaction'));
        });

        // Create an object with form data
        var data = {
            action: 'delete_transactions',
            transactions_ids: transactions_ids
        };
        
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/admin', 'POST', data, 'delete_transaction_response', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
    });

    /*
     * Delete transaction by id
     * 
     * @since   0.0.8.0
     */
    $(document).on('click', '.admin-page .theme-list > .card-body .admin-delete-transaction', function (e) {
        e.preventDefault();
        
        // Get transaction's id
        var transaction_id = $(this).closest('.card-transaction').attr('data-transaction');

        // Set data to pass
        var data = {
            action: 'delete_transaction',
            transaction_id: transaction_id
        };
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/admin', 'GET', data, 'delete_transaction_response', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
    });

    /*
     * Detect the transaction status change
     * 
     * @since   0.0.8.3
     */
    $(document).on('click', '.admin-page .admin-transaction-status-dropdown-list-ul .admin-transaction-status', function (e) {
        e.preventDefault();
        
        // Get transaction's id
        var transaction_id = $('.admin-page .transaction-header').attr('data-transaction');

        // Get status
        var status = $(this).attr('data-status');

        // Set data to pass
        var data = {
            action: 'change_transaction_status',
            transaction_id: transaction_id,
            status: status
        };

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/admin', 'GET', data, 'change_transaction_status_response', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
    });

    /*
     * Detect checkbox check
     * 
     * @since   0.0.8.5
     */ 
    $( document ).on( 'click', '.admin-page .theme-list > .card-body input[type="checkbox"]', function () {

        // Show the action
        if ( $('.admin-page .theme-list > .card-body :checkbox:checked').length > 0 ) {

            // Show actions
            $('.admin-page .card-actions').slideDown('slow');

            // Set selected items
            $('.admin-page .theme-list .theme-list-selected-items p').html($('.admin-page .theme-list > .card-body :checkbox:checked').length + ' ' + words.selected_items);

        } else {

            // Hide actions
            $('.admin-page .card-actions').slideUp('slow');
            
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
     * @since   0.0.8.0
     */
    Main.methods.load_payments_transactions = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();

        // Hide pagination
        $('.admin-page .theme-list > .card-footer').hide(); 

        // Hide actions
        $('.admin-page .card-actions').slideUp('slow');

        // Verify if the success response exists
        if ( status === 'success' ) {

            // All transactions
            var all_transactions = '';
            
            // List all transactions
            for ( var m = 0; m < data.transactions.length; m++ ) {

                // Default status
                var status = '<span class="badge bg-light theme-badge-1">'
                    + data.words.incomplete
                + '</span>';

                // Verify if transaction was successfully
                if ( data.transactions[m].status === '1' ) {

                    status = '<span class="badge bg-primary theme-badge-1">'
                        + data.words.success
                    + '</span>';         
    
                } else if ( data.transactions[m].status > 1 ) {

                    status = '<span class="badge bg-danger theme-badge-1">'
                        + data.words.error
                    + '</span>';                        

                }

                // Set transaction
                all_transactions += '<div class="card theme-box-1 card-transaction" data-transaction="' + data.transactions[m].transaction_id + '">'
                    + '<div class="card-header">'
                        + '<div class="row">'
                            + '<div class="col-lg-10 col-md-8 col-xs-8">'
                                + '<div class="media d-flex justify-content-start">'
                                    + '<div class="theme-checkbox-input-1">'
                                        + '<label for="admin-single-' + data.transactions[m].transaction_id + '">'
                                            + '<input type="checkbox" id="admin-single-' + data.transactions[m].transaction_id + '" data-transaction="' + data.transactions[m].transaction_id + '">'
                                            + '<span class="theme-checkbox-checkmark"></span>'
                                        + '</label>'
                                    + '</div>'
                                    + '<div class="media-body">'
                                        + '<h5>'
                                            + '<a href="' + url + 'admin/admin?p=transactions&transaction=' + data.transactions[m].transaction_id + '">'
                                                + '#' + data.transactions[m].transaction_id
                                            + '</a>'
                                        + '</h5>'
                                    + '</div>'
                                + '</div>'
                            + '</div>'
                            + '<div class="col-lg-1 col-md-2 col-xs-2">'
                                + status
                            + '</div>'
                            + '<div class="col-lg-1 col-md-2 col-xs-2 text-end">'
                                + '<div class="btn-group theme-dropdown-2">'
                                    + '<button type="button" class="btn dropdown-toggle text-end" aria-haspopup="true" aria-expanded="false" data-bs-toggle="dropdown">'
                                        + words.icon_more
                                    + '</button>'
                                    + '<ul class="dropdown-menu">'
                                        + '<li>'
                                            + '<a href="#" class="admin-delete-transaction">'
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

            // Display transactions
            $('.admin-page .theme-list > .card-body').html(all_transactions);   
            
            // Set limit
            let limit = ((data.page * 10) < data.total)?(data.page * 10):data.total;

            // Set text
            $('.admin-page .theme-list > .card-footer h6').html((((data.page - 1) * 10) + 1) + '-' + limit + ' ' + data.words.of + ' ' + data.total + ' ' + data.words.results);

            // Set page
            Main.pagination.page = data.page;

            // Display the pagination
            Main.show_pagination('.admin-page .theme-list', data.total);

            // Show pagination
            $('.admin-page .theme-list > .card-footer').show();  
            
        } else {

            // Set no data found message
            var no_data = '<p class="theme-box-1 theme-list-no-results-found">'
                                + data.message
                            + '</p>';

            // Display the no data found message
            $('.admin-page .theme-list > .card-body').html(no_data);    
            
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

        // Remove progress bar
        Main.remove_progress_bar();

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);

            // Hide actions
            $('.admin-page .card-actions').slideUp('slow');
            
            // Load all transactions
            Main.load_payments_transactions(1);
            
        } else {
            
            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);
            
        }

    };

    /*
     * Display transaction status change response
     * 
     * @param string status contains the response status
     * @param object data contains the response transaction
     * 
     * @since   0.0.8.3
     */
    Main.methods.change_transaction_status_response = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);

            // Display success status
            $('.admin-page .admin-transaction-status-btn').closest('div').html('<span class="label label-primary">' + data.words.success + '</span>');
            
        } else {
            
            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);
            
        }

    };
 
});