/*
 * Apps javascript file
*/

jQuery(document).ready( function ($) {
    'use strict';
    
    // Get home page url
    var url = $('.navbar-brand').attr('href');
    
    /*******************************
    METHODS
    ********************************/

    /*
     * Unzipping the app's zip
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
        Main.ajax_call(url + 'admin/ajax/user', 'GET', data, 'unzipping_zip');
        
    };

    /*******************************
    ACTIONS
    ********************************/

    /*
     * Display save changes button
     * 
     * @since   0.0.7.9
     */
    $(document).on('keyup', 'body .text-input', function () {

        // Display save button
        $('.settings-save-changes').fadeIn('slow');
        
    }); 
    
    /*
     * Display save changes button
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.9
     */
    $(document).on('change', 'body .checkbox-input', function (e) {
        
        // Display save button
        $('.settings-save-changes').fadeIn('slow');
        
    }); 

    /*
     * File change detection
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.1
     */
    $(document).on('change', '#file', function (e) {

        // Upload app
        $('#upload-app').submit();

    });

    /*
     * Save settings
     * 
     * @since   0.0.7.9
     */ 
    $( document ).on( 'click', '.user-page .settings-save-changes .btn', function () {
        
        // Hide save button
        $('.user-page .settings-save-changes').fadeOut('slow');

        // Get all inputs
        var inputs = $('.user-page .text-input').length;
        
        var all_inputs = [];
        
        for ( var i = 0; i < inputs; i++ ) {
            
            all_inputs[$('.user-page .text-input').eq(i).attr('id')] = $('.user-page .text-input').eq(i).val();
            
        }

        // Get all options
        var options = $('.user-page .checkbox-input').length;
        
        var all_options = [];
        
        for ( var o = 0; o < options; o++ ) {
            
            if ( $('.user-page .checkbox-input').eq(o).is(':checked') ) {
                
                all_options[$('.user-page .checkbox-input').eq(o).attr('id')] = 1;
                
            } else {
                
                all_options[$('.user-page .checkbox-input').eq(o).attr('id')] = 0;
                
            }
            
        }

        // Prepare data to send
        var data = {
            action: 'save_social_data',
            all_inputs: Object.entries(all_inputs),
            all_options: Object.entries(all_options)
        };
        
        data[$('.save-settings').attr('data-csrf')] = $('input[name="' + $('.save-settings').attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/user', 'POST', data, 'save_app_data');

        // Show loading animation
        $('.page-loading').fadeIn('slow');
        
    });

    /*
     * Select app
     * 
     * @since   0.0.8.1
     */ 
    $( document ).on( 'click', '.user-page .select-app', function (e) {
        e.preventDefault();
        
        // Select an app
        $('#file').click();
        
    });
   
    /*******************************
    RESPONSES
    ********************************/ 
   
    /*
     * Display app saving response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.9
     */
    Main.methods.save_app_data = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
        } else {

            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
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
            $('#app-installation .progress-bar-striped').attr('aria-valuenow', '100');
            $('#app-installation .progress-bar-striped').css('width', '100%');
            $('#app-installation .progress-bar-striped').text('100%');
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);

            setTimeout(function() {
                
                // Redirect to apps page
                document.location.href = url + 'admin/user?p=apps';

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
     * Upload app
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.1
     */
    $('#upload-app').submit(function (e) {
        e.preventDefault();

        var files = $('#file')[0].files;

        if ( files.length > 0 ) {
    
            var fileType = files[0].type.split('/');
            var form = new FormData();
            form.append('path', '/');
            form.append('file', files[0]);
            form.append('type', fileType[0]);
            form.append('enctype', 'multipart/form-data');
            form.append($('#upload-app').attr('data-csrf'), $('input[name="' + $('#upload-app').attr('data-csrf') + '"]').val());
    
            // Set the action
            form.append('action', 'upload_app');

            // Show installation process
            $('#app-installation').modal('show');

            // Upload media
            $.ajax({
                url: url + 'admin/ajax/user',
                type: 'POST',
                data: form,
                dataType: 'JSON',
                processData: false,
                contentType: false,
                success: function (data) {

                    // Verify if the success response exists
                    if ( data.success ) {

                        // Show the status
                        $('#app-installation .progress-bar-striped').attr('aria-valuenow', '20');
                        $('#app-installation .progress-bar-striped').css('width', '20%');
                        $('#app-installation .progress-bar-striped').text('20%');
                        
                        // Show message
                        $('#app-installation p').text(data.message);

                        // Unzip
                        Main.unzipping(data.file_name);
                        
                    } else {

                        // Display alert
                        Main.popup_fon('sube', data.message, 1500, 2000);
                        
                    }

                },
                error: function (jqXHR, textStatus, errorThrown) {

                    // Hide the modal
                    $('#app-installation').modal('hide');

                }

            });

        }

    });
    
    /*******************************
    DEPENDENCIES
    ********************************/

    // Hide loading animation
    $('.page-loading').fadeOut('slow');
 
});