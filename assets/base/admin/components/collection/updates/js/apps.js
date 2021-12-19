/*
 * Apps javascript file
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
     * @param array args contains the parameters
     * 
     * @since   0.0.8.1
     */    
    Main.start_download = function (args) {

        // Get the updates's code
        var code = args.code;

        // Get the app's slug
        var slug = args.slug;     

        // Prepare data to send
        var data = {
            action: 'download_app_updates',
            code: code,
            slug: slug
        };
        
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/updates', 'POST', data, 'download_app_updates');
        
    };

    /*
     * Start Extract
     * 
     * @param array args contains the parameters
     * 
     * @since   0.0.8.1
     */    
    Main.start_extract = function (args) {

        // Get the app's slug
        var slug = args.slug;   

        // Prepare data to send
        var data = {
            action: 'extract_app_updates',
            slug: slug
        };

		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/updates', 'POST', data, 'extract_app_updates');
        
    };

    /*
     * Start Backup
     * 
     * @param array args contains the parameters
     * 
     * @since   0.0.8.1
     */    
    Main.start_backup = function (args) {

        // Get the app's slug
        var slug = args.slug;  

        // Prepare data to send
        var data = {
            action: 'start_app_backup',
            slug: slug
        };

		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/updates', 'POST', data, 'start_app_backup');
        
    };

    /*
     * Verify if the string is url
     * 
     * @since   0.0.8.1
     * 
     * @return boolean true or false
     */  
    Main.is_url = function (string) {

        let url;

        // Verify if the string is url
        try {
            url = new URL(string);
        } catch (_) {
            return false;  
        }

        // Return boolean
        return url.protocol === 'http:' || url.protocol === 'https:';

    }

    /*******************************
    ACTIONS
    ********************************/

    /*
     * Generate new updates code
     * 
     * @since   0.0.8.1
     */
    $( document ).on( 'click', '.generate-new-updates-code', function (e) {
        e.preventDefault();

        // Get url 
        let data_url = $(this).attr('data-url');

        // Verify if the url is valid
        if ( Main.is_url(data_url) ) {

            // Redirect
            window.open(
                data_url,
                '_blank'
            );

        } else {

            // Display alert
            Main.show_alert('error', words.updates_url_not_valid, 1500, 2000);

        }

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
     * @since   0.0.8.1
     */
    Main.methods.updates_midrub_app = function ( status, data ) {

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
            Main.start_download({
                code: data.code,
                slug: data.slug
            });
            
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
     * @since   0.0.8.1
     */
    Main.methods.download_app_updates = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Show the status
            $('#updates-system .progress-bar-striped').attr('aria-valuenow', '25');
            $('#updates-system .progress-bar-striped').css('width', '25%');
            $('#updates-system .progress-bar-striped').text('25%');

            // Show message
            $('#updates-system p').text(data.message);

            // Start extract
            Main.start_extract({
                slug: data.slug
            });
            
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
     * @since   0.0.8.1
     */
    Main.methods.extract_app_updates = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Show the status
            $('#updates-system .progress-bar-striped').attr('aria-valuenow', '50');
            $('#updates-system .progress-bar-striped').css('width', '50%');
            $('#updates-system .progress-bar-striped').text('50%');

            // Show message
            $('#updates-system p').text(data.message);

            // Start backup
            Main.start_backup({
                slug: data.slug
            });
            
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
     * @since   0.0.8.1
     */
    Main.methods.start_app_backup = function ( status, data ) {

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
 
    /*******************************
    FORMS
    ********************************/
   
    /*
     * Updates Midrub's App
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.1
     */
    $(document).on('submit', '.updates-page .update-midrub', function (e) {
        e.preventDefault();
        
        // Get the updates's code
        var code = $(this).find('.code-input').val();

        // Get the app's slug
        var slug = $(this).closest('.list-group-item').attr('data-field');        

        // Prepare data to send
        var data = {
            action: 'updates_midrub_app',
            code: code,
            slug: slug
        };

		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/updates', 'POST', data, 'updates_midrub_app', 'ajax_onprogress');
        
        // Set progress bar
        Main.set_progress_bar(); 
        
    });
 
});