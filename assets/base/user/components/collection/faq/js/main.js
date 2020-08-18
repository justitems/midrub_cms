/*
 * Main Faq javascript file
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
     * Load the ticket's replies
     * 
     * @since   0.0.7.5
     */
    Main.load_ticket_replies = function () {
        
        var data = {
            action: 'load_ticket_replies',
            ticket_id: $('.submit-ticket-reply').find('.reply-ticket-id').val()
        };
        
        // Make ajax call
        Main.ajax_call(url + 'user/component-ajax/faq', 'GET', data, 'load_ticket_replies');
        
    };
   
    /*******************************
    RESPONSES
    ********************************/ 
   
    /*
     * Display faq search response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.5
     */
    Main.methods.load_faq_articles_by_search = function ( status, data ) {
        
        // Display search popup
        $('.faq-page .search-results').fadeIn('slow');
        
        // Display search results
        $('.faq-page .search-results ul').html(data.results);        

    };
    
    /*
     * Display tickets creation response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.5
     */
    Main.methods.create_new_ticket = function ( status, data ) {
        
        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
            // Reset form
            $('.submit-new-ticket')[0].reset();
            
            // Redirects to the created ticket
            setTimeout(function(){
                
                document.location.href = url + 'user/faq?p=tickets&ticket=' + data.ticket_id;
                
            }, 3000);
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }    

    };  
    
     /*
     * Display reply creation response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.5
     */
    Main.methods.create_ticket_reply = function ( status, data ) {
        
        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
            // Reset form
            $('.submit-ticket-reply').find('.reply-body').val('');
            
            // Reload ticket's replies
            Main.load_ticket_replies();
            
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
     * @since   0.0.7.5
     */
    Main.methods.load_ticket_replies = function ( status, data ) {
        
        // Verify if the success response exists
        if ( status === 'success' ) {
        
            var replies = '';

            for ( var e = 0; e < data.content.length; e++ ) {

                var username = data.content[e].username;

                if ( (data.content[e].first_name !== '') || (data.content[e].last_name !== '') ) {

                    username = data.content[e].first_name + ' ' + data.content[e].last_name;

                }

                // Set time
                var gettime = Main.calculate_time(data.content[e].created, data.cdate);

                replies += '<div class="ticket-reply">'
                                + '<div class="reply_people">'
                                    + '<div class="reply_img">'
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

            // Add replies
            $('.ticket-replies').html(replies);
        
        } else {
            
            // Add no replies message
            $('.ticket-replies').html('<p>' + data.message + '</p>');            
            
        } 
        
    };
    
     /*
     * Display ticket status change response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.5
     */
    Main.methods.set_ticket_status = function ( status, data ) {
        
        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
            // Set the text
            $( '.single-ticket .ticket-status' ).text( data.status );
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        } 
        
    };    
    
    /*******************************
    ACTIONS
    ********************************/
   
    /*
     * Detect search
     * 
     * @since   0.0.7.5
     */
    $(document).on('keyup', '.faq-page .search-articles', function () {
        
        $('.faq-page .cancel-search-for-articles').fadeIn('slow');
        
        var data = {
            action: 'load_faq_articles_by_search',
            key: $(this).val()
        };
        
        data[$('.faq-page .search-articles-form').attr('data-csrf')] = $('input[name="' + $('.faq-page .search-articles-form').attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'user/component-ajax/faq', 'POST', data, 'load_faq_articles_by_search');
        
    }); 
    
    /*
     * Cancel search for faq articles
     * 
     * @since   0.0.7.5
     */
    $(document).on('click', '.faq-page .cancel-search-for-articles', function (e) {
        
        // Hide Cancel Button
        $('.faq-page .cancel-search-for-articles').fadeOut('slow');
        
        // Hide found results
        $('.faq-page .search-results').fadeOut('slow');
        
        // Empty search input
        $('.faq-page .search-articles').val('');
        
    });
    
    /*
     * Change the ticket status
     * 
     * @since   0.0.7.5
     */
    $(document).on('click', '.single-ticket .change-ticket-status a', function (e) {
        e.preventDefault();
        
        // Get the ticket's status
        var status = $(this).attr('data-id');
        
        var data = {
            action: 'set_ticket_status',
            ticket_id: $('.submit-ticket-reply').find('.reply-ticket-id').val(),
            status: status
        };
        
        // Make ajax call
        Main.ajax_call(url + 'user/component-ajax/faq', 'GET', data, 'set_ticket_status');
        
    });
   
    /*******************************
    FORMS
    ********************************/
   
    /*
     * Create a new ticket
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.5
     */
     $(document).on('submit', '.submit-new-ticket', function (e) {
        e.preventDefault();
        
        // Create an object with form data
        var data = {
            action: 'create_new_ticket',
            subject: $(this).find('.ticket-subject').val(),
            body: $(this).find('.ticket-body').val()
        };
        
        // Set CSRF
        data[$(this).attr('data-csrf')] = $('input[name="' + $(this).attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'user/component-ajax/faq', 'POST', data, 'create_new_ticket');
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });
    
    /*
     * Create a ticket's reply
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.5
     */
     $(document).on('submit', '.submit-ticket-reply', function (e) {
        e.preventDefault();
        
        // Create an object with form data
        var data = {
            action: 'create_ticket_reply',
            body: $(this).find('.reply-body').val(),
            ticket_id: $(this).find('.reply-ticket-id').val()
        };
        
        // Set CSRF
        data[$(this).attr('data-csrf')] = $('input[name="' + $(this).attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'user/component-ajax/faq', 'POST', data, 'create_ticket_reply');
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });   
    
    /*******************************
    DEPENDENCIES
    ********************************/
   
    if ( $('.single-ticket').length > 0 ) {
        
        Main.load_ticket_replies();
        
    }
 
});