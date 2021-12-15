/*
 * Main Invoices javascript file
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
     * Load invoices by page
     * 
     * @param integer page contains the page number
     * @param integer progress contains the progress option
     * 
     * @since   0.0.8.1
     */    
    Main.load_payments_invoices = function (page, progress) {

        var data = {
            action: 'load_payments_invoices',
            page: page,
            key: $('.admin-page .admin-search-for-invoices').val()
        };
        
        // Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');

        // Verify if progress exists
        if ( typeof progress !== 'undefined' ) {

            // Make ajax call
            Main.ajax_call(url + 'admin/ajax/admin', 'POST', data, 'load_payments_invoices', 'ajax_onprogress');

            // Set progress bar
            Main.set_progress_bar();

        } else {

            // Make ajax call
            Main.ajax_call(url + 'admin/ajax/admin', 'POST', data, 'load_payments_invoices');

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

        // Load all invoices
        Main.load_payments_invoices(1);

    });

    /*
     * Search for invoices
     * 
     * @since   0.0.8.1
     */
    $(document).on('keyup', '.admin-page .admin-search-for-invoices', function () {

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

                // Load all invoices
                Main.load_payments_invoices(1, 1);

            }, 1000);

        } else {

            // Set opacity
            $this.closest('div').find('a').removeAttr('style');

            // Load all invoices
            Main.load_payments_invoices(1, 1);
            
        }
        
    }); 

    /*
     * Cancel the search for invoices
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.5
     */ 
    $( document ).on( 'click', '.admin-page .theme-cancel-search', function (e) {
        e.preventDefault();

        // Empty search input
        $('.admin-page .admin-search-for-invoices').val('');

        // Set opacity
        $(this).closest('div').find('a').removeAttr('style');

        // Load all invoices
        Main.load_payments_invoices(1, 1);
        
    });

    /*
     * Displays pagination by page click
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.1
     */    
    $( document ).on( 'click', 'body .theme-pagination li a', function (e) {
        e.preventDefault();
        
        // Get the page number
        var page = $(this).attr('data-page');

        // Load all invoices by page
        Main.load_payments_invoices(page, 1);
        
        // Set progress bar
        Main.set_progress_bar();
        
    });

    /*
     * Delete invoices
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.1
     */ 
    $( document ).on( 'click', '.admin-page .delete-invoices', function (e) {
        e.preventDefault();
    
        // Define the invoices ids variable
        var invoices_ids = [];
        
        // Get selected invoices ids
        $('.admin-page .list-invoices li input[type="checkbox"]:checkbox:checked').each(function () {
            invoices_ids.push($(this).attr('data-id'));
        });

        // Create an object with form data
        var data = {
            action: 'delete_invoices',
            invoices_ids: invoices_ids
        };
        
        // Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');  
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/admin', 'POST', data, 'delete_invoice_response', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
    });

    /*
     * Delete invoice by id
     * 
     * @since   0.0.8.1
     */
    $(document).on('click', '.admin-page .list-invoices .delete-invoice', function (e) {
        e.preventDefault();
        
        // Get invoice's id
        var invoice_id = $(this).closest('.invoices-single').attr('data-id');

        // Prepare data to send
        var data = {
            action: 'delete_invoice',
            invoice_id: invoice_id
        };
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/admin', 'GET', data, 'delete_invoice_response', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
    });
   
    /*******************************
    RESPONSES
    ********************************/ 
   
    /*
     * Display invoices by page
     * 
     * @param string status contains the response status
     * @param object data contains the response invoice
     * 
     * @since   0.0.8.1
     */
    Main.methods.load_payments_invoices = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();

        // Hide pagination
        $('.admin-page .theme-list > .card-footer').hide(); 

        // Hide actions
        $('.admin-page .card-actions').slideUp('slow');

        // Verify if the success response exists
        if ( status === 'success' ) {

            // All invoices
            var all_invoices = '';
            
            // List all invoices
            for ( var c = 0; c < data.invoices.length; c++ ) {

                // No account found
                var user = '<strong>' + data.words.account_deleted + '</strong>';

                // Verify if username is not null
                if ( data.invoices[c].username ) {

                    user = '<a href="' + url + 'admin/invoices?p=all_invoices&invoice=' + data.invoices[c].user_id + '">' + data.invoices[c].username + '</a>';

                }

                // Set invoice
                all_invoices += '<div class="card theme-box-1 card-invoice" data-invoice="' + data.invoices[c].invoice_id + '">'
                    + '<div class="card-header">'
                        + '<div class="row">'
                            + '<div class="col-lg-10 col-md-8 col-xs-8">'
                                + '<div class="media d-flex justify-content-start">'
                                    + '<div class="theme-checkbox-input-1">'
                                        + '<label for="invoices-single-' + data.invoices[c].invoice_id + '">'
                                            + '<input type="checkbox" id="invoices-single-' + data.invoices[c].invoice_id + '" data-invoice="' + data.invoices[c].invoice_id + '">'
                                            + '<span class="theme-checkbox-checkmark"></span>'
                                        + '</label>'
                                    + '</div>'
                                    + '<div class="media-body">'
                                        + '<h5>'
                                            + '<a href="' + url + 'admin/admin?invoice=' + data.invoices[c].invoice_id + '">'
                                                + data.invoices[c].invoice_title
                                            + '</a>'
                                        + '</h5>'
                                    + '</div>'
                                + '</div>'
                            + '</div>'
                            + '<div class="col-lg-1 col-md-2 col-xs-2">'
                                + user
                            + '</div>'
                            + '<div class="col-lg-1 col-md-2 col-xs-2 text-end">'
                                + '<div class="btn-group theme-dropdown-2">'
                                    + '<button type="button" class="btn dropdown-toggle text-end" aria-haspopup="true" aria-expanded="false" data-bs-toggle="dropdown">'
                                        + words.icon_more
                                    + '</button>'
                                    + '<ul class="dropdown-menu">'
                                        + '<li>'
                                            + '<a href="#" class="invoices-delete-invoice">'
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

            // Display templates
            $('.admin-page .theme-list > .card-body').html(all_invoices);   
            
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
     * Display invoice deletion response
     * 
     * @param string status contains the response status
     * @param object data contains the response invoice
     * 
     * @since   0.0.8.1
     */
    Main.methods.delete_invoice_response = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);
            
            // Load all invoices
            Main.load_payments_invoices(1);
            
        } else {
            
            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);
            
        }

    };
 
});