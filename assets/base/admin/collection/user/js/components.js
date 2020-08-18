/*
 * Components javascript file
*/

jQuery(document).ready( function ($) {
    'use strict';
    
    // Get home page url
    var url = $('.navbar-brand').attr('href');
    
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
     * Display save changes button
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.9
     */
    $(document).on('change', 'body .component-checkbox-input', function (e) {
        
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
     * Save settings
     * 
     * @since   0.0.7.9
     */ 
    $( document ).on( 'click', '.user-page .settings-save-changes .btn', function () {
        
        // Hide save button
        $('.user-page .settings-save-changes').fadeOut('slow');

        // Get all inputs
        var inputs = $('.user-page .social-text-input').length;
        
        var all_inputs = [];
        
        for ( var i = 0; i < inputs; i++ ) {
            
            all_inputs[$('.user-page .social-text-input').eq(i).attr('id')] = $('.user-page .social-text-input').eq(i).val();
            
        }

        // Get all options
        var options = $('.user-page .component-checkbox-input').length;
        
        var all_options = [];
        
        for ( var o = 0; o < options; o++ ) {
            
            if ( $('.user-page .component-checkbox-input').eq(o).is(':checked') ) {
                
                all_options[$('.user-page .component-checkbox-input').eq(o).attr('id')] = 1;
                
            } else {
                
                all_options[$('.user-page .component-checkbox-input').eq(o).attr('id')] = 0;
                
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
        Main.ajax_call(url + 'admin/ajax/user', 'POST', data, 'save_component_data');

        // Show loading animation
        $('.page-loading').fadeIn('slow');
        
    }); 

    /*
     * Select component
     * 
     * @since   0.0.8.1
     */ 
    $( document ).on( 'click', '.user-page .select-component', function (e) {
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
    Main.methods.unzipping_component_zip = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Show the status
            $('#component-installation .progress-bar-striped').attr('aria-valuenow', '100');
            $('#component-installation .progress-bar-striped').css('width', '100%');
            $('#component-installation .progress-bar-striped').text('100%');
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);

            setTimeout(function() {
                
                // Redirect to components page
                document.location.href = url + 'admin/user?p=components';

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
                        Main.popup_fon('sube', data.message, 1500, 2000);
                        
                    }

                },
                error: function (jqXHR, textStatus, errorThrown) {

                    // Hide the modal
                    $('#component-installation').modal('hide');

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