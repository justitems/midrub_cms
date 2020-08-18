/*
 * Plans javascript file
*/

jQuery(document).ready( function ($) {
    'use strict';
    
    // Get home page url
    var url = $('.navbar-brand').attr('href');
    
    /*******************************
    METHODS
    ********************************/

    /*
     * Load plans
     * 
     * @param integer page contains the page number
     * 
     * @since   0.0.7.9
     */    
    Main.user_load_plans = function (page) {

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
        
        // Set the CSRF field
        data[$('#new-plan .create-plan').attr('data-csrf')] = $('input[name="' + $('#new-plan .create-plan').attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/user', 'POST', data, 'load_all_plans');
        
    };

    /*
     * Load the plan's dropdowns
     * 
     * @since   0.0.8.2
     */    
    Main.user_load_plan_dropdowns = function () {

        // Verify if the plan's dropdown exists
        if ( $('.user-page .user-plan-dropdown').length > 0 ) {
            
            // List all dropdowns
            for ( var d = 0; d < $('.user-page .user-plan-dropdown').length; d++ ) {

                // Get dropdown's url
                let dropdown_url = $('.user-page .user-plan-dropdown').eq(d).attr('data-url');     

                // Prepare data to send
                var data = {
                    action: 'reload_plan_dropdown',
                    plan_id: $('.user-page .update-plan').attr('data-plan-id'),
                    option: $('.user-page .user-plan-dropdown').eq(d).attr('data-option')
                };
                
                // Set CSRF field
                data[$('#new-plan .create-plan').attr('data-csrf')] = $('input[name="' + $('#new-plan .create-plan').attr('data-csrf') + '"]').val();

                // Make ajax call
                Main.ajax_call(dropdown_url, 'POST', data, 'reload_plan_dropdown');

            }

        }
        
    };

    /*
     * Display plans pagination
     */
    Main.show_plans_pagination = function( id, total ) {
        
        // Empty pagination
        $( id + ' .pagination' ).empty();
        
        // Verify if page is not 1
        if ( parseInt(Main.pagination.page) > 1 ) {
            
            var bac = parseInt(Main.pagination.page) - 1;
            var pages = '<li><a href="#" data-page="' + bac + '">' + translation.mm128 + '</a></li>';
            
        } else {
            
            var pages = '<li class="pagehide"><a href="#">' + translation.mm128 + '</a></li>';
            
        }
        
        // Count pages
        var tot = parseInt(total) / 20;
        tot = Math.ceil(tot) + 1;
        
        // Calculate start page
        var from = (parseInt(Main.pagination.page) > 2) ? parseInt(Main.pagination.page) - 2 : 1;
        
        // List all pages
        for ( var p = from; p < parseInt(tot); p++ ) {
            
            // Verify if p is equal to current page
            if ( p === parseInt(Main.pagination.page) ) {
                
                // Display current page
                pages += '<li class="active"><a data-page="' + p + '">' + p + '</a></li>';
                
            } else if ( (p < parseInt(Main.pagination.page) + 3) && (p > parseInt(Main.pagination.page) - 3) ) {
                
                // Display page number
                pages += '<li><a href="#" data-page="' + p + '">' + p + '</a></li>';
                
            } else if ( (p < 6) && (Math.round(tot) > 5) && ((parseInt(Main.pagination.page) === 1) || (parseInt(Main.pagination.page) === 2)) ) {
                
                // Display page number
                pages += '<li><a href="#" data-page="' + p + '">' + p + '</a></li>';
                
            } else {
                
                break;
                
            }
            
        }
        
        // Verify if current page is 1
        if (p === 1) {
            
            // Display current page
            pages += '<li class="active"><a data-page="' + p + '">' + p + '</a></li>';
            
        }
        
        // Set the next page
        var next = parseInt( Main.pagination.page );
        next++;
        
        // Verify if next page should be displayed
        if (next < Math.round(tot)) {
            
            $( id + ' .pagination' ).html( pages + '<li><a href="#" data-page="' + next + '">' + translation.mm129 + '</a></li>' );
            
        } else {
            
            $( id + ' .pagination' ).html( pages + '<li class="pagehide"><a href="#">' + translation.mm129 + '</a></li>' );
            
        }
        
    };

    /*
     * Load plans groups
     * 
     * @param integer page contains the page number
     * 
     * @since   0.0.8.2
     */    
    Main.user_load_plans_groups = function (page) {

        var data = {
            action: 'load_all_plans_groups',
            page: page,
        };
        
        // Set the CSRF field
        data[$('#new-plan .create-plan').attr('data-csrf')] = $('input[name="' + $('#new-plan .create-plan').attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/user', 'POST', data, 'load_all_plans_groups');
        
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
        
        // Set the CSRF field
        data[$('#new-plan .create-plan').attr('data-csrf')] = $('input[name="' + $('#new-plan .create-plan').attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/user', 'POST', data, 'user_load_plans_groups_for_dropdown');
        
    };

    /*******************************
    ACTIONS
    ********************************/

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
     * Search plans
     * 
     * @since   0.0.7.9
     */
    $(document).on('keyup', '.user-page .user-search-for-plans', function () {
        
        // Load all plans by key
        Main.user_load_plans(1);
        
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
     * Search for dropdown items
     * 
     * @since   0.0.8.2
     */
    $(document).on('keyup', '.user-page .search-dropdown-items', function () {

        // Get dropdown's url
        let dropdown_url = $(this).closest('.dropdown').find('.btn-secondary').attr('data-url');     
        
        // Prepare data to send
        var data = {
            action: 'reload_plan_dropdown',
            plan_id: $('.user-page .update-plan').attr('data-plan-id'),
            option: $(this).closest('.dropdown').find('.btn-secondary').attr('data-option'),
            key: $(this).val()
        };
        
        // Set the CSRF field
        data[$('#new-plan .create-plan').attr('data-csrf')] = $('input[name="' + $('#new-plan .create-plan').attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(dropdown_url, 'POST', data, 'user_show_dropdown_items');
        
    });

    /*
     * Display save changes button
     * 
     * @since   0.0.7.9
     */
    $(document).on('keyup', 'body .plan-input', function () {

        // Display save button
        $('.settings-save-changes').fadeIn('slow');
        
    }); 
    
    /*
     * Display save changes button
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.9
     */
    $(document).on('change', 'body .plan-option-checkbox', function (e) {
        
        // Display save button
        $('.settings-save-changes').fadeIn('slow');
        
    }); 

    /*
     * Detect all plans selection
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.9
     */ 
    $( document ).on( 'click', '.user-page #user-plans-select-all', function (e) {
        
        setTimeout(function(){
            
            if ( $( '.user-page #user-plans-select-all' ).is(':checked') ) {

                $( '.user-page .list-contents li input[type="checkbox"]' ).prop('checked', true);

            } else {

                $( '.user-page .list-contents li input[type="checkbox"]' ).prop('checked', false);

            }
        
        },500);
        
    });

    /*
     * Delete plans
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.9
     */ 
    $( document ).on( 'click', '.user-page .delete-plans', function (e) {
        e.preventDefault();
    
        // Define the plans ids variable
        var plans_ids = [];
        
        // Get selected plans ids
        $('.user-page .list-contents li input[type="checkbox"]:checkbox:checked').each(function () {
            plans_ids.push($(this).attr('data-id'));
        });

        // Create an object with form data
        var data = {
            action: 'delete_plans',
            plans_ids: plans_ids
        };
        
        // Set the CSRF field
        data[$('.user-page .csrf-sanitize').attr('name')] = $('.user-page .csrf-sanitize').val();
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/user', 'POST', data, 'delete_plans_response');

        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });

    /*
     * Displays pagination by page click
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.9
     */    
    $( document ).on( 'click', 'body .pagination li a', function (e) {
        e.preventDefault();
        
        // Get the page number
        var page = $(this).attr('data-page');
        
        // Display results
        switch ( $(this).closest('ul').attr('data-type') ) {
            
            case 'plans':
                
                // Load all plans by page
                Main.user_load_plans(page);

                break;  
                
            case 'plans-groups':
            
                // Load all plans groups by page
                Main.user_load_plans_groups(page);

                break;  
            
        }
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });

    /*
     * Save settings
     * 
     * @since   0.0.7.9
     */ 
    $( document ).on( 'click', '.user-page .settings-save-changes .btn', function () {

        // Hide save button
        $('.user-page .settings-save-changes').fadeOut('slow');
        
        // Get all inputs
        var inputs = $('.user-page .update-plan .plan-input').length;
        
        // All inputs array
        var all_inputs = [];
        
        // List all inputs
        for ( var i = 0; i < inputs; i++ ) {
            
            // Set input
            all_inputs[$('.user-page .update-plan .plan-input').eq(i).attr('id')] = $('.user-page .update-plan .plan-input').eq(i).val();
            
        }

        // Verify if the plan's dropdown exists
        if ( $('.user-page .user-plan-dropdown').length > 0 ) {
            
            // List all dropdowns
            for ( var d = 0; d < $('.user-page .user-plan-dropdown').length; d++ ) {

                // Get dropdown's id
                let dropdown_id = $('.user-page .user-plan-dropdown').eq(d).attr('data-id');

                // Verify if dropdown_id exists
                if ( dropdown_id ) {
                
                    // Set dropdown's id as input
                    all_inputs[$('.user-page .user-plan-dropdown').eq(d).attr('data-option')] = dropdown_id;

                }

            }

        }
        
        // Get all options
        var options = $('.user-page .update-plan .plan-option-checkbox').length;
        
        // All options array
        var all_options = [];
        
        // List all options
        for ( var o = 0; o < options; o++ ) {
            
            // Verify if option is checked
            if ( $('.user-page .update-plan .plan-option-checkbox').eq(o).is(':checked') ) {
                all_options[$('.user-page .update-plan .plan-option-checkbox').eq(o).attr('id')] = 1;
            } else {
                all_options[$('.user-page .update-plan .plan-option-checkbox').eq(o).attr('id')] = 0;
            }
            
        }        

        // Prepare data to send
        var data = {
            action: 'update_a_plan',
            plan_id: $('.user-page .update-plan').attr('data-plan-id'),
            all_inputs: Object.entries(all_inputs),
            all_options: Object.entries(all_options)
        };
        
        // Set CSRF field
        data[$('#new-plan .create-plan').attr('data-csrf')] = $('input[name="' + $('#new-plan .create-plan').attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/user', 'POST', data, 'update_a_plan');

        // Show loading animation
        $('.page-loading').fadeIn('slow');
        
    });

    /*
     * Show the plans groups
     * 
     * @since   0.0.8.2
     */ 
    $( document ).on( 'click', '#new-plan .select-plans-group', function () {      

        // Load all plans groups for dropdown
        Main.user_load_plans_groups_for_dropdown();
        
    });    

    /*
     * Create a plans group
     * 
     * @since   0.0.8.2
     */ 
    $( document ).on( 'click', '#new-plan .save-plan-group', function () {      

        // Prepare data to send
        var data = {
            action: 'create_plans_group',
            group_name: $('#new-plan  .enter-group-name').val()
        };
        
        // Set CSRF field
        data[$('#new-plan .create-plan').attr('data-csrf')] = $('input[name="' + $('#new-plan .create-plan').attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/user', 'POST', data, 'create_plans_group');

        // Show loading animation
        $('.page-loading').fadeIn('slow');
        
    });

    /*
     * Delete a plans group
     * 
     * @since   0.0.8.2
     */ 
    $( document ).on( 'click', '#new-plan .btn-delete-plan-group', function () {      

        // Prepare data to send
        var data = {
            action: 'delete_plans_group',
            group_id: $(this).attr('data-id')
        };
        
        // Set CSRF field
        data[$('#new-plan .create-plan').attr('data-csrf')] = $('input[name="' + $('#new-plan .create-plan').attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/user', 'POST', data, 'delete_plans_group');

        // Show loading animation
        $('.page-loading').fadeIn('slow');
        
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
        $(this).closest('.input-group-btn').find('.btn-default').html(text);
        $(this).closest('.input-group-btn').find('.btn-default').attr('data-id', id);

    });

    /*
     * Change the plans dropdowns
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.2
     */
    $(document).on('click', '.user-page .dropdown.open .dropdown-items-list a', function (e) {
        e.preventDefault();

        // Get the item's name
        let text = $(this).text();

        // Get the item's id
        let id = $(this).attr('data-id');

        // Display the selected item
        $(this).closest('.dropdown').find('.btn-secondary').html(text);
        $(this).closest('.dropdown').find('.btn-secondary').attr('data-id', id);

        // Display save button
        $('.settings-save-changes').fadeIn('slow');

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

        // Uncheck all selection plans
        $( '.user-page #user-plans-select-all' ).prop('checked', false)

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Generate pagination
            Main.pagination.page = data.page;
            Main.show_plans_pagination('.user-page', data.total);

            // All plans
            var all_plans = '';
            
            // List all plans
            for ( var c = 0; c < data.plans.length; c++ ) {

                // Set plan
                all_plans += '<li class="contents-single" data-id="' + data.plans[c].plan_id + '">'
                    + '<div class="row">'
                        + '<div class="col-lg-10 col-md-8 col-xs-8">'
                            + '<div class="checkbox-option-select">'
                                + '<input id="user-plans-single-' + data.plans[c].plan_id + '" name="user-plans-single-' + data.plans[c].plan_id + '" data-id="' + data.plans[c].plan_id + '" type="checkbox">'
                                + '<label for="user-plans-single-' + data.plans[c].plan_id + '"></label>'
                            + '</div>'
                            + '<a href="' + url + 'admin/user?p=plans&plan_id=' + data.plans[c].plan_id + '">'
                                + data.plans[c].plan_name
                            + '</a>'
                        + '</div>'
                        + '<div class="col-lg-2 col-md-2 col-xs-2">'
                        + '</div>'
                    + '</div>'
                + '</li>';

            }

            // Get the page
            var page = ( (data.page - 1) < 1)?1:((data.page - 1) * 20);

            // Get results to
            var to = ((parseInt(page) * 20) < data.total)?(parseInt(data.page) * 20):data.total;

            // Display plans
            $('.user-page .list-contents').html(all_plans);

            // Display start listing
            $('.user-page .pagination-from').text(page);  
            
            // Display end listing
            $('.user-page .pagination-to').text(to);  

            // Display total items
            $('.user-page .pagination-total').text(data.total);

            // Show Pagination
            $('.user-page .pagination-area').show();  
            
        } else {

            // Hide Pagination
            $('.user-page .pagination-area').hide();  
            
            // Set no data found message
            var no_data = '<li>'
                                + data.message
                            + '</li>';

            // Display plans
            $('.user-page .list-contents').html(no_data);   
            
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

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
            // Redirect user to the plan's page
            setTimeout(function(){
                document.location.href = url + 'admin/user?p=plans&plan_id=' + data.plan_id;
            }, 3000);
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
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

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
            // Load all plans by key
            Main.user_load_plans(1);
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
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
    Main.methods.update_a_plan = function ( status, data ) {
        
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
     * Display the plans group creation response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.2
     */
    Main.methods.create_plans_group = function ( status, data ) {
        
        // Verify if the success response exists
        if ( status === 'success' ) {

            // Load all plans groups
            Main.user_load_plans_groups(1);

            // Load all plans groups for dropdown
            Main.user_load_plans_groups_for_dropdown();
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);

            // Empty the group's name input
            $('#new-plan  .enter-group-name').val('');
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
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

        // Empty pagination
        $('#new-plan .pagination').empty();

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
                groups += '<li class="list-group-item">'
                            + '<span class="badge">'
                                + '<button class="btn btn-link btn-delete-plan-group" type="button" data-id="' + data.groups[g].group_id + '">'
                                    + '<i class="icon-trash"></i>'
                                + '</button>'          
                            + '</span>'
                            + data.groups[g].group_name
                        + '</li>';

            }

            // Display the groups
            $('#new-plan .plans-groups-by-page').html(groups);
            
        } else {
            
            // Prepare no groups message
            var no_groups = '<li class="no-groups-found">'
                                    + data.message
                                + '</li>';
                    
            // Display message
            $('#new-plan .plans-groups-by-page').html(no_groups);

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
            var no_groups = '<li class="no-groups-found">'
                                    + data.message
                                + '</li>';
                    
            // Display message
            $('#new-plan .plans-groups-list').html(no_groups);

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
        
        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);

            // Load all plans groups
            Main.user_load_plans_groups(1);
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }

    };

    /*
     * Display the plan's dropdowns
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.2
     */
    Main.methods.reload_plan_dropdown = function ( status, data ) {
        
        // Verify if the success response exists
        if ( status === 'success' ) {

            // Verify if the default select exists
            if ( typeof data.response.default !== 'undefined' ) {

                // Display the select default message
                $('.user-page .user-plan-dropdown[data-option="' + data.option + '"]').html(data.response.default);

            } else {

                // Display the selected item's Name
                $('.user-page .user-plan-dropdown[data-option="' + data.option + '"]').html(data.response.selected.name);

                // Set the selected item's ID
                $('.user-page .user-plan-dropdown[data-option="' + data.option + '"]').attr('data-id', data.response.selected.id);

            }

            // Verify if the response has items
            if ( typeof data.response.items !== 'undefined' ) {
                
                // Items variable
                var items = '';

                // List all items
                for ( var i = 0; i < data.response.items.length; i++ ) {

                    // Set item
                    items += '<li class="list-group-item">'
                                + '<a href="#" data-id="' + data.response.items[i].id + '">'
                                    + data.response.items[i].name
                                + '</a>'
                            + '</li>';

                }

                // Display the items
                $('.user-page .user-plan-dropdown[data-option="' + data.option + '"]').closest('.dropdown').find('.list-group').html(items);
                
            } else {
                
                // Prepare no items message
                var no_items = '<li class="list-group-item no-results-found">'
                                        + data.response.no_items_message
                                    + '</li>';
                        
                // Display message
                $('.user-page .user-plan-dropdown[data-option="' + data.option + '"]').closest('.dropdown').find('.list-group').html(no_items);

            }
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);            
            
        }

    };

    /*
     * Display the dropdown's items in a plan
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.2
     */
    Main.methods.user_show_dropdown_items = function ( status, data ) {
        
        // Verify if the success response exists
        if ( status === 'success' ) {

            // Verify if the response has items
            if ( typeof data.response.items !== 'undefined' ) {
                
                // Items variable
                var items = '';

                // List all items
                for ( var i = 0; i < data.response.items.length; i++ ) {

                    // Set item
                    items += '<li class="list-group-item">'
                                + '<a href="#" data-id="' + data.response.items[i].id + '">'
                                    + data.response.items[i].name
                                + '</a>'
                            + '</li>';

                }

                // Display the items
                $('.user-page .dropdown.open .dropdown-items-list').html(items);
                
            } else {
                
                // Prepare no items message
                var no_items = '<li class="list-group-item no-results-found">'
                                        + data.response.no_items_message
                                    + '</li>';
                        
                // Display message
                $('.user-page .dropdown.open .dropdown-items-list').html(no_items);

            }
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);            
            
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
        data[$(this).attr('data-csrf')] = $('input[name="' + $(this).attr('data-csrf') + '"]').val();

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/user', 'POST', data, 'create_new_plan');
        
    });
    
    /*******************************
    DEPENDENCIES
    ********************************/

    // Hide loading animation
    $('.page-loading').fadeOut('slow');

    // Load all plans
    Main.user_load_plans(1);

    // Load plan's dropdowns
    Main.user_load_plan_dropdowns();
 
});