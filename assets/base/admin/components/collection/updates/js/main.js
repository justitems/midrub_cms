/*
 * Main javascript file
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
     * Start Download
     * 
     * @since   0.0.8.0
     */    
    Main.start_download = function () {

        // Get the updates's code
        var code = $('.updates-midrub .code-input').val();

        // Prepare data to send
        var data = {
            action: 'download_midrub_updates',
            code: code
        };
        
        // Set the CSRF field
        data[$('.updates-midrub').attr('data-csrf')] = $('input[name="' + $('.updates-midrub').attr('data-csrf') + '"]').val();

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/updates', 'POST', data, 'download_midrub_updates');
        
    };

    /*
     * Start Extract
     * 
     * @since   0.0.8.0
     */    
    Main.start_extract = function () {

        // Prepare data to send
        var data = {
            action: 'extract_midrub_updates'
        };

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/updates', 'GET', data, 'extract_midrub_updates');
        
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
        Main.ajax_call(url + 'admin/ajax/updates', 'GET', data, 'start_midrub_backup');
        
    };

    /*******************************
    ACTIONS
    ********************************/

    /*
     * Generate new updates code
     * 
     * @since   0.0.8.0
     */
    $( document ).on( 'click', '.generate-new-updates-code', function (e) {
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
        Main.ajax_call(url + 'admin/ajax/updates', 'GET', data, 'restore_midrub_backup');
        
        // Show loading animation
        $('.page-loading').fadeIn('slow');

    });
 
   
    /*******************************
    RESPONSES
    ********************************/ 
   
    /*
     * Display the updates process
     * 
     * @param string status contains the response status
     * @param object data contains the response transaction
     * 
     * @since   0.0.8.0
     */
    Main.methods.updates_midrub = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Show the modal
            $('#updates-system').modal('show');

            // Show the status
            $('#updates-system .progress-bar-striped').attr('aria-valuenow', '10');
            $('#updates-system .progress-bar-striped').css('width', '10%');
            $('#updates-system .progress-bar-striped').text('10%');

            // Show message
            $('#updates-system p').text(data.message);

            // Start download
            Main.start_download();
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }

    };

    /*
     * Display the updates download process
     * 
     * @param string status contains the response status
     * @param object data contains the response transaction
     * 
     * @since   0.0.8.0
     */
    Main.methods.download_midrub_updates = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Show the status
            $('#updates-system .progress-bar-striped').attr('aria-valuenow', '25');
            $('#updates-system .progress-bar-striped').css('width', '25%');
            $('#updates-system .progress-bar-striped').text('25%');

            // Show message
            $('#updates-system p').text(data.message);

            // Start extract
            Main.start_extract();
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);

            // Show the modal
            $('#updates-system').modal('hide');
            
        }

    };

    /*
     * Display the updates extract process
     * 
     * @param string status contains the response status
     * @param object data contains the response transaction
     * 
     * @since   0.0.8.0
     */
    Main.methods.extract_midrub_updates = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Show the status
            $('#updates-system .progress-bar-striped').attr('aria-valuenow', '50');
            $('#updates-system .progress-bar-striped').css('width', '50%');
            $('#updates-system .progress-bar-striped').text('50%');

            // Show message
            $('#updates-system p').text(data.message);

            // Start backup
            Main.start_backup();
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);

            // Show the modal
            $('#updates-system').modal('hide');
            
        }

    };

    /*
     * Display the updates status
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
            $('#updates-system .progress-bar-striped').attr('aria-valuenow', '100');
            $('#updates-system .progress-bar-striped').css('width', '100%');
            $('#updates-system .progress-bar-striped').text('100%');

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
            $('#updates-system').modal('hide');
            
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
     * Updates Midrub
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.0
     */
    $('.updates-midrub').submit(function (e) {
        e.preventDefault();
        
        // Get the updates's code
        var code = $(this).find('.code-input').val();

        // Prepare data to send
        var data = {
            action: 'updates_midrub',
            code: code
        };

        // Set CSRF
        data[$(this).attr('data-csrf')] = $('input[name="' + $(this).attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/updates', 'POST', data, 'updates_midrub');
        
        // Show loading animation
        $('.page-loading').fadeIn('slow');
        
    });
    
    /*******************************
    DEPENDENCIES
    ********************************/
 
});