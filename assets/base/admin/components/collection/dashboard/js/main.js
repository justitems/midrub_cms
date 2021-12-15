/*
 * Main Dashboard JavaScript file
*/
jQuery(document).ready( function ($) {
    'use strict';

    // Get website url
    var url =  $('meta[name=url]').attr('content');
    
    /*******************************
    METHODS
    ********************************/

    /*
     * Reorder the widgets
     * 
     * @since   0.0.8.5
     */
    Main.dashboard_reorder_widgets = function() {

        // Widgets container
        var all_widgets = [];

        // Get the widgets
        let widgets = $('.dashboard-page .dashboard-widget');

        // Verify if widgets exists
        if ( widgets.length > 0 ) {

            // List the widgets
            for ( var w = 0; w < widgets.length; w++ ) {

                // Add widget's slug to the container
                all_widgets.push($(widgets[w]).attr('data-widget'));

            }

            // Prepare data to send
            var data = {
                action: 'dashboard_reorder_widgets',
                widgets: all_widgets
            };

            // Set CSRF
            data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');

            // Make ajax call
            Main.ajax_call(url + 'admin/ajax/dashboard', 'POST', data, 'dashboard_reorder_widgets_response', 'ajax_onprogress');

            // Set progress bar
            Main.set_progress_bar();

        }

    };

    /*
     * Gets events
     * 
     * @param string date contains the current date
     * @param integer progress contains the progress option
     * 
     * @since   0.0.8.5
     */
    Main.dashboard_get_events = function(date, progress) {

        // Prepare data to send
        var data = {
            action: 'dashboard_get_events',
            view: $('.dashboard-page .dashboard-events-list-btn').attr('data-view'),
            current: $('.dashboard-page .dashboard-events-navigation-btns').attr('data-time'),
            date: date
        };

        // Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');

        // Verify if progress exists
        if ( typeof progress !== 'undefined' ) {

            // Make ajax call
            Main.ajax_call(url + 'admin/ajax/dashboard', 'POST', data, 'dashboard_display_events_response', 'ajax_onprogress');

            // Set progress bar
            Main.set_progress_bar();

        } else {

            // Make ajax call
            Main.ajax_call(url + 'admin/ajax/dashboard', 'POST', data, 'dashboard_display_events_response');

        }

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

        // Get events
        Main.dashboard_get_events();

    });

    /*
     * Detect widget mouse down
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.3
     */
    $(document).on('mousedown', '.dashboard-page .dashboard-widget .card-header h3', function(e) {

        // Verify if the widget is active
        if ( $('.dashboard-page .dashboard-widget-active').length > 0 ) {

            // Remove the active status
            $('.dashboard-page .dashboard-widget-active').remove();

        }

        // Remove active drag
        $('.dashboard-page .dashboard-widget').removeClass('card-drag-active');
        
        // Set active drag
        $(this).closest('.dashboard-widget').addClass('card-drag-active');

        // Get width
        let width = $(this).closest('.dashboard-widget').outerWidth();

        // Get height
        let height = $(this).closest('.dashboard-widget').outerHeight();

        // Get top position
        let top = $(this).closest('.dashboard-widget').offset().top;

        // Clone
        let copy = $(this).closest('.dashboard-widget').clone();

        // Add active class
        copy.addClass('dashboard-widget-active');

        // Append to
        copy.appendTo('.dashboard-page .dashboard-widgets-list');

        // Add top distance
        copy.attr('data-top', (e.pageY - top));

        // Set CSS
        $('.dashboard-page .dashboard-widget-active').css({
            'position': 'absolute',
            'z-index': '10',
            'top': top + 'px',
            'left': '15px',
            'margin-top': '0',     
            'width': width + 'px',
            'height': height + 'px',
            'opacity': '0.3'
        });

        // Set body cursor
        $('body').css({
            'cursor': 'move'
        });

    });

    /*
     * Detect mouse move
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.3
     */
    $(document).on('mousemove', 'body', function(e) {
        e.preventDefault();

        if ( $('.dashboard-page .dashboard-widget-active').length > 0 ) {

            // Get all widgets
            let widgets = $('.dashboard-page .dashboard-widgets-list > .dashboard-widget');

            // Verify if widgets exists
            if ( widgets.length > 0 ) {

                // List all widgets
                for ( var w = 0; w < (widgets.length - 1); w++ ) {

                    if ( ( $(widgets[w]).offset().top <= e.pageY ) && ( e.pageY <= ( $(widgets[w]).offset().top + $(widgets[w]).outerHeight() ) ) ) {

                        if ( w < 1 ) {

                            if ( $(widgets[(w + 1)]).hasClass('card-drag-active') && ( $(widgets[w]).offset().top + 100) <= e.pageY ) {

                                $(widgets[w]).removeClass('card-drag-over-top');
                                $(widgets[w]).removeClass('card-drag-over-bottom');

                            } else {

                                if ( ( $(widgets[w]).offset().top + 100) >= e.pageY ) {

                                    if ( !$(widgets[w]).hasClass('card-drag-active') ) {
                                        $(widgets[w]).addClass('card-drag-over-top');
                                    }
    
                                    $(widgets[w]).removeClass('card-drag-over-bottom');
    
                                } else {
    
                                    $(widgets[w]).removeClass('card-drag-over-top');
    
                                    if ( !$(widgets[w]).hasClass('card-drag-active') ) {
                                        $(widgets[w]).addClass('card-drag-over-bottom');
                                    }
    
                                }

                            }

                        } else if ( w === (widgets.length - 2) ) {

                            $(widgets[w]).removeClass('card-drag-over-top');
                            
                            if ( !$(widgets[w]).hasClass('card-drag-active') ) {
                                $(widgets[w]).addClass('card-drag-over-bottom');
                            }                            

                        }  else if ( $(widgets[(w + 1)]).hasClass('card-drag-active') ) {

                            $(widgets[w]).removeClass('card-drag-over-top');
                            $(widgets[w]).removeClass('card-drag-over-bottom');

                        }else {

                            $(widgets[w]).removeClass('card-drag-over-top');

                            if ( !$(widgets[w]).hasClass('card-drag-active') ) {
                                $(widgets[w]).addClass('card-drag-over-bottom');
                            }

                        }

                    } else {

                        $(widgets[w]).removeClass('card-drag-over-top');
                        $(widgets[w]).removeClass('card-drag-over-bottom');

                    }

                }

            }

            // Set CSS
            $('.dashboard-page .dashboard-widget-active').css({
                'top': (e.pageY - $('.dashboard-page .dashboard-widget-active').attr('data-top')) + 'px'
            });

        } else {
            return;
        }

    });

    /*
     * Detect mouse up
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.3
     */
    $(document).on('mouseup', 'body', function(e) {
        e.preventDefault();

        // Verify if active widget exists
        if ( $('.dashboard-page .dashboard-widget-active').length > 0 ) {

            // Set scale
            $('.dashboard-page .card-drag-active').css({
                'transform': 'scale(0.7)'
            });        

            // Verify if dragover top exists
            if ( $('.dashboard-page .dashboard-widgets-list > .card-drag-over-top').length > 0 ) {

                // Copy dragged widget
                $('.dashboard-page .card-drag-active').insertBefore('.dashboard-page .dashboard-widgets-list > .card-drag-over-top');

                // Remove over class
                $('.dashboard-page .dashboard-widgets-list > .dashboard-widget').removeClass('card-drag-over-top');

            }            

            // Verify if dragover bottom exists
            if ( $('.dashboard-page .dashboard-widgets-list > .card-drag-over-bottom').length > 0 ) {

                // Copy dragged widget
                $('.dashboard-page .card-drag-active').insertAfter('.dashboard-page .dashboard-widgets-list > .card-drag-over-bottom');

                // Remove over class
                $('.dashboard-page .dashboard-widgets-list > .dashboard-widget').removeClass('card-drag-over-bottom');

            }

            // Schedule event
            setTimeout(function() {

                // Remove scale
                $('.dashboard-page .card-drag-active').css({
                    'transform': 'scale(1)'
                });                
                // Remove active drag
                $('.dashboard-page .dashboard-widget').removeClass('card-drag-active');

                // Reorder the widgets
                Main.dashboard_reorder_widgets();

            }, 100);  

            // Remove active widget
            $('.dashboard-page .dashboard-widget-active').remove();

            // Removy body cursor
            $('body').css({
                'cursor': ''
            });

        } else {
            return;
        }

    });

    /*
     * Go to oldest dates
     * 
     * @since   0.0.8.5
     */
    $(document).on('click', '.dashboard-page .dashboard-events-old-btn', function (e) {
        e.preventDefault();
        
        // Get events
        Main.dashboard_get_events($(this).attr('data-time'), 1);
        
    });

    /*
     * Go to newest dates
     * 
     * @since   0.0.8.5
     */
    $(document).on('click', '.dashboard-page .dashboard-events-new-btn', function (e) {
        e.preventDefault();
        
        // Get events
        Main.dashboard_get_events($(this).attr('data-time'), 1);
        
    });
   
    /*
     * Detect dropdown selection
     * 
     * @param integer page contains the page number
     * 
     * @since   0.0.8.5
     */ 
    $( document ).on( 'click', '.dashboard-page .dashboard-events-navigation-btns .dropdown-menu a', function (e) {
        e.preventDefault();
        
        // Get item's ID
        let item = $(this).attr('data-view');

        // Get item's name
        let item_name = $(this).text();

        // Set item's ID
        $(this).closest('.theme-dropdown-1').find('.dashboard-events-list-btn').attr('data-view', item);

        // Set item's name
        $(this).closest('.theme-dropdown-1').find('.dashboard-events-list-btn > span').text(item_name);   
        
        // Get events
        Main.dashboard_get_events('', 1);
        
    });

    /*******************************
    RESPONSES
    ********************************/

    /*
     * Display the widgets reorder response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.5
     */
    Main.methods.dashboard_reorder_widgets_response = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();

        // Verify if the success response exists
        if ( status !== 'success' ) {
            
            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);

        }
        
    };

    /*
     * Display events
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.5
     */
    Main.methods.dashboard_display_events_response = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Start the list with dates
            var dates = '<div class="accordion" id="dashboard-events-accordion">';

            // List the dates list
            for ( var d = (data.dates.length - 1); d > -1; d-- ) {

                // Start events list
                var events = '<div class="accordion-body">'
                + '<ul class="dashboard-events-list">';

                // Verify if events exists
                if ( data.dates[d].events.length > 0 ) {

                    // List the events
                    for ( var e = 0; e < data.dates[d].events.length; e++ ) {

                        // Event's icon
                        var event_icon = '';

                        // Verify if font's icon exists
                        if ( data.dates[d].events[e].font_icon ) {

                            // Set the event's icon
                            event_icon = data.dates[d].events[e].font_icon;

                        }

                        // Add event
                        events += '<li class="dashboard-event" data-type="member-join">'
                            + '<div class="alert alert-light d-flex align-items-center" role="alert">'
                                + event_icon
                                + '<div>'
                                    + data.dates[d].events[e].title
                                + '</div>'
                            + '</div>'
                        + '</li>';

                    }

                } else {

                    // Set the no events message
                        events += '<li class="dashboard-no-events-found">'
                        + '<p>'
                            + data.words.no_events_were_found
                        + '</p>'
                    + '</li>';                   

                }

                // End events list
                events += '</ul>'
                + '</div>';

                // Add new date to the list
                dates += '<div class="accordion-item">'
                    + '<h2 class="accordion-header" id="dashboard-events-date-' + data.dates[d].day + '">'
                        + '<button class="accordion-button d-flex justify-content-between align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#dashboard-events-date-' + data.dates[d].day + '-events" aria-expanded="true" aria-controls="dashboard-events-date-' + data.dates[d].day + '-events">'
                            + '<span>'
                                + '<i class="iconify" data-icon="fluent:calendar-info-20-regular"></i>'
                                + data.dates[d].date
                            + '</span>'
                            + '<span>'
                                + '<i class="iconify" data-icon="fluent:alert-urgent-20-regular"></i>'
                                + '<div>'
                                    + data.dates[d].total
                                + '</div>'                                              
                            + '</span>'
                        + '</button>'
                    + '</h2>'
                    + '<div id="dashboard-events-date-' + data.dates[d].day + '-events" class="accordion-collapse collapse show" aria-labelledby="dashboard-events-date-' + data.dates[d].day + '">'
                        + events
                    + '</div>'
                + '</div>';

            }

            // End the list with dates
            dates += '</div>';
            
            // Display the dates
            $('.dashboard-page .dashboard-events-card > .card-body').html(dates);

            // Set events old
            $('.dashboard-page .dashboard-events-old-btn').attr('data-time', data.events_old);            

            // Set events new
            $('.dashboard-page .dashboard-events-new-btn').attr('data-time', data.events_new);
            
        } else {

            // Prepare the no events message
            let no_events_found = '<p class="p-3 theme-box-1">'
                + data.message
            + '</p>';

            // Display the no events message
            $('.dashboard-page .dashboard-events-card > .card-body').html(no_events_found);
            
        }

    };

});