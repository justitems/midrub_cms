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

    /*
     * Start Download
     * 
     * @since   0.0.8.0
     */    
    Main.start_download = function () {

        // Get the update's code
        var code = $('.update-midrub .code-input').val();

        // Prepare data to send
        var data = {
            action: 'download_midrub_update',
            code: code
        };
        
        // Set the CSRF field
        data[$('.update-midrub').attr('data-csrf')] = $('input[name="' + $('.update-midrub').attr('data-csrf') + '"]').val();

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/update', 'POST', data, 'download_midrub_update');
        
    };

    /*
     * Start Extract
     * 
     * @since   0.0.8.0
     */    
    Main.start_extract = function () {

        // Prepare data to send
        var data = {
            action: 'extract_midrub_update'
        };

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/update', 'GET', data, 'extract_midrub_update');
        
    };

    /*
     * Start Backup
     * 
     * @since   0.0.8.0
     */    
    Main.start_backup = function () {

        // Prepare data to send
        var data = {
            action: 'start_midrub_backup'
        };

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/update', 'GET', data, 'start_midrub_backup');
        
    };

    /*******************************
    ACTIONS
    ********************************/

    /*
     * Generate new update code
     * 
     * @since   0.0.8.0
     */
    $( document ).on( 'click', '.generate-new-update-code', function (e) {
        e.preventDefault();

        // Redirect
        window.open(
            'http://access-codes.midrub.com/',
            '_blank'
          );

    });

    /*
     * Restore backup
     * 
     * @since   0.0.8.0
     */
    $( document ).on( 'click', '.restore-backup', function (e) {
        e.preventDefault();

        // Prepare data to send
        var data = {
            action: 'restore_midrub_backup'
        };

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/update', 'GET', data, 'restore_midrub_backup');
        
        // Show loading animation
        $('.page-loading').fadeIn('slow');

    });
 
   
    /*******************************
    RESPONSES
    ********************************/ 
   
    /*
     * Display the update process
     * 
     * @param string status contains the response status
     * @param object data contains the response transaction
     * 
     * @since   0.0.8.0
     */
    Main.methods.update_midrub = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Show the modal
            $('#update-system').modal('show');

            // Show the status
            $('#update-system .progress-bar-striped').attr('aria-valuenow', '10');
            $('#update-system .progress-bar-striped').css('width', '10%');
            $('#update-system .progress-bar-striped').text('10%');

            // Show message
            $('#update-system p').text(data.message);

            // Start download
            Main.start_download();
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }

    };

    /*
     * Display the update download process
     * 
     * @param string status contains the response status
     * @param object data contains the response transaction
     * 
     * @since   0.0.8.0
     */
    Main.methods.download_midrub_update = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Show the status
            $('#update-system .progress-bar-striped').attr('aria-valuenow', '25');
            $('#update-system .progress-bar-striped').css('width', '25%');
            $('#update-system .progress-bar-striped').text('25%');

            // Show message
            $('#update-system p').text(data.message);

            // Start extract
            Main.start_extract();
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);

            // Show the modal
            $('#update-system').modal('hide');
            
        }

    };

    /*
     * Display the update extract process
     * 
     * @param string status contains the response status
     * @param object data contains the response transaction
     * 
     * @since   0.0.8.0
     */
    Main.methods.extract_midrub_update = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Show the status
            $('#update-system .progress-bar-striped').attr('aria-valuenow', '50');
            $('#update-system .progress-bar-striped').css('width', '50%');
            $('#update-system .progress-bar-striped').text('50%');

            // Show message
            $('#update-system p').text(data.message);

            // Start backup
            Main.start_backup();
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);

            // Show the modal
            $('#update-system').modal('hide');
            
        }

    };

    /*
     * Display the update status
     * 
     * @param string status contains the response status
     * @param object data contains the response transaction
     * 
     * @since   0.0.8.0
     */
    Main.methods.start_midrub_backup = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Show the status
            $('#update-system .progress-bar-striped').attr('aria-valuenow', '100');
            $('#update-system .progress-bar-striped').css('width', '100%');
            $('#update-system .progress-bar-striped').text('100%');

            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);

            // Refresh the page
            setTimeout(function() {
                document.location.href = document.location.href;
            }, 3000);
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);

            // Show the modal
            $('#update-system').modal('hide');
            
        }

    };
    
    /*
     * Display the backup restore status
     * 
     * @param string status contains the response status
     * @param object data contains the response transaction
     * 
     * @since   0.0.8.0
     */
    Main.methods.restore_midrub_backup = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);

            // Refresh the page
            setTimeout(function() {
                document.location.href = document.location.href;
            }, 3000);
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }

    };
 
    /*******************************
    FORMS
    ********************************/
   
    /*
     * Update Midrub
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.0
     */
    $('.update-midrub').submit(function (e) {
        e.preventDefault();
        
        // Get the update's code
        var code = $(this).find('.code-input').val();

        // Prepare data to send
        var data = {
            action: 'update_midrub',
            code: code
        };

        // Set CSRF
        data[$(this).attr('data-csrf')] = $('input[name="' + $(this).attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/update', 'POST', data, 'update_midrub');
        
        // Show loading animation
        $('.page-loading').fadeIn('slow');
        
    });
    
    /*******************************
    DEPENDENCIES
    ********************************/

    // Hide loading animation
    $('.page-loading').fadeOut('slow');
 
});