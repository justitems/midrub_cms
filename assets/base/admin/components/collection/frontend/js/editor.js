/*
 * Editor javascript file
*/

jQuery(document).ready(function ($) {
    'use strict';

    /*
     * Get the website's url
     */
    var url = $('meta[name=url]').attr('content');

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
    Main.load_selected_pages = function () {

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
            var items = $('#classification-popup-manager .classifications-list').find('li > div > div > a[data-bs-toggle="collapse"]');

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
    * Load default content
    *
    * @since   0.0.8.5
    */
    $(function () {

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

        // Load selected pages
        Main.load_selected_pages(); 

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
        $(this).closest('.dropdown').find('.btn-secondary > span').text(item_title);
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

                $(this).closest('.card').find('.list-items-ul').append(item);

                $(this).closest('.card').find('.list-items-ul').find('.summernote-editor').summernote();

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
        $(this).closest('.form-group').find('.classification-select-parent').attr('data-id', classification_id);

        // Set parent text
        $(this).closest('.form-group').find('.classification-select-parent > span').text(classification_text);

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

        // Remove progress bar
        Main.remove_progress_bar();

        // Verify if the success response exists
        if (status === 'success') {

            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);

            // Verify if the post was created
            if ( $('.editor-page .form-editor').attr('data-content-id') < 1 ) {

                // Set content's id
                $('.editor-page .form-editor').attr('data-content-id', data.content_id);

            }

        } else {

            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);

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

        // Remove progress bar
        Main.remove_progress_bar();

        // Verify if the success response exists
        if (status === 'success') {

            // Add slug
            $('#page-url-composer .url-slug').text(data.slug);
            $('#page-url-composer .url-slug').attr('data-slug', data.slug);

            // Empty input
            $('#page-url-composer .url-slug-input').val('');

        } else {

            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);

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
                        + data.pages[p].content_title
                    + '</a>'
                + '</li>';

            }

            // Display all pages
            $('.editor-page .' + data.drop_class + '_list').html(pages);

        } else {

            // Prepare the message
            let message = '<li class="list-group-item">'
                + '<p>'
                    + data.message
                + '</p>'
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
                    $('.editor-page .meta-dropdown-btn[data-id="' + data.contents[c].content_id + '"] > span').text(data.contents[c].title);

                }

            }

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
            Main.show_alert('error', data.message, 1500, 2000);

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

        // Remove progress bar
        Main.remove_progress_bar();

        // Verify if the success response exists
        if (status === 'success') {

            // Reset the form
            $('#add-new-classification .create-classification')[0].reset();

            // Hide form
            $('#classification-popup-manager #add-new-classification').collapse('hide');

            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);

            // Load classifications
            Main.load_classifications();

        } else {

            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);

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
            $('#classification-popup-manager .classifications-list').find('li:has(ul li) > div > div > a[data-bs-toggle="collapse"]').attr('aria-expanded', 'false');

            // Get all selected
            var all_selected = $('.editor-page .classification-selected-list-' + $('#classification-popup-manager .create-classification').attr('data-classification-slug')).find('input[type="checkbox"]');

            if (all_selected.length > 0) {

                // List all checkboxes
                for (var ch = 0; ch < all_selected.length; ch++) {

                    if ($(all_selected[ch]).is(':checked')) {

                        $('#classification-popup-manager .classifications-list #frontend-contents-single-' + $(all_selected[ch]).attr('data-id')).prop('checked', true);

                    }

                }

            }

        } else {

            // Prepare the message
            let message = '<li class="list-group-item no-results-found">'
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
            Main.show_alert('success', data.message, 1500, 2000);

            // Load classifications
            Main.load_classifications();

        } else {

            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);

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
        $('#add-new-classification .classification-select-parent > span').text(data.select_a_parent);
        $('#add-new-classification .classification-select-parent').removeAttr('data-id');

        // Verify if the success response exists
        if (status === 'success') {

            // Classifications list
            var classifications = '';

            // List all classifications
            for (var c = 0; c < data.classifications.length; c++) {

                classifications += '<li class="list-group-item">'
                    + '<a href="#" data-id="' + data.classifications[c].classification_id + '">'
                        + data.classifications[c].classification_name + ' (' + data.classifications[c].classification_id + ')'
                    + '</a>'
                + '</li>';

            }

            // Display all classifications
            $('#add-new-classification .classification-parents-list-ul').html(classifications);

        } else {

            // Prepare the message
            let message = '<li class="list-group-item">'
                + '<p>'
                    + data.message
                + '</p>'
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
            $('.editor-page .classification-selected-list-' + data.classification_slug).find('li:has(ul li) > div > div > a[data-bs-toggle="collapse"]').attr('aria-expanded', 'false');

        } else {

            // Prepare the message
            let message = '<li class="list-group-item no-results-found">'
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
                    $('.editor-page .classification-selected-list-' + data.response[s].classification_slug).find('li:has(ul li) > div > div > a[data-bs-toggle="collapse"]').attr('aria-expanded', 'false');

                } else {

                    // Prepare the message
                    let message = '<li class="list-group-item">'
                        + '<p>'
                            + data.response[s].message
                        + '</p>'
                    + '</li>';

                    // Display no contents found
                    $('.editor-page .classification-selected-list-' + data.response[s].classification_slug).html(message);

                }

            }

        }

    };

    /*
     * Display the upload media status
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.5
     */
    Main.methods.frontend_upload_content_media = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);   

            // Add image url
            $(Main.multimedia_btn).closest('.input-group').find('.contents-meta-text-input').val(data.file_url);
            
        } else {
            
            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);
            
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
        Main.ajax_call(url + 'admin/ajax/frontend', 'POST', data, 'create_new_content', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();

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
        Main.ajax_call(url + 'admin/ajax/frontend', 'POST', data, 'create_new_classification_option', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();

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
        Main.ajax_call(url + 'admin/ajax/frontend', 'POST', data, 'generate_url_slug', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();

    });

});