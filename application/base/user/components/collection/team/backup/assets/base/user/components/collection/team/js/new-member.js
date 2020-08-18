/*
 * New Member javascript file
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
     * Load the team's roles
     * 
     * @param integer page contains the page number
     * 
     * @since   0.0.8.2
     */
    Main.load_team_roles = function (page) {

        // Prepare data to send
        var data = {
            action: 'team_all_roles',
            key: $('.create-member .search-roles').val(),
            page: page
        };

        // Set CSRF
        data[$('.create-member .new-member').attr('data-csrf')] = $('input[name="' + $('.create-member .new-member').attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'user/component-ajax/team', 'POST', data, 'team_all_roles');
        
    };
    
    /*******************************
    ACTIONS
    ********************************/

    /*
     * Search the roles in the dropdown
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.2
     */
    $(document).on('keyup', '.create-member .search-roles', function (e) {
        e.preventDefault();

        // Load team's roles
        Main.load_team_roles(1);

    });

    /*
     * Detect selected role button click
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.2
     */
    $(document).on('click', '.create-member .selected-member-role', function (e) {
        e.preventDefault();

        // Load team's roles
        Main.load_team_roles(1);

    });

    /*
     * Show or hide the new role creation in the New Member page
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.2
     */
    $(document).on('click', '.create-member .new-role', function (e) {
        e.preventDefault();

        // Show or hide
        $('.create-member .new-member-role-create').slideToggle('slow');

    });

    /*
     * Detect new role creation click
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.2
     */
    $(document).on('click', '.create-member .btn-create-role', function (e) {
        e.preventDefault();

        // Create an object with form data
        var data = {
            action: 'team_create_role',
            role: $('.create-member .role-name').val()
        };
        
        // Set CSRF
        data[$('.create-member .new-member').attr('data-csrf')] = $('input[name="' + $('.create-member .new-member').attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'user/component-ajax/team', 'POST', data, 'team_create_role');
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');

    });

    /*
     * Detect and change dropdown value
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.2
     */
    $(document).on('click', '.create-member .dropdown-menu div > a', function (e) {
        e.preventDefault();

        // Get the item's text
        let text = $(this).text();

        // Get the item's id
        let item_id = $(this).attr('data-id');

        // Set dropdown icon
        let dropdown_icon = '<svg class="bi bi-chevron-down" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">'
                                + '<path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>'
                            + '</svg>';

        // Display the selected department
        $(this).closest('.dropdown').find('.btn-secondary').html(text + ' ' + dropdown_icon);
        $(this).closest('.dropdown').find('.btn-secondary').attr('data-id', item_id);

    });

    /*******************************
    RESPONSES
    ********************************/
   
    /*
     * Display team new member creation response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.0
     */
    Main.methods.team_new_member_response = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
            // Reset form
            $('.new-member')[0].reset();

            // Set dropdown icon
            let dropdown_icon = '<svg class="bi bi-chevron-down" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">'
                                    + '<path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>'
                                + '</svg>';

            // Display the select members role words
            $('.create-member .selected-member-role').html(data.words.select_a_role + ' ' + dropdown_icon);
            
            // Display the select members status words
            $('.create-member .selected-member-status').html(data.words.select_a_status + ' ' + dropdown_icon);

            // Uncheck email notification
            $('.create-member #team-member-send-email').prop( 'checked', false );

            // Load team's roles
            Main.load_team_roles(1);
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }

    };
    
    /*
     * Display role creation response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.2
     */
    Main.methods.team_create_role = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);

            // Reset form
            $('.create-member .role-name').val('');
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);            
            
        }

    };

    /*
     * Display roles response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.2
     */
    Main.methods.team_all_roles = function ( status, data ) {

        // Verify if the response is success
        if ( status === 'success' ) {

            // Roles variable
            var roles = '';

            // List all roles
            for ( var r = 0; r < data.roles.length; r++ ) {

                // Set the role
                roles += '<a class="dropdown-item" href="#" data-id="' + data.roles[r].role_id + '">'
                            + data.roles[r].role
                        + '</a>';

            }

            // Display the roles
            $('.create-member .member-roles > div').html(roles);

        } else {
            
            // Prepare no roles message
            let message = '<p>'
                            + data.message
                        '</p>';

            // Display the message
            $('.create-member .member-roles > div').html(message);

        }

    };
   
    /*******************************
    FORMS
    ********************************/
   
    /*
     * Create a new team's member
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.2
     */
    $('.create-member .new-member').submit(function (e) {
        e.preventDefault();
        
        // Create an object with form data
        var data = {
            action: 'team_new_member',
            role_id: $(this).find('.selected-member-role').attr('data-id'),
            first_name: $(this).find('.first-name').val(),
            last_name: $(this).find('.last-name').val(),
            username: $(this).find('.username').val(),
            email: $(this).find('.email').val(),
            password: $(this).find('.password').val(),
            status: $(this).find('.selected-member-status').attr('data-id')
        };
        
        // Set CSRF
        data[$(this).attr('data-csrf')] = $('input[name="' + $(this).attr('data-csrf') + '"]').val();

        // Verify if the email notification should be sent
        if ( $(this).find('#team-member-send-email').is(':checked') ) {

            // Send notification status
            data['notification'] = 1;

        } else {

            // Send notification status
            data['notification'] = 0;

        }

        // Make ajax call
        Main.ajax_call(url + 'user/component-ajax/team', 'POST', data, 'team_new_member_response');
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });

    // Load team's roles
    Main.load_team_roles(1);
 
});