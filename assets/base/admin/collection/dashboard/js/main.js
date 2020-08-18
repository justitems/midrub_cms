/*
 * Main javascript file
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
     * Detect modal closing
     * 
     * @since   0.0.8.1
     */
    $('#dashboard-manage-widgets').on('hidden.bs.modal', function () {

        // Reload the page
        document.location.href = document.location.href;

    });

    /*
     * Change the widget status
     * 
     * @since   0.0.8.1
     */
    $( document ).on( 'click', '#dashboard-manage-widgets .dashboard-change-widget-status a', function (e) {
        e.preventDefault();

        // Get the status
        let status = $(this).attr('data-type');

        // Get the widget's slug
        let slug = $(this).closest('.btn-group').find('.dashboard-widget-status').attr('data-target');

        // Prepare data to send
        var data = {
            action: 'change_widget_status',
            status: status,
            slug: slug
        };

        // Set CSRF
        data[$('.admin-page').attr('data-csrf-name')] = $('.admin-page').attr('data-csrf-hash');

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/dashboard', 'POST', data, 'change_widget_status');
        
        // Show loading animation
        $('.page-loading').fadeIn('slow');

    });

    /*
     * Change the widget status(second way)
     * 
     * @since   0.0.8.1
     */
    $( document ).on( 'click', '.dashboard-page .dashboard-change-widget-status a', function (e) {
        e.preventDefault();

        // Get the status
        let status = $(this).attr('data-type');

        // Get the widget's slug
        let slug = $(this).closest('.btn-group').find('.dashboard-widget-status').attr('data-target');

        // Prepare data to send
        var data = {
            action: 'change_widget_status',
            status: status,
            slug: slug
        };

        // Set CSRF
        data[$('.admin-page').attr('data-csrf-name')] = $('.admin-page').attr('data-csrf-hash');

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/dashboard', 'POST', data, 'change_widget_status2');
        
        // Show loading animation
        $('.page-loading').fadeIn('slow');

    });
 
   
    /*******************************
    RESPONSES
    ********************************/ 
   
    /*
     * Display the widget change status
     * 
     * @param string status contains the response status
     * @param object data contains the response transaction
     * 
     * @since   0.0.8.1
     */
    Main.methods.change_widget_status = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Change the widget's status
            $('#dashboard-manage-widgets .dashboard-widget-status[data-target="' + data.slug + '"]').html( data.status + ' <span class="caret"></span>' );
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }

    };

    /*
     * Display the widget change status(second way)
     * 
     * @param string status contains the response status
     * @param object data contains the response transaction
     * 
     * @since   0.0.8.1
     */
    Main.methods.change_widget_status2 = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);

            // Reload the page
            setTimeout(function() {
                document.location.href = document.location.href;
            }, 2000);
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }

    };    
    
    /*******************************
    DEPENDENCIES
    ********************************/

    // Hide loading animation
    $('.page-loading').fadeOut('slow');
 
});