/*
 * Week Calendar JavaScript Default
*/

jQuery(document).ready( function ($) {
    'use strict';

    /*******************************
    METHODS
    ********************************/

    /*
     * Generate month and year
     *
     * @param integer month contains the month
     * @param integer year contains the year
     * 
     * @since   0.0.8.5
     * 
     * @return string with date
     */
    Main.default_display_week_calendar_the_month_year = function ( month, year ) {

        // Set months
        var months = [
            '',
            Main.translation.theme_january,
            Main.translation.theme_february,
            Main.translation.theme_march,
            Main.translation.theme_april,
            Main.translation.theme_may,
            Main.translation.theme_june,
            Main.translation.theme_july,
            Main.translation.theme_august,
            Main.translation.theme_september,
            Main.translation.theme_october,
            Main.translation.theme_november,
            Main.translation.theme_december
        ];

        // Return month and year
        return months[parseInt(month)] + ' ' + year;
        
    }

    /*
     * Generate the calendar
     *
     * @param string id contains the calendar's ID
     * @param object date with the date
     * 
     * @since   0.0.8.5
     * 
     * @return string with date
     */
    Main.default_display_week_calendar = function ( id, date ) {

        // Display Month And Year
        $('.main .default-week-calendar#' + id + ' .card-header > h3').html(Main.default_display_week_calendar_the_month_year((date.getMonth() + 1), date.getFullYear()));

        // Set Monday
        let monday = date.getDate(), monday_selected = ($('.main .default-week-calendar#' + id).attr('data-datestamp') === date.toISOString().split('T')[0])?' class="default-week-calendar-day-active"':'';

        // Set Tuesday
        let tuesday = new Date(date.getTime() + 1 * 24 * 60 * 60 * 1000), tuesday_selected = ($('.main .default-week-calendar#' + id).attr('data-datestamp') === tuesday.toISOString().split('T')[0])?' class="default-week-calendar-day-active"':'';

        // Set Wednesday
        let wednesday = new Date(date.getTime() + 2 * 24 * 60 * 60 * 1000), wednesday_selected = ($('.main .default-week-calendar#' + id).attr('data-datestamp') === wednesday.toISOString().split('T')[0])?' class="default-week-calendar-day-active"':'';

        // Set Thursday
        let thursday = new Date(date.getTime() + 3 * 24 * 60 * 60 * 1000), thursday_selected = ($('.main .default-week-calendar#' + id).attr('data-datestamp') === thursday.toISOString().split('T')[0])?' class="default-week-calendar-day-active"':'';

        // Set Friday
        let friday = new Date(date.getTime() + 4 * 24 * 60 * 60 * 1000), friday_selected = ($('.main .default-week-calendar#' + id).attr('data-datestamp') === friday.toISOString().split('T')[0])?' class="default-week-calendar-day-active"':'';

        // Set Saturday
        let saturday = new Date(date.getTime() + 5 * 24 * 60 * 60 * 1000), saturday_selected = ($('.main .default-week-calendar#' + id).attr('data-datestamp') === saturday.toISOString().split('T')[0])?' class="default-week-calendar-day-active"':'';

        // Set Sunday
        let sunday = new Date(date.getTime() + 6 * 24 * 60 * 60 * 1000), sunday_selected = ($('.main .default-week-calendar#' + id).attr('data-datestamp') === sunday.toISOString().split('T')[0])?' class="default-week-calendar-day-active"':'';

        // Calendar container
        var calendar = '';

        // Verify if first day of the week is monday
        if ( parseInt($('.main .default-week-calendar').eq(0).attr('data-first-day')) === 1 ) {

            // Create the calendar
            calendar = '<div class="btn-group d-flex justify-content-between default-week-calendar-days" role="group" aria-label="Days">'
                    + '<a href="#"' + monday_selected + ' data-datestamp="' + date.toISOString().split('T')[0] + '">'
                        + words.mon
                        + '<span>'
                            + monday
                        + '</span>'
                    + '</a>'
                    + '<a href="#"' + tuesday_selected + ' data-datestamp="' + tuesday.toISOString().split('T')[0] + '">'
                        + words.tue
                        + '<span>'
                            + tuesday.getDate()
                        + '</span>'
                    + '</a>'
                    + '<a href="#"' + wednesday_selected + ' data-datestamp="' + wednesday.toISOString().split('T')[0] + '">'
                        + words.wed
                        + '<span>'
                            + wednesday.getDate()
                        + '</span>'
                    + '</a>'
                    + '<a href="#"' + thursday_selected + ' data-datestamp="' + thursday.toISOString().split('T')[0] + '">'
                        + words.thu
                        + '<span>'
                            + thursday.getDate()
                        + '</span>'
                    + '</a>'
                    + '<a href="#"' + friday_selected + ' data-datestamp="' + friday.toISOString().split('T')[0] + '">'
                        + words.fri
                        + '<span>'
                            + friday.getDate()
                        + '</span>'
                    + '</a>'
                    + '<a href="#"' + saturday_selected + ' data-datestamp="' + saturday.toISOString().split('T')[0] + '">'
                        + words.sat
                        + '<span>'
                            + saturday.getDate()
                        + '</span>'
                    + '</a>'
                    + '<a href="#"' + sunday_selected + ' data-datestamp="' + sunday.toISOString().split('T')[0] + '">'
                        + words.sun
                        + '<span>'
                            + sunday.getDate()
                        + '</span>'
                    + '</a>'
                + '</div>';

        } else {

            // Create the calendar
            calendar = '<div class="btn-group d-flex justify-content-between default-week-calendar-days" role="group" aria-label="Days">'
                + '<a href="#"' + monday_selected + ' data-datestamp="' + sunday.toISOString().split('T')[0] + '">'
                    + words.sun
                    + '<span>'
                        + monday
                    + '</span>'
                + '</a>'
                + '<a href="#"' + tuesday_selected + ' data-datestamp="' + date.toISOString().split('T')[0] + '">'
                    + words.mon
                    + '<span>'
                        + tuesday.getDate()
                    + '</span>'
                + '</a>'
                + '<a href="#"' + wednesday_selected + ' data-datestamp="' + tuesday.toISOString().split('T')[0] + '">'
                    + words.tue
                    + '<span>'
                        + wednesday.getDate()
                    + '</span>'
                + '</a>'
                + '<a href="#"' + thursday_selected + ' data-datestamp="' + wednesday.toISOString().split('T')[0] + '">'
                    + words.wed
                    + '<span>'
                        + thursday.getDate()
                    + '</span>'
                + '</a>'
                + '<a href="#"' + friday_selected + ' data-datestamp="' + thursday.toISOString().split('T')[0] + '">'
                    + words.thu
                    + '<span>'
                        + friday.getDate()
                    + '</span>'
                + '</a>'
                + '<a href="#"' + saturday_selected + ' data-datestamp="' + friday.toISOString().split('T')[0] + '">'
                    + words.fri
                    + '<span>'
                        + saturday.getDate()
                    + '</span>'
                + '</a>'
                + '<a href="#"' + sunday_selected + ' data-datestamp="' + saturday.toISOString().split('T')[0] + '">'
                    + words.sat
                    + '<span>'
                        + sunday.getDate()
                    + '</span>'
                + '</a>'
            + '</div>';

        }

        // Display the calendar
        $('.main .default-week-calendar#' + id + ' .card-body').html(calendar);
        
    }

    /*
     * Display events
     *
     * @param string id contains the calendar's ID
     * @param object events contains the events
     * 
     * @since   0.0.8.5
     * 
     * @return string with date
     */
    Main.default_display_week_calendar_events = function ( id, events ) {

        // Verify if events is object
       if ( typeof events === 'object' ) {

            // All events container
            var all_events = '';

            // List the events
            for ( var e = 0; e < events.length; e++ ) {

                // Verify if the required parameters exists
                if ( (typeof events[e].title === 'undefined') || (typeof events[e].subtitle === 'undefined') || (typeof events[e].icon === 'undefined') ) {
                    continue;
                }

                // Add events to the container
                all_events += '<li class="default-week-calendar-event">'
                    + '<div class="media">'
                        + events[e].icon
                        + '<div class="media-body">'
                            + '<h5>'
                                + events[e].title
                            + '</h5>'
                            + '<span>'
                                + events[e].subtitle
                            + '</span>'
                        + '</div>'
                    + '</div>'
                + '</li>';

            }

            // Display events
            $('.main .default-week-calendar' + id + ' .card-footer .default-week-calendar-events').html(all_events);

       }
        
    }

    /*
     * Display no events message
     *
     * @param string id contains the calendar's ID
     * @param string message contains the message to display
     * 
     * @since   0.0.8.5
     * 
     * @return string with date
     */
    Main.default_display_week_calendar_no_events = function ( id, message ) {

        // Prepare the message
        let the_message = '<li class="default-week-calendar-no-events">'
            + message
        + '</li>';

        // Display the no events message
        $('.main .default-week-calendar' + id + ' .card-footer .default-week-calendar-events').html(the_message);
        
    }
  
    /*******************************
    ACTIONS
    ********************************/

    /*
     * Load default content
     * 
     * @since   0.0.8.5 
     */
    $(function () {

        // Verify if week calendars exists
        if ( $('.main .default-week-calendar').length > 0 ) {

            // Identify all week calendars
            $( '.main .default-week-calendar' ).each(function() {

                // Create calendar data
                let calendar = '<div class="card-header d-flex justify-content-between">'
                    + '<h3></h3>'
                    + '<div class="btn-group" role="group" aria-label="Navigation Buttons">'
                        + '<button type="button" class="btn btn-secondary default-week-calendar-previous-week-btn">'
                            + '<i class="ri-arrow-left-circle-line"></i>'
                        + '</button>'
                        + '<button type="button" class="btn btn-secondary default-week-calendar-next-week-btn">'
                            + '<i class="ri-arrow-right-circle-line"></i>'
                        + '</button>'
                    + '</div>'
                + '</div>'
                + '<div class="card-body"></div>'
                + '<div class="card-footer">'
                    + '<ul class="default-week-calendar-events"></ul>'
                + '</div>';

                // Set calendar data
                $(this).html(calendar);

                // Get the calendar ID
                let id = $(this).attr('id');
                
                // Get date
                let date = $(this).attr('data-date');

                // Get month
                let month = $(this).attr('data-month');
                
                // Get year
                let year = $(this).attr('data-year');

                // Format
                let current_date_format = new Date(year + '-' + month + '-' + date);
                
                // Set This Week
                var this_week;
                
                // Verify if first day of the week is monday
                if ( parseInt($('.main .default-events-list').eq(0).attr('data-first-day')) === 1 ) {

                    // Prepare day of the week
                    let the_week_date = (current_date_format.getDay() === 0)?6:(current_date_format.getDay() - 1);

                    // Set This Week
                    this_week = new Date(current_date_format.setDate(current_date_format.getDate() - the_week_date));

                } else {

                    // Set This Week
                    this_week = new Date(current_date_format.setDate(current_date_format.getDate() - (current_date_format.getDay() - 1)))

                }

                // Prepare the new time
                let new_time = this_week.toISOString().split('T')[0].split('-');

                // Set date
                $('.main .default-week-calendar#' + id).attr('data-date', new_time[2]);

                // Set month
                $('.main .default-week-calendar#' + id).attr('data-month', new_time[1]);
                
                // Set year
                $('.main .default-week-calendar#' + id).attr('data-year', new_time[0]);        

                // Display calendar
                Main.default_display_week_calendar(id, this_week);

            });

        }

    });

    /*
     * Detect previous week button click
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.5
     */ 
    $( document ).on( 'click', '.main .default-week-calendar .default-week-calendar-previous-week-btn', function (e) {
        e.preventDefault();

        // Get the calendar ID
        let id = $(this).closest('.default-week-calendar').attr('id');
        
        // Get date
        let date = $(this).closest('.default-week-calendar').attr('data-date');

        // Get month
        let month = $(this).closest('.default-week-calendar').attr('data-month');
        
        // Get year
        let year = $(this).closest('.default-week-calendar').attr('data-year');

        // Format
        let current_date_format = new Date(year + '-' + month + '-' + date);

        // Set Previous Week
        let previous_week = new Date(current_date_format.getTime() - 7 * 24 * 60 * 60 * 1000);

        // Prepare the new time
        let new_time = previous_week.toISOString().split('T')[0].split('-');

        // Set date
        $('.main .default-week-calendar#' + id).attr('data-date', new_time[2]);

        // Set month
        $('.main .default-week-calendar#' + id).attr('data-month', new_time[1]);
        
        // Set year
        $('.main .default-week-calendar#' + id).attr('data-year', new_time[0]);        

        // Display calendar
        Main.default_display_week_calendar(id, previous_week);
        
    });

    /*
     * Detect next week button click
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.5
     */ 
    $( document ).on( 'click', '.main .default-week-calendar .default-week-calendar-next-week-btn', function (e) {
        e.preventDefault();

        // Get the calendar ID
        let id = $(this).closest('.default-week-calendar').attr('id');
        
        // Get date
        let date = $(this).closest('.default-week-calendar').attr('data-date');

        // Get month
        let month = $(this).closest('.default-week-calendar').attr('data-month');
        
        // Get year
        let year = $(this).closest('.default-week-calendar').attr('data-year');

        // Format
        let current_date_format = new Date(year + '-' + month + '-' + date);

        // Set Next Week
        let next_week = new Date(current_date_format.getTime() + 7 * 24 * 60 * 60 * 1000);

        // Prepare the new time
        let new_time = next_week.toISOString().split('T')[0].split('-');

        // Set date
        $('.main .default-week-calendar#' + id).attr('data-date', new_time[2]);

        // Set month
        $('.main .default-week-calendar#' + id).attr('data-month', new_time[1]);
        
        // Set year
        $('.main .default-week-calendar#' + id).attr('data-year', new_time[0]);        

        // Display calendar
        Main.default_display_week_calendar(id, next_week);
        
    });

    /*
     * Detect date button click
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.5
     */ 
    $( document ).on( 'click', '.main .default-week-calendar .default-week-calendar-days a', function (e) {
        e.preventDefault();

        // Remove active class
        $(this).closest('.default-week-calendar').find('.default-week-calendar-days a').removeClass('default-week-calendar-day-active');

        // Add active class
        $(this).addClass('default-week-calendar-day-active');

        // Set selected date
        $(this).closest('.default-week-calendar').attr('data-datestamp', $(this).attr('data-datestamp'));
        
    });

});