/*
 * All Members JavaScript file
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
     * Load members by page
     * 
     * @param integer page contains the page number
     * @param integer progress contains the progress option
     * 
     * @since   0.0.8.3
     */    
    Main.members_get_members =  function (page, progress) {

        // Prepare data to send
        var data = {
            action: 'members_get_members',
            key: $('.members-page .theme-search-for-members').val(),
            page: page
            
        };
        
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');

        // Verify if progress exists
        if ( typeof progress !== 'undefined' ) {

            // Make ajax call
            Main.ajax_call(url + 'admin/ajax/members', 'POST', data, 'members_display_members_response', 'ajax_onprogress');

            // Set progress bar
            Main.set_progress_bar();

        } else {

            // Make ajax call
            Main.ajax_call(url + 'admin/ajax/members', 'POST', data, 'members_display_members_response');

        }
        
    };

    /*
     * Get the countries
     * 
     * @since   0.0.8.5
     */    
    Main.members_get_countries =  function () {

        // Prepare data to send
        var data = {
            action: 'members_get_countries',
            key: $('.members-page [data-field="country"] .dropdown .theme-dropdown-search-for-items').val()
            
        };
        
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');     
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/members', 'POST', data, 'members_display_countries_response');
        
    };

    /*
     * Get the plans
     * 
     * @since   0.0.8.5
     */    
    Main.members_get_plans =  function () {

        // Prepare data to send
        var data = {
            action: 'members_get_plans',
            key: $('.members-page [data-field="plan"] .dropdown .theme-dropdown-search-for-items').val()
            
        };
        
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');     
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/members', 'POST', data, 'members_display_plans_response');
        
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

        // Verify if member list page
        if ( $('.members-page .theme-button-new').length > 0 ) {

            // Load all members by page
            Main.members_get_members(1);

        }

    });

    /*
     * Detect countries dropdown show
     * 
     * @since   0.0.8.5
     */ 
    $( '.members-page [data-field="country"] .dropdown' ).on( 'show.bs.dropdown', function () {

        // Reset input
        $('.members-page [data-field="country"] .dropdown .theme-dropdown-search-for-items').val('');
        
        // Get the countries
        Main.members_get_countries();
        
    });

    /*
     * Detect plan dropdown show
     * 
     * @since   0.0.8.5
     */ 
    $( '.members-page [data-field="plan"] .dropdown' ).on( 'show.bs.dropdown', function () {

        // Reset input
        $('.members-page [data-field="plan"] .dropdown .theme-dropdown-search-for-items').val('');
        
        // Get the plans
        Main.members_get_plans();
        
    });

    /*
     * Search members
     * 
     * @since   0.0.8.3
     */
    $(document).on('keyup', '.members-page .theme-search-for-members', function () {

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

                // Load all members by page
                Main.members_get_members(1, 1);

            }, 1000);

        } else {

            // Set opacity
            $this.closest('div').find('a').removeAttr('style');

            // Load all members by page
            Main.members_get_members(1, 1);
            
        }
        
    });

    /*
     * Search for countries
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.5
     */
    $(document).on('keyup', '.members-page [data-field="country"] .dropdown .theme-dropdown-search-for-items', function (e) {
        e.preventDefault();

        // Verify if an event was already scheduled
        if ( typeof Main.queue !== 'undefined' ) {

            // Clear previous timout
            clearTimeout(Main.queue);

        }

        // Schedule event
        Main.schedule_event(function() {

            // Get the countries
            Main.members_get_countries();

            // Set progress bar
            Main.set_progress_bar();

        }, 1000);  

    });

    /*
     * Search for plans
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.5
     */
    $(document).on('keyup', '.members-page [data-field="plan"] .dropdown .theme-dropdown-search-for-items', function (e) {
        e.preventDefault();

        // Verify if an event was already scheduled
        if ( typeof Main.queue !== 'undefined' ) {

            // Clear previous timout
            clearTimeout(Main.queue);

        }

        // Schedule event
        Main.schedule_event(function() {

            // Get the plans
            Main.members_get_plans();

            // Set progress bar
            Main.set_progress_bar();

        }, 1000);  

    });

    /*
     * Cancel the search for members
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.5
     */ 
    $( document ).on( 'click', '.members-page .theme-cancel-search', function (e) {
        e.preventDefault();

        // Empty search input
        $('.members-page .theme-search-for-members').val('');

        // Set opacity
        $(this).closest('div').find('a').removeAttr('style');

        // Load all members by page
        Main.members_get_members(1, 1);
        
    });

    /*
     * Delete member by id
     * 
     * @since   0.0.8.3
     */
    $(document).on('click', '.members-page .theme-list .members-delete-member', function (e) {
        e.preventDefault();

        // Prepare data to send
        var data = {
            action: 'members_delete_member',
            member_id: $(this).closest('.card-member').attr('data-member')
        };

		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');    
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/members', 'POST', data, 'delete_member_response', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
    });

    /*
     * Delete members by id
     * 
     * @since   0.0.8.3
     */
    $(document).on('click', '.members-page .members-delete-members', function (e) {
        e.preventDefault();

        // Define the members ids variable
        var members_ids = [];

        // Get selected members ids
        $('.members-page .theme-list > .card-body input[type="checkbox"]:checkbox:checked').each(function () {
            members_ids.push($(this).closest('.card-member').attr('data-member'));
        });

        // Prepare data to send
        var data = {
            action: 'members_delete_members',
            members_ids: members_ids
        };

		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');    
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/members', 'POST', data, 'delete_members_response', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
    });

    /*
     * Displays pagination by page click
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.3
     */    
    $( document ).on( 'click', '.members-page .theme-pagination li a', function (e) {
        e.preventDefault();
        
        // Get the page number
        var page = $(this).attr('data-page');

        // Display results
        switch ($(this).closest('ul').attr('data-type')) {

            case 'members':

                // Load all members by page
                Main.members_get_members(page, 1);              

                break;

        }
        
    });

    /*
     * Detect checkbox check
     * 
     * @since   0.0.8.5
     */ 
    $( document ).on( 'click', '.members-page .theme-list > .card-body input[type="checkbox"]', function () {

        // Show the action
        if ( $('.members-page .theme-list > .card-body :checkbox:checked').length > 0 ) {

            // Show actions
            $('.members-page .card-actions').slideDown('slow');

            // Set selected items
            $('.members-page .theme-list .theme-list-selected-items p').html($('.members-page .theme-list > .card-body :checkbox:checked').length + ' ' + words.selected_items);

        } else {

            // Hide actions
            $('.members-page .card-actions').slideUp('slow');
            
        }
        
    });

    /*
     * Save settings
     * 
     * @since   0.0.7.8
     */ 
    $( document ).on( 'click', 'body .theme-save-changes .theme-save-changes-btn', function () {
        
        // Get all dropdowns
        var dropdowns = $('.members-page .theme-dynamic-dropdown').length;
        
        var all_dropdowns = [];

        if (dropdowns > 0) {

            for (var d = 0; d < dropdowns; d++) {

                if ($('.members-page .theme-dynamic-dropdown').eq(d).attr('data-id')) {

                    all_dropdowns[$('.members-page .theme-dynamic-dropdown').eq(d).closest('.list-group-item').attr('data-field')] = $('.members-page .theme-dynamic-dropdown').eq(d).attr('data-id');

                }

            }

        }

        // Get all text inputs
        var text_inputs = $('.members-page .theme-text-input-1').length;
        
        var all_textareas = [];

        if (text_inputs > 0) {

            for (var t = 0; t < text_inputs; t++) {

                all_textareas[$('.members-page .theme-text-input-1').eq(t).closest('.list-group-item').attr('data-field')] = $('.members-page .theme-text-input-1').eq(t).val().replace(/</g,"&lt;").replace(/>/g,"&gt;");

            }

        }

        // Get all password inputs
        var password_inputs = $('.members-page .theme-password-input-1').length;

        if (password_inputs > 0) {

            for (var p = 0; p < password_inputs; p++) {

                all_textareas[$('.members-page .theme-password-input-1').eq(p).closest('.list-group-item').attr('data-field')] = $('.members-page .theme-password-input-1').eq(p).val().replace(/</g,"&lt;").replace(/>/g,"&gt;");

            }

        }

        // Get all checkboxes inputs
        var checkboxes = $('.members-page .theme-field-checkbox').length;

        // Verify if checkboxes exists
        if (checkboxes > 0) {

            for ( var c = 0; c < checkboxes; c++ ) {

                if ( $('.members-page .theme-field-checkbox').eq(c).is(':checked') ) {
                
                    all_textareas[$('.members-page .theme-field-checkbox').eq(c).closest('.list-group-item').attr('data-field')] = 1;
                    
                } else {
                    
                    all_textareas[$('.members-page .theme-field-checkbox').eq(c).closest('.list-group-item').attr('data-field')] = 0;
                    
                }

            }

        }

        // Get all textareas
        var textareas = $('.members-page .theme-textarea-1').length;

        // Verify if textareas exists
        if (textareas > 0) {

            // List all textareas
            for (var t = 0; t < textareas; t++) {

                // Append textarea's value
                all_textareas[$('.members-page .theme-textarea-1').eq(t).closest('.list-group-item').attr('data-field')] = $('.members-page .theme-textarea-1').eq(t).val().replace(/</g,"&lt;").replace(/>/g,"&gt;");

            }

        }

        // Define data to send
        var data = {
            action: 'members_save_member',
            all_dropdowns: Object.entries(all_dropdowns),
            all_textareas: Object.entries(all_textareas)
        };

        // Verify if member's ID exists
        if ( $('.members-page .panel-member-information').attr('data-member') ) {

            // Set member's ID
            data['member_id'] = $('.members-page .panel-member-information').attr('data-member');

        }
        
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/members', 'POST', data, 'members_save_member', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
    });
   
    /*******************************
    RESPONSES
    ********************************/ 

    /*
     * Display members
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.3
     */
    Main.methods.members_display_members_response = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();

        // Hide pagination
        $('.members-page .theme-list > .card-footer').hide(); 

        // Hide actions
        $('.members-page .card-actions').slideUp('slow');

        // Verify if the success response exists
        if ( status === 'success' ) {

            // All members
            var all_members = '';
            
            // List all members
            for ( var m = 0; m < data.members.length; m++ ) {
                
                // Set name
                var name = (data.members[m].first_name)?data.members[m].first_name + ' ' + data.members[m].last_name:data.members[m].username;

                // Position 
                var position = data.words.administrator;

                // Verify role
                if ( parseInt(data.members[m].role) < 1 ) {

                    // Set new position
                    position = data.words.user;

                }

                // Member's status
                var member_status = '<span class="badge bg-primary theme-badge-1">'
                    + data.words.active
                + '</span>';

                // Verify if status is inactive
                if ( parseInt(data.members[m].status) === 0 ) {

                    // New member's status
                    member_status = '<span class="badge bg-light theme-badge-1">'
                        + data.words.inactive
                    + '</span>';                    

                } else if ( parseInt(data.members[m].status) === 2 ) {

                    // New member's status
                    member_status = '<span class="badge bg-danger theme-badge-1">'
                        + data.words.blocked
                    + '</span>';                    

                }

                // Set member
                all_members += '<div class="card theme-box-1 card-member" data-member="' + data.members[m].user_id + '">'
                    + '<div class="card-header">'
                        + '<div class="row">'
                            + '<div class="col-lg-10 col-md-8 col-xs-8">'
                                + '<div class="media d-flex justify-content-start">'
                                    + '<div class="theme-checkbox-input-1">'
                                        + '<label for="members-single-' + data.members[m].user_id + '">'
                                            + '<input type="checkbox" id="members-single-' + data.members[m].user_id + '" data-member="' + data.members[m].user_id + '">'
                                            + '<span class="theme-checkbox-checkmark"></span>'
                                        + '</label>'
                                    + '</div>'
                                    + '<div class="media-body">'
                                        + '<h5>'
                                            + '<a href="' + url + 'admin/members?p=all_members&member=' + data.members[m].user_id + '">'
                                                + name
                                            + '</a>'
                                        + '</h5>'
                                    + '</div>'
                                + '</div>'
                            + '</div>'
                            + '<div class="col-lg-1 col-md-2 col-xs-2">'
                                + member_status
                            + '</div>'
                            + '<div class="col-lg-1 col-md-2 col-xs-2 text-end">'
                                + '<div class="btn-group theme-dropdown-2">'
                                    + '<button type="button" class="btn dropdown-toggle text-end" aria-haspopup="true" aria-expanded="false" data-bs-toggle="dropdown">'
                                        + words.icon_more
                                    + '</button>'
                                    + '<ul class="dropdown-menu">'
                                        + '<li>'
                                            + '<a href="#" class="members-delete-member">'
                                                + words.icon_delete
                                                + data.words.delete
                                            + '</a>'
                                        + '</li>'
                                    + '</ul>'
                                + '</div>'
                            + '</div>'
                        + '</div>'
                    + '</div>'
                + '</div>';

            }

            // Display members
            $('.members-page .theme-list > .card-body').html(all_members);   
            
            // Set limit
            let limit = ((data.page * 10) < data.total)?(data.page * 10):data.total;

            // Set text
            $('.members-page .theme-list > .card-footer h6').html((((data.page - 1) * 10) + 1) + '-' + limit + ' ' + data.words.of + ' ' + data.total + ' ' + data.words.results);

            // Set page
            Main.pagination.page = data.page;

            // Display the pagination
            Main.show_pagination('.members-page .theme-list', data.total);

            // Show pagination
            $('.members-page .theme-list > .card-footer').show();  
            
        } else {

            // Set no data found message
            var no_data = '<p class="theme-box-1 theme-list-no-results-found">'
                                + data.message
                            + '</p>';

            // Display the no data found message
            $('.members-page .theme-list > .card-body').html(no_data);   
            
        }

    };

    /*
     * Display the member saving response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.3
     */
    Main.methods.members_save_member = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();
        
        // Verify if the success response exists
        if ( status === 'success' ) {

            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);

            // Hide the save button
            $('body .theme-save-changes').slideUp('slow');

            // Verify if member's id exists
            if ( typeof data.member !== 'undefined' ) {

                // Set pause
                Main.schedule_event(function() {

                    // Redirect
                    document.location.href = url + 'admin/members?p=all_members&member=' + data.member;

                }, 3000);

            }
            
        } else {
            
            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);            
            
        }

    }

    /*
     * Display member deletion response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.3
     */
    Main.methods.delete_member_response = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);
            
            // Load all members by page
            Main.members_get_members(1);
            
        } else {
            
            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);
            
        }

    };

    /*
     * Display member deletion response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.3
     */
    Main.methods.delete_members_response = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);
            
            // Load all members by page
            Main.members_get_members(1);
            
        } else {
            
            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);
            
        }

    };

    /*
     * Display the countries response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.5
     */
    Main.methods.members_display_countries_response = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Countries container
            var countries = '';

            // List all countries
            for ( var c = 0; c < data.countries.length; c++ ) {

                // Add country to the container
                countries += '<li class="list-group-item">'
                    + '<a href="#" data-id="' + data.countries[c].id + '">'
                        + data.countries[c].name
                    + '</a>'
                + '</li>';

            }

            // Display the countries
            $('.members-page [data-field="country"] .dropdown .theme-dropdown-items-list').html(countries);
            
        } else {

            // Prepare the no countries found message
            let no_countries_found = '<li class="list-group-item">'
                + '<p>'
                    + data.message
                + '</p>'
            + '</li>';
            
            // Display the no countries found message
            $('.members-page [data-field="country"] .dropdown .theme-dropdown-items-list').html(no_countries_found);

        }
        
    };

    /*
     * Display the plans response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.5
     */
    Main.methods.members_display_plans_response = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Plans container
            var plans = '';

            // List all plans
            for ( var p = 0; p < data.plans.length; p++ ) {

                // Add plan to the container
                plans += '<li class="list-group-item">'
                    + '<a href="#" data-id="' + data.plans[p].id + '">'
                        + data.plans[p].name
                    + '</a>'
                + '</li>';

            }

            // Display the plans
            $('.members-page [data-field="plan"] .dropdown .theme-dropdown-items-list').html(plans);
            
        } else {

            // Prepare the no plans found message
            let no_plans_found = '<li class="list-group-item">'
                + '<p>'
                    + data.message
                + '</p>'
            + '</li>';
            
            // Display the no plans found message
            $('.members-page [data-field="plan"] .dropdown .theme-dropdown-items-list').html(no_plans_found);

        }
        
    };
 
});