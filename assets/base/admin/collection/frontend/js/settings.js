/*
 * Settings javascript file
*/

jQuery(document).ready( function ($) {
    'use strict';
    
    // Get home page url
    var url = $('.navbar-brand').attr('href');

    // Default properties
    Main.files = {};
    
    /*******************************
    METHODS
    ********************************/
   
    /*
     * Get pages by category
     * 
     * @param string drop_class contains the dropdown's class
     * 
     * @since   0.0.7.8
     */    
    Main.frontend_settings_load_pages_by_category =  function (drop_class) {

        // Prepare data
        var data = {
            action: 'settings_auth_pages_list',
            drop_class: drop_class,
            key: $('.frontend-page .' + drop_class + '_search').val()
        };

        // Set CSRF
        data[$('.save-settings').attr('data-csrf')] = $('input[name="' + $('.save-settings').attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/frontend', 'POST', data, 'settings_auth_show_pages');
        
    };

    /*
     * Load selected options
     * 
     * @since   0.0.7.8
     */    
    Main.load_selected_settings =  function () {

        // Prepare data
        var data = {
            action: 'settings_all_options'
        };
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/frontend', 'GET', data, 'settings_all_options');
        
    };

    /*
     * Load multimedia by page
     * 
     * @param integer page contains the page number
     * 
     * @since   0.0.7.8
     */
    Main.frontend_load_multimedia = function (page) {

        // Prepare data to send
        var data = {
            action: 'load_multimedia',
            page: page
        };

        // Set CSRF
        data[$('.save-settings').attr('data-csrf')] = $('input[name="' + $('.save-settings').attr('data-csrf') + '"]').val();

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/frontend', 'POST', data, 'load_multimedia');

    };

    /*
     * Upload file
     * 
     * @object file contains file to upload
     * 
     * @since   0.0.7.8
     */
    Main.saveFile = function (file) {

        Main.files[file.lastModified + '-' + file.size] = {
            key: file.lastModified + '-' + file.size,
            name: file.name,
            type: file.type,
            size: file.size,
            lastModified: file.lastModified
        };

        var fileType = file.type.split('/');
        var form = new FormData();
        form.append('path', '/');
        form.append('file', file);
        form.append('type', fileType[0]);
        form.append('enctype', 'multipart/form-data');
        form.append($('.upim').attr('data-csrf'), $('input[name="' + $('.upim').attr('data-csrf') + '"]').val());
        Main.getPreview(file, Main.files[file.lastModified + '-' + file.size]);
        var s = 0;

        $('.drag-and-drop-files .icon-cloud-upload').addClass('drag-upload-active');

        var intval = setInterval(function () {
            $('.drag-and-drop-files .icon-cloud-upload').removeClass('drag-upload-active');
            setTimeout(function () {
                $('.drag-and-drop-files .icon-cloud-upload').addClass('drag-upload-active');
            }, 500);
        }, 1000);

        var timer = setInterval(function () {
            var cover = Main.files[file.lastModified + '-' + file.size].cover;

            if (typeof cover !== 'undefined') {
                Main.uploadFile(form, Main.files[file.lastModified + '-' + file.size]);
                clearInterval(timer);
                clearInterval(intval);
            }

            if (s > 15) {
                Main.files[file.lastModified + '-' + file.size].cover = 'data:image/png;base64,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';
                Main.uploadFile(form, Main.files[file.lastModified + '-' + file.size]);
                clearInterval(timer);
                clearInterval(intval);
            } else {
                s++;
            }

        }, 1000);

    };

    /*
     * Get preview for multimedia files
     * 
     * @param object file contains the file
     * @param object object with file's params
     * 
     * @since   0.0.7.8
     */
    Main.getPreview = function (file, object) {

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

                var blob = new Blob([fileReader.result], { type: file.type });
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
     * Upload files
     * 
     * @param object form contains the form's data
     * @param object path with file's path
     * 
     * @since   0.0.7.8
     */
    Main.uploadFile = function (form, path) {

        // Set the media's cover
        form.append('cover', path.cover);

        // Set the action
        form.append('action', 'upload_media_in_storage');

        // Create inteval variable for animation
        var intval;

        // Upload media
        $.ajax({
            url: url + 'admin/ajax/frontend',
            type: 'POST',
            data: form,
            dataType: 'JSON',
            processData: false,
            contentType: false,
            beforeSend: function () {

                $('.drag-and-drop-files .icon-cloud-upload').addClass('drag-upload-active');

                intval = setInterval(function () {

                    $('.drag-and-drop-files .icon-cloud-upload').removeClass('drag-upload-active');

                    setTimeout(function () {

                        $('.drag-and-drop-files .icon-cloud-upload').addClass('drag-upload-active');

                    }, 500);

                }, 1000);

            },
            success: function (data) {

                if (data.success) {

                    // Load all media's files
                    Main.frontend_load_multimedia(1);

                    // Display alert
                    Main.popup_fon('subi', data.message, 1500, 2000);

                } else {

                    Main.popup_fon('sube', data.message, 1500, 2000);

                }

            },
            error: function (jqXHR, textStatus, errorThrown) {

                console.log(jqXHR);

            },
            complete: function () {

                setTimeout(function () {
                    $('.drag-and-drop-files .icon-cloud-upload').removeClass('drag-upload-active');
                }, 2000);

                clearInterval(intval);

            }

        });

    };

    /*******************************
    ACTIONS
    ********************************/

    /*
     * Search pages by category
     * 
     * @since   0.0.7.8
     */
    $(document).on('keyup', '.frontend-page .settings-dropdown-search-input', function () {
        
        // Load pages
        Main.frontend_settings_load_pages_by_category($(this).closest('.dropdown').attr('data-option'));
        
    });

    /*
     * Display save button
     * 
     * @since   0.0.7.8
     */
    $(document).on('change', '.frontend-page textarea, .frontend-page input[type="text"], .frontend-page .settings-option-checkbox', function (e) {
        e.preventDefault();

        // Display save button
        $('.settings-save-changes').fadeIn('slow');
        
    });

    /*
     * File change detection
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.8
     */
    $(document).on('change', '#file', function (e) {
        $('#upim').submit();
    });

    /*
     * Reload multimedia manager
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.8
     */
    $('#multimedia-manager').on('shown.bs.modal', function (e) {

        // Load multimedia files
        Main.frontend_load_multimedia(1);

    });

    /*
     * Get auth pages
     * 
     * @since   0.0.7.8
     */
    $(document).on('click', '.frontend-page .settings-dropdown-btn', function (e) {
        e.preventDefault();

        // Load pages
        Main.frontend_settings_load_pages_by_category($(this).closest('.dropdown').attr('data-option'));
        
    });

    /*
     * Select a page
     * 
     * @since   0.0.7.8
     */
    $(document).on('click', '.frontend-page .settings-dropdown-list-ul a', function (e) {
        e.preventDefault();

        // Get item's id
        var item_id = $(this).attr('data-id'); 
        
        // Get item's title
        var item_title = $(this).text();

        // Add item's title and item's id
        $(this).closest('.dropdown').find('.settings-dropdown-btn').text(item_title);
        $(this).closest('.dropdown').find('.settings-dropdown-btn').attr('data-id', item_id);

        // Display save button
        $('.settings-save-changes').fadeIn('slow');
        
    });   
    
    /*
     * Save settings
     * 
     * @since   0.0.7.8
     */ 
    $( document ).on( 'click', '.settings-save-changes', function () {
        
        // Hide save button
        $('.settings-save-changes').fadeOut('slow');
        
        // Get all dropdowns
        var dropdowns = $('.frontend-page .settings-dropdown-btn').length;
        
        var all_dropdowns = [];

        if (dropdowns > 0) {

            for (var d = 0; d < dropdowns; d++) {

                if ($('.frontend-page .settings-dropdown-btn').eq(d).attr('data-id')) {

                    all_dropdowns[$('.frontend-page .settings-dropdown-btn').eq(d).closest('.dropdown').attr('data-option')] = $('.frontend-page .settings-dropdown-btn').eq(d).attr('data-id');

                }

            }

        }

        // Get all textareas
        var textareas = $('.frontend-page .settings-textarea-value').length;
        
        var all_textareas = [];

        if (textareas > 0) {

            for (var t = 0; t < textareas; t++) {

                all_textareas[$('.frontend-page .settings-textarea-value').eq(t).attr('data-option')] = $('.frontend-page .settings-textarea-value').eq(t).val().replace(/</g,"&lt;").replace(/>/g,"&gt;");

            }

        }

        // Get all media's inputs
        var medias = $('.frontend-page .settings-media-value').length;

        // Verify if media's inputs exists
        if (medias > 0) {

            for (var m = 0; m < medias; m++) {

                all_textareas[$('.frontend-page .settings-media-value').eq(m).attr('data-option')] = $('.frontend-page .settings-media-value').eq(m).val().replace(/</g,"&lt;").replace(/>/g,"&gt;");

            }

        }

        // Get all checkboxes inputs
        var checkboxes = $('.frontend-page .settings-option-checkbox').length;

        // Verify if checkboxes exists
        if (checkboxes > 0) {

            for ( var c = 0; c < checkboxes; c++ ) {

                if ( $('.frontend-page .settings-option-checkbox').eq(c).is(':checked') ) {
                
                    all_textareas[$('.frontend-page .settings-option-checkbox').eq(c).attr('id')] = 1;
                    
                } else {
                    
                    all_textareas[$('.frontend-page .settings-option-checkbox').eq(c).attr('id')] = 0;
                    
                }

            }

        }
        
        // Prepare data to send
        var data = {
            action: 'save_frontend_settings',
            all_dropdowns: Object.entries(all_dropdowns),
            all_textareas: Object.entries(all_textareas)
        };
        
        // Set CSRF
        data[$('.save-settings').attr('data-csrf')] = $('input[name="' + $('.save-settings').attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/frontend', 'POST', data, 'save_frontend_settings');

        // Show loading animation
        $('.page-loading').fadeIn('slow');
        
    }); 

    /*
     * Drag and Drop detection
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.8
     */
    $(document).on('drag dragstart dragend dragover dragenter dragleave drop', '.drag-and-drop-files', function (e) {
        e.preventDefault();
        e.stopPropagation();

        $(this).addClass('drag-active');

        if (e.handleObj.origType === 'dragleave' || e.handleObj.origType === 'drop') {

            $(this).removeClass('drag-active');

            if (typeof e.originalEvent.dataTransfer.files[0] !== 'undefined') {
                $('#file').prop('files', e.originalEvent.dataTransfer.files);
                $('#upim').submit();
            }

        }

    });

    /*
     * Select a file
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.8
     */
    $(document).on('click', '.drag-and-drop-files a', function (e) {
        e.preventDefault();

        // Select a file
        $('#file').click();

    });

    /*
     * Detect multimedia button click
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.8
     */
    $(document).on('click', '.frontend-page .multimedia-manager-btn', function (e) {
        e.preventDefault();

        // Set multimedia button location
        Main.multimedia_btn = $(this);

    });

    /*
     * Detect multimedia item click
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.8
     */
    $(document).on('click', '.multimedia-gallery-items .gallery-item .item-info', function (e) {
        e.preventDefault();

        // Get file's url
        var file_url = $(this).attr('data-url');

        // Add image url
        $(Main.multimedia_btn).closest('.input-group').find('.settings-media-value').val(file_url);

        // Close modal
        $('#multimedia-manager').modal('toggle');

        // Display save button
        $('.settings-save-changes').fadeIn('slow');

    });

    /*
     * Delete media item
     * 
     * @since   0.0.7.8
     */
    $(document).on('click', '#multimedia-manager .delete-media-item', function (e) {
        e.preventDefault();

        // Get item's id
        var item_id = $(this).attr('data-id');

        // Prepare data
        var data = {
            action: 'delete_media_item',
            item_id: item_id
        };

        // Set CSRF
        data[$('.save-settings').attr('data-csrf')] = $('input[name="' + $('.save-settings').attr('data-csrf') + '"]').val();

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/frontend', 'POST', data, 'delete_media_item');

    });

    /*
     * Load old media's files
     * 
     * @since   0.0.8.2
     */
    $(document).on('click', '#multimedia-manager .btn-load-old-media', function (e) {
        e.preventDefault();

        // Get page
        let page = $(this).attr('data-page');

        // Load media by page
        Main.frontend_load_multimedia(page);

    });
   
    /*******************************
    RESPONSES
    ********************************/ 
   
    /*
     * Display auth pages
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.8
     */
    Main.methods.settings_auth_show_pages = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Pages list
            var pages = '';

            // List all pages
            for ( var p = 0; p < data.pages.length; p++ ) {

                pages += '<li class="list-group-item">'
                            + '<a href="#" data-id="' + data.pages[p].content_id + '">'
                                + data.pages[p].meta_value
                            + '</a>'
                        + '</li>';

            }

            // Display all pages
            $('.frontend-page .' + data.drop_class + '_list').html(pages);
            
        } else {

            var message = '<li class="list-group-item no-results-found">'
                + data.message
            + '</li>';

            // Display no contents found
            $('.frontend-page .' + data.drop_class + '_list').html(message);
            
        }

    };
 
    /*
     * Display settings saving response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.8
     */
    Main.methods.save_frontend_settings = function ( status, data ) { 

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
     * Display selected options
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.8
     */
    Main.methods.settings_all_options = function ( status, data ) { 

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Verify if pages by role exists
            if ( typeof data.response.pages_by_role !== 'undefined' ) {

                // List all pages
                for (let index = 0; index < data.response.pages_by_role.length; index++) {
                    
                    // Verify if class exists
                    if ( $('.' + data.response.pages_by_role[index].meta_value).length > 0 ) {

                        // Set text
                        $('.' + data.response.pages_by_role[index].meta_value).text(data.response.pages_by_role[index].title);

                        // Set content's id
                        $('.' + data.response.pages_by_role[index].meta_value).attr('data-id', data.response.pages_by_role[index].content_id);

                    }

                }

            }
            
        }
        
    };

    /*
     * Display user's media response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.8
     */
    Main.methods.load_multimedia = function (status, data) {

        // Hide the load more button
        $( '#multimedia-manager .btn-load-old-media' ).hide();

        // Verify if the success response exists
        if (status === 'success') {

            // Verify if more ol media files exists
            if ( ( data.page * 12 ) < data.total ) {

                // Show the load more button
                $( '#multimedia-manager .btn-load-old-media' ).show();

                // Set next page
                $( '#multimedia-manager .btn-load-old-media' ).attr('data-page', (data.page + 1));

            }

            // All files
            var files = '';

            // List all files
            for (var d = 0; d < data.medias.length; d++) {

                files += '<div class="gallery-item col-lg-3 col-md-4 col-sm-4 col-xs-6">'
                            + '<a href="#" data-url="' + data.medias[d].body + '" data-id="' + data.medias[d].media_id + '" class="item-info">'
                                + '<img src="' + data.medias[d].cover + '" class="img-responsive">'
                            + '</a>'
                            + '<a href="#" data-id="' + data.medias[d].media_id + '" class="delete-media-item">'
                                + '<i class="icon-trash"></i>'
                            + '</a>'                    
                        + '</div>';

            }

            // Verify if is the first page
            if ( data.page < 2 ) {

                // Display files
                $('#multimedia-manager .multimedia-gallery-items').html(files);

            } else {

                // Display files
                $('#multimedia-manager .multimedia-gallery-items').append(files);

            }

        } else {

            // Prepare no media files found
            var no_media_message = '<div class="col-xs-12">'
                                        + '<p>'
                                            + data.message
                                        + '</p>'
                                    + '</div>';

            // Display no media files found
            $('#multimedia-manager .multimedia-gallery-items').html(no_media_message);

        }

    };

    /*
     * Display media item
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.8
     */
    Main.methods.delete_media_item = function (status, data) {

        // Verify if the success response exists
        if (status === 'success') {

            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000); 
            
            // Load all media's files
            Main.frontend_load_multimedia(1);

        } else {

            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);

        }

    };
    
    /*******************************
    FORMS
    ********************************/
   
    /*
     * Upload files
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.8
     */
    $('#upim').submit(function (e) {
        e.preventDefault();

        var files = $('#file')[0].files;

        if (typeof files[0] !== 'undefined') {

            for (var f = 0; f < files.length; f++) {

                Main.saveFile(files[f]);

            }

        }

    });
    
    /*******************************
    DEPENDENCIES
    ********************************/

    // Hide loading animation
    $('.page-loading').fadeOut('slow');

    // Load selected options
    Main.load_selected_settings();
 
});