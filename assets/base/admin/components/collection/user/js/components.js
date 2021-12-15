/*
 * Components javascript file
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
     * Unzipping the component's zip
     * 
     * @param integer file_name contains the file name
     * 
     * @since   0.0.8.1
     */    
    Main.unzipping = function (file_name) {

        // Prepare data to send
        var data = {
            action: 'unzipping_component_zip',
            file_name: file_name
        };

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/user', 'GET', data, 'unzipping_component_zip');
        
    };

    /*******************************
    ACTIONS
    ********************************/

    /*
     * Display save changes button
     * 
     * @since   0.0.7.9
     */
    $(document).on('keyup', 'body .social-text-input', function () {

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

        // Upload component
        $('#upload-component').submit();

    });

    /*
     * Detect component save settings
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
            checkbox_inputs: []
        };
        
        // List all text inputs
        $('.main .theme-settings-options .theme-checkbox-input-2').each(function () {
            data.checkbox_inputs.push({
                field: $(this).closest('li').attr('data-field'),
                value: $(this).find('input[type=checkbox]').prop('checked')?1:0
            });
        });

		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');     
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/user', 'POST', data, 'user_update_component_settings_response', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
    });

    /*
     * Select component
     * 
     * @since   0.0.8.1
     */ 
    $( document ).on( 'click', '.user-page .default-installation-select-btn', function (e) {
        e.preventDefault();
        
        // Select a component
        $('#file').click();
        
    });
   
    /*******************************
    RESPONSES
    ********************************/ 
   
    /*
     * Display component saving response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.9
     */
    Main.methods.save_component_data = function ( status, data ) {

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
    Main.methods.unzipping_component_zip = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Show the status
            $('#component-installation .progress-bar-striped').attr('aria-valuenow', '100');
            $('#component-installation .progress-bar-striped').css('width', '100%');
            $('#component-installation .progress-bar-striped').text('100%');
            
            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);

            setTimeout(function() {
                
                // Redirect to components page
                document.location.href = url + 'admin/user?p=components';

            }, 3000);
            
        } else {

            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);
            
        }

    };

    /*
     * Display the update component settings response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.5
     */
    Main.methods.user_update_component_settings_response = function ( status, data ) {

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
     * Upload component
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.1
     */
    $('#upload-component').submit(function (e) {
        e.preventDefault();

        var files = $('#file')[0].files;

        if ( files.length > 0 ) {
    
            var fileType = files[0].type.split('/');
            var form = new FormData();
            form.append('path', '/');
            form.append('file', files[0]);
            form.append('type', fileType[0]);
            form.append('enctype', 'multipart/form-data');
            form.append($('#upload-component').attr('data-csrf'), $('input[name="' + $('#upload-component').attr('data-csrf') + '"]').val());
    
            // Set the action
            form.append('action', 'upload_component');

            // Show installation process
            $('#component-installation').modal('show');

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
                        $('#component-installation .progress-bar-striped').attr('aria-valuenow', '20');
                        $('#component-installation .progress-bar-striped').css('width', '20%');
                        $('#component-installation .progress-bar-striped').text('20%');
                        
                        // Show message
                        $('#component-installation p').text(data.message);

                        // Unzip
                        Main.unzipping(data.file_name);
                        
                    } else {

                        // Display alert
                        Main.show_alert('error', data.message, 1500, 2000);
                        
                    }

                },
                error: function (jqXHR) {

                    // Hide the modal
                    $('#component-installation').modal('hide');

                }

            });

        }

    });
    
    /*******************************
    DEPENDENCIES
    ********************************/
 
});