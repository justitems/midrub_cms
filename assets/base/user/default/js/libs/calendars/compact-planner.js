/*
 * Compact Planner JavaScript Default
*/

jQuery(document).ready( function ($) {
    'use strict';
  
    /*******************************
    ACTIONS
    ********************************/

    /*
     * Load default content
     * 
     * @since   0.0.8.5 
     */
    $(function () {

        // Verify if compact planners exists
        if ( $('.main .default-compact-planner').length > 0 ) {

            // Identify all compact planners
            $( '.main .default-compact-planner' ).each(function() {

                // Unique id
                let unique_id = Math.floor(Math.random() * 100);

                // Tabs container
                var tabs = '';

                // Days checked
                let days_checked = ($(this).attr('data-tab') === '0')?' checked':'';

                // Set tab
                tabs += '<input type="radio" name="default-compact-planner-tab" id="default-compact-planner-tab-days-' + unique_id + '" value="1"' + days_checked + ' />'
                + '<label class="btn btn-primary flex-fill" for="default-compact-planner-tab-days-' + unique_id + '">'
                    + words.icon_bi_planner
                    + words.days
                + '</label>';

                // Dates checked
                let dates_checked = ($(this).attr('data-tab') === '1')?' checked':'';

                // Set tab
                tabs += '<input type="radio" name="default-compact-planner-tab" id="default-compact-planner-tab-dates-' + unique_id + '" value="2"' + dates_checked + ' />'
                + '<label class="btn btn-primary flex-fill" for="default-compact-planner-tab-dates-' + unique_id + '">'
                    + words.icon_bi_calendar
                    + words.dates
                + '</label>';

                // Days container
                var days = '';

                // Days list
                let days_list = [
                    words.mon,
                    words.tue,
                    words.wed,
                    words.thu,
                    words.fri,
                    words.sat,
                    words.sun
                ];

                // List days
                for ( var d = 0; d < days_list.length; d++ ) {

                    // Set day's id
                    let day = (d + 1);

                    // Active class
                    var active = '';

                    // Verify if data-days exists
                    if ( $(this).attr('data-days') ) {

                        // Decode data_days
                        let data_days = JSON.parse($(this).attr('data-days'));

                        // Verify if the current day is selected
                        if ( data_days.includes(day) ) {
                            active = ' default-planner-selected-day';
                        }

                    }

                    // Verify if first day of the week is sunday
                    if ( parseInt($('.main .default-compact-planner').eq(0).attr('data-first-day')) === 7 ) {

                        // Verify if is the last day
                        if ( day === days_list.length ) {

                            // Add last day to the begin
                            days = '<button type="button" class="btn btn-secondary flex-fill' + active + '" data-day="' + day + '">'
                                + days_list[d]
                            + '</button>'
                            + days;
                            
                            break;

                        }

                    }

                    // Set day
                    days += '<button type="button" class="btn btn-secondary flex-fill' + active + '" data-day="' + day + '">'
                        + days_list[d]
                    + '</button>';

                }

                // Dates list
                let dates_list = [
                    '01',
                    '02',
                    '03',
                    '04',
                    '05',
                    '06',
                    '07',
                    '08',
                    '09',
                    '10',
                    '11',
                    '12',
                    '13',
                    '14',
                    '15',
                    '16',
                    '17',
                    '18',
                    '19',
                    '20',
                    '21',
                    '22',
                    '23',
                    '24',
                    '25',
                    '26',
                    '27',
                    '28',
                    '29',
                    '30',
                    '31'
                ];

                // Dates container
                var dates = '<tr>';

                // List dates
                for ( var da = 0; da < dates_list.length; da++ ) {

                    // Verify if is 7
                    if ( da % 7 === 0 ) {
                        
                        // Set row
                        dates += '</tr><tr>';

                    }

                    // Active class
                    var active = '';

                    // Date
                    let the_date = (da + 1);

                    // Verify if data-dates exists
                    if ( $(this).attr('data-dates') ) {

                        // Decode data_dates
                        let data_dates = JSON.parse($(this).attr('data-dates'));

                        // Verify if the current date is selected
                        if ( data_dates.includes(the_date) ) {
                            active = ' class="default-planner-selected-date"';
                        }

                    }

                    // Set date
                    dates += '<td>'
                        + '<a href="#"' + active + ' data-date="' + the_date + '">'
                            + dates_list[da]
                        + '</a>'
                    + '</td>';

                }

                // End row
                dates += '</tr>';

                // Tabs content
                let tabs_content = {
                    'days': ($(this).attr('data-tab') === '0')?' show':'',
                    'dates': ($(this).attr('data-tab') === '0')?'':' show'
                };

                // Compact Planner
                let compact_planner = '<div class="default-compact-planner-tabs-navigation d-flex justify-content-around">'
                    + tabs
                + '</div>'
                + '<div class="default-compact-planner-tabs-container">'
                    + '<div class="default-compact-planner-tab' + tabs_content['days'] + '" id="default-compact-planner-tab-days-' + unique_id + '-content">'
                        + '<div class="btn-group d-flex justify-content-around default-compact-planner-tab-days" role="group" aria-label="Days">'
                            + days
                        + '</div>'
                    + '</div>'
                    + '<div class="default-compact-planner-tab' + tabs_content['dates'] + '" id="default-compact-planner-tab-dates-' + unique_id + '-content">'
                        + '<table>'
                            + '<tbody class="default-dropdown-date-picker-calendar-dates">'
                                + dates
                            + '</tbody>'
                        + '</table>'
                    + '</div>'
                + '</div>';

                // Add compact planner
                $(this).html(compact_planner);
                
            });

        }

    });

    /*
     * Detect checkbox tab click
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.5
     */ 
    $( document ).on( 'change', '.default-compact-planner .default-compact-planner-tabs-navigation [type="radio"]', function (e) {
        e.preventDefault();
        
        // Hide tabs
        $(this).closest('.default-compact-planner').find('.default-compact-planner-tab').removeClass('show');

        // Show tabs
        $(this).closest('.default-compact-planner').find('#' + $(this).attr('id') + '-content').addClass('show');
        
    });

    /*
     * Detect day click
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.5
     */ 
    $( document ).on( 'click', '.default-compact-planner .default-compact-planner-tab-days .btn-secondary', function (e) {
        e.preventDefault();
        
        // Verify if the class default-planner-selected-day is selected
        if ( $(this).hasClass('default-planner-selected-day') ) {

            // Add class default-planner-selected-day
            $(this).removeClass('default-planner-selected-day');            

        } else {

            // Add class default-planner-selected-day
            $(this).addClass('default-planner-selected-day');

        }
        
    });

    /*
     * Detect date click
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.5
     */ 
    $( document ).on( 'click', '.default-compact-planner .default-dropdown-date-picker-calendar-dates a', function (e) {
        e.preventDefault();
        
        // Verify if the class default-planner-selected-date is selected
        if ( $(this).hasClass('default-planner-selected-date') ) {

            // Add class default-planner-selected-date
            $(this).removeClass('default-planner-selected-date');            

        } else {

            // Add class default-planner-selected-date
            $(this).addClass('default-planner-selected-date');

        }
        
    });

});