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
        
        var data = {
            action: 'activities_load_activities',
            page: page
        };
        
        // Make ajax call
        Main.ajax_call(url + 'user/ajax/activities', 'GET', data, 'activities_load_activities');
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    };
    
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
                                            + '<div class="panel">'
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
                                            + '<div class="panel">'
                                                + '<div class="panel-heading" id="accordion">'
                                                    + '<h3>'
                                                        + '<i class="icon-user"></i> ' + activities[a].header
                                                    + '</h3>'                                               
                                                + '</div>'
                                                + '<div class="panel-body">'
                                                    + activities[a].body
                                                    + activities[a].medias
                                                + '</div>'
                                                + '<div class="panel-footer">'
                                                    + activities[a].footer
                                                + '</div>'
                                                + '<div class="panel-row-right"></div>'
                                            + '</div>'
                                        + '</div>'
                                        + '<div class="col-xl-2 text-center clean">'
                                            + '<button type="button" class="published-button"><i class="icon-layers"></i></button>'
                                        + '</div>'
                                        + '<div class="col-xl-5 clean">'
                                            + '<p class="text-left date-event">'
                                                + time
                                            + '</p>'
                                        + '</div>'
                                    + '</div>';
                    
                }
                
            }
            
            $('.all-activities-list').append(all_activities);
            
        } else {
            
            // Hide load more
            $('.activities-page-footer .activities-pagination-load').hide();
            
            // Show no activities found message
            $('.activities-page-footer .activities-no-found').show();
            
        }

    };

    
    /*******************************
    ACTIONS
    ********************************/
   
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
   
    // Define the page
    Main.page = 1;
   
    // Load activities 
    Main.load_activities(1);
   
});