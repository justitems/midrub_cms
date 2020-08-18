/*
 * Team javascript file
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
     * Load the team's members
     * 
     * @param integer page contains the page number
     * 
     * @since   0.0.7.0
     */
    Main.load_team_members = function (page) {
        
        // Prepare data to send
        var data = {
            action: 'team_all_members',
            page: page
        };
        
        // Make ajax call
        Main.ajax_call(url + 'user/component-ajax/team', 'GET', data, 'all_team_members');
        
    };

    /*
     * Load the team's roles
     * 
     * @param integer page contains the page number
     * 
     * @since   0.0.7.9
     */
    Main.load_team_roles = function (page) {

        // Prepare data to send
        var data = {
            action: 'team_all_roles',
            page: page
        };
        
        // Make ajax call
        Main.ajax_call(url + 'user/component-ajax/team', 'GET', data, 'team_all_roles');
        
    };

    /*
     * Load total team's roles
     * 
     * @since   0.0.7.9
     */
    Main.load_total_team_roles = function () {

        // Prepare data to send
        var data = {
            action: 'team_total_roles',
        };
        
        // Make ajax call
        Main.ajax_call(url + 'user/component-ajax/team', 'GET', data, 'team_total_roles');
        
    };
    
    /*******************************
    ACTIONS
    ********************************/
   
    /*
     * Detect when roles modal opens
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.9
     */     
    $('.main #member-roles-popup').on('show.bs.modal', function (e) {

        // Load team's roles
        Main.load_team_roles(1);

    });

    /*
     * Load the member info
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.0
     */
    $(document).on('click', '.team-member-list .team-member-info', function (e) {
        e.preventDefault();
        
        // Empty fields
        $('#nav-member-info .member-id').empty();
        $('#nav-member-info .last-access').empty();
        $('#nav-member-info .joined-on').empty();
        $('#nav-member-info .member-status').empty();
        $('#nav-member-info .member-role').empty();
        $('#nav-member-info .about-member').empty();
        $('#nav-member-settings .username').val('');
        $('#nav-member-settings .email').val('');
        $('#nav-member-settings .member-role').val(0);
        $('#nav-member-settings .member-status').val(0);
        $('#nav-member-settings .member-about').val('');
        $('#nav-member-settings .password').val('');
        $('#nav-member-info-tab').click();
        $('.confirm').hide();
        
        // Get member's id
        var member_id = $(this).attr('data-id');
        
        // Prepare data to send
        var data = {
            action: 'team_member_info',
            member_id: member_id
        };
        
        // Make ajax call
        Main.ajax_call(url + 'user/component-ajax/team', 'GET', data, 'team_member_info');
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });
    
    /*
     * Delete the member button click
     * 
     * @since   0.0.7.0
     */
    $(document).on('click', '.delete-member', function () {
        
        // Display confirm link
        $('.confirm').fadeIn('slow');
        
    });
    
    /*
     * Cancel member deletion
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.0
     */    
    $(document).on('click', '.confirm .no', function (e) {
        e.preventDefault();
        
        $('.confirm').fadeOut('slow');
        
    });
    
    /*
     * Delete member
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.0
     */ 
    $(document).on('click', '.delete-member-account', function (e) {
        e.preventDefault();
        
        // Get member's id
        var member_id = $('.update-member-data').attr('data-id');

        // Prepare data to send
        var data = {
            action: 'team_member_delete',
            member_id: member_id
        };

        // Make ajax call
        Main.ajax_call(url + 'user/component-ajax/team', 'GET', data, 'team_member_delete');
        
    });

    /*
     * Detect when collapse opens
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.9
     */     
    $(document).on('click', '.main #member-roles-popup .btn-link', function (e) {

        // Get role's id
        var role_id = $(this).attr('data-id');

        // Prepare data to send
        var data = {
            action: 'team_get_permissions',
            role_id: role_id
        };

        // Make ajax call
        Main.ajax_call(url + 'user/component-ajax/team', 'GET', data, 'team_get_permissions');
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');

    });

    /*
     * Delete a team's role
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.9
     */     
    $(document).on('click', '.main #member-roles-popup .btn-delete-link', function (e) {

        // Get role's id
        var role_id = $(this).attr('data-id');

        // Prepare data to send
        var data = {
            action: 'team_delete_role',
            role_id: role_id
        };

        // Make ajax call
        Main.ajax_call(url + 'user/component-ajax/team', 'GET', data, 'team_delete_role');
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');

    });

    /*
     * Detect when permission is enabled/disabled
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.9
     */     
    $(document).on('click', '.main #member-roles-popup .permission-checkbox', function (e) {

        // Get role's id
        var role_id = $(this).attr('data-role');

        // Get permission
        var permission = $(this).attr('data-permission');

        // Create an object with form data
        var data = {
            action: 'save_role_permission',
            role_id: role_id,
            permission: permission
        };
        
        // Set CSRF
        data[$('.create-new-role').attr('data-csrf')] = $('input[name="' + $('.create-new-role').attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'user/component-ajax/team', 'POST', data, 'save_role_permission');
        
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
                
            case 'team-roles':

                // Load team's roles
                Main.load_team_roles(page);

                break;
            
        }
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
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
            
            // Load team's members
            Main.load_team_members(1);
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }

    };
    
    /*
     * Display team member update response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.0
     */
    Main.methods.team_update_member_response = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
            // Get member's id
            var member_id = $('.update-member-data').attr('data-id');

            // Prepare data to send
            var data = {
                action: 'team_member_info',
                member_id: member_id
            };

            // Make ajax call
            Main.ajax_call(url + 'user/component-ajax/team', 'GET', data, 'team_member_info');
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }

    };    
    
    /*
     * Display team's members
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.0
     */
    Main.methods.all_team_members = function ( status, data ) {

        // Reload the roles list
        Main.load_total_team_roles();

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            var members = '';
            
            for ( var m = 0; m < data.members.length; m++ ) {
                
                members += '<article class="col-xl-2">'
                                + '<figure class="theme-box">'
                                    + '<a href="#" data-toggle="modal" class="team-member-info" data-target="#team-member-info" data-id="' + data.members[m].member_id + '">'
                                        + '<img src="' + data.members[m].picture + '">'
                                    + '</a>'
                                    + '<header>'
                                        + '<div class="row">'
                                            + '<div class="col-xl-10">'
                                                + data.members[m].username
                                            + '</div>'
                                            + '<div class="col-xl-2 clean">'
                                                + '<a href="#" data-toggle="modal" class="team-member-info" data-target="#team-member-info" data-id="' + data.members[m].member_id + '">'
                                                    + '<i class="icon-info"></i>'
                                                + '</a>'
                                            + '</div>'
                                        + '</div>'
                                    + '</header>'
                                + '</figure>'
                            + '</article>';
                
            }
            
            $( '.team-member-list' ).html( members );
            
        } else {
            
            $( '.team-member-list' ).html( '<div class="col-xl-12"><p>' + data.message + '</p></div>' );
            
        }

    };
    
    /*
     * Display member's info
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.0
     */
    Main.methods.team_member_info = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            if ( data.member_info[0].last_access > data.member_info[0].date_joined ) {
                var last_access = Main.calculate_time( data.date, data.member_info[0].last_access );
            } else {
                var last_access = data.never;
            }

            // Display member's info
            $('#nav-member-info .member-id').html(data.member_info[0].member_username);
            $('#nav-member-info .last-access').html(last_access);
            $('#nav-member-info .joined-on').html(Main.calculate_time( data.date, data.member_info[0].date_joined ));
            $('#nav-member-info .member-role').html(data.member_info[0].role);
            $('#nav-member-info .about-member').html(data.member_info[0].about_member);
            $('#nav-member-settings .username').val(data.member_info[0].member_username);
            $('#nav-member-settings .email').val(data.member_info[0].member_email);
            $('#nav-member-settings .member-role').val(data.member_info[0].role_id);
            $('#nav-member-settings .member-status').val(data.member_info[0].status);
            $('#nav-member-settings .member-about').val(data.member_info[0].about_member);
            $('#nav-member-info .member-status').html($( '#nav-member-settings .member-status option:selected' ).text());
            $('.update-member-data').attr('data-id', data.member_info[0].member_id);
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);            
            
        }

    };
    
    /*
     * Member deletion response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.0
     */
    Main.methods.team_member_delete = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Close modal
            $('#team-member-info').modal('hide');
            
            // Hide confirm
            $('.confirm').hide();
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
            // Load team's members
            Main.load_team_members(1);
            
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
     * @since   0.0.7.9
     */
    Main.methods.team_create_role = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);

            // Load team's roles
            Main.load_team_roles(1);

            // Reload the roles list
            Main.load_total_team_roles();

            // Reset form
            $('.main .team-new-role').val('');
            
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
     * @since   0.0.7.9
     */
    Main.methods.team_all_roles = function ( status, data ) {

        if ( status === 'success' ) {
            
            var allroles = '';

            Main.pagination.page = data.page;
            Main.show_pagination('#member-roles-popup', data.total);

            for (var u = 0; u < data.roles.length; u++) {

                // Add role
                allroles += '<div class="card">'
                    + '<div class="card-header" id="headingOne">'
                        + '<h2 class="mb-0">'
                            + '<div class="btn-group" role="group">'
                                + '<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-' + data.roles[u].role_id + '" aria-expanded="false" aria-controls="accordion-' + data.roles[u].role_id + '" data-id="' + data.roles[u].role_id + '">'
                                    + data.roles[u].role
                                + '</button>'
                                + '<button class="btn btn-delete-link" type="button" data-id="' + data.roles[u].role_id + '">'
                                    + '<i class="icon-trash"></i>'
                                + '</button>'   
                            + '</div>'                         
                        + '</h2>'
                    + '</div>'
                    + '<div id="accordion-' + data.roles[u].role_id + '" class="show-roles-options collapse" aria-labelledby="headingOne" data-parent="#accordion-' + data.roles[u].role_id + '">'
                        + '<div class="card-body">'
                        + '</div>'
                    + '</div>'
                + '</div>';

            }

            $('#member-roles-popup .accordion').html(allroles);
            
        } else {
            
            $('.panel-body .pagination').empty();
            
            $('#member-roles-popup .accordion').html('<p>' + data.message + '</p>');
            
        }

    };

    /*
     * Display total roles response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.9
     */
    Main.methods.team_total_roles = function ( status, data ) {

        if ( status === 'success' ) {
            
            var allroles = data.default;

            for (var u = 0; u < data.roles.length; u++) {
    
                // Add role
                allroles += '<option value="' + data.roles[u].role_id + '">'
                                + data.roles[u].role
                            + '</option>';
    
            }
    
            $('.new-member .member-role').html(allroles);
            $('.update-member-data .member-role').html(allroles);
            
        } else {
            
            var allroles = data.default;
    
            $('.new-member .member-role').html(allroles);
            $('.update-member-data .member-role').html(allroles);
            
        }

    };

    /*
     * Display permissions
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.9
     */
    Main.methods.team_get_permissions = function ( status, data ) {

        if ( status === 'success' ) {

            // Display permissions
            $('#member-roles-popup #accordion-' + data.role_id + ' .card-body').html(data.permissions);
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);            
            
        }

    };

    /*
     * Display team's role
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.9
     */
    Main.methods.team_delete_role = function ( status, data ) {

        if ( status === 'success' ) {

            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);

            // Load team's roles
            Main.load_team_roles(1);

            // Reload the roles list
            Main.load_total_team_roles();

            // Load Team's members
            Main.load_team_members(1);
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);            
            
        }

    };

    /*
     * Display permission saving response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.9
     */
    Main.methods.save_role_permission = function ( status, data ) {

        if ( status === 'success' ) {

            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);            
            
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
     * @since   0.0.7.0
     */
    $('.new-member').submit(function (e) {
        e.preventDefault();
        
        // Create an object with form data
        var data = {
            action: 'team_new_member',
            username: $(this).find('.username').val(),
            email: $(this).find('.email').val(),
            role_id: $(this).find('.member-role').val(),
            status: $(this).find('.member-status').val(),
            about: $(this).find('.member-about').val(),
            password: $(this).find('.password').val()
        };
        
        // Set CSRF
        data[$('.new-member').attr('data-csrf')] = $('input[name="' + $('.new-member').attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'user/component-ajax/team', 'POST', data, 'team_new_member_response');
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });
    
    /*
     * Update member data
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.0
     */
    $('.update-member-data').submit(function (e) {
        e.preventDefault();
        
        // Create an object with form data
        var data = {
            action: 'team_update_member',
            username: $('#nav-member-settings .username').val(),
            email: $('#nav-member-settings .email').val(),
            role_id: $('#nav-member-settings .member-role').val(),
            status: $('#nav-member-settings .member-status').val(),
            about: $('#nav-member-settings .member-about').val(),
            password: $('#nav-member-settings .password').val()
        };
        
        // Set CSRF
        data[$('.new-member').attr('data-csrf')] = $('input[name="' + $('.new-member').attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'user/component-ajax/team', 'POST', data, 'team_update_member_response');
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });

    /*
     * Create new team's role
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.9
     */
    $('.create-new-role').submit(function (e) {
        e.preventDefault();
        
        // Create an object with form data
        var data = {
            action: 'team_create_role',
            role: $('#member-roles-popup .team-new-role').val()
        };
        
        // Set CSRF
        data[$('.create-new-role').attr('data-csrf')] = $('input[name="' + $('.create-new-role').attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'user/component-ajax/team', 'POST', data, 'team_create_role');
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });
    
    // Verify if the location has a hash
    if ( window.location.hash ) {

        var hash = window.location.hash;
        
        hash = hash.replace('#', '');

        var data = {
            action: 'team_member_info',
            member_id: hash
        };
        
        // Make ajax call
        Main.ajax_call(url + 'user/component-ajax/team', 'GET', data, 'team_member_info');
        
        // Show modal
        $('#team-member-info').modal('show');
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');

    }
    
    /*
     * Load team's members
     * 
     * @since   0.0.7.0
     */
    Main.load_team_members(1);
 
});