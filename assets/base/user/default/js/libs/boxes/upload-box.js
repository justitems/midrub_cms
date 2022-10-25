/*
 * Upload Box JavaScript file
*/

jQuery(document).ready( function ($) {
    'use strict';
    
    /*******************************
    METHODS
    ********************************/

    /*
     * Generate preview for a file
     * 
     * @param object file contains the file to upload
     * 
     * @since   0.0.8.3
     * 
     * @return object with preview
     */
    Main.the_upload_preview = function (file, object) {
        var fileReader = new FileReader();
        if (file.type.match('image')) {
            fileReader.onload = function () {
                var img = document.createElement('img');
                img.src = fileReader.result;

            var image = new Image();

            image.onload = function () {
                var canvas = document.createElement('canvas');
                canvas.width = 250;
                canvas.height = 250;

                canvas.getContext('2d').drawImage(this, 0, 0, 250, 250);

                object.cover = canvas.toDataURL('image/png');
            };
            image.src = img.src;

            };
            fileReader.readAsDataURL(file);
        } else {
            fileReader.onload = function () {
                var blob = new Blob([fileReader.result], {type: file.type});
                var url = URL.createObjectURL(blob);
                var video = document.createElement('video');
                var timeupdate = function () {
                    if (snapImage()) {
                        video.removeEventListener('timeupdate', timeupdate);
                        video.pause();
                    }
                };
                video.addEventListener('loadeddata', function () {
                    if (snapImage()) {
                        video.removeEventListener('timeupdate', timeupdate);
                    }
                });
                var snapImage = function () {
                    var canvas = document.createElement('canvas');
                    canvas.width = 250;
                    canvas.height = 250;
                    canvas.getContext('2d').drawImage(video, 0, 0, 250, 250);
                    var image = canvas.toDataURL();
                    var success = image.length > 10;
                    if (success) {
                        var img = document.createElement('img');
                        img.src = image;
                        URL.revokeObjectURL(url);
                        object.cover = img.src;
                    }
                    return success;
                };
                video.addEventListener('timeupdate', timeupdate);
                video.preload = 'metadata';
                video.src = url;
                video.muted = true;
                video.playsInline = true;
                video.play();
            };
            fileReader.readAsArrayBuffer(file);
        }
    };

    /*
     * Prepare the files before upload
     * 
     * @param object files contains the files to upload
     * @param function func contains the function
     * 
     * @since   0.0.8.3
     */
    Main.save_files = function (files, func) {

        // Upload files property
        Main.upload_files = {};

        // Set timers
        var timers = [];

        // List all files
        for ( var f = 0; f < files.length; f++ ) {

            var file = files[f];
        
            // Set file's data
            Main.upload_files[file.lastModified + '-' + file.size] = {
                file: file,
                key: file.lastModified + '-' + file.size,
                name: file.name,
                type: file.type,
                size: file.size,
                lastModified: file.lastModified,
                id: f
            };
            
            // Split the file to get the extension
            let file_type = file.type.split('/');

            // Verify the file is an image or video
            if ( ( file_type[0] !== 'image' ) && ( file_type[0] !== 'video' ) ) {

                // Default cover
                Main.upload_files[file.lastModified + '-' + file.size].cover = '';

            } else {

                // Get preview
                Main.the_upload_preview(file, Main.upload_files[file.lastModified + '-' + file.size]);

                // Prepare the counter
                var s = 0;

                // Set time interval
                timers[f] = setInterval(function() {
                    
                    // Verify if the cover exists
                    if ( typeof Main.upload_files[file.lastModified + '-' + file.size].cover !== 'undefined') {

                        // Clear the timer interval
                        clearInterval(timers[Main.upload_files[file.lastModified + '-' + file.size].id]);

                    }
                    
                    // If in 15 seconds no preview, set default cover
                    if ( s > 15 ) {

                        // Default cover
                        Main.upload_files[file.lastModified + '-' + file.size].cover = '';

                        // Clear the timer interval
                        clearInterval(timers[Main.upload_files[file.lastModified + '-' + file.size].id]);

                    } else {
                        s++;
                    }
                
                }, 1000);   

            }

        }

        // Count previews
        var previews = setInterval(function() {

            // Verify if Main.upload_files meets the files length
            if ( Object.values(Main.upload_files).length === files.length ) {

                // Verify if timers 
                if ( timers.length > 0 ) {

                    // List all timers
                    for ( var t = 0; t < timers.length; t++ ) {

                        // Clear the timer interval
                        clearInterval(timers[t]);

                    }

                }

                // Upload files
                func(Object.values(Main.upload_files));

                // Clear the timer interval
                clearInterval(previews);                

            }
        
        }, 1000);  

    };

    /*
     * Displays the drag and drop areas
     * 
     * @since   0.0.8.3
     */
    Main.reload_drag_and_drop_areas = function () {

        // Identify all drag and drop areas
        $(document).find( '.crm-drag-and-drop-files' ).each(function() {

            // Set the supported extensions
            let extensions = $(this).attr('data-supported-extensions');

            // Replace dots
            let without_dots = extensions.replace('/./g', '').replace('/,/g', ', ').toUpperCase();

            // For form container
            var for_form = '';

            // Verify if there data for form exists
            if ( $(this).find('[data-for="form"]').length > 0 ) {

                // Set form
                for_form = $(this).find('[data-for="form"]').html();

            }

            // Multiple files option
            var multiple = '';

            // Verify if the form supports multiple files upload
            if ( $(this).attr('data-multiple-files') ) {

                // Enable multiple
                multiple = ' multiple';

            }

            // Prepare content
            let content = '<div class="crm-upload-main">'
                + '<div class="crm-upload-icon">'
                    + '<i class="ri-upload-cloud-2-line"></i>'
                + '</div>'
                + '<div class="crm-upload-text">'
                    + '<h2>'
                        + Main.translation.theme_drag_drop_files_here
                    + '</h2>'
                    + '<p>'
                        + Main.translation.theme_files_supported + ': ' + without_dots
                    + '</p>'
                + '</div>'
                + '<div class="crm-upload-btn">'
                    + '<a href="#" class="crm-choose-files">'
                        + Main.translation.theme_choose_file
                + ' </a>'
                + '</div>'                                     
            + '</div>'
            + '<div class="crm-upload-over">'
                + '<div class="crm-upload-icon">'
                    + '<i class="ri-upload-cloud-2-line"></i>'
                + '</div>'  
            + '</div>'
            + '<div class="crm-upload-drop">'
                + '<div class="crm-upload-progress">'
                    + '<p>'
                        + '0%'
                    + '</p>'
                    + '<div class="progress">'
                        + '<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>'
                    + '</div>'
                + '</div>'                            
            + '</div>'
            + '<form action="' + $(this).attr('data-upload-form-url') + '" method="post" enctype="multipart/form-data" class="crm-upload-files-form d-none">'
                + '<input type="file" name="file[]" class="crm-upload-files-input" accept="' + extensions + '"' + multiple + '>'
                + for_form
            + '</form>'; 

            // Add content
            $(this).html(content);
            
        });

    };
  
    /*******************************
    ACTIONS
    ********************************/

    /*
     * Load default content
     * 
     * @since   0.0.8.3 
     */
    $(function () {

        // Verify if drag and drop area exists
        if ( $('.main .crm-drag-and-drop-files').length > 0 ) {

            // Reload drag and drop areas
            Main.reload_drag_and_drop_areas();

        }

    });

    /*
     * Detect drag and drop files
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.3
    */
    $( document ).on( 'drag dragstart dragend dragover dragenter dragleave drop', '.main .crm-drag-and-drop-files' , function (e) {
        e.preventDefault();
        e.stopPropagation();
        
        // Set drag active class
        $( this ).addClass( 'crm-drag-and-drop-files-over-active' );

        if ( e.handleObj.origType === 'dragleave' || e.handleObj.origType === 'drop' ) {
            
            // Remove drag active class
            $( this ).removeClass( 'crm-drag-and-drop-files-over-active' );

            // If files were dropped
            if ( e.handleObj.origType === 'drop' ) {

                // Verify if files exists
                if (typeof e.originalEvent.dataTransfer.files[0] !== 'undefined') {

                    // Set drop active class
                    $( this ).addClass( 'crm-drag-and-drop-files-drop-active' );

                    // Set files
                    Main.uploaded_files = e.originalEvent.dataTransfer.files;

                    // Empty the file input
                    $(this).find('form').find('[type="file"]').val('');

                    // Upload
                    $(this).find('form').submit();

                }           

            }
            
        }

    });

    /*
    * Detect file change value
    * 
    * @param object e with global object
    * 
    * @since   0.0.8.3
    */    
    $( document ).on( 'change', '.main .crm-drag-and-drop-files [type="file"]', function (e) {

        // Verify if files were dragged
        if ( typeof Main.uploaded_files !== 'undefined' ) {

            // Delete dragged files
            delete Main.uploaded_files;

        }        

        // Submit form
        $(this).closest('.crm-drag-and-drop-files').find('form').submit();

    });

    /*
     * Detect browse files click
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.3
    */
    $( document ).on( 'click', '.main .crm-drag-and-drop-files .crm-choose-files', function (e) {
        e.preventDefault();
    
        // Browse
        $(this).closest('.crm-drag-and-drop-files').find('[type="file"]').click();

    });
    
    /*******************************
    FORMS
    ********************************/

    /*
     * Upload media's files
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.3
     */
    $(document).on('submit', '.main .crm-upload-files-form', function (e) {
        e.preventDefault();

        // Set this
        let $this = $(this);

        // Set form's action
        let form_action = $this.closest('.crm-drag-and-drop-files').attr('data-upload-form-action');

        // Verify if files were dragged
        if ( typeof Main.uploaded_files !== 'undefined' ) {

            // Get files
            var files = Main.uploaded_files;

        } else {

            // Get files
            var files = $this.find('.crm-upload-files-input')[0].files;

        }

        // Verify if at least a file exists
        if ( typeof files[0] !== 'undefined' ) {

            // Save upload files
            Main.save_files(files, function(files) {

                // Prepare FormData
                var form = new FormData();

                // Append files to FormData
                form.append('path', '/');

                // Verify if the form has text fields
                if ( $this.find('input[type="text"]').length > 0 ) {

                    // Set text inputs
                    var text_inputs = $this.find('input[type="text"]');

                    // List all text fields
                    for ( var t = 0; t < text_inputs.length; t++ ) {

                        // Set text input
                        form.append($(text_inputs[t]).attr('name'), $(text_inputs[t]).attr('value'));                           

                    }

                }

                // List files
                for ( var f = 0; f < files.length; f++ ) {

                    // Set cover
                    form.append('covers[]', files[f].cover);                    

                    // Set files
                    form.append('files[]', files[f].file);

                }

                // Append multipart
                form.append('enctype', 'multipart/form-data');
                
                // Set the action
                form.append('action', form_action);

                // Get a new csrf
                $.get($('meta[name=url]').attr('content') + 'auth/ajax/page?action=generate_csrf', function (response) {

                    // Parse json
                    let json = JSON.parse(response);

                    // Verify if csrf exists
                    if ( typeof json.csrf !== 'undefined' ) {

                        // Verify if csrf name and hash exists
                        if ( (typeof json.csrf.name !== 'undefined') && (typeof json.csrf.hash !== 'undefined') ) {

                            // Set CSRF
                            form.append(json.csrf.name, json.csrf.hash);

                            // Upload files
                            $.ajax({

                                // Set url
                                url: $this.closest('.crm-drag-and-drop-files').attr('data-upload-form-url'),

                                // Request type
                                type: 'POST',

                                // Data
                                data: form,

                                // Format
                                dataType: 'JSON',

                                // Don't process
                                processData: false,

                                // No content's type
                                contentType: false,

                                // Get progress
                                xhr: function () {

                                    var xhr = $.ajaxSettings.xhr();

                                    xhr.upload.onprogress = function (e) {

                                        if (e.lengthComputable) {

                                            // Get percentage
                                            let percentage = ((e.loaded/e.total) * 100).toFixed(2);

                                            // Set percentage
                                            $this.closest('.crm-drag-and-drop-files').find('.crm-upload-progress p').text(percentage + '%');

                                            // Set progress
                                            $this.closest('.crm-drag-and-drop-files').find('.crm-upload-progress .progress-bar').attr('aria-valuenow', percentage).attr('style', 'width: ' + percentage + '%');

                                        }

                                    };

                                    return xhr;

                                },

                                // Success response
                                success: function (data) {

                                    // Verify if request was processed successfully
                                    if ( data.success === true ) {
                                        
                                        // Call the response function and return success message
                                        Main.call_object('success', data, form_action);
                                    
                                    } else {
                                    
                                        // Call the response function and return error message
                                        Main.call_object('error', data, form_action);
                                    
                                    }
                                    
                                },

                                // Complete response
                                complete: function() {

                                    // Remove the drop active class
                                    $this.closest('.crm-drag-and-drop-files').removeClass('crm-drag-and-drop-files-drop-active');

                                },

                                // Errors catcher
                                error: function (jqXHR) {
                                    
                                    // Display error
                                    console.log(jqXHR.responseText);
                                    
                                }
                                
                            });
                            
                        }

                    }

                });

            });
            
        }
        
    });

});