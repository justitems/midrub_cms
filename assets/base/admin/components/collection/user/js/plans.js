/*
 * Plans javascript file
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
     * Load plans
     * 
     * @param integer page contains the page number
     * @param integer progress contains the progress option
     * 
     * @since   0.0.7.9
     */    
    Main.user_load_plans = function (page, progress) {

        // Verify if is the plans page
        if ( $('.user-page .user-search-for-plans').length < 1 ) {
            return;
        }

        // Prepare data to send
        var data = {
            action: 'load_all_plans',
            page: page,
            key: $('.user-page .user-search-for-plans').val()
        };
        
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');

        // Verify if progress exists
        if ( typeof progress !== 'undefined' ) {

            // Make ajax call
            Main.ajax_call(url + 'admin/ajax/user', 'POST', data, 'load_all_plans', 'ajax_onprogress');

            // Set progress bar
            Main.set_progress_bar();

        } else {

            // Make ajax call
            Main.ajax_call(url + 'admin/ajax/user', 'POST', data, 'load_all_plans');

        }
        
    };

    /*
     * Load plans groups
     * 
     * @param integer page contains the page number
     * @param integer progress contains the progress option
     * 
     * @since   0.0.8.2
     */    
    Main.user_load_plans_groups = function (page, progress) {

        // Prepare data to send
        var data = {
            action: 'load_all_plans_groups',
            page: page,
        };
        
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');

        // Verify if progress exists
        if ( typeof progress !== 'undefined' ) {

            // Make ajax call
            Main.ajax_call(url + 'admin/ajax/user', 'POST', data, 'load_all_plans_groups', 'ajax_onprogress');

            // Set progress bar
            Main.set_progress_bar();

        } else {

            // Make ajax call
            Main.ajax_call(url + 'admin/ajax/user', 'POST', data, 'load_all_plans_groups');

        }
        
    };

    /*
     * Load all plans groups for dropdown
     * 
     * @since   0.0.8.2
     */    
    Main.user_load_plans_groups_for_dropdown = function () {

        var data = {
            action: 'load_all_plans_groups',
            key: $('#new-plan .plans-search-groups').val(),
            page: 1
        };
        
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/user', 'POST', data, 'user_load_plans_groups_for_dropdown', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
    };

    /*
     * Load the plans groups
     * 
     * @since   0.0.8.5
     */    
    Main.user_get_plans_groups = function () {  

        // Prepare data to send
        var data = {
            action: 'load_all_plans_groups',
            key: $('.user-page [data-field="plans_group"] .dropdown .theme-dropdown-search-for-items').val(),
            page: 1
        };
                
        // Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/user', 'POST', data, 'user_display_plans_groups_response', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();        
        
    };

    /*
     * Get components and apps
     * 
     * @since   0.0.8.5
     */    
    Main.load_components_and_apps =  function () {

        // Prepare data
        var data = {
            action: 'settings_components_and_apps_list',
            key: $('.user-page [data-field="user_redirect"] .dropdown .theme-dropdown-search-for-items').val()
        };

		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');   
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/user', 'POST', data, 'user_display_components_and_apps_response');
        
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

        // Load all plans
        Main.user_load_plans(1);

    });

    /*
     * Detect new plan modal
     * 
     * @since   0.0.8.2
     */ 
    $(document).on('show.bs.modal', '#new-plan', function () {

        // Load all plans groups
        Main.user_load_plans_groups(1);

    });

    /*
     * Detect groups dropdown show
     * 
     * @since   0.0.8.5
     */ 
    $( '.user-page [data-field="plans_group"] .dropdown' ).on( 'show.bs.dropdown', function () {

        // Reset input
        $('.user-page [data-field="plans_group"] .dropdown .theme-dropdown-search-for-items').val('');
        
        // Get the plans groups
        Main.user_get_plans_groups();
        
    });

    /*
     * Detect groups dropdown show
     * 
     * @since   0.0.8.5
     */ 
    $( '.user-page [data-field="user_redirect"] .dropdown' ).on( 'show.bs.dropdown', function () {

        // Reset input
        $('.user-page [data-field="user_redirect"] .dropdown .theme-dropdown-search-for-items').val('');
        
        // Get the apps and components
        Main.load_components_and_apps();
        
    });

    /*
     * Search plans
     * 
     * @since   0.0.7.9
     */
    $(document).on('keyup', '.user-page .user-search-for-plans', function () {

        // Set this
        let $this = $(this);

        // Verify if input has a value
        if ( $(this).val() !== '' ) {

            // Verify if an event was already scheduled
            if ( typeof Main.queue !== 'undefined' ) {

                // Clear previous timout
                clearTimeout(Main.queue);

            }
            
            // Verify if loader icon has style
            if ( !$this.closest('div').find('.theme-list-loader-icon').attr('style') ) {

                // Set opacity
                $this.closest('div').find('.theme-list-loader-icon').fadeTo( 'slow', 1.0);

            }

            Main.schedule_event(function() {

                // Set opacity
                $this.closest('div').find('.theme-list-loader-icon').removeAttr('style');         

                // Set opacity
                $this.closest('div').find('a').fadeTo( 'slow', 1.0);

                // Load all plans by key
                Main.user_load_plans(1, 1);

            }, 1000);

        } else {

            // Set opacity
            $this.closest('div').find('a').removeAttr('style');

            // Load all plans by key
            Main.user_load_plans(1, 1);
            
        }
        
    });

    /*
     * Search plans groups
     * 
     * @since   0.0.8.2
     */
    $(document).on('keyup', '#new-plan .plans-search-groups', function () {
        
        // Load all plans groups for dropdown
        Main.user_load_plans_groups_for_dropdown();
        
    });

    /*
     * Detect fields keyup
     */
    $(document).on('keyup', '#user-plan-manage-text .theme-text-input-1', function () {

        // Show the save button
        $('body .theme-save-changes').slideDown('slow');

    });    

    /*
     * Detect fields change
     */
    $(document).on('change', '#user-plan-manage-text .theme-text-input-1', function () {

        // Show the save button
        $('body .theme-save-changes').slideDown('slow');

    }); 

    /*
     * Cancel the search for plans
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.5
     */ 
    $( document ).on( 'click', '.user-page .theme-cancel-search', function (e) {
        e.preventDefault();

        // Empty search input
        $('.user-page .user-search-for-plans').val('');

        // Set opacity
        $(this).closest('div').find('a').removeAttr('style');

        // Load all plans by key
        Main.user_load_plans(1, 1);
        
    });

    /*
     * Delete plans
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.9
     */ 
    $(document).on( 'click', '.user-page .user-delete-plans', function (e) {
        e.preventDefault();
    
        // Define the plans ids variable
        var plans_ids = [];
        
        // Get selected plans ids
        $('.user-page .theme-list > .card-body input[type="checkbox"]:checkbox:checked').each(function () {
            plans_ids.push($(this).attr('data-plan'));
        });

        // Create an object with form data
        var data = {
            action: 'delete_plans',
            plans_ids: plans_ids
        };
        
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/user', 'POST', data, 'delete_plans_response', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
    });

    /*
     * Displays pagination by page click
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.9
     */    
    $(document).on( 'click', 'body .theme-pagination li a', function (e) {
        e.preventDefault();
        
        // Get the page number
        var page = $(this).attr('data-page');
        
        // Display results
        switch ( $(this).closest('ul').attr('data-type') ) {
            
            case 'plans':
                
                // Load all plans by page
                Main.user_load_plans(page, 1);

                break;  
                
            case 'plans-groups':
            
                // Load all plans groups by page
                Main.user_load_plans_groups(page, 1);

                break;  
            
        }
        
    });

    /*
     * Save settings
     * 
     * @since   0.0.8.5
     */ 
    $(document).on( 'click', 'body .theme-save-changes .theme-save-changes-btn', function () {

        // Get all dropdowns
        var dropdowns = $('.user-page .theme-dynamic-dropdown').length;
        
        // All dropdowns container
        var all_dropdowns = [];

        // Verify if dropdowns exists
        if (dropdowns > 0) {

            // List all dropdowns
            for (var d = 0; d < dropdowns; d++) {

                // Verify if dropdown's id exists
                if ($('.user-page .theme-dynamic-dropdown').eq(d).closest('.list-group-item').attr('data-field')) {

                    // Append dropdown's value
                    all_dropdowns[$('.user-page .theme-dynamic-dropdown').eq(d).closest('.list-group-item').attr('data-field')] = $('.user-page .theme-dynamic-dropdown').eq(d).attr('data-id');

                }

            }

        }

        // Get all textareas
        var textareas = $('.user-page .theme-text-input-1').length;
        
        // All textareas container
        var all_textareas = [];

        // Verify if textareas exists
        if (textareas > 0) {

            // List all textareas
            for (var t = 0; t < textareas; t++) {

                // Append textarea's value
                all_textareas[$('.user-page .theme-text-input-1').eq(t).closest('.list-group-item').attr('data-field')] = $('.user-page .theme-text-input-1').eq(t).val().replace(/</g,"&lt;").replace(/>/g,"&gt;");

            }

        }

        // Get all checkboxes inputs
        var checkboxes = $('.user-page .theme-field-checkbox').length;

        // Verify if checkboxes exists
        if (checkboxes > 0) {

            // List all checkboxes
            for ( var c = 0; c < checkboxes; c++ ) {

                // Verify if the checkbox is checked
                if ( $('.user-page .theme-field-checkbox').eq(c).is(':checked') ) {
                
                    // Append checkbox's value
                    all_textareas[$('.user-page .theme-field-checkbox').eq(c).closest('.list-group-item').attr('data-field')] = 1;
                    
                } else {
                    
                    // Append checkbox's value
                    all_textareas[$('.user-page .theme-field-checkbox').eq(c).closest('.list-group-item').attr('data-field')] = 0;
                    
                }

            }

        }

        // Texts
        var texts = [];

        // Get the languages
        var languages = $('#user-plan-manage-text #nav-plan-text-tabs > .tab-pane');

        // Verify if languages exists
        if ( languages.length > 0 ) {

            // List the languages
            for ( var l = 0; l < languages.length; l++ ) {

                // Set language
                texts[$(languages[l]).attr('data-language')] = {};

                // Set title
                texts[$(languages[l]).attr('data-language')]['title'] = $(languages[l]).find('.user-plan-manage-text-title').val();

                // Set short description
                texts[$(languages[l]).attr('data-language')]['short_description'] = $(languages[l]).find('.user-plan-manage-text-short-description').val();
                
                // Set displayed price
                texts[$(languages[l]).attr('data-language')]['displayed_price'] = $(languages[l]).find('.user-plan-manage-text-displayed-price').val();                

                // Get the features
                let the_features = $(languages[l]).find('.user-plan-features > li > span');

                // Verify if features exists
                if ( the_features.length > 0 ) {

                    // Features container
                    texts[$(languages[l]).attr('data-language')]['features'] = [];

                    // List features
                    for ( var f = 0; f < the_features.length; f++ ) {

                        // Append feature
                        texts[$(languages[l]).attr('data-language')]['features'].push($(the_features[f]).text());

                    }

                }

            }

        }

        // Prepare data to send
        var data = {
            action: 'user_update_a_plan',
            plan_id: $('.user-page .update-plan').attr('data-plan-id'),
            all_dropdowns: Object.entries(all_dropdowns),
            all_textareas: Object.entries(all_textareas),
            texts: Object.entries(texts)
        };
        
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/user', 'POST', data, 'user_update_a_plan_response', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
    });

    /*
     * Show the plans groups
     * 
     * @since   0.0.8.2
     */ 
    $(document).on( 'click', '#new-plan .select-plans-group', function () {      

        // Load all plans groups for dropdown
        Main.user_load_plans_groups_for_dropdown();
        
    });    

    /*
     * Create a plans group
     * 
     * @since   0.0.8.2
     */ 
    $(document).on( 'click', '#new-plan .save-plan-group', function () {      

        // Prepare data to send
        var data = {
            action: 'create_plans_group',
            group_name: $('#new-plan  .enter-group-name').val()
        };
        
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/user', 'POST', data, 'create_plans_group', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
    });

    /*
     * Delete a plans group
     * 
     * @since   0.0.8.2
     */ 
    $(document).on( 'click', '#new-plan .btn-delete-plan-group', function () {      

        // Prepare data to send
        var data = {
            action: 'delete_plans_group',
            group_id: $(this).attr('data-id')
        };
        
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/user', 'POST', data, 'delete_plans_group', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
    });

    /*
     * Change the plans groups
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.2
     */
    $(document).on('click', '#new-plan .plans-groups-list a', function (e) {
        e.preventDefault();

        // Get the group's name
        let text = $(this).text();

        // Get the group's id
        let id = $(this).attr('data-id');

        // Display the selected item
        $(this).closest('.input-group').find('.select-plans-group > span').html(text);
        $(this).closest('.input-group').find('.select-plans-group').attr('data-id', id);

    });

    /*
     * Detect checkbox check
     * 
     * @since   0.0.8.5
     */ 
    $( document ).on( 'click', '.user-page .theme-list > .card-body input[type="checkbox"]', function () {

        // Show the action
        if ( $('.user-page .theme-list > .card-body :checkbox:checked').length > 0 ) {

            // Show actions
            $('.user-page .card-actions').slideDown('slow');

            // Set selected items
            $('.user-page .theme-list .theme-list-selected-items p').html($('.user-page .theme-list > .card-body :checkbox:checked').length + ' ' + words.selected_items);

        } else {

            // Hide actions
            $('.user-page .card-actions').slideUp('slow');
            
        }
        
    });

    /*
     * Detect dropdown selection
     * 
     * @param integer page contains the page number
     * 
     * @since   0.0.8.5
     */ 
    $( document ).on( 'click', '.main .theme-settings-options .dropdown .theme-dropdown-items-list a', function (e) {
        e.preventDefault();
        
        // Get the item's name
        let text = $(this).text();

        // Get the item's id
        let id = $(this).attr('data-id');

        // Display the selected item
        $(this).closest('.dropdown').find('.btn-secondary > span').html(text);
        $(this).closest('.dropdown').find('.btn-secondary').attr('data-id', id);
        
    });

    /*
     * Save new plan's feature
     * 
     * @param integer page contains the page number
     * 
     * @since   0.0.8.5
     */ 
    $( document ).on( 'click', '#user-plan-manage-text .user-save-plan-feature', function (e) {
        e.preventDefault();
        
        // Get the feature's text
        let feature_text = $(this).closest('.input-group').find('.user-plan-feature').val();

        // Verify how long is a feature
        if ( feature_text.trim().length < 1 ) {

            // Display alert
            Main.show_alert('error', words.feature_text_short, 1500, 2000);
            return;

        }

        // Create the feature html code
        let feature = '<li class="list-group-item d-flex justify-content-between">'
            + '<span>'
                + feature_text
            + '</span>'
            + '<button type="button" class="btn btn-link btn-delete-plan-feature">'
                + words.icon_delete
            + '</button>'   
        + '</li>';

        // Append feature
        $(this).closest('.form-group').find('.user-plan-features').append(feature);

        // Empty the feature's text
        $(this).closest('.input-group').find('.user-plan-feature').val('');

        // Show the save button
        $('body .theme-save-changes').slideDown('slow');
        
    });

    /*
     * Remove the plan's feature
     * 
     * @param integer page contains the page number
     * 
     * @since   0.0.8.5
     */ 
    $( document ).on( 'click', '#user-plan-manage-text .btn-delete-plan-feature', function (e) {
        e.preventDefault();
        
        // Remove plan's feature
        $(this).closest('li').remove();

        // Show the save button
        $('body .theme-save-changes').slideDown('slow');
        
    });
   
    /*******************************
    RESPONSES
    ********************************/

    /*
     * Display plans response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.9
     */
    Main.methods.load_all_plans = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();

        // Hide pagination
        $('.user-page .theme-list > .card-footer').hide(); 

        // Hide actions
        $('.user-page .card-actions').slideUp('slow');

        // Verify if the success response exists
        if ( status === 'success' ) {

            // All plans
            var all_plans = '';
            
            // List all plans
            for ( var p = 0; p < data.plans.length; p++ ) {

                // Set plan
                all_plans += '<div class="card theme-box-1 card-plan">'
                    + '<div class="card-header">'
                        + '<div class="row">'
                            + '<div class="col-12">'
                                + '<div class="media d-flex justify-content-start">'
                                    + '<div class="theme-checkbox-input-1">'
                                        + '<label for="user-plans-single-' + data.plans[p].plan_id + '">'
                                            + '<input type="checkbox" id="user-plans-single-' + data.plans[p].plan_id + '" data-plan="' + data.plans[p].plan_id + '">'
                                            + '<span class="theme-checkbox-checkmark"></span>'
                                        + '</label>'
                                    + '</div>'
                                    + '<div class="media-body">'
                                        + '<h5>'
                                            + '<a href="' + url + 'admin/user?p=plans&plan_id=' + data.plans[p].plan_id + '">'
                                                + data.plans[p].plan_name
                                            + '</a>'
                                        + '</h5>'
                                    + '</div>'
                                + '</div>'
                            + '</div>'
                        + '</div>'
                    + '</div>'
                + '</div>';

            }
            
            // Display templates
            $('.user-page .theme-list > .card-body').html(all_plans);   
            
            // Set limit
            let limit = ((data.page * 10) < data.total)?(data.page * 10):data.total;

            // Set text
            $('.user-page .theme-list > .card-footer h6').html((((data.page - 1) * 10) + 1) + '-' + limit + ' ' + data.words.of + ' ' + data.total + ' ' + data.words.results);

            // Set page
            Main.pagination.page = data.page;

            // Display the pagination
            Main.show_pagination('.user-page .theme-list', data.total);

            // Show pagination
            $('.user-page .theme-list > .card-footer').show();  
            
        } else {

            // Set no data found message
            var no_data = '<p class="theme-box-1 theme-list-no-results-found">'
                                + data.message
                            + '</p>';

            // Display the no data found message
            $('.user-page .theme-list > .card-body').html(no_data);  
            
        }

    };
   
    /*
     * Display new plan creation response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.9
     */
    Main.methods.create_new_plan = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);
            
            // Redirect user to the plan's page
            setTimeout(function(){
                document.location.href = url + 'admin/user?p=plans&plan_id=' + data.plan_id;
            }, 3000);
            
        } else {
            
            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);
            
        }

    }; 

    /*
     * Display plans deletion response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.9
     */
    Main.methods.delete_plans_response = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);
            
            // Load all plans by key
            Main.user_load_plans(1);
            
        } else {
            
            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);
            
        }

    };

    /*
     * Display the plan update response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.4
     */
    Main.methods.user_update_a_plan_response = function ( status, data ) {

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
     * Display the plans group creation response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.2
     */
    Main.methods.create_plans_group = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();
        
        // Verify if the success response exists
        if ( status === 'success' ) {

            // Load all plans groups
            Main.user_load_plans_groups(1);

            // Load all plans groups for dropdown
            Main.user_load_plans_groups_for_dropdown();
            
            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);

            // Empty the group's name input
            $('#new-plan  .enter-group-name').val('');
            
        } else {
            
            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);
            
        }

    };

    /*
     * Display the plans group by page
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.2
     */
    Main.methods.load_all_plans_groups = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();

        // Empty pagination
        $('#new-plan .theme-pagination').empty();

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Set the pagination page
            Main.pagination.page = data.page;

            // Display the pagination
            Main.show_pagination('#new-plan', data.total);
            
            // Groups variable
            var groups = '';

            // List all groups
            for ( var g = 0; g < data.groups.length; g++ ) {

                // Set group
                groups += '<li class="list-group-item d-flex justify-content-between">'
                            + '<span>'
                                + data.groups[g].group_name
                            + '</span>'
                            + '<button type="button" class="btn btn-link btn-delete-plan-group" data-id="' + data.groups[g].group_id + '">'
                                + words.icon_delete
                            + '</button>'   
                        + '</li>';

            }

            // Display the groups
            $('#new-plan .plans-groups-by-page').html(groups);
            
        } else {
            
            // Prepare no groups message
            var no_groups = '<li class="list-group-item default-card-box-no-items-found">'
                + data.message
            + '</li>';
                    
            // Display message
            $('#new-plan .plans-groups-by-page').html(no_groups);

        }

    };

    /*
     * Display the plans group deletion response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.2
     */
    Main.methods.delete_plans_group = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();
        
        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);

            // Load all plans groups
            Main.user_load_plans_groups(1);
            
        } else {
            
            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);
            
        }

    };

    /*
     * Display the plans groups in the dropdown
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.2
     */
    Main.methods.user_load_plans_groups_for_dropdown = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Groups variable
            var groups = '';

            // List all groups
            for ( var g = 0; g < data.groups.length; g++ ) {

                // Set group
                groups += '<li class="list-group-item">'
                            + '<a href="#" data-id="' + data.groups[g].group_id + '">'
                                + data.groups[g].group_name
                            + '</a>'
                        + '</li>';

            }

            // Display the groups
            $('#new-plan .plans-groups-list').html(groups);
            
        } else {

            // Prepare no groups message
            let no_groups = '<li class="list-group-item">'
                + '<p>'
                    + data.message
                + '</p>'
            + '</li>';
                    
            // Display message
            $('#new-plan .plans-groups-list').html(no_groups);

        }

    };

    /*
     * Display the plans groups in the dropdown
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.5
     */
    Main.methods.user_display_plans_groups_response = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Groups variable
            var groups = '';

            // List all groups
            for ( var g = 0; g < data.groups.length; g++ ) {

                // Set group
                groups += '<li class="list-group-item">'
                            + '<a href="#" data-id="' + data.groups[g].group_id + '">'
                                + data.groups[g].group_name
                            + '</a>'
                        + '</li>';

            }

            // Display the groups
            $('.user-page [data-field="plans_group"] .dropdown .theme-dropdown-items-list').html(groups);
            
        } else {

            // Prepare no groups message
            let no_groups = '<li class="list-group-item">'
                + '<p>'
                    + data.message
                + '</p>'
            + '</li>';
                    
            // Display message
            $('.user-page [data-field="plans_group"] .dropdown .theme-dropdown-items-list').html(no_groups);

        }

    };

    /*
     * Display components and apps response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.5
     */
    Main.methods.user_display_components_and_apps_response = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Apps list
            var apps = '';

            // List all apps
            for ( var p = 0; p < data.apps.length; p++ ) {

                apps += '<li class="list-group-item">'
                            + '<a href="#" data-id="' + data.apps[p].slug + '">'
                                + data.apps[p].name
                            + '</a>'
                        + '</li>';

            }

            // Display all apps
            $('.user-page [data-field="user_redirect"] .dropdown .theme-dropdown-items-list').html(apps);
            
        } else {

            // Prepare the no components and apps message
            let message = '<li class="list-group-item">'
                + '<p>'
                    + data.message
                + '</p>'
            + '</li>';

            // Display no contents found
            $('.user-page [data-field="user_redirect"] .dropdown .theme-dropdown-items-list').html(message);
            
        }

    };
    
    /*******************************
    FORMS
    ********************************/
   
    /*
     * Create a new plan
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.9
     */
    $('#new-plan .create-plan').submit(function (e) {
        e.preventDefault();
        
        // Prepare data to send
        var data = {
            action: 'create_new_plan',
            plan_name: $(this).find('.plan_name').val(),
            group_id: $(this).find('.select-plans-group').attr('data-id')
        };
        
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/user', 'POST', data, 'create_new_plan', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
    });
 
});