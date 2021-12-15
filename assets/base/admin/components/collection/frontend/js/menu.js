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
     * Get pages
     * 
     * @param string drop_class contains the dropdown's class
     * 
     * @since   0.0.7.8
     */    
    Main.load_pages =  function (drop_class) {

        // Prepare data
        var data = {
            action: 'settings_auth_pages_list',
            drop_class: drop_class,
            key: $('.frontend-page .' + drop_class + '-search').val()
        };

		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/frontend', 'POST', data, 'show_pages');
        
    };

    /*
     * Get selected pages
     * 
     * @param array contains the pages id
     * 
     * @since   0.0.7.8
     */    
    Main.selected_pages =  function (page_ids) {

        // Prepare data
        var data = {
            action: 'load_selected_pages',
            page_ids: page_ids
        };

		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/frontend', 'POST', data, 'load_selected_pages');
        
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
     * Display save changes button
     * 
     * @since   0.0.7.8
     */
    $(document).on('keyup', 'body .menu-item-text-input', function () {

        // Show the save button
        $('body .theme-save-changes').slideDown('slow');  
        
    }); 
    
    /*
     * Select a menu
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.8
     */
    $(document).on('click', '.frontend-page .theme-dropdown-items-list a', function (e) {
        e.preventDefault();

        // Get menu's slug
        var menu_slug = $(this).attr('data-slug'); 
        
        // Get menu's name
        var menu_name = $(this).text();

        // Add menu's name and menu's slug
        $(this).closest('.dropdown').find('.btn-secondary > span').text(menu_name);
        $(this).closest('.dropdown').find('.btn-secondary').attr('data-slug', menu_slug);

        // Display new menu item button
        $('.frontend-page .frontend-new-menu-item').fadeIn('slow');

        // Prepare data to send
        var data = {
            action: 'frontend_get_menu_items',
            menu: menu_slug
        };
        
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/frontend', 'POST', data, 'frontend_display_menu_items_response');
        
    }); 
    
    /*
     * New menu item
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.8
     */
    $(document).on('click', '.frontend-page .frontend-new-menu-item', function (e) {
        e.preventDefault();

        var data = {
            action: 'new_menu_item',
            menu: $('.frontend-page .menu-dropdown-btn').attr('data-slug')
        };
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/frontend', 'POST', data, 'new_menu_item');
        
    });

    /*
     * Save menu's items
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.8
     */ 
    $( document ).on( 'click', 'body .theme-save-changes-btn', function (e) {
        e.preventDefault();
        
        // Hide the save button
        $('body .theme-save-changes').slideUp('slow');  
        
        // Get all items
        var items = $('.frontend-page .show-menu-items .menu-item').length;
        
        var all_items = [];
        
        for ( var i = 0; i < items; i++ ) {

            all_items[i] = [];
                
            for ( var o = 0; o < $('.frontend-page .show-menu-items .menu-item').eq(i).find('.tab-pane').length; o++ ) {

                all_items[i].push({
                    [$('.frontend-page .show-menu-items .menu-item').eq(i).find('.tab-pane').eq(o).attr('data-lang')]: {
                        name: $('.frontend-page .show-menu-items .menu-item').eq(i).find('.tab-pane').eq(o).find('.menu-item-text-input').val(),
                        selected_page: $('.frontend-page .show-menu-items .menu-item').eq(i).find('.tab-pane').eq(o).find('.theme-menu-select-pages-for-item').attr('data-id')?$('.frontend-page .show-menu-items .menu-item').eq(i).find('.tab-pane').eq(o).find('.theme-menu-select-pages-for-item').attr('data-id'):' ',
                        permalink: $('.frontend-page .show-menu-items .menu-item').eq(i).find('.tab-pane').eq(o).find('.menu-item-permalink').val(),
                        description: $('.frontend-page .show-menu-items .menu-item').eq(i).find('.tab-pane').eq(o).find('.menu-item-description').val(),
                        class: $('.frontend-page .show-menu-items .menu-item').eq(i).find('.tab-pane').eq(o).find('.menu-item-class').val(),
                        parent: $('.frontend-page .show-menu-items .menu-item-box').eq(i).attr('data-parent')
                    }
                });

            }
            
        }

        var data = {
            action: 'frontend_save_menu_items',
            menu: $('.frontend-page .frontend-menu-dropdown-btn').attr('data-slug'),
            all_items: Object.entries(all_items)
        };
        
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/frontend', 'POST', data, 'frontend_save_menu_items_response', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
    });

    /*
     * Delete menu's items
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.8
     */ 
    $( document ).on( 'click', '.frontend-page .frontend-delete-menu-item', function (e) {
        e.preventDefault();

        // Item Level
        var item_level = 0;

        // Get parent if exists
        if ( $(this).closest('.menu-item-box').attr('data-parent') ) {
            item_level = parseInt($(this).closest('.menu-item-box').attr('data-parent'));
        }

        // Start count
        var start = 0;

        // Items to remove
        var remove_items = [];

        // List all menu items
        for ( var i = 0; i < $('.show-menu-items .menu-item-box').length; i++) {

            // Current level
            var current_level = 0;

            // If current has a parent
            if ( $('.show-menu-items .menu-item-box').eq(i).attr('data-parent') ) {
                current_level = parseInt($('.show-menu-items .menu-item-box').eq(i).attr('data-parent'));
            }

            // Verify if data ID exists
            if ( $(this).closest('.menu-item-box').attr('data-id') ) {

                // Verify if listed item has the current clicked id
                if ( $(this).closest('.menu-item-box').attr('data-id') === $('.show-menu-items .menu-item-box').eq(i).attr('data-id') ) {
                    start = 1;
                } else if ( ( item_level >= current_level ) && ( start > 0 ) ) {
                    start = 0;
                    break;
                }

            } else {

                // Start is 0
                start = 0;

                // Remove the item
                $(this).closest('.menu-item-box').remove();

            }

            // Verify if start is positive
            if ( start > 0 ) {
                remove_items.push(i);
            }

        }

        if ( remove_items ) {

            for ( var l = remove_items.length; l >= 0; l-- ) {

                // Remove item
                $('.show-menu-items .menu-item-box').eq(remove_items[l]).remove();

            }

        }

        // Show the save button
        $('body .theme-save-changes').slideDown('slow');  
        
    });

    /*
     * Get pages
     * 
     * @since   0.0.7.8
     */
    $(document).on('click', '.frontend-page .theme-menu-select-pages-for-item', function (e) {
        e.preventDefault();

        // Load pages
        Main.load_pages($(this).closest('.dropdown').attr('data-option'));
        
    });

    /*
     * Select a page
     * 
     * @since   0.0.7.8
     */
    $(document).on('click', '.frontend-page .theme-item-dropdown-pages-list a', function (e) {
        e.preventDefault();

        // Get item's id
        var item_id = $(this).attr('data-id'); 
        
        // Get item's title
        var item_title = $(this).text();

        // Add item's title and item's id
        $(this).closest('.dropdown').find('.theme-menu-select-pages-for-item > span').text(item_title);
        $(this).closest('.dropdown').find('.theme-menu-select-pages-for-item').attr('data-id', item_id);

        // Show the save button
        $('body .theme-save-changes').slideDown('slow');  
        
    });
   
    /*******************************
    RESPONSES
    ********************************/ 
   
    /*
     * Display new menu item response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.8
     */
    Main.methods.new_menu_item = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Set languages
            Main.available_languages = data.languages;

            // Set item words
            Main.menu_item_words = data.words;

            // Verify if menu has items
            if ( data.all_items.length > 0 ) {

                var items = '<option value="" disabled selected>' + data.words.select_menu_item + '</option>';

                for ( var i = 0; i < data.all_items.length; i++ ) {

                    // Verify if item has a parent
                    if ($('.show-menu-items .menu-item-box[data-id="' + data.all_items[i].classification_id + '"]').attr('data-parent')) {

                        // Verify the level parent is great than 10
                        if ( parseInt($('.show-menu-items .menu-item-box[data-id="' + data.all_items[i].classification_id + '"]').attr('data-parent')) > 9 ) {
                            continue;
                        }

                    }

                    items += '<option value="' + data.all_items[i].classification_id + '">'
                                + data.all_items[i].meta_value
                            + '</option>';

                }

            }

            // Display parents
            $('#create-menu-item #frontend-select-menu-item-parent-list').html(items);

            // Show modal
            $('#create-menu-item').modal('show');
            
        } else {

            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);
            
        }

    };

    /*
     * Display menu saving response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.8
     */
    Main.methods.frontend_save_menu_items_response = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);

            // Display new menu item button
            $('.frontend-page .frontend-new-menu-item').fadeIn('slow');

            // Prepare data to send
            var data = {
                action: 'frontend_get_menu_items',
                menu: $('.frontend-page .frontend-menu-dropdown-btn').attr('data-slug')
            };

            // Set CSRF
            data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');

            // Make ajax call
            Main.ajax_call(url + 'admin/ajax/frontend', 'POST', data, 'frontend_display_menu_items_response');
            
        } else {

            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);
            
        }

    };

    /*
     * Display menu items response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.8
     */
    Main.methods.frontend_display_menu_items_response = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Selected pages array
            var selected_pages = [];

            // Items array
            var items = [];

            // Genealogy array
            var genealogy = [];

            // Item count
            var item = 0;

            // Meta var
            var meta = '';

            // Language var
            var language = '';

            // All items var
            var all_items = '';

            // List all available items
            for (var l = 0; l < data.items.length; l++) {

                if (l < 1) {

                    language = data.items[l].language;
                    meta = data.items[l].meta_name;
                    items[item] = [];

                } else if ((language === data.items[l].language) && (meta === data.items[l].meta_name)) {

                    item++;
                    items[item] = [];

                }

                items[item].push({
                    [data.items[l].language]: {
                        'classification_id': data.items[l].classification_id,
                        [data.items[l].meta_name]: data.items[l].meta_value,
                        [data.items[l].meta_name + '_extra']: data.items[l].meta_extra
                    }
                });

            }

            // List all available items
            for (var l = 0; l < items.length; l++) {

                // Languages default
                var languages_list = '';

                // Tabs default
                var tabs = '';

                // Classification ID
                var classification_id = 0;

                for (var s = 0; s < data.languages.length; s++) {

                    // Name
                    var name = '';

                    var select_page = '';

                    // Permalink
                    var permalink = '';

                    // Description
                    var description = '';

                    // Class
                    var iclass = '';

                    for (var d = 0; d < items[l].length; d++) {

                        if (typeof items[l][d][data.languages[s]] !== 'undefined') {

                            if (typeof items[l][d][data.languages[s]]['classification_id'] !== 'undefined') {

                                classification_id = items[l][d][data.languages[s]]['classification_id'];

                            }                            

                            if (typeof items[l][d][data.languages[s]]['name'] !== 'undefined') {

                                name = items[l][d][data.languages[s]]['name'];

                            }

                            if (typeof items[l][d][data.languages[s]]['selected_page_extra'] !== 'undefined') {

                                select_page = ' data-id="' + items[l][d][data.languages[s]]['selected_page_extra'] + '"';

                                if (!selected_pages.includes(items[l][d][data.languages[s]]['selected_page_extra'])) {
                                    selected_pages.push(items[l][d][data.languages[s]]['selected_page_extra']);
                                }

                            }

                            if (typeof items[l][d][data.languages[s]]['permalink'] !== 'undefined') {

                                permalink = items[l][d][data.languages[s]]['permalink'];

                            }

                            if (typeof items[l][d][data.languages[s]]['description'] !== 'undefined') {

                                description = items[l][d][data.languages[s]]['description'];

                            }

                            if (typeof items[l][d][data.languages[s]]['class'] !== 'undefined') {

                                iclass = items[l][d][data.languages[s]]['class'];

                            }

                        }

                    }

                    var active = '', tab_active = '';

                    if (s < 1) {

                        active = ' active',
                        tab_active = ' show active';

                    }

                    // Get random number
                    var random_number = (new Date).getTime();

                    // Append language
                    languages_list += '<li class="nav-item">'
                        + '<a href="#' + data.languages[s] + '-' + l + '-' + random_number + '" class="nav-link' + active + '" data-bs-toggle="tab" data-bs-target="#' + data.languages[s] + '-' + l + '-' + random_number + '">'
                            + data.languages[s].charAt(0).toUpperCase() + data.languages[s].slice(1)
                        + '</a>'
                    + '</li>';

                    tabs += '<div id="' + data.languages[s] + '-' + l + '-' + random_number + '" class="tab-pane fade' + tab_active + '" data-lang="' + data.languages[s] + '">'
                        + '<div class="form-group">'
                            + '<div class="row">'
                                + '<div class="col-lg-12">'
                                    + '<label class="theme-label" for="menu-item-text-input">'
                                        + data.words.item_name
                                    + '</label>'
                                + '</div>'
                            + '</div>'
                            + '<div class="row">'
                                + '<div class="col-lg-12">'
                                    + '<input type="text" placeholder="' + data.words.enter_item_name + '" value="' + name + '" class="form-control menu-item-text-input.theme-text-input-1" id="menu-item-text-input" data-slug="menu_item_name">'
                                    + '<small class="form-text text-muted theme-small">'
                                        + data.words.enter_item_name_description
                                    + '</small>'
                                + '</div>'
                            + '</div>'
                        + '</div>'
                        + '<div class="form-group">'
                            + '<div class="row">'
                                + '<div class="col-lg-12">'
                                    + '<label class="theme-label" for="menu-item-permalink">'
                                        + data.words.item_permalink
                                    + '</label>'
                                + '</div>'
                            + '</div>'
                            + '<div class="row">'
                                + '<div class="col-lg-6">'
                                    + '<div class="dropdown m-0 theme-dropdown-1" data-option="theme-item-pages-list-' + random_number + '">'
                                        + '<button type="button" class="btn btn-secondary d-flex justify-content-between align-items-start theme-menu-select-pages-for-item" aria-expanded="false" data-bs-toggle="dropdown"' + select_page + '>'
                                            + '<span>'
                                                + data.words.select_page
                                            + '</span>'
                                            + words.icon_arrow_down
                                        + '</button>'
                                        + '<div class="dropdown-menu" aria-labelledby="dropdown-items">'
                                            + '<input type="text" placeholder="' + data.words.search_page + '" class="search-dropdown-items theme-item-pages-list-' + random_number + '-search">'
                                            + '<div>'
                                                + '<ul class="list-group theme-item-dropdown-pages-list theme-item-pages-list-' + random_number + '-list">'                                             
                                                + '</ul>'
                                            + '</div>'
                                        + '</div>'
                                    + '</div>'
                                + '</div>'
                                + '<div class="col-lg-6">'
                                    + '<input type="text" placeholder="' + data.words.item_enter_url + '" value="' + permalink + '" class="form-control menu-item-text-input menu-item-permalink.theme-text-input-1" id="menu-item-permalink">'
                                + '</div>'
                            + '</div>'
                            + '<div class="row">'
                                + '<div class="col-lg-12">'
                                    + '<small class="form-text text-muted theme-small">'
                                        + '<a href="#show-advanced-options-' + data.languages[s] + l + '-' + '-' + random_number + '" role="button" aria-expanded="false" aria-controls="show-advanced-options-' + data.languages[s] + l + '-' + '-' + random_number + '" data-bs-toggle="collapse">'
                                            + data.words.show_advanced_options
                                        + '</a>'
                                    + '</small>'
                                    + '<div class="row">'
                                        + '<div class="col-lg-12">'
                                            + '<div class="collapse multi-collapse" id="show-advanced-options-' + data.languages[s] + l + '-' + '-' + random_number + '">'
                                                + '<div class="form-group">'
                                                    + '<div class="row">'
                                                        + '<div class="col-lg-12">'
                                                            + '<label class="theme-label" for="menu-item-description">'
                                                                + data.words.item_description
                                                            + '</label>'
                                                        + '</div>'
                                                    + '</div>'
                                                    + '<div class="row">'
                                                        + '<div class="col-lg-12">'
                                                            + '<input type="text" placeholder="' + data.words.enter_item_description + '" value="' + description + '" class="form-control menu-item-description menu-item-text-input.theme-text-input-1" id="menu-item-description">'
                                                            + '<small class="form-text text-muted theme-small">'
                                                                + data.words.item_description_info
                                                            + '</small>'
                                                        + '</div>'
                                                    + '</div>'
                                                    + '<div class="form-group">'
                                                        + '<div class="row">'
                                                            + '<div class="col-lg-12">'
                                                                + '<label class="theme-label" for="menu-item-class">'
                                                                    + data.words.item_class
                                                                + '</label>'
                                                            + '</div>'
                                                        + '</div>'
                                                        + '<div class="row">'
                                                            + '<div class="col-lg-12">'
                                                                + '<input type="text" placeholder="' + data.words.enter_item_class + '" value="' + iclass + '" class="form-control menu-item-class menu-item-text-input.theme-text-input-1" id="menu-item-class">'
                                                                + '<small class="form-text text-muted theme-small">'
                                                                    + data.words.item_class_description
                                                                + '</small>'
                                                            + '</div>'
                                                        + '</div>'
                                                    + '</div>'
                                                + '</div>'
                                            + '</div>'
                                        + '</div>'
                                    + '</div>'
                                + '</div>'
                            + '</div>'
                        + '</div>'
                    + '</div>';

                }

                var parent = '';

                // List available classifications
                for ( var pa = 0; pa < data.classifications.length; pa++ ) {

                    // If current listed parent is equal with item's parent
                    if ( data.classifications[pa].classification_id === classification_id ) {

                        // Verify if the classification has positive array
                        if ( parseInt(data.classifications[pa].classification_parent) > 0 ) {

                            // Get genealogy
                            var get_genealogy = genealogy[data.classifications[pa].classification_parent];

                            // Increase genealogy
                            get_genealogy++;

                            // Set new value
                            genealogy[classification_id] = get_genealogy;

                            // Set default margin left
                            var margin_left = (get_genealogy * 5) + '%';

                            // Set parent value
                            parent = ' data-parent="' + get_genealogy + '" style="margin-left: ' + margin_left + '"';

                        } else {

                            // Set genealogy
                            genealogy[classification_id] = 0;
                            

                        }

                    }

                }

                // Set the item's data
                all_items += '<div class="row mt-3 menu-item-box"' + parent + ' data-id="' + classification_id + '">'
                    + '<div class="col-lg-12">'
                        + '<div class="theme-box-1">'
                            + '<div class="card theme-card-box menu-item">'
                                + '<div class="card-header border-0">'
                                    + '<ul class="nav nav-tabs nav-justified">'
                                        + languages_list
                                    + '</ul>'
                                + '</div>'
                                + '<div class="card-body">'
                                    + '<div class="tab-content tab-all-editors">'
                                        + tabs
                                    + '</div>'
                                + '</div>'
                                + '<div class="card-footer">'
                                    + '<div class="row">'
                                        + '<div class="col-12">'
                                            + '<a href="#" class="btn-option theme-button-1 w-100 d-block text-center frontend-delete-menu-item">'
                                                + words.icon_delete
                                                + words.delete
                                            + '</a>'
                                        + '</div>'
                                    + '</div>'
                                + '</div>'                                
                            + '</div>'
                        + '</div>'
                    + '</div>'
                + '</div>';

            }

            // Load selected pages
            Main.selected_pages(selected_pages);

            // Add menu's item to list
            $('.frontend-page .show-menu-items').html(all_items);
            
        } else {

            // Empty menu list
            $('.frontend-page .show-menu-items').empty();
            
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
    Main.methods.show_pages = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Pages list
            var pages = '';

            // List all pages
            for ( var p = 0; p < data.pages.length; p++ ) {

                pages += '<li class="list-group-item">'
                            + '<a href="#" data-id="' + data.pages[p].content_id + '">'
                                + data.pages[p].content_title
                            + '</a>'
                        + '</li>';

            }

            // Display all pages
            $('.frontend-page .' + data.drop_class + '-list').html(pages);
            
        } else {

            // Prepare the no pages message
            let message = '<li class="list-group-item">'
                + '<p>'
                    + data.message
                + '</p>'
            + '</li>';

            // Display no contents found
            $('.frontend-page .' + data.drop_class + '-list').html(message);
            
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
    Main.methods.load_selected_pages = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {

            for ( var c = 0; c < data.contents.length; c++ ) {

                // Verify if selected page exists
                if ( $('.frontend-page .theme-menu-select-pages-for-item[data-id="' + data.contents[c].content_id + '"]').length > 0 ) {

                    // Add page title
                    $('.frontend-page .theme-menu-select-pages-for-item[data-id="' + data.contents[c].content_id + '"] > span').text(data.contents[c].title);

                }

            }
            
        } else {

            // Remove all page's ids
            $('.frontend-page .theme-menu-select-pages-for-item').removeAttr('data-id');
            
        }

    };
    
    /*******************************
    FORMS
    ********************************/

    /*
     * Create a new menu item
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.8
     */
    $('body .create-menu-item').submit(function (e) {
        e.preventDefault();

        // Languages default
        var languages = '';

        // Tabs default
        var tabs = '';

        // List all available languages
        for ( var l = 0; l < Main.available_languages.length; l++ ) {

            var active = '', tab_active = '';

            if ( l < 1 ) {

                active = ' active',
                tab_active = ' show active';

            }

            // Get random number
            var random_number = (new Date).getTime();

            // Append language
            languages += '<li class="nav-item">'
                            + '<a href="#' + Main.available_languages[l] + '-' + random_number + '" class="nav-link' + active + '" data-bs-toggle="tab" data-bs-target="#' + Main.available_languages[l] + '-' + random_number + '">'
                                + Main.available_languages[l].charAt(0).toUpperCase() + Main.available_languages[l].slice(1)
                            + '</a>'
                        + '</li>';

            tabs += '<div id="' + Main.available_languages[l] + '-' + random_number + '" class="tab-pane fade' + tab_active + '" data-lang="' + Main.available_languages[l] + '">'
                        + '<div class="form-group">'
                            + '<div class="row">'
                                + '<div class="col-lg-12">'
                                    + '<label class="theme-label" for="menu-item-text-input">'
                                        + Main.menu_item_words.item_name
                                    + '</label>'
                                + '</div>'
                            + '</div>'
                            + '<div class="row">'
                                + '<div class="col-lg-12">'
                                + '<input type="text" placeholder="' + Main.menu_item_words.enter_item_name + '" class="form-control menu-item-text-input.theme-text-input-1" id="menu-item-text-input" data-slug="menu_item_name">'
                                + '<small class="form-text text-muted theme-small">'
                                    + Main.menu_item_words.enter_item_name_description
                                + '</small>'
                            + '</div>'
                        + '</div>'
                    + '</div>'
                    + '<div class="form-group">'
                        + '<div class="row">'
                            + '<div class="col-lg-12">'
                                + '<label class="theme-label" for="menu-item-permalink">'
                                    + Main.menu_item_words.item_permalink
                                + '</label>'
                            + '</div>'
                        + '</div>'
                        + '<div class="row">'
                            + '<div class="col-lg-6">'
                                + '<div class="dropdown theme-dropdown-1 m-0" data-option="theme-item-pages-list-' + random_number + '">'
                                    + '<button type="button" class="btn btn-secondary d-flex justify-content-between align-items-start theme-menu-select-pages-for-item" aria-expanded="false" data-bs-toggle="dropdown">'
                                        + '<span>'
                                            + Main.menu_item_words.select_page
                                        + '</span>'
                                        + words.icon_arrow_down
                                    + '</button>'
                                    + '<div class="dropdown-menu" aria-labelledby="dropdown-items">'
                                        + '<input type="text" placeholder="' + Main.menu_item_words.search_page + '" class="search-dropdown-items theme-item-pages-list-' + random_number + '-search">'
                                        + '<div>'
                                            + '<ul class="list-group theme-item-dropdown-pages-list theme-item-pages-list-' + random_number + '-list">'                                             
                                            + '</ul>'
                                        + '</div>'
                                    + '</div>'
                                + '</div>'
                            + '</div>'
                        + '<div class="col-lg-6">'
                            + '<input type="text" placeholder="' + Main.menu_item_words.item_enter_url + '" class="form-control menu-item-text-input menu-item-permalink.theme-text-input-1" id="menu-item-permalink">'
                        + '</div>'
                    + '</div>'
                    + '<div class="row">'
                        + '<div class="col-lg-12">'
                            + '<small class="form-text text-muted theme-small">'
                                + '<a href="#show-advanced-options-' + Main.available_languages[l] + '-' + random_number + '" role="button" aria-expanded="false" aria-controls="show-advanced-options-' + Main.available_languages[l] + '-' + random_number + '" data-bs-toggle="collapse">'
                                    + Main.menu_item_words.show_advanced_options
                                + '</a>'
                            + '</small>'
                            + '<div class="row">'
                                + '<div class="col-lg-12">'
                                    + '<div class="collapse multi-collapse" id="show-advanced-options-' + Main.available_languages[l] + '-' + random_number + '">'
                                        + '<div class="form-group">'
                                            + '<div class="row">'
                                                + '<div class="col-lg-12">'
                                                    + '<label class="theme-label" for="menu-item-description">'
                                                        + Main.menu_item_words.item_description
                                                    + '</label>'
                                                + '</div>'
                                            + '</div>'
                                            + '<div class="row">'
                                                + '<div class="col-lg-12">'
                                                    + '<input type="text" placeholder="' + Main.menu_item_words.enter_item_description + '" class="form-control menu-item-description menu-item-text-input.theme-text-input-1" id="menu-item-description">'
                                                    + '<small class="form-text text-muted theme-small">'
                                                        + Main.menu_item_words.item_description_info
                                                    + '</small>'
                                                + '</div>'
                                            + '</div>'
                                        + '</div>'
                                        + '<div class="form-group">'
                                            + '<div class="row">'
                                                + '<div class="col-lg-12">'
                                                    + '<label class="theme-label" for="menu-item-class">'
                                                    + Main.menu_item_words.item_class
                                                + '</label>'
                                            + '</div>'
                                        + '</div>'
                                        + '<div class="row">'
                                            + '<div class="col-lg-12">'
                                                + '<input type="text" placeholder="' + Main.menu_item_words.enter_item_class + '" class="form-control menu-item-class menu-item-text-input.theme-text-input-1" id="menu-item-class">'
                                                + '<small class="form-text text-muted theme-small">'
                                                    + Main.menu_item_words.item_class_description
                                                + '</small>'
                                            + '</div>'
                                        + '</div>'
                                    + '</div>'
                                + '</div>'
                            + '</div>'
                        + '</div>'
                    + '</div>'
                + '</div>'
            + '</div>'
        + '</div>';

        }

        var parent = '';
        var parent_id = 0;

        if ( $('#create-menu-item #frontend-select-menu-item-parent-list').val() ) {

            // Last parent value
            var last_parent_value = 1;

            // Verify if parent has a parent too
            if ( $('.show-menu-items .menu-item-box[data-id="' + $('#create-menu-item #frontend-select-menu-item-parent-list').val() + '"]').attr('data-parent') ) {

                // Set parent value
                var last_parent_value = $('.show-menu-items .menu-item-box[data-id="' + $('#create-menu-item #frontend-select-menu-item-parent-list').val() + '"]').attr('data-parent');

                // Increase last parent value
                last_parent_value++;               
                
            }

            // Set default margin left
            var margin_left = (last_parent_value * 5) + '%';

            parent = ' data-id="' + $('#create-menu-item #frontend-select-menu-item-parent-list').val() + '" data-parent="' + last_parent_value + '" style="margin-left: ' + margin_left + '"';
            parent_id = $('#create-menu-item #frontend-select-menu-item-parent-list').val();

        }

        // Set the item's data
        var item = '<div class="row mt-3 menu-item-box"' + parent + '>'
                    + '<div class="col-lg-12">'
                        + '<div class="theme-box-1">'
                            + '<div class="card theme-card-box menu-item">'
                                + '<div class="card-header border-0">'
                                    + '<ul class="nav nav-tabs nav-justified">'
                                        + languages
                                    + '</ul>'
                                + '</div>'
                                + '<div class="card-body">'
                                    + '<div class="tab-content tab-all-editors">'
                                        + tabs
                                    + '</div>'
                                + '</div>'
                                + '<div class="card-footer">'
                                    + '<div class="row">'
                                        + '<div class="col-12">'
                                            + '<a href="#" class="btn-option theme-button-1 w-100 d-block text-center frontend-delete-menu-item">'
                                                + words.icon_delete
                                                + words.delete
                                            + '</a>'
                                        + '</div>'
                                    + '</div>'
                                + '</div>'
                            + '</div>'
                        + '</div>'
                    + '</div>'    
                + '</div>'
            + '</div>';

        // Verify if parent is selected
        if ( parent_id ) {

            // Item Level
            var item_level = 0;

            // Get parent if exists
            if ($(this).closest('.menu-item-box').attr('data-parent')) {
                item_level = parseInt($(this).closest('.menu-item-box').attr('data-parent'));
            }
            
            // Start count
            var start = 0;

            // End response
            var end = 0;

            // List all menu items
            for (var i = 0; i < $('.show-menu-items .menu-item-box').length; i++) {

                // Current level
                var current_level = 0;

                // If current has a parent
                if ($('.show-menu-items .menu-item-box').eq(i).attr('data-parent')) {
                    current_level = parseInt($('.show-menu-items .menu-item-box').eq(i).attr('data-parent'));
                }

                // Verify if listed item has the id as our parent
                if ($('.show-menu-items .menu-item-box').eq(i).attr('data-id') === parent_id) {
                    start = 1;
                } else if ((item_level >= current_level) && (start > 0)) {
                    start = 0;
                    break;
                } 

                // Set current level as end
                end = i;

            }
            
            // Add menu's item to list
            $(item).insertAfter($('.show-menu-items .menu-item-box').eq(end));
            
        } else {

            // Add menu's item to list
            $('.frontend-page .show-menu-items').append(item);

        }

        // Hide modal
        $("#create-menu-item").modal('hide');

        // Show the save button
        $('body .theme-save-changes').slideDown('slow');

    });
 
});