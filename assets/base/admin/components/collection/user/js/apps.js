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
     * Detect app save settings
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.5
     */ 
    $( document ).on( 'click', 'body .theme-save-changes .theme-save-changes-btn', function (e) {
        e.preventDefault();

        // Prepare data to send
        var data = {
            action: 'user_update_settings',
            checkbox_inputs: [],
            text_inputs: []
        };
        
        // List all checkbox's inputs
        $('.main .theme-settings-options .theme-checkbox-input-2').each(function () {
            data.checkbox_inputs.push({
                field: $(this).closest('li').attr('data-field'),
                value: $(this).find('input[type="checkbox"]').prop('checked')?1:0
            });
        });

        // Get all text's inputs
        var texts = $('.user-page .theme-text-input-1').length;

        // Verify if texts exists
        if (texts > 0) {

            // List all text's inputs
            $('.user-page .theme-text-input-1').each(function () {
                data.text_inputs.push({
                    field: $(this).closest('li').attr('data-field'),
                    value: $(this).val().replace(/</g,"&lt;").replace(/>/g,"&gt;")
                });
            });

        }

		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');     
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/user', 'POST', data, 'user_update_app_settings_response', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
    });

    /*
     * Select app
     * 
     * @since   0.0.8.1
     */ 
    $( document ).on( 'click', '.user-page .default-installation-select-btn', function (e) {
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
            Main.show_alert('success', data.message, 1500, 2000);
            
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
            $('#app-installation .progress-bar-striped').attr('aria-valuenow', '100');
            $('#app-installation .progress-bar-striped').css('width', '100%');
            $('#app-installation .progress-bar-striped').text('100%');
            
            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);

            setTimeout(function() {
                
                // Redirect to apps page
                document.location.href = url + 'admin/user?p=apps';

            }, 3000);
            
        } else {

            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);
            
        }

    };

    /*
     * Display the update app settings response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.5
     */
    Main.methods.user_update_app_settings_response = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Hide the save button
            $('body .theme-save-changes').slideUp('slow');
            
            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);
            
        } else {
            
            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);

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
                        Main.show_alert('error', data.message, 1500, 2000);
                        
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
 
});