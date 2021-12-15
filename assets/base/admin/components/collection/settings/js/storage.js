/*
 * Storage JavaScript file
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
     * Get items for a storage's dropdown
     * 
     * @since   0.0.8.4
     */    
    Main.settings_get_storage_dropdown_items =  function () {

        // Prepare data
        var data = {
            action: 'settings_get_storage_dropdown_items',
            key: $('.settings-page [data-field="storage_dropdown"] .dropdown .theme-dropdown-search-for-items').val()
        };

        // Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/settings', 'POST', data, 'settings_display_storage_dropdown_items', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
    };

    /*******************************
    ACTIONS
    ********************************/

    /*
     * Detect storage's locations dropdown show
     * 
     * @since   0.0.8.5
     */ 
    $( '.settings-page [data-field="storage_dropdown"] .dropdown' ).on( 'show.bs.dropdown', function () {

        // Reset input
        $('.settings-page [data-field="storage_dropdown"] .dropdown .theme-dropdown-search-for-items').val('');
        
        // Get the storage's dropdown items
        Main.settings_get_storage_dropdown_items();
        
    });

    /*
     * Search for available storage's locations
     * 
     * @since   0.0.8.4
     */
    $(document).on('keyup', '.settings-page [data-field="storage_dropdown"] .dropdown .theme-dropdown-search-for-items', function () {

        // Verify if an event was already scheduled
        if ( typeof Main.queue !== 'undefined' ) {

            // Clear previous timout
            clearTimeout(Main.queue);

        }

        // Schedule event
        Main.schedule_event(function() {

            // Get the storage's dropdown items
            Main.settings_get_storage_dropdown_items();

            // Set progress bar
            Main.set_progress_bar();

        }, 1000); 
        
    });

    /*
     * Detect when the storage's location is selected
     * 
     * @since   0.0.8.4
     */
    $(document).on('click', '.settings-page .settings-dropdown-list-ul a', function (e) {
        e.preventDefault();
        
        // Prepare data
        var data = {
            action: 'settings_change_storage_location',
            location: $(this).attr('data-location')
        };

        // Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/settings', 'POST', data, 'settings_display_storage_select_response', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
    });
   
    /*******************************
    RESPONSES
    ********************************/ 
   
    /*
     * Display the response for storage's dropdown
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.4
     */
    Main.methods.settings_display_storage_dropdown_items = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Items container
            var items = '';

            // List all items
            for ( var d = 0; d < data.locations.length; d++ ) {

                // Add location to the container
                items += '<li class="list-group-item">'
                    + '<a href="#" data-id="' + data.locations[d].location_id + '">'
                        + data.locations[d].location_name
                    + '</a>'
                + '</li>';

            }

            // Display all items
            $('.settings-page [data-field="storage_dropdown"] .dropdown .theme-dropdown-items-list').html(items);
            
        } else {

            // Prepare the no locations found message
            let no_locations_found = '<li class="list-group-item">'
                + '<p>'
                    + data.message
                + '</p>'
            + '</li>';
            
            // Display the no locations found message
            $('.settings-page [data-field="storage_dropdown"] .dropdown .theme-dropdown-items-list').html(no_locations_found);
            
        }

    };

    /*
     * Display the response for storage's dropdown
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.4
     */
    Main.methods.settings_display_storage_select_response = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);

            // Set the selected storage's location
            $('.settings-page [data-option="storage_locations"] .btn-secondary').html(data.location.location_name).attr('data-location', data.location.location_id);
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }

    };
 
});