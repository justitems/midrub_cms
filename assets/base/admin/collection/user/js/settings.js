/*
 * Settings javascript file
*/

jQuery(document).ready( function ($) {
    'use strict';
    
    // Get home page url
    var url = $('.navbar-brand').attr('href');
    
    /*******************************
    METHODS
    ********************************/

    /*******************************
    ACTIONS
    ********************************/

    /*
     * Search pages by category
     * 
     * @since   0.0.7.9
     */
    $(document).on('keyup', '.user-page .settings-dropdown-search-input', function () {
        
        // Load pages
        Main.user_settings_load_pages_by_category($(this).closest('.dropdown').attr('data-option'));
        
    });

    /*
     * Display save button
     * 
     * @since   0.0.7.9
     */
    $(document).on('change', '.user-page textarea', function (e) {
        e.preventDefault();

        // Display save button
        $('.settings-save-changes').fadeIn('slow');
        
    }); 
    
    /*
     * Save settings
     * 
     * @since   0.0.7.9
     */ 
    $( document ).on( 'click', '.settings-save-changes', function () {
        
        // Hide save button
        $('.settings-save-changes').fadeOut('slow');
        
        // Get all dropdowns
        var dropdowns = $('.user-page .settings-dropdown-btn').length;
        
        var all_dropdowns = [];

        if (dropdowns > 0) {

            for (var d = 0; d < dropdowns; d++) {

                if ($('.user-page .settings-dropdown-btn').eq(d).attr('data-id')) {

                    all_dropdowns[$('.user-page .settings-dropdown-btn').eq(d).closest('.dropdown').attr('data-option')] = $('.user-page .settings-dropdown-btn').eq(d).attr('data-id');

                }

            }

        }

        // Get all textareas
        var textareas = $('.user-page .settings-textarea-value').length;
        
        var all_textareas = [];

        if (textareas > 0) {

            for (var t = 0; t < textareas; t++) {

                all_textareas[$('.user-page .settings-textarea-value').eq(t).attr('data-option')] = $('.user-page .settings-textarea-value').eq(t).val().replace(/</g,"&lt;").replace(/>/g,"&gt;");

            }

        }
        
        // Prepare data to send
        var data = {
            action: 'save_user_settings',
            all_dropdowns: Object.entries(all_dropdowns),
            all_textareas: Object.entries(all_textareas)
        };
        
        data[$('.save-settings').attr('data-csrf')] = $('input[name="' + $('.save-settings').attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/user', 'POST', data, 'save_user_settings');

        // Show loading animation
        $('.page-loading').fadeIn('slow');
        
    }); 
   
    /*******************************
    RESPONSES
    ********************************/
 
    /*
     * Display settings saving response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.9
     */
    Main.methods.save_user_settings = function ( status, data ) { 

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
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
 
});