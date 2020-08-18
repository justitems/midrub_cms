/*
 * Roles javascript file
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
            page: page
        };

        // Set CSRF
        data[$('.teams-page .roles-actions').attr('data-name')] = $('.teams-page .roles-actions').attr('data-value');
        
        // Make ajax call
        Main.ajax_call(url + 'user/component-ajax/team', 'POST', data, 'team_all_roles');
        
    };
    
    /*******************************
    ACTIONS
    ********************************/

    /*
     * Detect all roles selection
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.2
     */ 
    $( document ).on( 'click', '.teams-page #all-roles-select', function (e) {

        // Select or unselect checkboxes
        setTimeout(function(){
            
            // Verify if the checkbox is checked
            if ( $( '.teams-page #all-roles-select' ).is(':checked') ) {

                // Check all checkboxes
                $( '.teams-page input[type="checkbox"]' ).prop('checked', true);

            } else {

                // Uncheck all checkboxes
                $( '.teams-page input[type="checkbox"]' ).prop('checked', false);

            }
        
        },500);
        
    });

    /*
     * Detect roles action
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.2
     */ 
    $( document ).on( 'click', '.teams-page .actions-roles > a', function (e) {
        e.preventDefault();

        // Get action id
        let action = $(this).attr('data-id');

        // Selected roles array
        var selected_roles = [];

        // Get all selected roles
        let roles = $('.teams-page .team-list input[type="checkbox"]');

        // List all roles
        for ( var r = 0; r < roles.length; r++ ) {

            // Verify if the checkbox is checked
            if ( $(roles[r]).is(':checked') ) {

                // Set member
                selected_roles.push($(roles[r]).attr('data-id'));

            }

        }

        // Prepare data to send
        var data = {
            action: 'roles_action_execute',
            selected_action: action,
            selected_roles: selected_roles
        };

        // Set CSRF
        data[$(this).closest('.dropdown').find('.roles-actions').attr('data-name')] = $(this).closest('.dropdown').find('.roles-actions').attr('data-value');
        
        // Make ajax call
        Main.ajax_call(url + 'user/component-ajax/team', 'POST', data, 'roles_action_execute');

        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });

    /*
     * Detect pagination click
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.2
     */ 
    $( document ).on( 'click', 'body .pagination a', function (e) {
        e.preventDefault();
        
        // Get page number
        var page = $(this).attr('data-page');

        // Load results
        if ( $(this).closest('.pagination').attr('data-type') === 'roles' ) {
        
            // Load team's roles
            Main.load_team_roles(page);
            
        }

        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });
    
    /*******************************
    RESPONSES
    ********************************/

    /*
     * Display roles response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.2
     */
    Main.methods.team_all_roles = function ( status, data ) {

        // Hide the pagination
        $('.team-list .panel-footer').hide();

        // Uncheck all checboxes
        $('.team-list [type="checkbox"]').prop('checked', false);

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Display the pagination
            $('.team-list .panel-footer').show();

            // Set limit
            let limit = ((data.page * 10) < data.total)?(data.page * 10):data.total;

            // Display the results
            $('.team-list .panel-footer h6').text((((data.page - 1) * 10) + 1) + '-' + limit + ' ' + data.words.of + ' ' + data.total + ' ' + data.words.results);
            
            // Allroles variable
            var allroles = '';

            // List all roles
            for (var u = 0; u < data.roles.length; u++) {

                // Set member
                allroles += '<div class="member-single" data-id="' + data.roles[u].role_id + '">'
                                + '<div class="row">'
                                    + '<div class="col-xl-10 media">'
                                        + '<label>'
                                            + '<input type="checkbox" id="member-' + data.roles[u].role_id + '" data-id="' + data.roles[u].role_id + '" />'
                                            + '<span class="checkmark"></span>'
                                        + '</label>'
                                        + '<div class="media-body">'
                                            + '<h5>'
                                                + '<a href="' + url + 'user/team?p=roles&role=' + data.roles[u].role_id + '">'
                                                    + data.roles[u].role
                                                + '</a>'
                                            + '</h5>'
                                            + '<p>'
                                                + '<svg class="bi bi-people m-0 mr-1" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">'
                                                    + '<path fill-rule="evenodd" d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.995-.944v-.002.002zM7.022 13h7.956a.274.274 0 0 0 .014-.002l.008-.002c-.002-.264-.167-1.03-.76-1.72C13.688 10.629 12.718 10 11 10c-1.717 0-2.687.63-3.24 1.276-.593.69-.759 1.457-.76 1.72a1.05 1.05 0 0 0 .022.004zm7.973.056v-.002.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10c-1.668.02-2.615.64-3.16 1.276C1.163 11.97 1 12.739 1 13h3c0-1.045.323-2.086.92-3zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/>'
                                                + '</svg>'
                                                + data.roles[u].number + ' ' + data.words.members
                                            + '</p>'
                                        + '</div>'
                                    + '</div>'
                                + '</div>'
                            + '</div>';

            }

            // Display roles list
            $( '.team-list .roles-list' ).html( allroles );

            // Pagination
            if ( data.page < 2 ) {
                    
                $('.team-list .page-item').eq(0).addClass('pagehide');                
                
            } else {
                
                $('.team-list .page-item').eq(0).removeClass('pagehide');
                $('.team-list .page-item').eq(0).find('.page-link').attr('data-page', (parseInt(data.page) - 1));
                
            }

            if ( (parseInt(data.page) * 10 ) < parseInt(data.total) ) {

                $('.team-list .page-item').eq(1).removeClass('pagehide');
                $('.team-list .page-item').eq(1).find('.page-link').attr('data-page', (parseInt(data.page) + 1));
                
            } else {
                
                $('.team-list .page-item').eq(1).addClass('pagehide');

            }
            
        } else {

            // Prepare the no roles found message
            let message = '<p class="no-roles-found">'
                            + data.message
                        + '</p>';
            
            // Display the no roles found message
            $( '.team-list .roles-list' ).html(message);
            
        }

    };

    /*
     * Display the roles action response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.2
     */
    Main.methods.roles_action_execute = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
            // Load team's roles
            Main.load_team_roles(1);
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);            
            
        }

    };
   
    /*******************************
    FORMS
    ********************************/

    // Load team's roles
    Main.load_team_roles(1);
 
});