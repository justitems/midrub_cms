/*
 * Frontend Theme JavaScript file
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
     * @param array args contains the parameters
     * 
     * @since   0.0.8.3
     */    
    Main.start_download = function (args) {

        // Get the update's code
        var code = args.code;

        // Get the Frontend Theme slug
        var slug = args.slug;     

        // Prepare data to send
        var data = {
            action: 'download_frontend_theme_update',
            code: code,
            slug: slug
        };
        
        // Set the CSRF field
        data[$('.update-midrub').attr('data-csrf')] = $('input[name="' + $('.update-midrub').attr('data-csrf') + '"]').val();

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/update', 'POST', data, 'download_frontend_theme_update');
        
    };

    /*
     * Start Extract
     * 
     * @param array args contains the parameters
     * 
     * @since   0.0.8.3
     */    
    Main.start_extract = function (args) {

        // Get the Frontend Theme slug
        var slug = args.slug;   

        // Prepare data to send
        var data = {
            action: 'extract_frontend_theme_update',
            slug: slug
        };

        // Set the CSRF field
        data[$('.update-midrub').attr('data-csrf')] = $('input[name="' + $('.update-midrub').attr('data-csrf') + '"]').val();

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/update', 'POST', data, 'extract_frontend_theme_update');
        
    };

    /*
     * Start Backup
     * 
     * @param array args contains the parameters
     * 
     * @since   0.0.8.3
     */    
    Main.start_backup = function (args) {

        // Get the Frontend Theme slug
        var slug = args.slug;  

        // Prepare data to send
        var data = {
            action: 'start_frontend_theme_backup',
            slug: slug
        };

        // Set the CSRF field
        data[$('.update-midrub').attr('data-csrf')] = $('input[name="' + $('.update-midrub').attr('data-csrf') + '"]').val();

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/update', 'POST', data, 'start_frontend_theme_backup');
        
    };

    /*
     * Verify if the string is url
     * 
     * @since   0.0.8.3
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
     * Generate new update code
     * 
     * @since   0.0.8.1
     */
    $( document ).on( 'click', '.generate-new-update-code', function (e) {
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
            Main.popup_fon('sube', words.update_url_not_valid, 1500, 2000);

        }

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
     * @since   0.0.8.3
     */
    Main.methods.update_midrub_frontend_theme = function ( status, data ) {

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
            Main.start_download({
                code: data.code,
                slug: data.slug
            });
            
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
     * @since   0.0.8.3
     */
    Main.methods.download_frontend_theme_update = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Show the status
            $('#update-system .progress-bar-striped').attr('aria-valuenow', '25');
            $('#update-system .progress-bar-striped').css('width', '25%');
            $('#update-system .progress-bar-striped').text('25%');

            // Show message
            $('#update-system p').text(data.message);

            // Start extract
            Main.start_extract({
                slug: data.slug
            });
            
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
     * @since   0.0.8.3
     */
    Main.methods.extract_frontend_theme_update = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Show the status
            $('#update-system .progress-bar-striped').attr('aria-valuenow', '50');
            $('#update-system .progress-bar-striped').css('width', '50%');
            $('#update-system .progress-bar-striped').text('50%');

            // Show message
            $('#update-system p').text(data.message);

            // Start backup
            Main.start_backup({
                slug: data.slug
            });
            
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
     * @since   0.0.8.3
     */
    Main.methods.start_frontend_theme_backup = function ( status, data ) {

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
 
    /*******************************
    FORMS
    ********************************/
   
    /*
     * Update Frontend Theme
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.3
     */
    $('.update-midrub').submit(function (e) {
        e.preventDefault();
        
        // Get the update's code
        var code = $(this).find('.code-input').val();

        // Get the Frontend Theme slug
        var slug = $(this).find('.slug-input').val();        

        // Prepare data to send
        var data = {
            action: 'update_midrub_frontend_theme',
            code: code,
            slug: slug
        };

        // Set CSRF
        data[$(this).attr('data-csrf')] = $('input[name="' + $(this).attr('data-csrf') + '"]').val();

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/update', 'POST', data, 'update_midrub_frontend_theme');
        
        // Show loading animation
        $('.page-loading').fadeIn('slow');
        
    });
    
    /*******************************
    DEPENDENCIES
    ********************************/

    // Hide loading animation
    $('.page-loading').fadeOut('slow');
 
});