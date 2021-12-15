/*
 * Main Tickets javascript file
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
     * Load tickets
     * 
     * @param integer page contains the page number
     * @param string type contains the request's type
     * @param integer progress contains the progress option
     * 
     * @since   0.0.7.9
     */    
    Main.load_tickets =  function (page, type, progress) {
        
        // Prepare data
        var data = {
            action: 'load_tickets',
            key: $('.support-page .support-search-for-tickets').val(),
            page: page
        };
        
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');   

        // Verify if progress exists
        if ( typeof progress !== 'undefined' ) {

            // Make ajax call
            Main.ajax_call(url + 'admin/ajax/support', 'POST', data, 'load_tickets', 'ajax_onprogress');

            // Set progress bar
            Main.set_progress_bar();

        } else {

            // Make ajax call
            Main.ajax_call(url + 'admin/ajax/support', 'POST', data, 'load_tickets');

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
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');   

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/support', 'POST', data, 'load_ticket_replies');
        
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

        // Verify if is the page with tickets
        if ( $('.support-page .support-search-for-tickets').length > 0 ) {

            // Load all tickets
            Main.load_tickets(1);

        } else {

            // Reload ticket's replies
            Main.load_ticket_replies();

        }

    });

    /*
     * Search tickets
     * 
     * @since   0.0.7.9
     */
    $(document).on('keyup', '.support-page .support-search-for-tickets', function () {

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

                // Load all tickets
                Main.load_tickets(1, 1);

            }, 1000);

        } else {

            // Set opacity
            $this.closest('div').find('a').removeAttr('style');

            // Load all tickets
            Main.load_tickets(1, 1);
            
        }
        
    });

    /*
     * Cancel the search for tickets
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.5
     */ 
    $( document ).on( 'click', '.support-page .theme-cancel-search', function (e) {
        e.preventDefault();

        // Empty search input
        $('.support-page .support-search-for-tickets').val('');

        // Set opacity
        $(this).closest('div').find('a').removeAttr('style');

        // Load all tickets
        Main.load_tickets(1, 1);
        
    });

    /*
     * Detect checkbox check
     * 
     * @since   0.0.8.5
     */ 
    $( document ).on( 'click', '.support-page .theme-list > .card-body input[type="checkbox"]', function () {

        // Show the action
        if ( $('.support-page .theme-list > .card-body :checkbox:checked').length > 0 ) {

            // Show actions
            $('.support-page .card-actions').slideDown('slow');

            // Set selected items
            $('.support-page .theme-list .theme-list-selected-items p').html($('.support-page .theme-list > .card-body :checkbox:checked').length + ' ' + words.selected_items);

        } else {

            // Hide actions
            $('.support-page .card-actions').slideUp('slow');
            
        }
        
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
        
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');   

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/support', 'POST', data, 'delete_tickets', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
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
        
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');   

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/support', 'POST', data, 'close_ticket', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
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

		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');   
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/support', 'POST', data, 'set_ticket_status', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
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

        // Remove progress bar
        Main.remove_progress_bar();

        // Hide pagination
        $('.support-page .theme-list > .card-footer').hide(); 

        // Hide actions
        $('.support-page .card-actions').slideUp('slow');

        // Verify if the success response exists
        if ( status === 'success' ) {

            // All tickets
            var all_tickets = '';
            
            // List all tickets
            for ( var c = 0; c < data.tickets.length; c++ ) {

                var status = parseInt(data.tickets[c].status);

                if ( status === 1 ) {
                    
                    var status = '<span class="badge bg-danger theme-badge-1">'
                                    + data.words.unanswered
                                + '</span>';

                } else if ( status < 1 ) {
                    
                    var status = '<span class="badge bg-light theme-badge-1">'
                                    + data.words.closed
                                + '</span>';
                    
                } else {
                    
                    var status = '<span class="badge bg-primary theme-badge-1">'
                                    + data.words.answered
                                + '</span>';                    
                    
                }

                // Set ticket
                all_tickets += '<div class="card theme-box-1 card-ticket" data-ticket="' + data.tickets[c].ticket_id + '">'
                    + '<div class="card-header">'
                        + '<div class="row">'
                            + '<div class="col-lg-10 col-md-8 col-xs-8">'
                                + '<div class="media d-flex justify-content-start">'
                                    + '<div class="theme-checkbox-input-1">'
                                        + '<label for="support-single-' + data.tickets[c].ticket_id + '">'
                                            + '<input type="checkbox" id="support-single-' + data.tickets[c].ticket_id + '" data-ticket="' + data.tickets[c].ticket_id + '">'
                                            + '<span class="theme-checkbox-checkmark"></span>'
                                        + '</label>'
                                    + '</div>'
                                    + '<div class="media-body">'
                                        + '<h5>'
                                            + '<a href="' + url + 'admin/support?p=tickets&ticket=' + data.tickets[c].ticket_id + '">'
                                                + data.tickets[c].subject
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
                                            + '<a href="#" class="support-close-ticket">'
                                                + words.icon_close
                                                + data.words.close
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
            $('.support-page .theme-list > .card-body').html(all_tickets);   
            
            // Set limit
            let limit = ((data.page * 10) < data.total)?(data.page * 10):data.total;

            // Set text
            $('.support-page .theme-list > .card-footer h6').html((((data.page - 1) * 10) + 1) + '-' + limit + ' ' + data.words.of + ' ' + data.total + ' ' + data.words.results);

            // Set page
            Main.pagination.page = data.page;

            // Display the pagination
            Main.show_pagination('.support-page .theme-list', data.total);

            // Show pagination
            $('.support-page .theme-list > .card-footer').show();  
            
        } else {

            // Set no data found message
            var no_data = '<p class="theme-box-1 theme-list-no-results-found">'
                                + data.message
                            + '</p>';

            // Display the no data found message
            $('.support-page .theme-list > .card-body').html(no_data);  
            
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

        // Remove progress bar
        Main.remove_progress_bar();

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);
            
            // Uncheck all
            $( '.support-page input[type="checkbox"]' ).prop('checked', false);
            
            // Load all tickets
            Main.load_tickets(1);
            
        } else {
            
            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);
            
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

        // Remove progress bar
        Main.remove_progress_bar();

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);
            
            // Load all tickets
            Main.load_tickets(1);
            
        } else {
            
            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);
            
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

                // Add reply to the list
                replies += '<div class="theme-box-1 mb-3">'
                    + '<div class="card card-reply theme-card-box">'
                        + '<div class="card-header">'
                            + '<button class="btn btn-link">'
                                + '<img src="' + data.content[e].avatar + '" alt="avatar">'
                                + username + ' <span>' + data.content[e].created + '</span>'
                            + '</button>'
                        + '</div>'
                        + '<div class="card-body">'
                            + '<div class="theme-card-box-article">'
                                + '<p>'
                                    + data.content[e].body
                                + '</p>'
                            + '</div>'
                        + '</div>'
                    + '</div>'
                + '</div>';                

            }

            // Display replies
            $('.support-page .support-ticket-replies').html(replies);
        
        } else {

            // Prepare no replies message
            var message = '<div class="theme-box-1">'
                + '<p class="support-no-replies-found">'
                    + data.message
                + '</p>'
            + '</div>';
            
            // Display message
            $('.support-page .support-ticket-replies').html(message);            
            
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

        // Remove progress bar
        Main.remove_progress_bar();
        
        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);

            // Reload ticket's replies
            Main.load_ticket_replies();

            // Reset the reply form
            $('.support-page .create-new-ticket-reply')[0].reset();
            
        } else {
            
            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);
            
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

        // Remove progress bar
        Main.remove_progress_bar();
        
        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);
            
            // Set the text
            $( '.support-page .ticket-status span' ).text( data.status );
            
        } else {
            
            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);
            
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
            body: $(this).find('.support-reply-body').val(),
            ticket_id: $(this).attr('data-id')
        };
        
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');   
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/support', 'POST', data, 'create_ticket_reply', 'ajax_onprogress');
        
        // Set progress bar
        Main.set_progress_bar();
        
    });
 
});