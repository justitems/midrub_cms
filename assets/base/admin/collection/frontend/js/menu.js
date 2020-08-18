/*
 * Themes javascript file
*/

jQuery(document).ready( function ($) {
    'use strict';
    
    // Get home page url
    var url = $('.navbar-brand').attr('href');
    
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
        data[$('.save-settings').attr('data-csrf')] = $('input[name="' + $('.save-settings').attr('data-csrf') + '"]').val();
        
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
        data[$('.save-settings').attr('data-csrf')] = $('input[name="' + $('.save-settings').attr('data-csrf') + '"]').val();
        
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

        // Display save button
        $('.theme-menu-save-changes').fadeIn('slow');
        
    }); 
    
    /*
     * Select a menu
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.8
     */
    $(document).on('click', '.frontend-page .menu-dropdown-list-ul a', function (e) {
        e.preventDefault();

        // Get menu's slug
        var menu_slug = $(this).attr('data-slug'); 
        
        // Get menu's name
        var menu_name = $(this).text();

        // Add menu's name and menu's slug
        $(this).closest('.dropdown').find('.menu-dropdown-btn').text(menu_name);
        $(this).closest('.dropdown').find('.menu-dropdown-btn').attr('data-slug', menu_slug);

        // Display new menu item button
        $('.frontend-page .new-menu-item').fadeIn('slow');

        // Prepare data to send
        var data = {
            action: 'get_menu_items',
            menu_slug: menu_slug
        };
        
        data[$('.save-settings').attr('data-csrf')] = $('input[name="' + $('.save-settings').attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/frontend', 'POST', data, 'get_menu_items');
        
    }); 
    
    /*
     * New menu item
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.8
     */
    $(document).on('click', '.frontend-page .new-menu-item', function (e) {
        e.preventDefault();

        var data = {
            action: 'new_menu_item',
            menu_slug: $('.frontend-page .menu-dropdown-btn').attr('data-slug')
        };
        
        data[$('.save-settings').attr('data-csrf')] = $('input[name="' + $('.save-settings').attr('data-csrf') + '"]').val();
        
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
    $( document ).on( 'click', '.theme-menu-save-changes', function (e) {
        e.preventDefault();
        
        // Hide save button
        $('.theme-menu-save-changes').fadeOut('slow');
        
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
            action: 'save_menu_items',
            menu_slug: $('.frontend-page .menu-dropdown-btn').attr('data-slug'),
            all_items: Object.entries(all_items)
        };
        
        data[$('.save-settings').attr('data-csrf')] = $('input[name="' + $('.save-settings').attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/frontend', 'POST', data, 'save_menu_items');

        // Show loading animation
        $('.page-loading').fadeIn('slow');
        
    });

    /*
     * Delete menu's items
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.8
     */ 
    $( document ).on( 'click', '.frontend-page .delete-menu-item', function (e) {
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

            // Verify if listed item has the current clicked id
            if ( $(this).closest('.menu-item-box').attr('data-id') === $('.show-menu-items .menu-item-box').eq(i).attr('data-id') ) {
                start = 1;
            } else if ( ( item_level >= current_level ) && ( start > 0 ) ) {
                start = 0;
                break;
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

        // Display save button
        $('.theme-menu-save-changes').fadeIn('slow');
        
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
        $(this).closest('.dropdown').find('.theme-menu-select-pages-for-item').text(item_title);
        $(this).closest('.dropdown').find('.theme-menu-select-pages-for-item').attr('data-id', item_id);

        // Display save button
        $('.theme-menu-save-changes').fadeIn('slow');
        
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
            Main.popup_fon('sube', data.message, 1500, 2000);
            
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
    Main.methods.save_menu_items = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);

            // Display new menu item button
            $('.frontend-page .new-menu-item').fadeIn('slow');

            // Prepare data to send
            var data = {
                action: 'get_menu_items',
                menu_slug: $('.frontend-page .menu-dropdown-btn').attr('data-slug')
            };

            data[$('.save-settings').attr('data-csrf')] = $('input[name="' + $('.save-settings').attr('data-csrf') + '"]').val();

            // Make ajax call
            Main.ajax_call(url + 'admin/ajax/frontend', 'POST', data, 'get_menu_items');
            
        } else {

            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
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
    Main.methods.get_menu_items = function ( status, data ) {

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

                        active = ' class="active"',
                            tab_active = ' in active';

                    }

                    // Get random number
                    var random_number = (new Date).getTime();

                    languages_list += '<li' + active + '>'
                        + '<a data-toggle="tab" href="#' + data.languages[s] + '-' + l + '-' + random_number + '">'
                            + data.languages[s].charAt(0).toUpperCase() + data.languages[s].slice(1)
                        + '</a>'
                    + '</li>';

                    tabs += '<div id="' + data.languages[s] + '-' + l + '-' + random_number + '" class="tab-pane fade' + tab_active + '" data-lang="' + data.languages[s] + '">'
                    + '<div class="form-group">'
                        + '<div class="row">'
                            + '<div class="col-lg-12">'
                                + '<label for="menu-item-text-input">'
                                    + data.words.item_name
                                + '</label>'
                            + '</div>'
                        + '</div>'
                        + '<div class="row">'
                            + '<div class="col-lg-12">'
                                + '<input type="text" class="form-control menu-item-text-input" id="menu-item-text-input" placeholder="' + data.words.enter_item_name + '" value="' + name + '" data-slug="menu_item_name">'
                                + '<small class="form-text text-muted">'
                                    + data.words.enter_item_name_description
                                + '</small>'
                            + '</div>'
                        + '</div>'
                    + '</div>'
                    + '<div class="form-group">'
                        + '<div class="row">'
                            + '<div class="col-lg-12">'
                                + '<label for="menu-item-permalink">'
                                    + data.words.item_permalink
                                + '</label>'
                            + '</div>'
                        + '</div>'
                        + '<div class="row">'
                            + '<div class="col-lg-6">'
                                + '<div class="dropdown" data-option="theme-item-pages-list-' + random_number + '">'
                                    + '<button class="btn btn-secondary dropdown-toggle theme-menu-select-pages-for-item" type="button" data-toggle="dropdown" aria-expanded="false"' + select_page + '>'
                                        + data.words.select_page
                                    + '</button>'
                                    + '<div class="dropdown-menu" aria-labelledby="dropdown-items">'
                                        + '<div class="card">'
                                            + '<div class="card-head">'
                                                + '<input type="text" class="search-dropdown-items theme-item-pages-list-' + random_number + '-search" placeholder="' + data.words.search_page + '">'
                                            + '</div>'
                                            + '<div class="card-body">'
                                                + '<ul class="list-group theme-item-dropdown-pages-list theme-item-pages-list-' + random_number + '-list">'
                                                + '</ul>'
                                            + '</div>'
                                        + '</div>'
                                    + '</div>'
                                + '</div>'
                            + '</div>'
                            + '<div class="col-lg-6">'
                                + '<input type="text" class="form-control menu-item-text-input menu-item-permalink" id="menu-item-permalink" placeholder="' + data.words.item_enter_url + '" value="' + permalink + '">'
                            + '</div>'
                        + '</div>'
                        + '<div class="row">'
                            + '<div class="col-lg-12">'
                                + '<p class="show-more-content">'
                                    + '<a data-toggle="collapse" href="#show-advanced-options-' + data.languages[s] + l + '-' + '-' + random_number + '" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">'
                                        + data.words.show_advanced_options
                                    + '</a>'
                                + '</p>'
                                + '<div class="row">'
                                    + '<div class="col-lg-12">'
                                        + '<div class="collapse multi-collapse" id="show-advanced-options-' + data.languages[s] + l + '-' + '-' + random_number + '">'
                                            + '<div class="form-group">'
                                                + '<div class="row">'
                                                    + '<div class="col-lg-12">'
                                                        + '<label for="menu-item-description">'
                                                            + data.words.item_description
                                                        + '</label>'
                                                    + '</div>'
                                                + '</div>'
                                                + '<div class="row">'
                                                    + '<div class="col-lg-12">'
                                                        + '<input type="text" class="form-control menu-item-description menu-item-text-input" id="menu-item-description" placeholder="' + data.words.enter_item_description + '" value="' + description + '">'
                                                            + '<small class="form-text text-muted">'
                                                                + data.words.item_description_info
                                                            + '</small>'
                                                        + '</div>'
                                                    + '</div>'
                                                + '</div>'
                                                + '<div class="form-group">'
                                                    + '<div class="row">'
                                                        + '<div class="col-lg-12">'
                                                            + '<label for="menu-item-class">'
                                                                + data.words.item_class
                                                            + '</label>'
                                                        + '</div>'
                                                    + '</div>'
                                                    + '<div class="row">'
                                                        + '<div class="col-lg-12">'
                                                            + '<input type="text" class="form-control menu-item-class menu-item-text-input" id="menu-item-class" placeholder="' + data.words.enter_item_class + '" value="' + iclass + '">'
                                                            + '<small class="form-text text-muted">'
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
                    + '</div>';

                }

                var parent = '';

                // List available classifications
                for ( var pa = 0; pa < data.classifications.length; pa++ ) {

                    // If current listed parent is equal with item's parent
                    if ( data.classifications[pa].classification_id === classification_id ) {

                        // Verify if the classification has positive array
                        if ( parseInt(data.classifications[pa].parent) > 0 ) {

                            // Get genealogy
                            var get_genealogy = genealogy[data.classifications[pa].parent];

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
                all_items += '<div class="row menu-item-box"' + parent + ' data-id="' + classification_id + '">'
                + '<div class="col-lg-12">'
                    + '<div class="panel panel-default menu-item">'
                        + '<div class="panel-heading">'
                            + '<div class="row">'
                                + '<div class="col-lg-11">'
                                    + '<ul class="nav nav-tabs nav-justified">'
                                        + languages_list
                                    + '</ul>'
                                + '</div>'
                                + '<div class="col-lg-1 text-right">'
                                    + '<div class="btn-group">'
                                        + '<button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                                            + '<i class="icon-options-vertical"></i>'
                                        + '</button>'
                                        + '<ul class="dropdown-menu">'
                                            + '<li>'
                                                + '<a href="#" class="delete-menu-item">'
                                                    + '<i class="icon-trash"></i>'
                                                    + data.words.delete
                                                + '</a>'
                                            + '</li>'
                                        + '</ul>'
                                    + '</div>'
                                + '</div>'
                            + '</div>'
                        + '</div>'
                        + '<div class="panel-body">'
                            + '<div class="tab-content tab-all-editors">'
                                + tabs
                            + '</div>'
                        + '</div>'
                    + '</div>'
                + '</div>'
                + '</div>';

            }


            // Verify if parent is selected
            if (parent) {



            } else {



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
                                + data.pages[p].meta_value
                            + '</a>'
                        + '</li>';

            }

            // Display all pages
            $('.frontend-page .' + data.drop_class + '-list').html(pages);
            
        } else {

            var message = '<li class="list-group-item no-results-found">'
                + data.message
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
                    $('.frontend-page .theme-menu-select-pages-for-item[data-id="' + data.contents[c].content_id + '"]').text(data.contents[c].title);

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

                active = ' class="active"',
                tab_active = ' in active';

            }

            // Get random number
            var random_number = (new Date).getTime();

            languages += '<li' + active + '>'
                            + '<a data-toggle="tab" href="#' + Main.available_languages[l] + '-' + random_number + '">'
                                + Main.available_languages[l].charAt(0).toUpperCase() + Main.available_languages[l].slice(1)
                            + '</a>'
                        + '</li>';

            tabs += '<div id="' + Main.available_languages[l] + '-' + random_number + '" class="tab-pane fade' + tab_active + '" data-lang="' + Main.available_languages[l] + '">'
                        + '<div class="form-group">'
                            + '<div class="row">'
                                + '<div class="col-lg-12">'
                                    + '<label for="menu-item-text-input">'
                                        + Main.menu_item_words.item_name
                                    + '</label>'
                                + '</div>'
                            + '</div>'
                            + '<div class="row">'
                                + '<div class="col-lg-12">'
                                + '<input type="text" class="form-control menu-item-text-input" id="menu-item-text-input" placeholder="' + Main.menu_item_words.enter_item_name + '" data-slug="menu_item_name">'
                                + '<small class="form-text text-muted">'
                                    + Main.menu_item_words.enter_item_name_description
                                + '</small>'
                            + '</div>'
                        + '</div>'
                    + '</div>'
                    + '<div class="form-group">'
                        + '<div class="row">'
                            + '<div class="col-lg-12">'
                                + '<label for="menu-item-permalink">'
                                    + Main.menu_item_words.item_permalink
                                + '</label>'
                            + '</div>'
                        + '</div>'
                        + '<div class="row">'
                            + '<div class="col-lg-6">'
                                + '<div class="dropdown" data-option="theme-item-pages-list-' + random_number + '">'
                                    + '<button class="btn btn-secondary dropdown-toggle theme-menu-select-pages-for-item" type="button" data-toggle="dropdown" aria-expanded="false">'
                                        + Main.menu_item_words.select_page
                                    + '</button>'
                                    + '<div class="dropdown-menu" aria-labelledby="dropdown-items">'
                                        + '<div class="card">'
                                            + '<div class="card-head">'
                                                + '<input type="text" class="search-dropdown-items theme-item-pages-list-' + random_number + '-search" placeholder="' + Main.menu_item_words.search_page + '">'
                                            + '</div>'
                                            + '<div class="card-body">'
                                                + '<ul class="list-group theme-item-dropdown-pages-list theme-item-pages-list-' + random_number + '-list">'
                                                + '</ul>'
                                            + '</div>'
                                        + '</div>'
                                    + '</div>'
                                + '</div>'
                            + '</div>'
                        + '<div class="col-lg-6">'
                            + '<input type="text" class="form-control menu-item-text-input menu-item-permalink" id="menu-item-permalink" placeholder="' + Main.menu_item_words.item_enter_url + '">'
                        + '</div>'
                    + '</div>'
                    + '<div class="row">'
                        + '<div class="col-lg-12">'
                            + '<p class="show-more-content">'
                                + '<a data-toggle="collapse" href="#show-advanced-options-' + Main.available_languages[l] + '-' + random_number + '" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">'
                                    + Main.menu_item_words.show_advanced_options
                                + '</a>'
                            + '</p>'
                            + '<div class="row">'
                                + '<div class="col-lg-12">'
                                    + '<div class="collapse multi-collapse" id="show-advanced-options-' + Main.available_languages[l] + '-' + random_number + '">'
                                        + '<div class="form-group">'
                                            + '<div class="row">'
                                                + '<div class="col-lg-12">'
                                                    + '<label for="menu-item-description">'
                                                        + Main.menu_item_words.item_description
                                                    + '</label>'
                                                + '</div>'
                                            + '</div>'
                                            + '<div class="row">'
                                                + '<div class="col-lg-12">'
                                                    + '<input type="text" class="form-control menu-item-description menu-item-text-input" id="menu-item-description" placeholder="' + Main.menu_item_words.enter_item_description + '">'
                                                    + '<small class="form-text text-muted">'
                                                        + Main.menu_item_words.item_description_info
                                                    + '</small>'
                                                + '</div>'
                                            + '</div>'
                                        + '</div>'
                                        + '<div class="form-group">'
                                            + '<div class="row">'
                                                + '<div class="col-lg-12">'
                                                    + '<label for="menu-item-class">'
                                                    + Main.menu_item_words.item_class
                                                + '</label>'
                                            + '</div>'
                                        + '</div>'
                                        + '<div class="row">'
                                            + '<div class="col-lg-12">'
                                                + '<input type="text" class="form-control menu-item-class menu-item-text-input" id="menu-item-class" placeholder="' + Main.menu_item_words.enter_item_class + '">'
                                                + '<small class="form-text text-muted">'
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
        var item = '<div class="row menu-item-box"' + parent + '>'
                    + '<div class="col-lg-12">'
                        + '<div class="panel panel-default menu-item">'
                            + '<div class="panel-heading">'
                                + '<div class="row">'
                                    + '<div class="col-lg-11">'
                                        + '<ul class="nav nav-tabs nav-justified">'
                                            + languages
                                        + '</ul>'
                                    + '</div>'
                                    + '<div class="col-lg-1 text-right">'
                                    + '<div class="btn-group">'
                                        + '<button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                                            + '<i class="icon-options-vertical"></i>'
                                        + '</button>'
                                        + '<ul class="dropdown-menu">'
                                            + '<li>'
                                                + '<a href="#" class="delete-menu-item">'
                                                    + '<i class="icon-trash"></i>'
                                                    + Main.menu_item_words.delete
                                                + '</a>'
                                            + '</li>'
                                        + '</ul>'
                                    + '</div>'
                                + '</div>'
                            + '</div>'
                        + '</div>'
                        + '<div class="panel-body">'
                            + '<div class="tab-content tab-all-editors">'
                                + tabs
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

        // Display save button
        $('.theme-menu-save-changes').fadeIn('slow');

    });
    
    /*******************************
    DEPENDENCIES
    ********************************/

    // Hide loading animation
    $('.page-loading').fadeOut('slow');
 
});