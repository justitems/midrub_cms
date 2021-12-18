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
     * Get components and apps
     * 
     * @param string drop_class contains the dropdown's class
     * 
     * @since   0.0.7.9
     */    
    Main.load_components_and_apps =  function (drop_class) {

        // Prepare data
        var data = {
            action: 'settings_components_and_apps_list',
            drop_class: drop_class,
            key: $('.user-page .' + drop_class + '-search').val()
        };

		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');   
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/user', 'POST', data, 'show_components_and_apps');
        
    };

    /*
     * Get selected components and apps
     *
     * @param array component_slugs contains the components and apps slug
     * 
     * @since   0.0.7.9
     */    
    Main.selected_components_apps = function (component_slugs) {

        // Prepare data
        var data = {
            action: 'load_selected_components',
            component_slugs: component_slugs
        };

		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');   
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/user', 'POST', data, 'load_selected_components');
        
    };

    /*******************************
    ACTIONS
    ********************************/

    /*
     * Search components and apps
     * 
     * @since   0.0.7.9
     */
    $(document).on('keyup', 'body .search-dropdown-items', function () {

        // Load components and apps
        Main.load_components_and_apps($(this).closest('.dropdown').attr('data-option'));
        
    });

    /*
     * Display save changes button
     * 
     * @since   0.0.7.9
     */
    $(document).on('keyup', 'body .menu-item-text-input', function () {

        // Display save button
        $('body .theme-save-changes').slideDown('slow');
        
    }); 

    /*
     * Select a menu
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.8
     */
    $(document).on('click', '.user-page .theme-dropdown-items-list a', function (e) {
        e.preventDefault();

        // Get menu's slug
        var menu_slug = $(this).attr('data-slug'); 
        
        // Get menu's name
        var menu_name = $(this).text();

        // Add menu's name and menu's slug
        $(this).closest('.dropdown').find('.btn-secondary > span').text(menu_name);
        $(this).closest('.dropdown').find('.btn-secondary').attr('data-slug', menu_slug);

        // Display new menu item button
        $('.user-page .user-new-menu-item').fadeIn('slow');

        // Prepare data to send
        var data = {
            action: 'user_get_menu_items',
            menu: menu_slug
        };
        
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/user', 'POST', data, 'user_display_menu_items_response');
        
    });
    
    /*
     * New menu item
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.9
     */
    $(document).on('click', '.user-page .user-new-menu-item', function (e) {
        e.preventDefault();

        // Prepare data to send
        var data = {
            action: 'new_menu_item',
            menu_slug: $('.user-page .user-menu-dropdown-btn').attr('data-slug')
        };

		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');   
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/user', 'POST', data, 'new_menu_item');
        
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
        var items = $('.user-page .show-menu-items .menu-item').length;
        
        var all_items = [];
        
        for ( var i = 0; i < items; i++ ) {

            all_items[i] = [];
                
            for ( var o = 0; o < $('.user-page .show-menu-items .menu-item').eq(i).find('.tab-pane').length; o++ ) {

                all_items[i].push({
                    [$('.user-page .show-menu-items .menu-item').eq(i).find('.tab-pane').eq(o).attr('data-lang')]: {
                        name: $('.user-page .show-menu-items .menu-item').eq(i).find('.tab-pane').eq(o).find('.menu-item-text-input').val(),
                        selected_component: $('.user-page .show-menu-items .menu-item').eq(i).find('.tab-pane').eq(o).find('.theme-menu-select-component-for-item').attr('data-slug')?$('.user-page .show-menu-items .menu-item').eq(i).find('.tab-pane').eq(o).find('.theme-menu-select-component-for-item').attr('data-slug'):' ',
                        permalink: $('.user-page .show-menu-items .menu-item').eq(i).find('.tab-pane').eq(o).find('.menu-item-permalink').val(),
                        description: $('.user-page .show-menu-items .menu-item').eq(i).find('.tab-pane').eq(o).find('.menu-item-description').val(),
                        class: $('.user-page .show-menu-items .menu-item').eq(i).find('.tab-pane').eq(o).find('.menu-item-class').val(),
                        parent: $('.user-page .show-menu-items .menu-item-box').eq(i).attr('data-parent')
                    }
                });

            }
            
        }

        // Prepare data to send
        var data = {
            action: 'save_menu_items',
            menu_slug: $('.user-page .user-menu-dropdown-btn').attr('data-slug'),
            all_items: Object.entries(all_items)
        };
        
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/user', 'POST', data, 'user_save_menu_items_response', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
    });

    /*
     * Delete menu's items
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.9
     */ 
    $( document ).on( 'click', '.user-page .user-delete-menu-item', function (e) {
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

        // Display save button
        $('body .theme-save-changes').slideDown('slow');
        
    });

    /*
     * Get components and apps
     * 
     * @since   0.0.7.9
     */
    $(document).on('click', '.user-page .theme-menu-select-component-for-item', function (e) {
        e.preventDefault();

        // Load components and apps
        Main.load_components_and_apps($(this).closest('.dropdown').attr('data-option'));
        
    });

    /*
     * Select a page
     * 
     * @since   0.0.7.9
     */
    $(document).on('click', '.user-page .theme-item-dropdown-pages-list a', function (e) {
        e.preventDefault();

        // Get item's slug
        var item_slug = $(this).attr('data-slug'); 
        
        // Get item's title
        var item_title = $(this).text();

        // Add item's title and item's id
        $(this).closest('.dropdown').find('.theme-menu-select-component-for-item > span').text(item_title);
        $(this).closest('.dropdown').find('.theme-menu-select-component-for-item').attr('data-slug', item_slug);

        // Display save button
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
     * @since   0.0.7.9
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
            $('#create-menu-item #user-select-menu-item-parent-list').html(items);

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
     * @since   0.0.7.9
     */
    Main.methods.user_save_menu_items_response = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);

            // Prepare data to send
            var data = {
                action: 'user_get_menu_items',
                menu: $('.user-page .user-menu-dropdown-btn').attr('data-slug')
            };

            // Set CSRF
            data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');   

            // Make ajax call
            Main.ajax_call(url + 'admin/ajax/user', 'POST', data, 'user_display_menu_items_response');
            
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
     * @since   0.0.7.9
     */
    Main.methods.user_display_menu_items_response = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Selected components array
            var selected_components = [];

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
                var languages = '';

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

                            if (typeof items[l][d][data.languages[s]]['selected_component'] !== 'undefined') {

                                select_page = ' data-slug="' + items[l][d][data.languages[s]]['selected_component'] + '"';

                                if (!selected_components.includes(items[l][d][data.languages[s]]['selected_component'])) {
                                    selected_components.push(items[l][d][data.languages[s]]['selected_component']);
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
                    languages += '<li class="nav-item">'
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
                                + '<input type="text" class="form-control menu-item-text-input theme-text-input-1" id="menu-item-text-input' + l + '-' + '-' + random_number + '" placeholder="' + data.words.enter_item_name + '" value="' + name + '" data-slug="menu_item_name">'
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
                                + '<div class="dropdown theme-dropdown-1 m-0" data-option="theme-item-pages-list-' + random_number + '">'
                                    + '<button type="button" class="btn btn-secondary dropdown-toggle d-flex justify-content-between align-items-start theme-menu-select-component-for-item" aria-expanded="false"' + select_page + ' data-bs-toggle="dropdown">'
                                        + '<span>'
                                            + data.words.select_component_or_app
                                        + '</span>'
                                        + words.icon_arrow_down
                                    + '</button>'
                                    + '<div class="dropdown-menu" aria-labelledby="dropdown-items">'
                                        + '<input type="text" class="search-dropdown-items theme-item-pages-list-' + random_number + '-search" placeholder="' + data.words.search_component_or_app + '">'
                                        + '<div>'
                                            + '<ul class="list-group theme-item-dropdown-pages-list theme-item-pages-list-' + random_number + '-list">'
                                            + '</ul>'                                    
                                        + '</div>'
                                    + '</div>'
                                + '</div>'
                            + '</div>'
                            + '<div class="col-lg-6">'
                                + '<input type="text" class="form-control menu-item-text-input theme-text-input-1 menu-item-permalink" id="menu-item-permalink' + l + '-' + '-' + random_number + '" placeholder="' + data.words.item_enter_url + '" value="' + permalink + '">'
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
                                                        + '<input type="text" class="form-control menu-item-description menu-item-text-input theme-text-input-1" id="menu-item-description' + l + '-' + '-' + random_number + '" placeholder="' + data.words.enter_item_description + '" value="' + description + '">'
                                                            + '<small class="form-text text-muted theme-small">'
                                                                + data.words.item_description_info
                                                            + '</small>'
                                                        + '</div>'
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
                                                            + '<input type="text" class="form-control menu-item-class menu-item-text-input theme-text-input-1" id="menu-item-class' + l + '-' + '-' + random_number + '" placeholder="' + data.words.enter_item_class + '" value="' + iclass + '">'
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
                                    + '<div class="row">'
                                        + '<div class="col-12">'
                                            + '<ul class="nav nav-tabs nav-justified">'
                                                + languages
                                            + '</ul>'
                                        + '</div>'
                                    + '</div>'
                                + '</div>'
                                + '<div class="card-body">'
                                    + '<div class="tab-content tab-all-editors">'
                                        + tabs
                                    + '</div>'
                                + '</div>'
                                + '<div class="card-footer">'
                                    + '<div class="row">'
                                        + '<div class="col-12">'
                                            + '<a href="#" class="btn-option theme-button-1 w-100 d-block text-center user-delete-menu-item">'
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

            // Load selected components and apps
            Main.selected_components_apps(selected_components);

            // Add menu's item to list
            $('.user-page .show-menu-items').html(all_items);
            
        } else {

            // Empty menu list
            $('.user-page .show-menu-items').empty();
            
        }

    };

    /*
     * Display components and apps response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.9
     */
    Main.methods.show_components_and_apps = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Apps list
            var apps = '';

            // List all apps
            for ( var p = 0; p < data.apps.length; p++ ) {

                apps += '<li class="list-group-item">'
                            + '<a href="#" data-slug="' + data.apps[p].slug + '">'
                                + data.apps[p].name
                            + '</a>'
                        + '</li>';

            }

            // Display all apps
            $('.user-page .' + data.drop_class + '-list').html(apps);
            
        } else {

            // Prepare the no components and apps message
            let message = '<li class="list-group-item">'
                + '<p>'
                    + data.message
                + '</p>'
            + '</li>';

            // Display no contents found
            $('.user-page .' + data.drop_class + '-list').html(message);
            
        }

    };

    /*
     * Display selected components
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.9
     */
    Main.methods.load_selected_components = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {

            for ( var c = 0; c < data.components.length; c++ ) {

                // Verify if selected page exists
                if ( $('.user-page .theme-menu-select-component-for-item[data-slug="' + data.components[c].slug + '"]').length > 0 ) {

                    // Add page title
                    $('.user-page .theme-menu-select-component-for-item[data-slug="' + data.components[c].slug + '"] > span').text(data.components[c].name);

                }

            }
            
        } else {

            // Remove all components and apps slugs
            $('.user-page .theme-menu-select-component-for-item').removeAttr('data-slug');
            
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
     * @since   0.0.7.9
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
                                + '<input type="text" class="form-control menu-item-text-input theme-text-input-1" id="menu-item-text-input' + l + '-' + '-' + random_number + '" placeholder="' + Main.menu_item_words.enter_item_name + '" data-slug="menu_item_name">'
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
                                    + '<button type="button" class="btn btn-secondary dropdown-toggle d-flex justify-content-between align-items-start theme-menu-select-component-for-item" aria-expanded="false" data-bs-toggle="dropdown">'
                                        + '<span>'
                                            + Main.menu_item_words.select_component_or_app
                                        + '</span>'
                                        + words.icon_arrow_down
                                    + '</button>'
                                    + '<div class="dropdown-menu" aria-labelledby="dropdown-items">'
                                        + '<input type="text" class="search-dropdown-items theme-item-pages-list-' + random_number + '-search" placeholder="' + Main.menu_item_words.search_component_or_app + '">'
                                        + '<div>'
                                            + '<ul class="list-group theme-item-dropdown-pages-list theme-item-pages-list-' + random_number + '-list">'
                                            + '</ul>'
                                        + '</div>'
                                    + '</div>'
                                + '</div>'
                            + '</div>'
                        + '<div class="col-lg-6">'
                            + '<input type="text" class="form-control menu-item-text-input theme-text-input-1 menu-item-permalink" id="menu-item-permalink' + l + '-' + '-' + random_number + '" placeholder="' + Main.menu_item_words.item_enter_url + '">'
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
                                                    + '<input type="text" class="form-control menu-item-description menu-item-text-input theme-text-input-1" id="menu-item-description' + l + '-' + '-' + random_number + '" placeholder="' + Main.menu_item_words.enter_item_description + '">'
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
                                                    + '<input type="text" class="form-control menu-item-class menu-item-text-input theme-text-input-1" id="menu-item-class' + l + '-' + '-' + random_number + '" placeholder="' + Main.menu_item_words.enter_item_class + '">'
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

        if ( $('#create-menu-item #user-select-menu-item-parent-list').val() ) {

            // Last parent value
            var last_parent_value = 1;

            // Verify if parent has a parent too
            if ( $('.show-menu-items .menu-item-box[data-id="' + $('#create-menu-item #user-select-menu-item-parent-list').val() + '"]').attr('data-parent') ) {

                // Set parent value
                var last_parent_value = $('.show-menu-items .menu-item-box[data-id="' + $('#create-menu-item #user-select-menu-item-parent-list').val() + '"]').attr('data-parent');

                // Increase last parent value
                last_parent_value++;               
                
            }

            // Set default margin left
            var margin_left = (last_parent_value * 5) + '%';

            parent = ' data-id="' + $('#create-menu-item #user-select-menu-item-parent-list').val() + '" data-parent="' + last_parent_value + '" style="margin-left: ' + margin_left + '"';
            parent_id = $('#create-menu-item #user-select-menu-item-parent-list').val();

        }

        // Set the item's data
        var item = '<div class="row mt-3 menu-item-box"' + parent + '>'
                    + '<div class="col-lg-12">'
                        + '<div class="theme-box-1">'
                            + '<div class="card theme-card-box menu-item">'
                                + '<div class="card-header border-0">'
                                    + '<div class="row">'
                                        + '<div class="col-12">'
                                            + '<ul class="nav nav-tabs nav-justified">'
                                                + languages
                                            + '</ul>'
                                        + '</div>'
                                    + '</div>'
                                + '</div>'
                                + '<div class="card-body">'
                                    + '<div class="tab-content tab-all-editors">'
                                        + tabs
                                    + '</div>'
                                + '</div>'
                                + '<div class="card-footer">'
                                    + '<div class="row">'
                                        + '<div class="col-12">'
                                            + '<a href="#" class="btn-option theme-button-1 w-100 d-block text-center user-delete-menu-item">'
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
            $('.user-page .show-menu-items').append(item);

        }

        // Hide modal
        $("#create-menu-item").modal('hide');

        // Display save button
        $('body .theme-save-changes').slideDown('slow');

    });
    
    /*******************************
    DEPENDENCIES
    ********************************/
 
});