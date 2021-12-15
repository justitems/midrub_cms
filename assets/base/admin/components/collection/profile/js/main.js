/*
 * Profile Main JavaScript file
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

    /*
     * Get the countries
     * 
     * @since   0.0.8.5
     */    
    Main.profile_get_countries =  function () {

        // Prepare data to send
        var data = {
            action: 'profile_get_countries',
            key: $('.profile-page [data-field="country"] .dropdown .theme-dropdown-search-for-items').val()
            
        };
        
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');     
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/profile', 'POST', data, 'profile_display_countries_response');
        
    };

    /*******************************
    ACTIONS
    ********************************/

    /*
     * Detect countries dropdown show
     * 
     * @since   0.0.8.5
     */ 
    $( '.profile-page [data-field="country"] .dropdown' ).on( 'show.bs.dropdown', function () {

        // Reset input
        $('.profile-page [data-field="country"] .dropdown .theme-dropdown-search-for-items').val('');
        
        // Get the countries
        Main.profile_get_countries();
        
    });

    /*
     * Search for countries
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.5
     */
    $(document).on('keyup', '.profile-page [data-field="country"] .dropdown .theme-dropdown-search-for-items', function (e) {
        e.preventDefault();

        // Verify if an event was already scheduled
        if ( typeof Main.queue !== 'undefined' ) {

            // Clear previous timout
            clearTimeout(Main.queue);

        }

        // Schedule event
        Main.schedule_event(function() {

            // Get the countries
            Main.profile_get_countries();

            // Set progress bar
            Main.set_progress_bar();

        }, 1000);  

    });

    /*
     * Detect profile image remove
     * 
     * @since   0.0.8.5
     */ 
    $( document ).on( 'click', '.profile-page [data-field="profile_my_photo"] .admin-field-remove-image', function () {
        
        // Prepare data to send
        var data = {
            action: 'profile_remove_profile_image'
        };

		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');     
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/profile', 'POST', data, 'profile_remove_profile_image_response', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
    });

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
            action: 'profile_update_general_info',
            text_inputs: [],
            dynamic_dropdowns: []
        };
        
        // List all text inputs
        $('.main .theme-settings-options .theme-text-input-1').each(function () {
            data.text_inputs.push({
                field: $(this).closest('li').attr('data-field'),
                value: $(this).val()
            });
        });

        // List all dynamic dropdowns
        $('.main .theme-settings-options .theme-dynamic-dropdown').each(function () {
            data.dynamic_dropdowns.push({
                field: $(this).closest('li').attr('data-field'),
                value: $(this).attr('data-id')
            });
        });        

		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');     
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/profile', 'POST', data, 'profile_update_general_info_response', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
    }); 
   
    /*******************************
    RESPONSES
    ********************************/ 

    /*
     * Display the upload profile image status
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.5
     */
    Main.methods.profile_change_profile_image = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);   

            // Set the profile image
            $('.profile-page .theme-image-field > .card-header').html('<img src="' + data.file_url + '" alt="Midrub" width="32">');

            // Close modal
            $('#profile-upload-photo-modal .btn-close').click();

            // Verify if the theme has profile image
            if ( $('.main .sidebar-bottom .theme-profile-image').length > 0 ) {

                // Reset the image
                $('.main .sidebar-bottom .theme-profile-image > img').attr('src', data.file_url);

            }
            
        } else {
            
            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);
            
        }

    };

    /*
     * Display the remove profile image response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.5
     */
    Main.methods.profile_remove_profile_image_response = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);

            // Reset the profile image
            Main.reset_field_image('.profile-page [data-field="profile_my_photo"]');
            
            // Verify if the theme has profile image
            if ( $('.main .sidebar-bottom .theme-profile-image').length > 0 ) {

                // Reset the image
                $('.main .sidebar-bottom .theme-profile-image > img').attr('src', url + 'assets/img/avatar-placeholder.png');

            }
            
        } else {
            
            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);

        }
        
    };

    /*
     * Display the profile countries response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.5
     */
    Main.methods.profile_display_countries_response = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Countries container
            var countries = '';

            // List all countries
            for ( var c = 0; c < data.countries.length; c++ ) {

                // Add country to the container
                countries += '<li class="list-group-item">'
                    + '<a href="#" data-id="' + data.countries[c].id + '">'
                        + data.countries[c].name
                    + '</a>'
                + '</li>';

            }

            // Display the countries
            $('.profile-page [data-field="country"] .dropdown .theme-dropdown-items-list').html(countries);
            
        } else {

            // Prepare the no countries found message
            let no_countries_found = '<li class="list-group-item">'
                + '<p>'
                    + data.message
                + '</p>'
            + '</li>';
            
            // Display the no countries found message
            $('.profile-page [data-field="country"] .dropdown .theme-dropdown-items-list').html(no_countries_found);

        }
        
    };

    /*
     * Display the profile general info update response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.5
     */
    Main.methods.profile_update_general_info_response = function ( status, data ) {

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
 
});