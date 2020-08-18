/*
 * Main notifications javascript file
*/

jQuery(document).ready( function ($) {
    'use strict';
    
    /*
     * Get the website's url
     */
    var url =  $('meta[name=url]').attr('content');
    
    /*******************************
    METHODS
    ********************************/

    /*
     * Load notifications by page
     * 
     * @param integer page contains the page number
     * 
     * @since   0.0.7.9
     */
    Main.load_notifications_by_page = function (page) {
        
        // Prepare data
        var data = {
            action: 'load_notifications_by_page',
            page: page
        };
        
        // Make ajax call
        Main.ajax_call(url + 'user/component-ajax/notifications', 'GET', data, 'load_notifications_by_page');
        
    };
    
    
    /*******************************
    ACTIONS
    ********************************/ 
    
    /*
     * Detect notifications pagination click
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.9
     */ 
    $( document ).on( 'click', '.main .next-button, .main .back-button', function (e) {
        e.preventDefault();
        
        // Get page number
        var page = $(this).attr('data-page');
        
        // Loads notifications
        Main.load_notifications_by_page(page);
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });

    /*
     * Detect notification delete click
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.9
     */ 
    $( document ).on( 'click', '.main .delete-notification', function (e) {
        e.preventDefault();
        
        // Get tthe notification's id
        var notification_id = $(this).closest('li').attr('data-notification');
        
        // Prepare data
        var data = {
            action: 'delete_notification',
            notification_id: notification_id
        };
        
        // Make ajax call
        Main.ajax_call(url + 'user/component-ajax/notifications', 'GET', data, 'delete_notification');
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });
    
    /*******************************
    RESPONSES
    ********************************/
   
    /*
     * Display notifications results
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.9
     */
    Main.methods.load_notifications_by_page = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            if ( $('.main .next-button').length > 0 ) {
            
                if ( data.page < 2 ) {
                    
                    $('.main .back-button').addClass('btn-disabled');
                    
                } else {
                    
                    $('.main .back-button').removeClass('btn-disabled');
                    $('.main .back-button').attr('data-page', (parseInt(data.page) - 1));
                    
                }
                
                if ( (parseInt(data.page) * 10 ) < data.total ) {
                    
                    $('.main .next-button').removeClass('btn-disabled');
                    $('.main .next-button').attr('data-page', (parseInt(data.page) + 1));
                    
                } else {
                    
                    $('.main .next-button').addClass('btn-disabled');
                    
                }
            
            }
            
            var notifications = '';
            
            // List all notifications
            for ( var n = 0; n < data.notifications.length; n++ ) {

                var unread = '';

                // Verify if the notification is unread
                if ( data.notifications[n].user_id !== data.user_id ) {
                    unread = ' class="unread-notification"';
                }
                
                notifications += '<li data-notification="' + data.notifications[n].notification_id + '"' + unread + '>'
                    + '<div class="row">'
                        + '<div class="col-11">'
                            + '<a href="' + url + 'user/notifications?p=notifications&notification=' + data.notifications[n].notification_id + '" class="show-notification">'
                                + '<i class="icon-star"></i>'
                                + data.notifications[n].notification_title
                            + '</a>'
                        + '</div>'
                        + '<div class="col-1">'
                            + '<div class="btn-group">'
                                + '<button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                                    + '<i class="icon-options-vertical"></i>'
                                + '</button>'
                                + '<div class="dropdown-menu dropdown-menu-action">'
                                    + '<a href="#" class="delete-notification">'
                                        + '<i class="icon-trash"></i>'
                                        + data.words.delete
                                    + '</a>'
                                + '</div>'
                            + '</div>'
                        + '</div>'
                    + '</div>'
                + '</li>';
                
            }
            
            // Display notifications
            $( '.main .notifications-list-show' ).html( notifications );
            
        } else {
            
            // Display no notifications found message
            $( '.main .notifications-list-show' ).html( '<li class="no-results-found">' + data.message + '</li>' );
            
        }

    }

    /*
     * Display notification's delete message
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.9
     */
    Main.methods.delete_notification = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);

            // Loads notifications
            Main.load_notifications_by_page(1);
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }

    };  
    
    /*******************************
    FORMS
    ********************************/
    
});