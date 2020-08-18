/*
 * Members javascript file
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
     * @since   0.0.8.2
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
    
    /*******************************
    ACTIONS
    ********************************/

    /*
     * Detect all members selection
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.2
     */ 
    $( document ).on( 'click', '.teams-page #all-members-select', function (e) {

        // Select or unselect checkboxes
        setTimeout(function(){
            
            // Verify if the checkbox is checked
            if ( $( '.teams-page #all-members-select' ).is(':checked') ) {

                // Check all checkboxes
                $( '.teams-page input[type="checkbox"]' ).prop('checked', true);

            } else {

                // Uncheck all checkboxes
                $( '.teams-page input[type="checkbox"]' ).prop('checked', false);

            }
        
        },500);
        
    });

    /*
     * Detect members action
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.2
     */ 
    $( document ).on( 'click', '.teams-page .actions-members > a', function (e) {
        e.preventDefault();

        // Get action id
        let action = $(this).attr('data-id');

        // Selected members array
        var selected_members = [];

        // Get all selected members
        let members = $('.teams-page .members-list input[type="checkbox"]');

        // List all members
        for ( var c = 0; c < members.length; c++ ) {

            // Verify if the checkbox is checked
            if ( $(members[c]).is(':checked') ) {

                // Set member
                selected_members.push($(members[c]).attr('data-id'));

            }

        }

        // Prepare data to send
        var data = {
            action: 'members_action_execute',
            selected_action: action,
            selected_members: selected_members
        };

        // Set CSRF
        data[$(this).closest('.dropdown').find('.members-actions').attr('data-name')] = $(this).closest('.dropdown').find('.members-actions').attr('data-value');
        
        // Make ajax call
        Main.ajax_call(url + 'user/component-ajax/team', 'POST', data, 'members_action_execute');

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
        if ( $(this).closest('.pagination').attr('data-type') === 'members' ) {
        
            // Load team's members
            Main.load_team_members(page);
            
        }

        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });

    /*******************************
    RESPONSES
    ********************************/
    
    /*
     * Display team's members
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.2
     */
    Main.methods.all_team_members = function ( status, data ) {

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
            
            // Members variable
            var members = '';
            
            // List all members
            for ( var m = 0; m < data.members.length; m++ ) {

                // Get the joined date
                let joined_date = Main.calculate_time(data.time, data.members[m].date_joined).replace(/<\/?[^>]+(>|$)/g, "");

                // Last access default
                let last_access = data.words.never;

                // Verify if last access exists
                if ( parseInt(data.members[m].last_access) > 0 ) {

                    // Change the last access
                    last_access = Main.calculate_time(data.time, data.members[m].last_access).replace(/<\/?[^>]+(>|$)/g, "");

                }

                // Status
                var status = '<a class="btn btn-secondary theme-color-green" href="#">'
                                + '<svg class="bi bi-shift theme-color-green" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">'
                                    + '<path fill-rule="evenodd" d="M7.27 2.047a1 1 0 0 1 1.46 0l6.345 6.77c.6.638.146 1.683-.73 1.683H11.5v3a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1v-3H1.654C.78 10.5.326 9.455.924 8.816L7.27 2.047zM14.346 9.5L8 2.731 1.654 9.5H4.5a1 1 0 0 1 1 1v3h5v-3a1 1 0 0 1 1-1h2.846z"/>'
                                + '</svg>'
                                + data.words.active
                            + '</a>';

                // Verify if the status is inactive
                if ( parseInt(data.members[m].status) > 0 ) {

                    // Set inactive status
                    var status = '<a class="btn btn-secondary theme-color-red" href="#">'
                                    + '<svg class="bi bi-shift theme-color-red" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">'
                                        + '<path fill-rule="evenodd" d="M7.27 2.047a1 1 0 0 1 1.46 0l6.345 6.77c.6.638.146 1.683-.73 1.683H11.5v3a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1v-3H1.654C.78 10.5.326 9.455.924 8.816L7.27 2.047zM14.346 9.5L8 2.731 1.654 9.5H4.5a1 1 0 0 1 1 1v3h5v-3a1 1 0 0 1 1-1h2.846z"/>'
                                    + '</svg>'
                                    + data.words.inactive
                                + '</a>';
                    
                }

                // Set member
                members += '<div class="member-single" data-id="' + data.members[m].member_id + '">'
                                + '<div class="row">'
                                    + '<div class="col-xl-10 col-lg-9 media">'
                                        + '<label>'
                                            + '<input type="checkbox" id="member-' + data.members[m].member_id + '" data-id="' + data.members[m].member_id + '" />'
                                            + '<span class="checkmark"></span>'
                                        + '</label>'
                                        + '<img class="mr-3" src="' + data.members[m].picture + '" alt="Member\'s Avatar" />'
                                        + '<div class="media-body">'
                                            + '<h5>'
                                                + '<a href="' + url + 'user/team?p=members&member=' + data.members[m].member_id + '">'
                                                    + data.members[m].username
                                                + '</a>'
                                            + '</h5>'
                                            + '<p>'
                                                + '<svg class="bi bi-person-plus" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">'
                                                    + '<path fill-rule="evenodd" d="M11 14s1 0 1-1-1-4-6-4-6 3-6 4 1 1 1 1h10zm-9.995-.944v-.002.002zM1.022 13h9.956a.274.274 0 00.014-.002l.008-.002c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664a1.05 1.05 0 00.022.004zm9.974.056v-.002.002zM6 7a2 2 0 100-4 2 2 0 000 4zm3-2a3 3 0 11-6 0 3 3 0 016 0zm4.5 0a.5.5 0 01.5.5v2a.5.5 0 01-.5.5h-2a.5.5 0 010-1H13V5.5a.5.5 0 01.5-.5z" clip-rule="evenodd"></path>'
                                                    + '<path fill-rule="evenodd" d="M13 7.5a.5.5 0 01.5-.5h2a.5.5 0 010 1H14v1.5a.5.5 0 01-1 0v-2z" clip-rule="evenodd"></path>'
                                                + '</svg>'
                                                + joined_date
                                                + '<svg class="bi bi-box-arrow-in-right" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">'
                                                    + '<path fill-rule="evenodd" d="M8.146 11.354a.5.5 0 0 1 0-.708L10.793 8 8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0z"/>'
                                                    + '<path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 1 8z"/>'
                                                    + '<path fill-rule="evenodd" d="M13.5 14.5A1.5 1.5 0 0 0 15 13V3a1.5 1.5 0 0 0-1.5-1.5h-8A1.5 1.5 0 0 0 4 3v1.5a.5.5 0 0 0 1 0V3a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v10a.5.5 0 0 1-.5.5h-8A.5.5 0 0 1 5 13v-1.5a.5.5 0 0 0-1 0V13a1.5 1.5 0 0 0 1.5 1.5h8z"/>'
                                                + '</svg>'
                                                + last_access
                                            + '</p>'
                                        + '</div>'
                                    + '</div>'
                                    + '<div class="col-xl-2 col-lg-3">'
                                        + '<div>'
                                            + '<a class="btn btn-secondary" href="#">'
                                                + '<svg class="bi bi-person-check" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">'
                                                    + '<path fill-rule="evenodd" d="M11 14s1 0 1-1-1-4-6-4-6 3-6 4 1 1 1 1h10zm-9.995-.944v-.002.002zM1.022 13h9.956a.274.274 0 0 0 .014-.002l.008-.002c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664a1.05 1.05 0 0 0 .022.004zm9.974.056v-.002.002zM6 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zm6.854.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>'
                                                + '</svg>'
                                                + data.members[m].role
                                            + '</a>'
                                        + '</div>'
                                        + '<div>'
                                            + status
                                        + '</div>'
                                    + '</div>'
                                + '</div>'
                            + '</div>';
                
            }
            
            // Display members list
            $( '.team-list .members-list' ).html( members );

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

            // Prepare the no members found message
            let message = '<p class="no-members-found">'
                            + data.message
                        + '</p>';
            
            // Display the no members found message
            $( '.team-list .members-list' ).html(message);
            
        }

    };

    /*
     * Display the members action response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.2
     */
    Main.methods.members_action_execute = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
            // Load team's members
            Main.load_team_members(1);
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);            
            
        }

    };
   
    /*******************************
    FORMS
    ********************************/

    // Load team's members
    Main.load_team_members(1);
 
});