/*
 * Acivities
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
     * Display activities_load_activities loads all activities
     * 
     * @param integer page contains the page number
     * 
     * @since   0.0.7.0
     */
    Main.load_activities = function (page) {
        
        // Prepare data to send
        var data = {
            action: 'activities_load_activities',
            member_id: $('.activities-page-header .filter-members-btn').attr('data-id'),
            type: $('.activities-page-header .filter-types-btn').attr('data-id'),
            order: $('.activities-page-header .order-activities-btn').attr('data-id'),
            page: page
        };

        // Set CSRF
        data[$('.activities-page-header').attr('data-name')] = $('.activities-page-header').attr('data-value');
        
        // Make ajax call
        Main.ajax_call(url + 'user/component-ajax/activities', 'POST', data, 'activities_load_activities');
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    };

    /*
     * Load the team's members
     * 
     * @since   0.0.8.2
     */
    Main.load_team_members = function () {
        
        // Prepare data to send
        var data = {
            action: 'load_team_members',
            key: $('.activities-page-header .search-members').val()
        };

        // Set CSRF
        data[$('.activities-page-header').attr('data-name')] = $('.activities-page-header').attr('data-value');

        // Make ajax call
        Main.ajax_call(url + 'user/component-ajax/activities', 'POST', data, 'load_team_members');
        
    };

    /*
     * Load the activities types
     * 
     * @since   0.0.8.2
     */
    Main.load_activities_types = function () {
        
        // Prepare data to send
        var data = {
            action: 'load_activities_types',
            key: $('.activities-page-header .search-types').val()
        };

        // Set CSRF
        data[$('.activities-page-header').attr('data-name')] = $('.activities-page-header').attr('data-value');

        // Make ajax call
        Main.ajax_call(url + 'user/component-ajax/activities', 'POST', data, 'load_activities_types');
        
    };

    /*******************************
    ACTIONS
    ********************************/
   
    /*
     * Search the members
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.2
     */
    $(document).on('keyup', '.activities-page-header .search-members', function (e) {
        e.preventDefault();

        // Load team's members 
        Main.load_team_members();

    });

    /*
     * Search the types
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.2
     */
    $(document).on('keyup', '.activities-page-header .search-types', function (e) {
        e.preventDefault();

        // Load activities types
        Main.load_activities_types();

    });

    /*
     * Detect load more click
     * 
     * @since   0.0.7.0
     */
    $(document).on('click', '.activities-pagination-load', function (e) {
        e.preventDefault();
        
        // Define the page
        Main.page = Main.page + 1;        

        // Load activities 
        Main.load_activities(Main.page);        
        
    });

    /*
     * Change the dropdown
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.2
     */
    $(document).on('click', '.activities-page .dropdown-menu a', function (e) {
        e.preventDefault();

        // Get the department's text
        let text = $(this).text();

        // Get the id
        let id = $(this).attr('data-id');

        if ( $(this).closest('.dropdown-menu').hasClass('members-filter-activities') ) {

            // If is members, add icon
            text = '<svg class="bi bi-people" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">'
                        + '<path fill-rule="evenodd" d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.995-.944v-.002.002zM7.022 13h7.956a.274.274 0 0 0 .014-.002l.008-.002c-.002-.264-.167-1.03-.76-1.72C13.688 10.629 12.718 10 11 10c-1.717 0-2.687.63-3.24 1.276-.593.69-.759 1.457-.76 1.72a1.05 1.05 0 0 0 .022.004zm7.973.056v-.002.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10c-1.668.02-2.615.64-3.16 1.276C1.163 11.97 1 12.739 1 13h3c0-1.045.323-2.086.92-3zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/>'
                    + '</svg>'
                    + text;    
                    
            // Show reset button
            $('.activities-page .btn-reset-filters').fadeIn('slow');

        } else if ( $(this).closest('.dropdown-menu').hasClass('types-filter-activities') ) {

            // If is types, add icon
            text = '<svg class="bi bi-file-plus" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">'
                        + '<path d="M9 1H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V8h-1v5a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h5V1z"/>'
                        + '<path fill-rule="evenodd" d="M13.5 1a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1H13V1.5a.5.5 0 0 1 .5-.5z"/>'
                        + '<path fill-rule="evenodd" d="M13 3.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0v-2z"/>'
                    + '</svg>'
                    + text;  
                    
            // Show reset button
            $('.activities-page .btn-reset-filters').fadeIn('slow');

        } else if ( $(this).closest('.dropdown-menu').hasClass('order-activities') ) {

            // If is order, add icon
            text = '<svg class="bi bi-arrow-up-down" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">'
                        + '<path fill-rule="evenodd" d="M11 3.5a.5.5 0 01.5.5v9a.5.5 0 01-1 0V4a.5.5 0 01.5-.5z" clip-rule="evenodd"/>'
                        + '<path fill-rule="evenodd" d="M10.646 2.646a.5.5 0 01.708 0l3 3a.5.5 0 01-.708.708L11 3.707 8.354 6.354a.5.5 0 11-.708-.708l3-3zm-9 7a.5.5 0 01.708 0L5 12.293l2.646-2.647a.5.5 0 11.708.708l-3 3a.5.5 0 01-.708 0l-3-3a.5.5 0 010-.708z" clip-rule="evenodd"/>'
                        + '<path fill-rule="evenodd" d="M5 2.5a.5.5 0 01.5.5v9a.5.5 0 01-1 0V3a.5.5 0 01.5-.5z" clip-rule="evenodd"/>'
                    + '</svg>'
                    + text;      

        }

        // Set arrow down
        text = text
                + '<svg class="bi bi-chevron-down" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">'
                    + '<path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>'
                + '</svg>';

        // Display the selected item
        $(this).closest('.dropdown').find('.btn-secondary').html(text);
        $(this).closest('.dropdown').find('.btn-secondary').attr('data-id', id);

        // Empty activities
        $('.all-activities-list').empty();

        // Load activities 
        Main.load_activities(1);

    });

    /*
     * Reset the filters
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.3
     */
    $(document).on('click', '.activities-page .btn-reset-filters', function (e) {
        e.preventDefault();

        // Set members content
        var members = '<svg class="bi bi-people" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">'
                        + '<path fill-rule="evenodd" d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.995-.944v-.002.002zM7.022 13h7.956a.274.274 0 0 0 .014-.002l.008-.002c-.002-.264-.167-1.03-.76-1.72C13.688 10.629 12.718 10 11 10c-1.717 0-2.687.63-3.24 1.276-.593.69-.759 1.457-.76 1.72a1.05 1.05 0 0 0 .022.004zm7.973.056v-.002.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10c-1.668.02-2.615.64-3.16 1.276C1.163 11.97 1 12.739 1 13h3c0-1.045.323-2.086.92-3zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/>'
                    + '</svg> '
                    + words.members
                    + ' <svg class="bi bi-chevron-down" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">'
                        + '<path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>'
                    + '</svg>';

        // Display members content
        $('.activities-page .filter-members-btn').html(members);

        // Remove attr
        $('.activities-page .filter-members-btn').removeAttr('data-id');

        // Set all types
        var all_types = '<svg class="bi bi-file-plus" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">'
                        + '<path d="M9 1H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V8h-1v5a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h5V1z"/>'
                        + '<path fill-rule="evenodd" d="M13.5 1a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1H13V1.5a.5.5 0 0 1 .5-.5z"/>'
                        + '<path fill-rule="evenodd" d="M13 3.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0v-2z"/>'
                    + '</svg> '
                    + words.all_types
                    + ' <svg class="bi bi-chevron-down" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">'
                        + '<path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>'
                    + '</svg>';

        // Display all types
        $('.activities-page .filter-types-btn').html(all_types); 

        // Remove attr
        $('.activities-page .filter-types-btn').removeAttr('data-id');        

        // Hide reset button
        $('.activities-page .btn-reset-filters').fadeOut('slow');

        // Define the page
        Main.page = 1;
    
        // Load activities 
        Main.load_activities(1);

        // Load team's members 
        Main.load_team_members();

        // Load activities types
        Main.load_activities_types();

    });
    
    /*******************************
    RESPONSES
    ********************************/
   
    /*
     * Display activities response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.0
     */
    Main.methods.activities_load_activities = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            var activities = data.activities;
            
            var all_activities = '';

            if ( data.total <= (Main.page * 10) ) {
                
                // Hide load more
                $('.activities-page-footer .activities-pagination-load').hide();
                
            } else {
                
                // Show load more
                $('.activities-page-footer .activities-pagination-load').show();
                
            }
            
            // Hide no activities found message
            $('.activities-page-footer .activities-no-found').hide();
            
            for ( var a = 0; a < activities.length; a++ ) {
                
                var time = Main.calculate_time(activities[a].time, data.date);
                
                if ( a % 2 === 0 ) {
                    
                    var body = '';
                    
                    if ( activities[a].body || activities[a].medias ) {
                        
                        body = '<div class="panel-body">'
                                    + activities[a].body
                                    + activities[a].medias
                                + '</div>';
                        
                    }
                    
                    var footer = '';
                    
                    if ( activities[a].footer ) {
                        
                        footer = '<div class="panel-footer">'
                                    + activities[a].footer
                                + '</div>';
                        
                    }                    
                    
                    all_activities += '<div class="row">'
                                        + '<div class="col-xl-5 clean">'
                                            + '<p class="text-right date-event">'
                                                + time
                                            + '</p>'
                                        + '</div>'
                                        + '<div class="col-xl-2 text-center clean">'
                                            + '<button type="button" class="published-button">'
                                                + activities[a].icon
                                            + '</button>'
                                        + '</div>'
                                        + '<div class="col-xl-5 clean">'
                                            + '<div class="panel theme-box">'
                                                + '<div class="panel-heading" id="accordion">'
                                                    + '<h3>'
                                                        + '<i class="icon-user"></i> ' + activities[a].header
                                                    + '</h3>'                                               
                                                + '</div>'
                                                + body
                                                + footer
                                                + '<div class="panel-row-left"></div>'
                                            + '</div>'
                                        + '</div>'
                                    + '</div>';
                    
                } else {
                    
                    all_activities += '<div class="row">'
                                        + '<div class="col-xl-5 clean">'
                                            + '<div class="panel theme-box">'
                                                + '<div class="panel-heading" id="accordion">'
                                                    + '<h3>'
                                                        + '<i class="icon-user"></i> ' + activities[a].header
                                                    + '</h3>'                                               
                                                + '</div>'
                                                + body
                                                + footer                                                
                                                + '<div class="panel-row-right"></div>'
                                            + '</div>'
                                        + '</div>'
                                        + '<div class="col-xl-2 text-center clean">'
                                            + '<button type="button" class="published-button">'
                                                + activities[a].icon
                                            + '</button>'
                                        + '</div>'
                                        + '<div class="col-xl-5 clean">'
                                            + '<p class="text-left date-event">'
                                                + time
                                            + '</p>'
                                        + '</div>'
                                    + '</div>';
                    
                }
                
            }
            
            // Append activities
            $('.all-activities-list').append(all_activities);
            
        } else {
            
            // Hide load more
            $('.activities-page-footer .activities-pagination-load').hide();
            
            // Show no activities found message
            $('.activities-page-footer .activities-no-found').show();
            
        }

    };

    /*
     * Display the team's members
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.2
     */
    Main.methods.load_team_members = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Members variable
            var members = '';

            // List all members
            for ( var m = 0; m < data.members.length; m++ ) {

                // Set the member
                members += '<a class="dropdown-item" href="#" data-id="' + data.members[m].member_id + '">'
                                    + data.members[m].username
                                + '</a>';

            }

            // Display the members
            $('.activities-page-header .members-filter-activities > div').html(members);

        } else {
            
            // Prepare no members message
            let message = '<p>'
                            + data.message
                        '</p>';

            // Display the message
            $('.activities-page-header .members-filter-activities > div').html(message);
            
        }

    };

    /*
     * Display the activities types
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.2
     */
    Main.methods.load_activities_types = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Types variable
            var types = '';

            // List all types
            for ( var t = 0; t < data.types.length; t++ ) {

                // Set the type
                types += '<a class="dropdown-item" href="#" data-id="' + data.types[t].template + '">'
                            + data.types[t].template.charAt(0).toUpperCase() + data.types[t].template.slice(1)
                        + '</a>';

            }

            // Display the types
            $('.activities-page-header .types-filter-activities > div').html(types);

        } else {
            
            // Prepare no types message
            let message = '<p>'
                            + data.message
                        '</p>';

            // Display the message
            $('.activities-page-header .types-filter-activities > div').html(message);
            
        }

    };
   
    // Define the page
    Main.page = 1;
   
    // Load activities 
    Main.load_activities(1);

    // Load team's members 
    Main.load_team_members();

    // Load activities types
    Main.load_activities_types();
   
});