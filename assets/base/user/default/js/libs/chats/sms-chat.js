/*
 * SMS Chat JavaScript Default
*/

jQuery(document).ready( function ($) {
    'use strict';

    /*******************************
    METHODS
    ********************************/

    /*
     * Display the navigation
     *
     * @param string id contains the calendar's ID
     * @param object params contains the navigation parameters
     * 
     * @since   0.0.8.5
     */
    Main.default_sms_chat_conversation_display_navigation = function ( id, params ) {

        // Check for required parameters
        if ( (typeof params.page !== 'undefined') && (typeof params.total !== 'undefined') && (typeof params.newest !== 'undefined') && (typeof params.oldest !== 'undefined') ) {

            // Verify if oldest items should be loaded
            if ( params.oldest ) {

                // Verify if old items exists
                if ( params.page > 1 ) {

                    if ( $(id).find('.default-sms-chat-conversation-load-old-messages').length > 0 ) {

                        // Set page
                        $(id).find('.default-sms-chat-conversation-load-old-messages .btn-link').attr('data-page', (params.page - 1));

                        // Display old items button
                        $(id).find('.default-sms-chat-conversation-load-old-messages .btn-link').slideDown('fast');

                    }

                } else {

                    // Hide the button
                    $(id).find('.default-sms-chat-conversation-load-old-messages .btn-link').slideUp('fast');

                }

            }

            // Verify if newest items should be loaded
            if ( params.newest ) {

                // Verify if new items exists
                if ( (params.page * 10) < parseInt(params.total) ) {

                    if ( $(id).find('.default-sms-chat-conversation-load-new-messages').length > 0 ) {

                        // Set page
                        $(id).find('.default-sms-chat-conversation-load-new-messages .btn-link').attr('data-page', (params.page + 1));

                        // Display new items button
                        $(id).find('.default-sms-chat-conversation-load-new-messages .btn-link').slideDown('fast');

                    }

                } else {

                    // Hide the button
                    $(id).find('.default-sms-chat-conversation-load-new-messages .btn-link').slideUp('fast');

                }

            }

        }

    }

    /*
     * Hide the loading animation
     *
     * @param string id contains the calendar's ID
     * 
     * @since   0.0.8.5
     */
    Main.default_sms_chat_conversation_hide_loading_animation = function ( id ) {

        // Set a pause
        Main.schedule_event(function() {

            // Hide animation
            $(id).find('.default-sms-chat-conversation-loading-old-messages-animation').removeAttr('style');
            $(id).find('.default-sms-chat-conversation-loading-new-messages-animation').removeAttr('style');

        }, 300);

    }
  
    /*******************************
    ACTIONS
    ********************************/

    /*
     * Detect load old items click 
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.5
     */ 
    $( document ).on( 'click', '.default-sms-chat-conversation-load-old-messages .btn-link', function (e) {
        e.preventDefault();

        // Remove active class
        $(this).closest('.default-sms-chat').find('default-sms-chat-conversation-load-old-messages').removeClass('default-sms-chat-conversation-load-old-messages-active');
        $(this).closest('.default-sms-chat').find('default-sms-chat-conversation-load-new-messages').removeClass('default-sms-chat-conversation-load-new-messages-active');

        // Set active
        $(this).closest('.default-sms-chat-conversation-load-old-messages').addClass('default-sms-chat-conversation-load-old-messages-active');

        // Hide the button
        $(this).slideUp('fast', function () {

            // Show animation
            $(this).closest('.card-body').find('.default-sms-chat-conversation-loading-old-messages-animation').slideDown('fast');

        });
        
    });

    /*
     * Detect load new items click 
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.5
     */ 
    $( document ).on( 'click', '.default-sms-chat-conversation-load-new-messages .btn-link', function (e) {
        e.preventDefault();

        // Set active
        $(this).closest('.default-sms-chat').find('default-sms-chat-conversation-load-old-messages').removeClass('default-sms-chat-conversation-load-old-messages-active');
        $(this).closest('.default-sms-chat').find('default-sms-chat-conversation-load-new-messages').removeClass('default-sms-chat-conversation-load-new-messages-active');

        // Set active
        $(this).closest('.default-sms-chat-conversation-load-new-messages').addClass('default-sms-chat-conversation-load-new-messages-active');

        // Hide the button
        $(this).slideUp('fast', function () {

            // Show animation
            $(this).closest('.card-body').find('.default-sms-chat-conversation-loading-new-messages-animation').slideDown('fast');

        });
        
    });

    /*
     * Detect load old items click 
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.5
     */ 
    $( document ).on( 'click', '.default-sms-chat-conversation-load-old-messages .btn-link', function (e) {
        e.preventDefault();

        // Remove the last parameter
        $('.main .default-sms-chat').attr('data-last', 0);

        // Get the page
        let page = $(this).attr('data-page');

        // Get messages by page
        Main.crm_tw_sms_manager_get_conversation(page, 1);
        
    });

    /*
     * Detect load new items click 
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.5
     */ 
    $( document ).on( 'click', '.default-sms-chat-conversation-load-new-messages .btn-link', function (e) {
        e.preventDefault();

        // Remove the last parameter
        $('.main .default-sms-chat').attr('data-last', 0);

        // Get the page
        let page = $(this).attr('data-page');

        // Get messages by page
        Main.crm_tw_sms_manager_get_conversation(page, 1);
        
    });

});