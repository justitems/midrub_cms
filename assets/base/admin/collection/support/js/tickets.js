/*
 * Main Tickets javascript file
*/

jQuery(document).ready( function ($) {
    'use strict';
    
    // Get home page url
    var url = $('.navbar-brand').attr('href');
    
    /*******************************
    METHODS
    ********************************/

    /*
     * Load tickets
     * 
     * @param integer page contains the page number
     * @param string type contains the request's type
     * 
     * @since   0.0.7.9
     */    
    Main.load_tickets =  function (page, type) {
        
        // Prepare data
        var data = {
            action: 'load_tickets',
            key: $('.support-page .search-tickets').val(),
            page: page
        };
        
        // Set the CSRF field
        data[$('.support-page .csrf-sanitize').attr('name')] = $('.support-page .csrf-sanitize').val();
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/support', 'POST', data, 'load_tickets');
        
    };

    /*
     * Display tickets pagination
     */
    Main.show_tickets_pagination = function( id, total ) {
        
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

    /*
     * Load the ticket's replies
     * 
     * @since   0.0.7.9
     */
    Main.load_ticket_replies = function () {
        
        // Prepare data to send
        var data = {
            action: 'load_ticket_replies',
            ticket_id: $('.support-page .create-new-ticket-reply').attr('data-id')
        };

        // Set CSRF
        data[$('.support-page .create-new-ticket-reply').attr('data-csrf')] = $('input[name="' + $('.support-page .create-new-ticket-reply').attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/support', 'POST', data, 'load_ticket_replies');
        
    };


    /*******************************
    ACTIONS
    ********************************/

    /*
     * Search tickets
     * 
     * @since   0.0.7.9
     */
    $(document).on('keyup', '.support-page .search-tickets', function () {
        
        // Load all tickets
        Main.load_tickets(1);
        
    });

    /*
     * Detect all tickets selection
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.9
     */ 
    $( document ).on( 'click', '.support-page #support-tickets-select-all', function (e) {
        
        setTimeout(function(){
            
            if ( $( '.support-page #support-tickets-select-all' ).is(':checked') ) {

                $( '.support-page .list-contents input[type="checkbox"]' ).prop('checked', true);

            } else {

                $( '.support-page .list-contents input[type="checkbox"]' ).prop('checked', false);

            }
        
        },500);
        
    });

    /*
     * Delete tickets
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.9
     */ 
    $( document ).on( 'click', '.support-page .delete-tickets', function (e) {
        e.preventDefault();
        
        // Prepare data
        var data = {
            action: 'delete_tickets'
        };
        
        // Get all tickets
        var tickets = $('.support-page .list-contents input[type="checkbox"]');
        
        var selected = [];
        
        // List all tickets
        for ( var d = 0; d < tickets.length; d++ ) {

            if ( tickets[d].checked ) {
                selected.push($(tickets[d]).attr('data-id'));
            }
            
        }

        // Set selected tickets
        data['tickets'] = selected;
        
        // Set the CSRF field
        data[$('.support-page .csrf-sanitize').attr('name')] = $('.support-page .csrf-sanitize').val();

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/support', 'POST', data, 'delete_tickets');
        
    });

    /*
     * Close ticket
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.9
     */ 
    $( document ).on( 'click', '.support-page .close-ticket', function (e) {
        e.preventDefault();
        
        // Prepare data
        var data = {
            action: 'close_ticket',
            ticket_id: $(this).closest('.ticket-single').attr('data-id')
        };
        
        // Set the CSRF field
        data[$('.support-page .csrf-sanitize').attr('name')] = $('.support-page .csrf-sanitize').val();

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/support', 'POST', data, 'close_ticket');
        
    });

    /*
     * Change the ticket status
     * 
     * @since   0.0.7.9
     */
    $(document).on('click', '.support-page .change-ticket-status a', function (e) {
        e.preventDefault();
        
        // Get the ticket's status
        var status = $(this).attr('data-id');
        
        var data = {
            action: 'set_ticket_status',
            ticket_id: $('.support-page .create-new-ticket-reply').attr('data-id'),
            status: status
        };

        // Set the CSRF field
        data[$('.support-page .create-new-ticket-reply').attr('data-csrf')] = $('input[name="' + $('.support-page .create-new-ticket-reply').attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/support', 'POST', data, 'set_ticket_status');
        
    });
 
    /*******************************
    RESPONSES
    ********************************/ 

    /*
     * Display tickets response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.9
     */
    Main.methods.load_tickets = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Generate pagination
            Main.pagination.page = data.page;
            Main.show_tickets_pagination('.support-page', data.total);

            // All tickets
            var all_tickets = '';
            
            // List all tickets
            for ( var c = 0; c < data.tickets.length; c++ ) {

                var status = parseInt(data.tickets[c].status);

                if ( status === 1 ) {
                    
                    var status = '<span class="label label-primary">'
                                    + data.words.unanswered
                                + '</span>';

                } else if ( status < 1 ) {
                    
                    var status = '<span class="label label-primary">'
                                    + data.words.closed
                                + '</span>';
                    
                } else {
                    
                    var status = '<span class="label label-primary">'
                                    + data.words.answered
                                + '</span>';                    
                    
                }

                // Set content
                all_tickets += '<li class="ticket-single" data-id="' + data.tickets[c].ticket_id + '">'
                    + '<div class="row">'
                        + '<div class="col-lg-10 col-md-8 col-xs-8">'
                            + '<div class="checkbox-option-select">'
                                + '<input id="frontent-ticket-single-' + data.tickets[c].ticket_id + '" name="frontent-ticket-single-' + data.tickets[c].ticket_id + '" data-id="' + data.tickets[c].ticket_id + '" type="checkbox">'
                                + '<label for="frontent-ticket-single-' + data.tickets[c].ticket_id + '"></label>'
                            + '</div>'
                            + '<a href="' + url + 'admin/support?p=tickets&ticket=' + data.tickets[c].ticket_id + '">'
                                + data.tickets[c].subject
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
                                        + '<a href="#" class="close-ticket">'
                                            + '<i class="fas fa-power-off"></i>'
                                            + data.words.close
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

            // Display contents
            $('.support-page .list-contents').html(all_tickets);

            // Display start listing
            $('.support-page .pagination-from').text(page);  
            
            // Display end listing
            $('.support-page .pagination-to').text(to);  

            // Display total items
            $('.support-page .pagination-total').text(data.total);

            // Show Pagination
            $('.support-page .pagination-area').show();  
            
        } else {

            // Hide Pagination
            $('.support-page .pagination-area').hide();  
            
            // Set no data found message
            var no_data = '<li>'
                                + data.message
                            + '</li>';

            // Display contents
            $('.support-page .list-contents').html(no_data);   
            
        }

    }; 

    /*
     * Display tickets deletion response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.9
     */
    Main.methods.delete_tickets = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
            // Uncheck all
            $( '.support-page input[type="checkbox"]' ).prop('checked', false);
            
            // Load all tickets
            Main.load_tickets(1);
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }

    };

    /*
     * Display tickets closing response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.9
     */
    Main.methods.close_ticket = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
            // Load all tickets
            Main.load_tickets(1);
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }

    };

     /*
     * Display ticket's replies response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.9
     */
    Main.methods.load_ticket_replies = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
        
            // Replies
            var replies = '';

            // List all replies
            for ( var e = 0; e < data.content.length; e++ ) {

                // Get username
                var username = data.content[e].username;

                // Verify if user has added first and last name
                if ( (data.content[e].first_name !== '') || (data.content[e].last_name !== '') ) {

                    // Set username
                    username = data.content[e].first_name + ' ' + data.content[e].last_name;

                }

                // Set time
                var gettime = Main.calculate_time(data.content[e].created, data.cdate);

                // Add reply to the list
                replies += '<div class="single-reply">'
                                + '<div class="reply-people">'
                                    + '<div class="reply-img">'
                                        + '<img src="' + data.content[e].avatar + '" alt="avatar">'
                                    + '</div>'
                                    + '<div class="reply">'
                                        + '<h5>' + username + ' <span>' + gettime + '</span></h5>'
                                        + '<p>'
                                            + data.content[e].body
                                        + '</p>'
                                    + '</div>'
                                + '</div>'
                            + '</div>';

            }

            // Display replies
            $('.support-page .ticket-replies').html(replies);
        
        } else {

            // Prepare no replies message
            var message = '<div class="single-reply">'
                + '<div class="row">'
                    + '<div class="col-lg-12">'
                        + '<p class="no-replies-found">'
                            + data.message
                        + '</p>'
                    + '</div>'
                + '</div>'
            + '</div>';
            
            // Display message
            $('.support-page .ticket-replies').html(message);            
            
        } 
        
    };

     /*
     * Display reply creation response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.9
     */
    Main.methods.create_ticket_reply = function ( status, data ) {
        
        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);

            // Reload ticket's replies
            Main.load_ticket_replies();

            // Reset the reply form
            $('.support-page .create-new-ticket-reply')[0].reset();
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }    

    };

     /*
     * Display ticket status change response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.9
     */
    Main.methods.set_ticket_status = function ( status, data ) {
        
        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
            // Set the text
            $( '.support-page .ticket-status' ).text( data.status );
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        } 
        
    };
    
    /*******************************
    FORMS
    ********************************/

    /*
     * Create a ticket's reply
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.9
     */
    $(document).on('submit', '.support-page .create-new-ticket-reply', function (e) {
        e.preventDefault();
        
        // Create an object with form data
        var data = {
            action: 'create_ticket_reply',
            body: $(this).find('.reply-body').val(),
            ticket_id: $(this).attr('data-id')
        };
        
        // Set CSRF
        data[$(this).attr('data-csrf')] = $('input[name="' + $(this).attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/support', 'POST', data, 'create_ticket_reply');
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });
    
    /*******************************
    DEPENDENCIES
    ********************************/

    // Verify if is the page with tickets
    if ( $('.support-page .search-tickets').length > 0 ) {

        // Load all tickets
        Main.load_tickets(1);

    } else {

        // Reload ticket's replies
        Main.load_ticket_replies();

    }

    // Hide loading animation
    $('.page-loading').fadeOut('slow');
 
});