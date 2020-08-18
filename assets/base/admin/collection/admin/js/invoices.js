/*
 * Main Invoices javascript file
*/

jQuery(document).ready( function ($) {
    'use strict';
    
    // Get home page url
    var url = $('.navbar-brand').attr('href');
    
    /*******************************
    METHODS
    ********************************/

    /*
     * Load invoices by page
     * 
     * @param integer page contains the page number
     * 
     * @since   0.0.8.1
     */    
    Main.load_payments_invoices = function (page) {

        var data = {
            action: 'load_payments_invoices',
            page: page,
            key: $('.admin-page .search-invoices').val()
        };
        
        // Set the CSRF field
        data[$('.admin-page .csrf-sanitize').attr('name')] = $('.admin-page .csrf-sanitize').val();
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/admin', 'POST', data, 'load_payments_invoices');
        
    };

    /*
     * Display invoices pagination
     */
    Main.show_invoices_pagination = function( id, total ) {
        
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
     * Search for invoices
     * 
     * @since   0.0.8.1
     */
    $(document).on('keyup', '.admin-page .search-invoices', function () {
        
        // Load all invoices
        Main.load_payments_invoices(1);
        
    }); 

    /*
     * Displays pagination by page click
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.1
     */    
    $( document ).on( 'click', 'body .pagination li a', function (e) {
        e.preventDefault();
        
        // Get the page number
        var page = $(this).attr('data-page');

        // Load all invoices by page
        Main.load_payments_invoices(page);
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });

    /*
     * Detect all invoices selection
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.1
     */ 
    $( document ).on( 'click', '.admin-page #admin-invoices-select-all', function (e) {

        setTimeout(function(){
            
            if ( $( '.admin-page #admin-invoices-select-all' ).is(':checked') ) {

                $( '.admin-page .list-invoices li input[type="checkbox"]' ).prop('checked', true);

            } else {

                $( '.admin-page .list-invoices li input[type="checkbox"]' ).prop('checked', false);

            }
        
        },500);
        
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
        
        // Set the CSRF field
        data[$('.admin-page .csrf-sanitize').attr('name')] = $('.admin-page .csrf-sanitize').val();
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/admin', 'POST', data, 'delete_invoice_response');

        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
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
        Main.ajax_call(url + 'admin/ajax/admin', 'GET', data, 'delete_invoice_response');

        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
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

        // Uncheck all selected invoices
        $( '.admin-page #admin-invoices-select-all' ).prop('checked', false)

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Generate pagination
            Main.pagination.page = data.page;
            Main.show_invoices_pagination('.admin-page', data.total);

            // All invoices
            var all_invoices = '';
            
            // List all invoices
            for ( var c = 0; c < data.invoices.length; c++ ) {

                // No account found
                var user = '<strong>' + data.words.account_deleted + '</strong>';

                // Verify if username is not null
                if ( data.invoices[c].username ) {

                    user = '<a href="' + url + 'admin/users#' + data.invoices[c].user_id + '">' + data.invoices[c].username + '</a>';

                }

                // Set invoice
                all_invoices += '<li class="invoices-single" data-id="' + data.invoices[c].invoice_id + '">'
                    + '<div class="row">'
                        + '<div class="col-lg-10 col-md-8 col-xs-8">'
                            + '<div class="checkbox-option-select">'
                                + '<input id="admin-invoices-single-' + data.invoices[c].invoice_id + '" name="admin-invoices-single-' + data.invoices[c].invoice_id + '" data-id="' + data.invoices[c].invoice_id + '" type="checkbox">'
                                + '<label for="admin-invoices-single-' + data.invoices[c].invoice_id + '"></label>'
                            + '</div>'
                            + '<a href="' + url + 'admin/admin?invoice=' + data.invoices[c].invoice_id + '">'
                                + data.invoices[c].invoice_title
                            + '</a>'
                        + '</div>'
                        + '<div class="col-lg-1 col-md-2 col-xs-2">'
                            + user
                        + '</div>'
                        + '<div class="col-lg-1 col-md-2 col-xs-2 text-right">'
                            + '<div class="btn-group">'
                                + '<button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                                    + '<i class="icon-options-vertical"></i>'
                                + '</button>'
                                + '<ul class="dropdown-menu">'
                                    + '<li>'
                                        + '<a href="#" class="delete-invoice">'
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

            // Display invoices
            $('.admin-page .list-invoices').html(all_invoices);

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

            // Display invoices
            $('.admin-page .list-invoices').html(no_data);   
            
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

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
            // Load all invoices
            Main.load_payments_invoices(1);
            
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

    // Load all invoices
    Main.load_payments_invoices(1);
 
});