/*
 * Themes JavaScript file
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
     * Unzipping the theme's zip
     * 
     * @param integer file_name contains the file name
     * 
     * @since   0.0.8.4
     */    
    Main.unzipping = function (file_name) {

        // Prepare data to send
        var data = {
            action: 'unzipping_theme_zip',
            file_name: file_name
        };

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/admin', 'GET', data, 'unzipping_theme_zip');
        
    };
    

    /*******************************
    ACTIONS
    ********************************/

    /*
     * File change detection
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.4
     */
    $(document).on('change', '#file', function (e) {

        // Upload theme
        $('#upload-theme').submit();

    });

    /*
     * Enable theme
     * 
     * @since   0.0.8.4
     */
    $(document).on('click', '.admin-page .admin-enable-theme', function (e) {
        e.preventDefault();
        
        // Get theme's slug
        var theme_slug = $(this).closest('.card-theme').attr('data-theme');

        // Prepare data
        var data = {
            action: 'enable_theme',
            theme_slug: theme_slug
        };
        
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/admin', 'POST', data, 'enable_theme');
        
    }); 
    
    /*
     * Disable theme
     * 
     * @since   0.0.8.4
     */
    $(document).on('click', '.admin-page .admin-disable-theme', function (e) {
        e.preventDefault();
        
        // Get theme's slug
        var theme_slug = $(this).closest('.card-theme').attr('data-theme');

        // Prepare data
        var data = {
            action: 'disable_theme',
            theme_slug: theme_slug
        };
        
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/admin', 'POST', data, 'disable_theme');
        
    });

    /*
     * Select theme
     * 
     * @since   0.0.8.4
     */ 
    $( document ).on( 'click', '.admin-page .select-theme', function (e) {
        e.preventDefault();
        
        // Select a theme
        $('#file').click();
        
    });
   
    /*******************************
    RESPONSES
    ********************************/ 
   
    /*
     * Display theme activation response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.4
     */
    Main.methods.enable_theme = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);

            // Refresh page after 2 seconds
            setTimeout(

                function(){

                    // Refresh page
                    document.location.href = document.location.href;

                }, 2000

            );
            
        } else {
            
            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);
            
        }

    };

    /*
     * Display theme deactivation response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.4
     */
    Main.methods.disable_theme = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);

            // Refresh page after 2 seconds
            setTimeout(

                function(){

                    // Refresh page
                    document.location.href = document.location.href;

                }, 2000

            );
            
        } else {
            
            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);
            
        }

    };

    /*
     * Display unzipping response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.4
     */
    Main.methods.unzipping_theme_zip = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Show the status
            $('#theme-installation .progress-bar-striped').attr('aria-valuenow', '100');
            $('#theme-installation .progress-bar-striped').css('width', '100%');
            $('#theme-installation .progress-bar-striped').text('100%');
            
            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);

            setTimeout(function() {
                
                // Redirect to themes page
                document.location.href = url + 'admin/admin?p=themes';

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
     * Upload theme
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.4
     */
    $('#upload-theme').submit(function (e) {
        e.preventDefault();

        var files = $('#file')[0].files;

        if ( files.length > 0 ) {
    
            var fileType = files[0].type.split('/');
            var form = new FormData();
            form.append('path', '/');
            form.append('file', files[0]);
            form.append('type', fileType[0]);
            form.append('enctype', 'multipart/form-data');
            form.append($('.main').attr('data-csrf'), $('.main').attr('data-csrf-value'));
    
            // Set the action
            form.append('action', 'upload_theme');

            // Show installation process
            $('#theme-installation').modal('show');

            // Upload media
            $.ajax({
                url: url + 'admin/ajax/admin',
                type: 'POST',
                data: form,
                dataType: 'JSON',
                processData: false,
                contentType: false,
                success: function (data) {

                    // Verify if the success response exists
                    if ( data.success ) {

                        // Show the status
                        $('#theme-installation .progress-bar-striped').attr('aria-valuenow', '20');
                        $('#theme-installation .progress-bar-striped').css('width', '20%');
                        $('#theme-installation .progress-bar-striped').text('20%');
                        
                        // Show message
                        $('#theme-installation p').text(data.message);

                        // Unzip
                        Main.unzipping(data.file_name);
                        
                    } else {

                        // Display alert
                        Main.show_alert('error', data.message, 1500, 2000);
                        
                    }

                },
                error: function (jqXHR) {
                    console.log(jqXHR);

                    // Hide the modal
                    $('#theme-installation').modal('hide');

                }

            });

        }

    });
    
    /*******************************
    DEPENDENCIES
    ********************************/
 
});