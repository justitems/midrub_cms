/*
 * Networks javascript file
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
     * Unzipping the network's zip
     * 
     * @param string file_name contains the file's name
     * 
     * @since   0.0.8.5
     */    
    Main.unzipping = function (file_name) {

        // Prepare data to send
        var data = {
            action: 'frontend_unzipping_network_zip',
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
     * @since   0.0.8.5
     */
    $(document).on('change', '#file', function () {

        // Upload network
        $('#upload-network').submit();

    });

    /*
     * Save settings
     * 
     * @since   0.0.8.5
     */ 
    $(document).on( 'click', 'body .theme-save-changes .theme-save-changes-btn', function () {
        
        // Get all dropdowns
        var dropdowns = $('.frontend-page .theme-dynamic-dropdown').length;
        
        // All dropdowns container
        var all_dropdowns = [];

        // Verify if dropdowns exists
        if (dropdowns > 0) {

            // List all dropdowns
            for (var d = 0; d < dropdowns; d++) {

                // Verify if dropdown's id exists
                if ($('.frontend-page .theme-dynamic-dropdown').eq(d).closest('.list-group-item').attr('data-field')) {

                    // Append dropdown's value
                    all_dropdowns[$('.frontend-page .theme-dynamic-dropdown').eq(d).closest('.list-group-item').attr('data-field')] = $('.frontend-page .theme-dynamic-dropdown').eq(d).attr('data-id');

                }

            }

        }

        // Get all textareas
        var textareas = $('.frontend-page .theme-text-input-1').length;
        
        // All textareas container
        var all_textareas = [];

        // Verify if textareas exists
        if (textareas > 0) {

            // List all textareas
            for (var t = 0; t < textareas; t++) {

                // Append textarea's value
                all_textareas[$('.frontend-page .theme-text-input-1').eq(t).closest('.list-group-item').attr('data-field')] = $('.frontend-page .theme-text-input-1').eq(t).val().replace(/</g,"&lt;").replace(/>/g,"&gt;");

            }

        }

        // Get all checkboxes inputs
        var checkboxes = $('.frontend-page .theme-field-checkbox').length;
        
        // Verify if checkboxes exists
        if (checkboxes > 0) {

            // List all checkboxes
            for ( var c = 0; c < checkboxes; c++ ) {

                // Verify if the checkbox is checked
                if ( $('.frontend-page .theme-field-checkbox').eq(c).is(':checked') ) {
                
                    // Append checkbox's value
                    all_textareas[$('.frontend-page .theme-field-checkbox').eq(c).closest('.list-group-item').attr('data-field')] = 1;
                    
                } else {
                    
                    // Append checkbox's value
                    all_textareas[$('.frontend-page .theme-field-checkbox').eq(c).closest('.list-group-item').attr('data-field')] = 0;
                    
                }

            }

        }

        // Prepare data to send
        var data = {
            action: 'frontend_save_social_data',
            all_dropdowns: Object.entries(all_dropdowns),
            all_textareas: Object.entries(all_textareas),
        };

		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/frontend', 'POST', data, 'frontend_save_social_data_response', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
    }); 

    /*
     * Select network
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.5
     */ 
    $( document ).on( 'click', '.frontend-page .default-installation-select-btn', function (e) {
        e.preventDefault();
        
        // Select an network
        $('#file').click();
        
    });
   
    /*******************************
    RESPONSES
    ********************************/ 
   
    /*
     * Display social saving response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.5
     */
    Main.methods.frontend_save_social_data_response = function ( status, data ) {

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

    /*
     * Display unzipping response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.5
     */
    Main.methods.unzipping_zip = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Show the status
            $('#network-installation .progress-bar-striped').attr('aria-valuenow', '100');
            $('#network-installation .progress-bar-striped').css('width', '100%');
            $('#network-installation .progress-bar-striped').text('100%');
            
            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);

            setTimeout(function() {
                
                // Redirect to networks page
                document.location.href = url + 'admin/frontend?p=social_access&group=frontend_page';

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
     * Upload network
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.5
     */
    $('#upload-network').submit(function (e) {
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
            form.append('action', 'frontend_upload_network');

            // Show installation process
            $('#network-installation').modal('show');

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
                        $('#network-installation .progress-bar-striped').attr('aria-valuenow', '20');
                        $('#network-installation .progress-bar-striped').css('width', '20%');
                        $('#network-installation .progress-bar-striped').text('20%');
                        
                        // Show message
                        $('#network-installation p').text(data.message);

                        // Unzip
                        Main.unzipping(data.file_name);
                        
                    } else {

                        // Display alert
                        Main.show_alert('error', data.message, 1500, 2000);
                        
                    }

                },
                error: function (jqXHR) {

                    // Show error
                    console.log(jqXHR);

                    // Hide the modal
                    $('#network-installation').modal('hide');

                }

            });

        }

    });
 
});