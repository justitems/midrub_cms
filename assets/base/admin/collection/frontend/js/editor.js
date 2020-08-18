/*
 * Editor javascript file
*/

jQuery(document).ready(function ($) {
    'use strict';

    // Get home page url
    var url = $('.navbar-brand').attr('href');

    // Default properties
    Main.files = {};

    /*******************************
    METHODS
    ********************************/

    /*
     * Get pages
     * 
     * @param string drop_class contains the dropdown's class
     * 
     * @since   0.0.7.8
     */
    Main.load_pages = function (drop_class) {

        // Prepare data
        var data = {
            action: 'settings_auth_pages_list',
            drop_class: drop_class,
            key: $('.editor-page .' + drop_class + '_search').val()
        };

        // Set the CSRF field
        data[$('.form-editor').attr('data-csrf')] = $('input[name="' + $('.form-editor').attr('data-csrf') + '"]').val();

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/frontend', 'POST', data, 'show_pages');

    };

    /*
     * Get selected pages
     * 
     * @since   0.0.7.8
     */
    Main.load_selected_pages = function (drop_class) {

        // Selected pages array
        var selected_pages = [];

        // Get all dropdowns
        var dropdowns = $('.editor-page .meta-dropdown-btn');

        // Verify if text dropdowns fields exists
        if (dropdowns.length > 0) {

            // List all dropdowns fields
            for (var p = 0; p < dropdowns.length; p++) {

                if ($(dropdowns[p]).attr('data-id')) {

                    selected_pages.push($(dropdowns[p]).attr('data-id'));

                }

            }

        }

        // Load selected pages
        Main.selected_pages(selected_pages);

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

        // Set the CSRF field
        data[$('.form-editor').attr('data-csrf')] = $('input[name="' + $('.form-editor').attr('data-csrf') + '"]').val();

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

    /*
     * Get selected pages
     * 
     * @param array contains the pages id
     * 
     * @since   0.0.7.8
     */
    Main.selected_pages = function (page_ids) {

        // Prepare data
        var data = {
            action: 'load_selected_pages',
            page_ids: page_ids
        };

        // Set the CSRF field
        data[$('.form-editor').attr('data-csrf')] = $('input[name="' + $('.form-editor').attr('data-csrf') + '"]').val();

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/frontend', 'POST', data, 'load_selected_pages');

    };

    /*
     * Get selected pages
     * 
     * @since   0.0.7.9
     */
    Main.load_classifications = function () {

        // Prepare data
        var data = {
            action: 'load_classifications',
            meta_option_classification_slug: $('#add-new-classification .create-classification').attr('data-classification-slug')
        };

        // Set the CSRF field
        data[$('.form-editor').attr('data-csrf')] = $('input[name="' + $('.form-editor').attr('data-csrf') + '"]').val();

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/frontend', 'POST', data, 'load_classifications');

    };

    /*
     * Get classification's items
     * 
     * @since   0.0.7.9
     */
    Main.load_classification_items = function () {

        // Prepare data
        var data = {
            action: 'get_classification_parents',
            key: $('#add-new-classification .search-classifications-parents').val(),
            meta_option_classification_slug: $('#add-new-classification .create-classification').attr('data-classification-slug')
        };

        // Set the CSRF field
        data[$('.form-editor').attr('data-csrf')] = $('input[name="' + $('.form-editor').attr('data-csrf') + '"]').val();

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/frontend', 'POST', data, 'get_classification_parents');

    };

    /*
     * Filter classification list by search
     * 
     * @since   0.0.7.9
     */
    Main.filter_classification_list_by_search = function () {

        // Verify if search value exists
        if ( $('#classification-popup-manager .search-for-classifications').val() ) {

            // Hide all
            $('#classification-popup-manager .classifications-list > li').hide();

            // Add parent class
            $('#classification-popup-manager .classifications-list > li').addClass('classifications-parent');

            // Get all classification's items
            var items = $('#classification-popup-manager .classifications-list').find('li > div > div > a[data-toggle="collapse"]');

            // List all classification's items
            for ( var i = 0; i < items.length; i++ ) {

                // Verify if item's name contains the text
                if( $(items[i]).text().toLowerCase().indexOf($('#classification-popup-manager .search-for-classifications').val().toLowerCase()) >= 0) {

                    // Show parent
                    $(items[i]).closest('.classifications-parent').show();

                }
                
            }

        } else {

            // Display all
            $('#classification-popup-manager .classifications-list > li').show();

        }

    };

    /*******************************
    ACTIONS
    ********************************/

    /*
     * Search pages
     * 
     * @since   0.0.7.8
     */
    $(document).on('keyup', 'body .search-dropdown-items', function () {

        // Load pages
        Main.load_pages($(this).closest('.dropdown').attr('data-option'));

    });

    /*
     * Search for classifications
     * 
     * @since   0.0.7.9
     */
    $(document).on('keyup', '#add-new-classification .search-classifications-parents', function () {

        // Load classification's items
        Main.load_classification_items();

    });

    /*
     * Search for classifications
     * 
     * @since   0.0.7.9
     */
    $(document).on('keyup', '#classification-popup-manager .search-for-classifications', function () {

        // Filter classification list by search
        Main.filter_classification_list_by_search();

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
     * Detect when classifications manager is closed
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.9
     */
    $('#classification-popup-manager').on('hidden.bs.modal', function (e) {

        // All selected items
        var all_classification_ids = [];

        // Get all classification's items
        var items = $('#classification-popup-manager .classifications-list').find('input[type="checkbox"]');

        // List all classification's items
        for (var i = 0; i < items.length; i++) {

            if ($(items[i]).is(':checked')) {

                // Set id
                all_classification_ids.push($(items[i]).attr('data-id'));

            }

        }

        // Prepare data
        var data = {
            action: 'selected_classification_item',
            all_classification_ids: all_classification_ids,
            classification_slug: $('#classification-popup-manager .create-classification').attr('data-classification-slug')
        };

        // Set the CSRF field
        data[$('.form-editor').attr('data-csrf')] = $('input[name="' + $('.form-editor').attr('data-csrf') + '"]').val();

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/frontend', 'POST', data, 'selected_classification_item');

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
    $(document).on('click', '.form-editor .multimedia-manager-btn', function (e) {
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
        $(Main.multimedia_btn).closest('.input-group').find('.contents-meta-text-input').val(file_url);

        // Close modal
        $('#multimedia-manager').modal('toggle');

    });

    /*
     * Get pages
     * 
     * @since   0.0.7.8
     */
    $(document).on('click', '.editor-page .meta-dropdown-btn', function (e) {
        e.preventDefault();

        // Load pages
        Main.load_pages($(this).closest('.dropdown').attr('data-option'));

    });

    /*
     * Select a page
     * 
     * @since   0.0.7.8
     */
    $(document).on('click', '.editor-page .meta-dropdown-list-ul a', function (e) {
        e.preventDefault();

        // Get item's id
        var item_id = $(this).attr('data-id');

        // Get item's title
        var item_title = $(this).text();

        // Add item's title and item's id
        $(this).closest('.dropdown').find('.btn-secondary').text(item_title);
        $(this).closest('.dropdown').find('.btn-secondary').attr('data-id', item_id);

    });

    /*
     * Add new list item
     * 
     * @since   0.0.7.8
     */
    $(document).on('click', '.editor-page .btn-new-list-item', function (e) {
        e.preventDefault();

        // Get item's type
        var type = $(this).attr('data-type');

        if ( typeof window[type] !== 'undefined' ) {

            if ( window[type].length > 0 ) {

                var item = '<li>';

                for ( var e = 0; e < window[type].length; e++ ) {
                    item += window[type][e];
                }

                item += '</li>';

                $(this).closest('.panel').find('.list-items-ul').append(item);

                $(this).closest('.panel').find('.list-items-ul').find('.summernote-editor').summernote();

            }

        }

    });

    /*
     * Delete list item
     * 
     * @since   0.0.7.8
     */
    $(document).on('click', '.editor-page .list-items-ul .delete-item', function (e) {
        e.preventDefault();

        $(this).closest('li').remove();

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

        // Set the CSRF field
        data[$('.form-editor').attr('data-csrf')] = $('input[name="' + $('.form-editor').attr('data-csrf') + '"]').val();

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/frontend', 'POST', data, 'delete_media_item');

    });

    /*
     * Open classification popup manager
     * 
     * @since   0.0.7.9
     */
    $(document).on('click', '.editor-page .btn-classification-popup-manager', function (e) {
        e.preventDefault();

        // Get classification's slug
        var classification_slug = $(this).attr('data-classification-slug');

        if ( $('#classification-popup-manager .create-classification').attr('data-classification-slug') === classification_slug ) {

            // Show modal
            $('#classification-popup-manager').modal('show');

        } else {

            // Prepare data
            var data = {
                action: 'get_classification_data',
                classification_slug: classification_slug
            };

            // Set the CSRF field
            data[$('.form-editor').attr('data-csrf')] = $('input[name="' + $('.form-editor').attr('data-csrf') + '"]').val();

            // Make ajax call
            Main.ajax_call(url + 'admin/ajax/frontend', 'POST', data, 'classification_data');

        }

    });

    /*
     * Delete classification's item
     * 
     * @since   0.0.7.9
     */
    $(document).on('click', '#classification-popup-manager .delete-classification-single', function (e) {
        e.preventDefault();

        // All classification's items ids
        var all_classification_ids = [];

        // Get all classification's items
        var items = $(this).closest('li').find('input[type="checkbox"]');

        // List all classification's item childs
        for (var i = 0; i < items.length; i++) {

            // Set id
            all_classification_ids.push($(items[i]).attr('data-id'));

        }

        // Prepare data
        var data = {
            action: 'delete_classification',
            all_classification_ids: all_classification_ids,
            single_item: $('#add-new-classification .create-classification').attr('data-single-item')
        };

        // Set the CSRF field
        data[$('.form-editor').attr('data-csrf')] = $('input[name="' + $('.form-editor').attr('data-csrf') + '"]').val();

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/frontend', 'POST', data, 'delete_classification');

    }); 
    
    /*
     * Load classification's items
     * 
     * @since   0.0.7.9
     */
    $(document).on('click', '#classification-popup-manager .new-classification-link', function (e) {
        e.preventDefault();

        // Empty search input
        $('#add-new-classification .search-classifications-parents').val('');

        // Get classification's items
        Main.load_classification_items();

    }); 

    /*
     * Select parent
     * 
     * @since   0.0.7.9
     */
    $(document).on('click', '#classification-popup-manager .classification-parents-list-ul li a', function (e) {
        e.preventDefault();

        // Get parent id
        var classification_id = $(this).attr('data-id');

        // Get parent text
        var classification_text = $(this).text();

        // Set parent id
        $(this).closest('.form-group').find('.btn-secondary').attr('data-id', classification_id);

        // Set parent text
        $(this).closest('.form-group').find('.btn-secondary').text(classification_text);

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
     * Display content creation response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.8
     */
    Main.methods.create_new_content = function (status, data) {

        // Verify if the success response exists
        if (status === 'success') {

            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);

            // Verify if the post was created
            if ( $('.editor-page .form-editor').attr('data-content-id') < 1 ) {

                // Set content's id
                $('.editor-page .form-editor').attr('data-content-id', data.content_id);

            }

        } else {

            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);

        }

    };

    /*
     * Display url generation response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.8
     */
    Main.methods.generate_url_slug = function (status, data) {

        // Verify if the success response exists
        if (status === 'success') {

            // Add slug
            $('#page-url-composer .url-slug').text(data.slug);
            $('#page-url-composer .url-slug').attr('data-slug', data.slug);

            // Empty input
            $('#page-url-composer .url-slug-input').val('');

        } else {

            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);

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
     * Display pages response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.8
     */
    Main.methods.show_pages = function (status, data) {

        // Verify if the success response exists
        if (status === 'success') {

            // Pages list
            var pages = '';

            // List all pages
            for (var p = 0; p < data.pages.length; p++) {

                pages += '<li class="list-group-item">'
                    + '<a href="#" data-id="' + data.pages[p].content_id + '">'
                        + data.pages[p].meta_value
                    + '</a>'
                + '</li>';

            }

            // Display all pages
            $('.editor-page .' + data.drop_class + '_list').html(pages);

        } else {

            var message = '<li class="list-group-item no-results-found">'
                + data.message
            + '</li>';

            // Display no contents found
            $('.editor-page .' + data.drop_class + '_list').html(message);

        }

    };

    /*
     * Display selected pages
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.8
     */
    Main.methods.load_selected_pages = function (status, data) {

        // Verify if the success response exists
        if (status === 'success') {

            for (var c = 0; c < data.contents.length; c++) {

                // Verify if selected page exists
                if ($('.editor-page .meta-dropdown-btn[data-id="' + data.contents[c].content_id + '"]').length > 0) {

                    // Add page title
                    $('.editor-page .meta-dropdown-btn[data-id="' + data.contents[c].content_id + '"]').text(data.contents[c].title);

                }

            }

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

    /*
     * Display classification data
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.9
     */
    Main.methods.classification_data = function (status, data) {

        // Verify if the success response exists
        if (status === 'success') {

            // Display inputs
            $('#classification-popup-manager .tab-pane').html( data.inputs );

            // Display classification words
            $('#classification-popup-manager .create-classification').attr('data-single-item', data.field.words_list.single_item );
            $('#classification-popup-manager .create-classification').attr('data-classification-slug', data.field.slug );
            $('#classification-popup-manager .search-for-classifications').attr('placeholder', data.field.words_list.search_input_placeholder );
            $('#classification-popup-manager .new-classification-link').html( data.field.words_list.new_classification_option );
            $('#classification-popup-manager .enter-category-slug').attr('placeholder', data.field.words_list.classification_slug_input_placeholder );
            
            // Show modal
            $('#classification-popup-manager').modal('show');

            // Load classifications
            Main.load_classifications();

        } else {

            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);

        }

    };

    /*
     * Display saving classification option response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.9
     */
    Main.methods.create_new_classification_option = function (status, data) {

        // Verify if the success response exists
        if (status === 'success') {

            // Reset the form
            $('#add-new-classification .create-classification')[0].reset();

            // Hide form
            $('#classification-popup-manager #add-new-classification').collapse('hide');

            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);

            // Load classifications
            Main.load_classifications();

        } else {

            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);

        }

    };

    /*
     * Display classifications list
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.9
     */
    Main.methods.load_classifications = function (status, data) {

        // Verify if the success response exists
        if (status === 'success') {

            // Display classifications
            $('#classification-popup-manager .classifications-list').html(data.classifications);

            // Filter classification list by search
            Main.filter_classification_list_by_search();

            // Show arrow
            $('#classification-popup-manager .classifications-list').find('li:has(ul li) > div > div > a[data-toggle="collapse"]').attr('aria-expanded', 'false');

            // Get all selected
            var all_selected = $('.editor-page .classification-selected-list-' + $('#classification-popup-manager .create-classification').attr('data-classification-slug')).find('input[type="checkbox"]');

            if (all_selected.length > 0) {

                // List all checkboxes
                for (var ch = 0; ch < all_selected.length; ch++) {

                    if ($(all_selected[ch]).is(':checked')) {

                        $('#classification-popup-manager .classifications-list #frontent-contents-single-' + $(all_selected[ch]).attr('data-id')).prop('checked', true);

                    }

                }

            }

        } else {

            var message = '<li class="list-group-item no-results-found">'
                + data.message
            + '</li>';

            // Display no data message
            $('#classification-popup-manager .classifications-list').html(message);

        }

    };

    /*
     * Display classification item deletion response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.9
     */
    Main.methods.delete_classification = function (status, data) {

        // Verify if the success response exists
        if (status === 'success') {

            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);

            // Load classifications
            Main.load_classifications();

        } else {

            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);

        }

    }; 
    
    /*
     * Display classification's parents
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.9
     */
    Main.methods.get_classification_parents = function (status, data) {

        // Reset parent button
        $('#add-new-classification .classification-select-parent').text(data.select_a_parent);
        $('#add-new-classification .classification-select-parent').removeAttr('data-id');

        // Verify if the success response exists
        if (status === 'success') {

            // Classifications list
            var classifications = '';

            // List all classifications
            for (var c = 0; c < data.classifications.length; c++) {

                classifications += '<li class="list-group-item">'
                    + '<a href="#" data-id="' + data.classifications[c].classification_id + '">'
                        + data.classifications[c].name
                    + '</a>'
                + '</li>';

            }

            // Display all classifications
            $('#add-new-classification .classification-parents-list-ul').html(classifications);

        } else {

            var message = '<li class="list-group-item no-results-found">'
                + data.message
            + '</li>';

            // Display no contents found
            $('#add-new-classification .classification-parents-list-ul').html(message);

        }

    };

    /*
     * Display selected classification's items
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.9
     */
    Main.methods.selected_classification_item = function (status, data) {

        // Verify if the success response exists
        if (status === 'success') {

            // Display all classifications
            $('.editor-page .classification-selected-list-' + data.classification_slug).html(data.classifications);

            // Show arrow
            $('.editor-page .classification-selected-list-' + data.classification_slug).find('li:has(ul li) > div > div > a[data-toggle="collapse"]').attr('aria-expanded', 'false');

        } else {

            var message = '<li class="list-group-item no-results-found">'
                + data.message
            + '</li>';

            // Display no contents found
            $('.editor-page .classification-selected-list-' + data.classification_slug).html(message);

        }

    };

    /*
     * Display contents classifications
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.9
     */
    Main.methods.get_content_classifications = function (status, data) {

        // Verify if the success response exists
        if (status === 'success') {

            for ( var s = 0; s < data.response.length; s++ ) {

                // Verify if the success response exists
                if ( data.response[s].success ) {

                    // Display all classifications
                    $('.editor-page .classification-selected-list-' + data.response[s].classification_slug).html(data.response[s].classifications);

                    // Show arrow
                    $('.editor-page .classification-selected-list-' + data.response[s].classification_slug).find('li:has(ul li) > div > div > a[data-toggle="collapse"]').attr('aria-expanded', 'false');

                } else {

                    var message = '<li class="list-group-item no-results-found">'
                            + data.response[s].message
                        + '</li>';

                    // Display no contents found
                    $('.editor-page .classification-selected-list-' + data.response[s].classification_slug).html(message);

                }

            }

        }

    };

    /*******************************
    FORMS
    ********************************/

    /*
     * Create a new content
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.8
     */
    $('.editor-page .form-editor').submit(function (e) {
        e.preventDefault();

        // Define data to send
        var data = {
            action: 'create_new_content',
            contents_category: $(this).attr('data-content-category'),
            content_id: $(this).attr('data-content-id'),
            contents_slug: $('#page-url-composer .url-slug').attr('data-slug'),
            status: $('.editor-page .content-status').val()
        };

        // Verify if auth component is selected
        if ($('.editor-page .auth-components-selected-component').length > 0) {
            data['contents_component'] = $('.editor-page .auth-components-selected-component').val();
        } else if ($('.editor-page .theme-templates-selected-template').length > 0) {
            data['theme_template'] = $('.editor-page .theme-templates-selected-template').val();
        }

        // Verify if contents has a static slug for url
        if ($('#page-url-composer .category-slug').length > 0) {
            data['contents_static_url_slug'] = $('#page-url-composer .category-slug').attr('data-slug');
        }

        // Get all editors
        var editors = $('.editor-page .tab-all-editors > .tab-pane');

        // List all categories
        for (var d = 0; d < editors.length; d++) {

            // Set title and body
            data[$(editors[d]).attr('id')] = {
                'content_title': $(editors[d]).find('.content-title').val()
            };

            // Verify if content's body is enabled
            if ($('#summernote').length > 0) {
                data[$(editors[d]).attr('id')]['content_body'] = $(editors[d]).find('#summernote').summernote('code');
            }

            // Get all text input fields
            var text_inputs = $(editors[d]).find('.contents-meta-text-input');

            // Verify if text input fields exists
            if (text_inputs.length > 0) {

                // List all input fields
                for (var e = 0; e < text_inputs.length; e++) {

                    if ( $(text_inputs[e]).closest('.list-items-ul').length > 0 ) {
                        continue;
                    }

                    if ($(text_inputs[e]).attr('data-slug')) {

                        data[$(editors[d]).attr('id')][$(text_inputs[e]).attr('data-slug')] = {
                            'meta': $(text_inputs[e]).attr('data-meta'),
                            'value': $(text_inputs[e]).val()
                        };

                    }

                }

            }

            // Get all checkboxes fields
            var checkboxes_inputs = $(editors[d]).find('.contents-meta-checkbox-input');

            // Verify if checbox input is checked
            if (checkboxes_inputs.length > 0) {

                // List all checkbox inputs fields
                for (var i = 0; i < checkboxes_inputs.length; i++) {

                    if ( $(checkboxes_inputs[i]).closest('.list-items-ul').length > 0 ) {
                        continue;
                    }

                    if ($(checkboxes_inputs[i]).prop('checked')) {

                        data[$(editors[d]).attr('id')][$(checkboxes_inputs[i]).attr('data-slug')] = {
                            'meta': $(checkboxes_inputs[i]).attr('data-meta'),
                            'value': 1
                        };

                    }

                }

            }

            // Get all dropdowns
            var dropdowns = $(editors[d]).find('.meta-dropdown-btn');

            // Verify if text dropdowns fields exists
            if (dropdowns.length > 0) {

                // List all dropdowns fields
                for (var p = 0; p < dropdowns.length; p++) {

                    if ( $(dropdowns[p]).closest('.list-items-ul').length > 0 ) {
                        continue;
                    }

                    if ($(dropdowns[p]).attr('data-id')) {

                        data[$(editors[d]).attr('id')][$(dropdowns[p]).closest('.dropdown').attr('data-option')] = {
                            'meta': $(dropdowns[p]).attr('data-meta'),
                            'value': '',
                            'extra': $(dropdowns[p]).attr('data-id')
                        };

                    }

                }

            }

            // Get all meta editors
            var meta_editors = $('#' + $(editors[d]).attr('id') ).find('.summer-area');

            if (meta_editors.length > 0) {

                // List all meta editors
                for (var v = 0; v < meta_editors.length; v++) {

                    if ( $(meta_editors).eq(v).find('.editor-body').closest('.list-items-ul').length > 0 ) {
                        continue;
                    }

                    if ( $(meta_editors).eq(v).find('.editor-body').attr('data-slug') ) {

                        data[$(editors[d]).attr('id')][$(meta_editors).eq(v).find('.editor-body').attr('data-slug')] = {
                            'meta': $(meta_editors).eq(v).find('.editor-body').attr('data-meta'),
                            'value': $(meta_editors).eq(v).find('.summernote-editor').summernote('code')
                        };

                    }

                }

            }

            // Get all lists
            var all_lists = $('#' + $(editors[d]).attr('id') ).find('.list-area');

            if (all_lists.length > 0) {

                // List all lists
                for (var al = 0; al < all_lists.length; al++) {
                    
                    // Get all list's items
                    var list_items = $(all_lists[al]).find('.list-items-ul > li');

                    if ( list_items.length > 0 ) {

                        var lists_array = [];

                        for ( var li = 0; li < list_items.length; li++ ) {

                            // Get all text input fields
                            var text_inputs = $(list_items).eq(li).find('.contents-meta-text-input');

                            // Verify if text input fields exists
                            if (text_inputs.length > 0) {

                                // List all input fields
                                for (var e = 0; e < text_inputs.length; e++) {

                                    if ($(text_inputs).eq([e]).attr('data-slug')) {

                                        lists_array[li + '_' + $(text_inputs).eq([e]).attr('data-slug')] = {
                                            'meta': $(text_inputs).eq([e]).attr('data-slug'),
                                            'value': $(text_inputs).eq([e]).val()
                                        };

                                    }

                                }

                            }

                            // Get all checkboxes fields
                            var checkboxes_inputs = $(list_items[li]).find('.contents-meta-checkbox-input');

                            // Verify if checbox input is checked
                            if (checkboxes_inputs.length > 0) {

                                // List all checkbox inputs fields
                                for (var i = 0; i < checkboxes_inputs.length; i++) {

                                    if ($(checkboxes_inputs[i]).prop('checked')) {

                                        lists_array[li + '_' + i + '_' + $(checkboxes_inputs[i]).attr('data-slug')] = {
                                            'meta': $(checkboxes_inputs[i]).attr('data-slug'),
                                            'value': 1
                                        };

                                    }

                                }

                            }

                            // Get all dropdowns
                            var dropdowns = $(list_items).eq(li).find('.meta-dropdown-btn');

                            // Verify if text dropdowns fields exists
                            if (dropdowns.length > 0) {

                                // List all dropdowns fields
                                for (var p = 0; p < dropdowns.length; p++) {

                                    if ($(dropdowns).eq(p).attr('data-id')) {

                                        lists_array[li  + '_' + $(dropdowns).eq(p).closest('.dropdown').attr('data-option')] = {
                                            'meta': $(dropdowns).eq(p).closest('.dropdown').attr('data-option'),
                                            'value': '',
                                            'extra': $(dropdowns).eq(p).attr('data-id')
                                        };

                                    }

                                }

                            }

                            // Get all meta editors
                            var meta_editors = $(list_items).eq(li).find('.summer-area');

                            if (meta_editors.length > 0) {

                                // List all meta editors
                                for (var v = 0; v < meta_editors.length; v++) {

                                    if ($(meta_editors).eq(v).find('.editor-body').attr('data-slug')) {

                                        lists_array[li + '_' + $(meta_editors).eq(v).find('.editor-body').attr('data-slug')] = {
                                            'meta': $(meta_editors).eq(v).find('.editor-body').attr('data-slug'),
                                            'value': $(meta_editors).eq(v).find('.summernote-editor').summernote('code')
                                        };

                                    }

                                }

                            }

                            if ( lists_array ) {

                                data[$(editors[d]).attr('id')][$(all_lists).eq(al).attr('data-slug')] = {
                                    'meta': $(all_lists).eq(al).attr('data-slug'),
                                    'value': Object.values(lists_array)
                                };

                            }

                        }

                    }

                }

            }          

        }

        // Get all classifications
        var all_classifications = $('.editor-page .classification-selected-list');

        if (all_classifications.length > 0) {

            var classifications = [];

            // List all classifications
            for (var cl = 0; cl < all_classifications.length; cl++) {

                // Get all checkboxes
                var list_checkboxes = $(all_classifications[cl]).find('input[type="checkbox"]');

                if (list_checkboxes.length > 0) {

                    // List all checkboxes
                    for (var ch = 0; ch < list_checkboxes.length; ch++) {

                        if ($(list_checkboxes[ch]).is(':checked')) {

                            classifications[$(all_classifications[cl]).closest('.form-group').find('.btn-classification-popup-manager').attr('data-classification-slug') + '_' + ch] = {
                                'meta': $(all_classifications[cl]).closest('.form-group').find('.btn-classification-popup-manager').attr('data-classification-slug'),
                                'value': $(list_checkboxes[ch]).attr('data-id')
                            };

                        }

                    }

                }

            }

            if ( classifications ) {
                        
                data['classifications'] = Object.values(classifications);

            }

        }
        
        // Set the CSRF field
        data[$(this).attr('data-csrf')] = $('input[name="' + $(this).attr('data-csrf') + '"]').val();

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/frontend', 'POST', data, 'create_new_content');

        // Display loading animation
        $('.page-loading').fadeIn('slow');

    });

    /*
     * Create a new classification option
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.9
     */
    $('#add-new-classification .create-classification').submit(function (e) {
        e.preventDefault();

        // Define data to send
        var data = {
            action: 'create_new_classification_option',
            slug: $(this).find('.enter-category-slug').val(),
            meta_option_classification_slug: $(this).attr('data-classification-slug'),
            single_item: $(this).attr('data-single-item')
        };

        if ($('#add-new-classification .classification-select-parent').attr('data-id')) {
            data['parent'] = $('#add-new-classification .classification-select-parent').attr('data-id');
        }

        // Get all classifications languages
        var languages = $(this).find('.tab-all-classifications > .tab-pane');

        // List all languages
        for (var d = 0; d < languages.length; d++) {

            // Get all text input fields
            var text_inputs = $(languages[d]).find('.classification-input');

            // Prepare language name
            var language = $(languages[d]).attr('id').replace('classification-', '');

            // Set language property
            data[language] = {};

            // Verify if text input fields exists
            if (text_inputs.length > 0) {

                // List all input fields
                for (var e = 0; e < text_inputs.length; e++) {

                    if ($(text_inputs[e]).attr('data-meta')) {

                        data[language][$(text_inputs[e]).attr('data-meta')] = {
                            'meta': $(text_inputs[e]).attr('data-meta'),
                            'value': $(text_inputs[e]).val()
                        };

                    }

                }

            }

        }
        
        // Set the CSRF field
        data[$(this).attr('data-csrf')] = $('input[name="' + $(this).attr('data-csrf') + '"]').val();

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/frontend', 'POST', data, 'create_new_classification_option');

        // Display loading animation
        $('.page-loading').fadeIn('slow');

    });

    /*
     * Create a new content
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.8
     */
    $('#page-url-composer .update-content-url').submit(function (e) {
        e.preventDefault();

        // Define data to send
        var data = {
            action: 'generate_url_slug',
            url_slug: $(this).find('.url-slug-input').val(),
            category_slug: $(this).find('.category-slug').attr('data-slug')
        };

        // Set the CSRF field
        data[$(this).attr('data-csrf')] = $('input[name="' + $(this).attr('data-csrf') + '"]').val();

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/frontend', 'POST', data, 'generate_url_slug');

        // Display loading animation
        $('.page-loading').fadeIn('slow');

    });

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

    // Get all tabs
    var langs = $(document).find('.tab-all-editors > .tab-pane');

    // Verify if there are tabs
    if (langs.length > 0) {

        // List available language tabs
        for (var e = 0; e < langs.length; e++) {

            if ($('#' + $(langs[e]).attr('id') + ' .content-body').val()) {

                // Enable summernote
                $('.' + $(langs[e]).find('.summernote-body').attr('data-dir')).summernote('code', $('#' + $(langs[e]).attr('id') + ' .content-body').val());

            } else {

                // Enable summernote
                $('.' + $(langs[e]).find('.summernote-body').attr('data-dir')).summernote();

            }

            // Get all editors
            var editors = $('#' + $(langs[e]).attr('id') ).find('.summer-area');

            if (editors.length > 0) {

                // List all editors
                for (var d = 0; d < editors.length; d++) {

                    if ( $(editors).eq(d).find('.editor-' + $(editors).eq(d).find('.summernote-editor').attr('data-dir')).val() ) {

                        // Enable summernote
                        $('.' + $(editors).eq(d).find('.summernote-editor').attr('data-dir')).summernote();

                        // Add code
                        $(editors).eq(d).find('.note-editable').html($(editors).eq(d).find('.editor-' + $(editors).eq(d).find('.summernote-editor').attr('data-dir')).val());

                    } else {

                        // Enable summernote
                        $('.' + $(editors).eq(d).find('.summernote-editor').attr('data-dir')).summernote();

                    }

                }

            }

        }

        // Verify if content's ID exists
        if ( $('.form-editor').attr('data-content-id') ) {

            // Prepare data
            var data = {
                action: 'get_content_classifications',
                content_id: $('.form-editor').attr('data-content-id')
            };

            // Set the CSRF field
            data[$('.form-editor').attr('data-csrf')] = $('input[name="' + $('.form-editor').attr('data-csrf') + '"]').val();

            // Make ajax call
            Main.ajax_call(url + 'admin/ajax/frontend', 'POST', data, 'get_content_classifications');

        }

    }

    // Hide loading animation
    $('.page-loading').fadeOut('slow');

    // Load selected pages
    Main.load_selected_pages();

});