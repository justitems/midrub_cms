/*
 * Profile Preferences JavaScript file
*/

jQuery(document).ready( function ($) {
    'use strict';
    
    /*
     * Get the website's url
     */
    let url = $('meta[name=url]').attr('content');
    
    /*******************************
    METHODS
    ********************************/

    /*******************************
    ACTIONS
    ********************************/

    /*
     * Detect profile save settings
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.5
     */ 
    $( document ).on( 'click', 'body .theme-save-changes .theme-save-changes-btn', function (e) {
        e.preventDefault();

        // Prepare data to send
        var data = {
            action: 'profile_update_preferences',
            dropdowns: []
        };

        // List all dynamic dropdowns
        $('.main .theme-settings-options .theme-dropdown-1').each(function () {
            data.dropdowns.push({
                field: $(this).closest('li').attr('data-field'),
                value: $(this).attr('data-id')
            });
        });        

		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');     
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/profile', 'POST', data, 'profile_update_preferences_response', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
    }); 
   
    /*******************************
    RESPONSES
    ********************************/ 

    /*
     * Display the profile preferences update response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.5
     */
    Main.methods.profile_update_preferences_response = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Hide the save button
            $('body .theme-save-changes').slideUp('slow');
            
            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);
            
        } else {
            
            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);

        }
        
    };
    
    /*******************************
    FORMS
    ********************************/
    
    /*******************************
    DEPENDENCIES
    ********************************/
 
});