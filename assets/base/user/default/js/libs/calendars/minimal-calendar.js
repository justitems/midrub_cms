/*
 * Minimal Calendar JavaScript file
*/

jQuery(document).ready( function ($) {
    'use strict';
    
    /*******************************
    METHODS
    ********************************/

    /*
     * Display calendar
     *
     * @param integer month contains the month
     * @param integer day contains the day
     * @param integer year contains the year
     * @param integer first_day contains the option for first day of the week 
     * 
     * @since   0.0.8.5 
     */
    Main.show_calendar = function ( month, day, year ) {

        // Display months
        show_year( month, year );
        
        // Set current date
        let current = new Date();
        
        // Set day
        let d = new Date(year, month, 0);
        
        // Get time
        let e = new Date(d.getFullYear(), d.getMonth(), 1);
        
        // Current day
        let fday = e.getDay();
        
        // Show option
        var show = 1;

        // Increase day
        fday++;

        // Verify if first day of the week is monday
        if ( parseInt($('#theme-open-time-picker-modal').attr('data-first-day')) === 1 ) {

            // Set days of the week
            var n = '<tr>'
                        + '<td>'
                            + Main.translation.theme_m
                        + '</td>'
                        + '<td>'
                            + Main.translation.theme_t
                        + '</td>'
                        + '<td>'
                            + Main.translation.theme_w
                        + '</td>'
                        + '<td>'
                            + Main.translation.theme_tu
                        + '</td>'
                        + '<td>'
                            + Main.translation.theme_f
                        + '</td>'
                        + '<td>'
                            + Main.translation.theme_s
                        + '</td>'
                        + '<td>'
                            + Main.translation.theme_su
                        + '</td>'
                    + '</tr>'
                    + '<tr>';

            // Set day calc
            var day_calc = 2;

        } else {

            // Set days of the week
            var n = '<tr>'
                        + '<td>'
                            + Main.translation.theme_su
                        + '</td>'
                        + '<td>'
                            + Main.translation.theme_m
                        + '</td>'
                        + '<td>'
                            + Main.translation.theme_t
                        + '</td>'
                        + '<td>'
                            + Main.translation.theme_w
                        + '</td>'
                        + '<td>'
                            + Main.translation.theme_tu
                        + '</td>'
                        + '<td>'
                            + Main.translation.theme_f
                        + '</td>'
                        + '<td>'
                            + Main.translation.theme_s
                        + '</td>'
                    + '</tr>'
                    + '<tr>';

            // Set day calc
            var day_calc = 1;

        }

        // Calculate days
        for ( var s = day_calc; s < 40; s++ ) {

            if ( show > d.getDate() ) {
                break;
            }
            
            if ( (s - day_calc) % 7 === 0 ) {
                n += '</tr><tr>';
            }
            
            if ( fday <= s ) {

                let this_month = (parseInt(month) < 10) ? '0' + parseInt(month) : month;

                let this_date = (show < 10) ? '0' + show : show;

                var add_date = '';

                if ( year + '-' + this_month + '-' + this_date === Main.selected_date ) {

                    add_date = 'default-selected-date';

                }

                if ( ( this_date === day ) && ( parseInt(month) === current.getMonth() + 1 ) && ( year === current.getFullYear() ) ) {

                    n += '<td><a href="#" class="default-current-day ' + add_date + '" data-date="' + year + '-' + this_month + '-' + this_date + '">' + this_date + '</a></td>';

                } else {

                    if ( ( ( show < day ) && ( parseInt(month) === current.getMonth() + 1 ) && ( year == current.getFullYear() ) ) || ( ( ( parseInt(month) < current.getMonth() + 1 ) && ( year <= current.getFullYear() ) ) || ( year < current.getFullYear() ) ) ) {

                        n += '<td><a href="#" data-date="' + year + '-' + this_month + '-' + this_date + '" class="' + add_date + '">' + this_date + '</a></td>';

                    } else {

                        n += '<td><a href="#" data-date="' + year + '-' + this_month + '-' + this_date + '" class="' + add_date + '">' + this_date + '</a></td>';

                    }

                }

                show++;

            } else {

                n += '<td></td>';

            }

        }

        n += '</tr>';
        
        // Display calendar's content
        $( '#theme-open-time-picker-modal .default-calendar-dates' ).html( n );
        
    };

    /*
     * Display current month and year
     *
     * @since   0.0.8.5  
     */
    function show_year( month, year ) {

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

        // Add month and year
        $( '#theme-open-time-picker-modal .default-year-month' ).text( months[parseInt(month)] + ' ' + year );
        
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

        // Verify if time pickers exists
        if ( $('.main .theme-time-picker').length > 0 ) {

            // Identify all time pickers
            $( '.main .theme-time-picker' ).each(function() {

                // Default date and time
                var date_time = '';

                // Get date format
                var date_format = $(this).closest('.theme-time-picker').attr('data-date-format');

                // Set replacers
                let replacers = {
                    'd': ( 10 > parseInt($(this).closest('.theme-time-picker').attr('data-day'))?'0' + parseInt($(this).closest('.theme-time-picker').attr('data-day')):parseInt($(this).closest('.theme-time-picker').attr('data-day'))),
                    'm': ( 10 > parseInt($(this).closest('.theme-time-picker').attr('data-month'))?'0' + parseInt($(this).closest('.theme-time-picker').attr('data-month')):parseInt($(this).closest('.theme-time-picker').attr('data-month'))),
                    'y': parseInt($(this).closest('.theme-time-picker').attr('data-year'))
                };

                // Replace the date
                date_format = date_format.replace(/dd/g, replacers['d']);

                // Replace the month
                date_format = date_format.replace(/mm/g, replacers['m']);

                // Replace the year
                date_format = date_format.replace(/yyyy/g, replacers['y']);

                // Verify if the time should be used
                if ( parseInt($(this).attr('data-time')) === 1 ) {
                
                    // Get time's format
                    let time_format = $(this).closest('.theme-time-picker').attr('data-time-format');

                    // Verify if is 12 hours format
                    if ( parseInt(time_format) === 12 ) {

                        // Set date and time
                        date_time = date_format + ' ' + $(this).closest('.theme-time-picker').attr('data-hour') + ':' + $(this).closest('.theme-time-picker').attr('data-minute') + ' ' + $(this).closest('.theme-time-picker').attr('data-meridiem');
                        
                    } else {

                        // Set date and time
                        date_time = date_format + ' ' + $(this).closest('.theme-time-picker').attr('data-hour') + ':' + $(this).closest('.theme-time-picker').attr('data-minute');
                        
                    }            
                    
                } else {

                    // Set date
                    date_time = date_format;            

                }

                // Prepare content
                let content = '<div class="theme-time-picker-selected-time">'
                    + '<span>'
                        + date_time
                    + '</span>'
                + '</div>'
                + '<div class="theme-time-picker-btn">'
                    + '<a href="#theme-open-time-picker-modal" data-toggle="modal">'
                        + '<i class="ri-calendar-2-line"></i>'
                    + '</a>'
                + '</div>'; 

                // Add content
                $(this).html(content);
                
            });

        }

    });

    /*
     * Detect when the time picker modal opens
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.5 
     */      
    $('#theme-open-time-picker-modal').on('show.bs.modal', function (e) {
        
        // Set picker's ID
        let id = $(e.relatedTarget).closest('.theme-time-picker').attr('data-id');

        // Set button's ID
        $('#theme-open-time-picker-modal').attr('data-id', id);

        // Get date's format
        let date_format = $(e.relatedTarget).closest('.theme-time-picker').attr('data-date-format');

        // Set date's format
        $('#theme-open-time-picker-modal').attr('data-date-format', date_format);

        // Set day
        Main.day = $(e.relatedTarget).closest('.theme-time-picker').attr('data-day');

        // Set month
        Main.month = $(e.relatedTarget).closest('.theme-time-picker').attr('data-month');
        
        // Set year
        Main.year = $(e.relatedTarget).closest('.theme-time-picker').attr('data-year');

        // Set selected day
        Main.selected_date = Main.year + '-' + Main.month + '-' + Main.day;

        // Set day
        $('#theme-open-time-picker-modal').attr('data-day', Main.day);
        
        // Set month
        $('#theme-open-time-picker-modal').attr('data-month', Main.month);
        
        // Set year
        $('#theme-open-time-picker-modal').attr('data-year', Main.year);

        // Set the first day of the week
        $('#theme-open-time-picker-modal').attr('data-first-day', $(e.relatedTarget).closest('.theme-time-picker').attr('data-first-day'));        

        // Verify if the time should be used
        if ( parseInt($(e.relatedTarget).closest('.theme-time-picker').attr('data-time')) === 1 ) {
        
            // Get time's format
            let time_format = $(e.relatedTarget).closest('.theme-time-picker').attr('data-time-format');

            // Get hour
            let hour = $(e.relatedTarget).closest('.theme-time-picker').attr('data-hour');

            // Get minute
            let minute = $(e.relatedTarget).closest('.theme-time-picker').attr('data-minute');

            // Set time's format
            $('#theme-open-time-picker-modal').attr('data-time-format', time_format);

            // Enable the time button
            $('#theme-open-time-picker-modal').attr('data-time', 1);

            // Remove the selected hour class
            $('#theme-open-time-picker-modal .theme-time-picker-hour-select').removeClass('theme-time-picker-hour-selected');

            // Add the selected hour class
            $('#theme-open-time-picker-modal .theme-time-picker-hour-select[data-hour="' + hour + '"]').addClass('theme-time-picker-hour-selected');   
            
            // Remove the selected minute class
            $('#theme-open-time-picker-modal .theme-time-picker-minute-select').removeClass('theme-time-picker-minute-selected');

            // Add the selected minute class
            $('#theme-open-time-picker-modal .theme-time-picker-minute-select[data-minute="' + minute + '"]').addClass('theme-time-picker-minute-selected'); 

            // Verify if is 12 hours format
            if ( parseInt(time_format) === 12 ) {

                // Get meridiem
                let meridiem = $(e.relatedTarget).closest('.theme-time-picker').attr('data-meridiem');

                // Remove the selected class
                $('#theme-open-time-picker-modal .theme-time-picker-hours-minutes-select .theme-time-picker-meridiem-select').removeClass('theme-time-picker-meridiem-selected');

                // Add the selected class
                $('#theme-open-time-picker-modal .theme-time-picker-hours-minutes-select .theme-time-picker-meridiem-select[data-meridiem="' + meridiem + '"]').addClass('theme-time-picker-meridiem-selected'); 

                // Set the meridiem class
                $('#theme-open-time-picker-modal .theme-time-picker-hours-minutes-select').addClass('theme-time-picker-show-meridiem');

                // Set time's text
                $('#theme-open-time-picker-modal #theme-time-picker-hours-minutes-select').html('<i class="ri-time-line"></i> ' + hour + ':' + minute + ' ' + meridiem + ' <i class="ri-arrow-down-s-line"></i>');

                // Set hour
                $('#theme-open-time-picker-modal #theme-time-picker-hours-minutes-select').attr('data-hour', $(e.relatedTarget).closest('.theme-time-picker').attr('data-hour'));

                // Set minute
                $('#theme-open-time-picker-modal #theme-time-picker-hours-minutes-select').attr('data-minute', $(e.relatedTarget).closest('.theme-time-picker').attr('data-minute'));

                // Set meridiem
                $('#theme-open-time-picker-modal #theme-time-picker-hours-minutes-select').attr('data-meridiem', $(e.relatedTarget).closest('.theme-time-picker').attr('data-meridiem'));
                
            } else {

                // Set time's text
                $('#theme-open-time-picker-modal #theme-time-picker-hours-minutes-select').html('<i class="ri-time-line"></i> ' + hour + ':' + minute + ' <i class="ri-arrow-down-s-line"></i>');

                // Set hour
                $('#theme-open-time-picker-modal #theme-time-picker-hours-minutes-select').attr('data-hour', $(e.relatedTarget).closest('.theme-time-picker').attr('data-hour'));            

                // Set minute
                $('#theme-open-time-picker-modal #theme-time-picker-hours-minute-select').attr('data-minute', $(e.relatedTarget).closest('.theme-time-picker').attr('data-minute'));

            }            
            
        } else {

            // Disable the time button
            $('#theme-open-time-picker-modal').attr('data-time', 0);

        }

        // Display calendar
        Main.show_calendar( Main.month, Main.day, Main.year);

    });

    /*
     * Select a date
     *
     * @param object e with global object
     * 
     * @since   0.0.8.5 
     */  
    $(document).on('click', '#theme-open-time-picker-modal .default-calendar-dates tr td a', function (e) {
        e.preventDefault();

        // Remove class default-selected-date
        $('#theme-open-time-picker-modal .default-calendar-dates tr td a').removeClass('default-selected-date');
        
        // Add class default-selected-date
        $(this).addClass('default-selected-date');

        // Get the selected date
        let selected_date = $(this).attr('data-date');

        // Split date
        let split_date = selected_date.split( '-' );

        // Set selected date
        Main.selected_date = split_date[0] + '-' + split_date[1] + '-' + split_date[2];         

        // Set day
        $('#theme-open-time-picker-modal').attr('data-day', split_date[2]);

        // Set month
        $('#theme-open-time-picker-modal').attr('data-month', split_date[1]);

        // Set year
        $('#theme-open-time-picker-modal').attr('data-year', split_date[0]);

    });

    /*
     * Select a hours, minutes and meridiem
     *
     * @param object e with global object
     * 
     * @since   0.0.8.5 
     */  
    $(document).on('click', '#theme-open-time-picker-modal .theme-time-picker-hours-minutes-select a, #theme-open-time-picker-modal .theme-time-picker-hours-minutes-select .theme-time-picker-meridiem-select', function (e) {
        e.preventDefault();

        // Process data by class
        if ( $(this).hasClass('theme-time-picker-hour-select') ) {

            // Remove the selected class
            $('#theme-open-time-picker-modal .theme-time-picker-hours-minutes-select .theme-time-picker-hour-select').removeClass('theme-time-picker-hour-selected');

            // Add the selected class
            $(this).addClass('theme-time-picker-hour-selected');

        } else if ( $(this).hasClass('theme-time-picker-minute-select') ) {

            // Remove the selected class
            $('#theme-open-time-picker-modal .theme-time-picker-minute-select').removeClass('theme-time-picker-minute-selected');

            // Add the selected class
            $(this).addClass('theme-time-picker-minute-selected');            

        } else if ( $(this).hasClass('theme-time-picker-meridiem-select') ) {

            // Remove the selected class
            $('#theme-open-time-picker-modal .theme-time-picker-hours-minutes-select .theme-time-picker-meridiem-select').removeClass('theme-time-picker-meridiem-selected');

            // Add the selected class
            $(this).addClass('theme-time-picker-meridiem-selected'); 

        }

    });

    /*
     * Go back button
     *
     * @param object e with global object
     * 
     * @since   0.0.8.5 
     */    
    $(document).on('click', '#theme-open-time-picker-modal .default-go-back', function (e) {
        e.preventDefault();

        // Decrease month
        Main.month--;

        // Verify if month is 0
        if ( Main.month < 1 ) {
            
            // Decrease year
            Main.year--;

            // Default month
            Main.month = 12;
            
        }
        
        // Display calendar
        Main.show_calendar( Main.month, Main.day, Main.year);
        
    });
    
    /*
     * Go next button
     *
     * @param object e with global object
     * 
     * @since   0.0.8.5 
     */    
    $(document).on('click', '#theme-open-time-picker-modal .default-go-next', function (e) {
        e.preventDefault();

        // Increase month
        Main.month++;

        // If next month is hight than 12
        if ( Main.month > 12 ) {
            
            // Increase year
            Main.year++;
            
            // Defaulr month
            Main.month = 1;
            
        }
        
        // Display calendar
        Main.show_calendar( Main.month, Main.day, Main.year);
        
    });

    /*
     * Set hours and minutes in the time picker
     *
     * @param object e with global object
     * 
     * @since   0.0.8.5 
     */    
    $(document).on('click', '#theme-open-time-picker-modal .theme-time-picker-hours-minutes-ok-btn', function (e) {
        e.preventDefault();

        // Get hour
        let hour = $('#theme-open-time-picker-modal .theme-time-picker-hours-minutes-select .theme-time-picker-hour-selected').attr('data-hour');

        // Get minute
        let minute = $('#theme-open-time-picker-modal .theme-time-picker-hours-minutes-select .theme-time-picker-minute-selected').attr('data-minute');

        // Verify if meridiem exists
        if ( $('#theme-open-time-picker-modal #theme-time-picker-hours-minutes-select').attr('data-meridiem') ) {

            // Get meridiem
            let meridiem = $('#theme-open-time-picker-modal .theme-time-picker-hours-minutes-select .theme-time-picker-meridiem-selected').attr('data-meridiem');

            // Set time's text
            $('#theme-open-time-picker-modal #theme-time-picker-hours-minutes-select').html('<i class="ri-time-line"></i> ' + hour + ':' + minute + ' ' + meridiem + ' <i class="ri-arrow-down-s-line"></i>');

            // Set meridiem
            $('#theme-open-time-picker-modal #theme-time-picker-hours-minutes-select').attr('data-meridiem', meridiem);
            
            // Set time
            Main.selected_time = hour + ':' + minute + ' ' + meridiem;
            
        } else {

            // Set time's text
            $('#theme-open-time-picker-modal #theme-time-picker-hours-minutes-select').html('<i class="ri-time-line"></i> ' + hour + ':' + minute + ' <i class="ri-arrow-down-s-line"></i>');

            // Set time
            Main.selected_time = hour + ':' + minute;

        }

        // Set hour
        $('#theme-open-time-picker-modal #theme-time-picker-hours-minutes-select').attr('data-hour', hour);

        // Set minute
        $('#theme-open-time-picker-modal #theme-time-picker-hours-minutes-select').attr('data-minute', minute);

        // Hide dropdown
        Main.hide_dropdown();
        
    });

    /*
     * Set time from the time picker
     *
     * @param object e with global object
     * 
     * @since   0.0.8.5 
     */    
    $(document).on('click', '#theme-open-time-picker-modal .default-time-set-time', function (e) {
        e.preventDefault();

        // Get date format
        let date_format = $('#theme-open-time-picker-modal').attr('data-date-format');

        // Set replacers
        let replacers = {
            'd': $('#theme-open-time-picker-modal').attr('data-day'),
            'm': $('#theme-open-time-picker-modal').attr('data-month'),
            'y': $('#theme-open-time-picker-modal').attr('data-year')
        };

        // Replace the date
        date_format = date_format.replace(/dd/g, replacers['d']);

        // Replace the month
        date_format = date_format.replace(/mm/g, replacers['m']);

        // Replace the year
        date_format = date_format.replace(/yyyy/g, replacers['y']);

        // Verify if time is enabled
        if ( parseInt($('#theme-open-time-picker-modal').attr('data-time')) === 1 ) {

            // Get hour
            let hour = $('#theme-open-time-picker-modal #theme-time-picker-hours-minutes-select').attr('data-hour');

            // Get minute
            let minute = $('#theme-open-time-picker-modal #theme-time-picker-hours-minutes-select').attr('data-minute');

            // Verify if time period exists
            if ( $('#theme-open-time-picker-modal #theme-time-picker-hours-minutes-select').attr('data-meridiem') ) {

                // Get meridiem
                let meridiem = $('#theme-open-time-picker-modal #theme-time-picker-hours-minutes-select').attr('data-meridiem');
                
                // Set time
                var get_time = date_format + ' ' + hour + ':' + minute + ' ' + meridiem;
                
                // Set meridiem
                $('.main .theme-time-picker[data-id="' + $(this).closest('#theme-open-time-picker-modal').attr('data-id') + '"]').attr('data-meridiem', meridiem);                
                
            } else {
                
                // Set time
                var get_time = date_format + ' ' + hour + ':' + minute;
                
            }

            // Set hour
            $('.main .theme-time-picker[data-id="' + $(this).closest('#theme-open-time-picker-modal').attr('data-id') + '"]').attr('data-hour', hour);
            
            // Set day
            $('.main .theme-time-picker[data-id="' + $(this).closest('#theme-open-time-picker-modal').attr('data-id') + '"]').attr('data-minute', minute);            

        } else {

            // Set time
            var get_time = date_format;

        }

        // Set day
        $('.main .theme-time-picker[data-id="' + $(this).closest('#theme-open-time-picker-modal').attr('data-id') + '"]').attr('data-day', $('#theme-open-time-picker-modal').attr('data-day'));

        // Set month
        $('.main .theme-time-picker[data-id="' + $(this).closest('#theme-open-time-picker-modal').attr('data-id') + '"]').attr('data-month', $('#theme-open-time-picker-modal').attr('data-month'));
        
        // Set year
        $('.main .theme-time-picker[data-id="' + $(this).closest('#theme-open-time-picker-modal').attr('data-id') + '"]').attr('data-year', $('#theme-open-time-picker-modal').attr('data-year'));

        // Set time
        $('.main .theme-time-picker[data-id="' + $(this).closest('#theme-open-time-picker-modal').attr('data-id') + '"]').attr('data-date', get_time).find('span').text(get_time);

        // Hide modal
        $('#theme-open-time-picker-modal').modal('hide');
        
    });

});