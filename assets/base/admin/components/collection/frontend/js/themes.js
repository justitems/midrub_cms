/*
 * Themes javascript file
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
     * @since   0.0.8.1
     */    
    Main.unzipping = function (file_name) {

        // Prepare data to send
        var data = {
            action: 'unzipping_zip',
            file_name: file_name
        };

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/frontend', 'GET', data, 'unzipping_zip');
        
    };

    /*******************************
    ACTIONS
    ********************************/

    /*
     * File change detection
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.1
     */
    $(document).on('change', '#file', function (e) {

        // Upload theme
        $('#upload-theme').submit();

    });

    /*
     * Enable theme
     * 
     * @since   0.0.8.5
     */
    $(document).on('click', '.frontend-page .frontend-enable-theme', function (e) {
        e.preventDefault();
        
        // Get theme's slug
        let theme = $(this).closest('.card').attr('data-theme');

        // Prepare data
        var data = {
            action: 'frontend_enable_theme',
            theme: theme
        };
        
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/frontend', 'POST', data, 'frontend_enable_theme_response', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
    }); 
    
    /*
     * Disable theme
     * 
     * @since   0.0.8.5
     */
    $(document).on('click', '.frontend-page .frontend-disable-theme', function (e) {
        e.preventDefault();
        
        // Get theme's slug
        let theme = $(this).closest('.card').attr('data-theme');

        // Prepare data
        var data = {
            action: 'frontend_disable_theme',
            theme: theme
        };
        
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/frontend', 'POST', data, 'frontend_disable_theme_response', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
    });

    /*
     * Select theme
     * 
     * @since   0.0.8.1
     */ 
    $( document ).on( 'click', '.frontend-page .default-installation-select-btn', function (e) {
        e.preventDefault();
        
        // Select a theme
        $('#file').click();
        
    });

    /*
     * Detect dropdown selection
     * 
     * @param integer page contains the page number
     * 
     * @since   0.0.8.5
     */ 
    $( document ).on( 'click', '.frontend-page .theme-settings-options .dropdown .theme-dropdown-items-list a', function (e) {
        e.preventDefault();
        
        // Get item's ID
        let item = $(this).attr('data-id');

        // Get item's name
        let item_name = $(this).text();

        // Set item's ID
        $(this).closest('.dropdown').find('.btn-secondary').attr('data-id', item);

        // Set item's name
        $(this).closest('.dropdown').find('.btn-secondary > span').text(item_name);        
        
    });
   
    /*******************************
    RESPONSES
    ********************************/ 
   
    /*
     * Display theme enable response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.5
     */
    Main.methods.frontend_enable_theme_response = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();

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
     * Display theme disable response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.5
     */
    Main.methods.frontend_disable_theme_response = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();

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
     * @since   0.0.8.1
     */
    Main.methods.unzipping_zip = function ( status, data ) {

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
                document.location.href = url + 'admin/frontend?p=themes&group=frontend_page';

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
     * @since   0.0.8.1
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
            form.append($('#upload-theme').attr('data-csrf'), $('input[name="' + $('#upload-theme').attr('data-csrf') + '"]').val());
    
            // Set the action
            form.append('action', 'upload_theme');

            // Show installation process
            $('#theme-installation').modal('show');

            // Upload media
            $.ajax({
                url: url + 'admin/ajax/frontend',
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
                        Main.popup_fon('sube', data.message, 1500, 2000);
                        
                    }

                },
                error: function (jqXHR, textStatus, errorThrown) {

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