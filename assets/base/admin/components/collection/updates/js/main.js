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

        // Prepare data to send
        var data = {
            action: 'download_midrub_updates'
        };
        
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');

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
        Main.ajax_call(url + 'admin/ajax/updates', 'GET', data, 'restore_midrub_backup', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();

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

        // Remove progress bar
        Main.remove_progress_bar();

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
            Main.show_alert('error', data.message, 1500, 2000);
            
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
            Main.show_alert('error', data.message, 1500, 2000);

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
            Main.show_alert('error', data.message, 1500, 2000);

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
            Main.show_alert('success', data.message, 1500, 2000);

            // Refresh the page
            setTimeout(function() {
                document.location.href = document.location.href;
            }, 3000);
            
        } else {
            
            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);

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

        // Remove progress bar
        Main.remove_progress_bar();

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);

            // Refresh the page
            setTimeout(function() {
                document.location.href = document.location.href;
            }, 3000);
            
        } else {
            
            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);
            
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
    $(document).on('submit', '.updates-page .update-midrub', function (e) {
        e.preventDefault();

        // Prepare data to send
        var data = {
            action: 'updates_midrub'
        };

		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/updates', 'POST', data, 'updates_midrub', 'ajax_onprogress');
        
        // Set progress bar
        Main.set_progress_bar(); 
        
    });
    
    /*******************************
    DEPENDENCIES
    ********************************/
 
});