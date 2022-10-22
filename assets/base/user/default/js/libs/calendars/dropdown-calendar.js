/*
 * Dropdown Calendar JavaScript Default
*/

jQuery(document).ready( function ($) {
    'use strict';

    // Global variables
    var day, month, year, selected_date;
    
    /*******************************
    METHODS
    ********************************/

    /*
     * Display dropdown calendars
     * 
     * @since   0.0.8.5 
     */
    Main.default_dropdown_calendars = function () {

        // Verify if date pickers exists
        if ( $('.main .default-dropdown-date-picker').length > 0 ) {

            // Identify all time pickers
            $( '.main .default-dropdown-date-picker' ).each(function() {

                // Set day
                day = $(this).attr('data-date');

                // Set month
                month = $(this).attr('data-month');
                
                // Set year
                year = $(this).attr('data-year');

                // Format the date
                selected_date = year + '-' + month + '-' + day;

                // Get date format
                var date_format = $(this).closest('.default-dropdown-date-picker').attr('data-date-format');

                // Set replacers
                let replacers = {
                    'd': ( 10 > parseInt($(this).closest('.default-dropdown-date-picker').attr('data-date'))?'0' + parseInt($(this).closest('.default-dropdown-date-picker').attr('data-date')):parseInt($(this).closest('.default-dropdown-date-picker').attr('data-date'))),
                    'm': ( 10 > parseInt($(this).closest('.default-dropdown-date-picker').attr('data-month'))?'0' + parseInt($(this).closest('.default-dropdown-date-picker').attr('data-month')):parseInt($(this).closest('.default-dropdown-date-picker').attr('data-month'))),
                    'y': parseInt($(this).closest('.default-dropdown-date-picker').attr('data-year'))
                };

                // Default date
                var the_dropdown_date_picker = '';

                // Replace the separator
                the_dropdown_date_picker = date_format.replaceAll('/', '<span class="default-dropdown-date-picker-separator">' + '/' + '</span>');

                // Set date
                the_dropdown_date_picker = the_dropdown_date_picker.replace(/dd/g, '<span class="default-dropdown-date-picker-date" contenteditable="true" placeholder="00" maxlength="2">' + replacers['d'] + '</span>');

                // Replace the month
                the_dropdown_date_picker = the_dropdown_date_picker.replace(/mm/g, '<span class="default-dropdown-date-picker-month" contenteditable="true" placeholder="00" maxlength="2">' + replacers['m'] + '</span>');

                // Replace the year
                the_dropdown_date_picker = the_dropdown_date_picker.replace(/yyyy/g, '<span class="default-dropdown-date-picker-year" contenteditable="true" placeholder="0000" maxlength="4">' + replacers['y'] + '</span>');

                // Unique id
                let unique_id = Math.floor(Math.random() * 100);

                // Prepare content
                let content = '<div class="row">'
                    + '<div class="col-9">'
                        + '<div class="default-dropdown-date-picker-container">'
                            + the_dropdown_date_picker
                        + '</div>'
                    + '</div>'                                                                        
                    + '<div class="col-3 p-0 text-center">'
                        + '<div id="default-dropdown-date-picker-dropdown-' + unique_id + '" class="dropdown dropdown-options m-0 theme-dropdown-5 theme-dropdown-icon-1">'
                            + '<button class="btn btn-link" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown">'
                                + words.icon_arrow_down
                            + '</button>'
                            + '<div class="dropdown-menu default-dropdown-date-picker-dropdown-menu dropdown-menu-right">'
                                + '<div class="card">'
                                    + '<div class="card-body">'
                                        + '<table>'
                                            + '<thead>'
                                                + '<tr>'
                                                    + '<th class="text-center">'
                                                        + '<button type="button" class="btn btn-primary default-dropdown-date-picker-dropdown-previous-btn">'
                                                            + words.icon_arrow_left_line
                                                        + '</button>'
                                                    + '</th>'                                                                                                           
                                                    + '<th class="default-dropdown-date-picker-year-month">'
                                                        + Main.default_dropdown_calendar_the_month_year(month, year)
                                                    + '</th>'
                                                    + '<th class="text-center">'
                                                        + '<button type="button" class="btn btn-primary default-dropdown-date-picker-dropdown-next-btn">'
                                                            + words.icon_arrow_right_line
                                                        + '</button>'
                                                    + '</th>'
                                                + '</tr>'
                                            + '</thead>'
                                            + '<tbody>'
                                                + '<tr>'
                                                    + '<td colspan="3">'
                                                        + '<table>'
                                                            + '<tbody class="default-dropdown-date-picker-calendar-dates">'
                                                                + Main.default_dropdown_calendar_the_calendar(month, day, year)
                                                            + '</tbody>'
                                                        + '</table>'
                                                    + '</td>'
                                                + '</tr>'
                                            + '</tbody>'
                                        + '</table>'
                                    + '</div>'
                                + '</div>'
                            + '</div>'
                        + '</div>'
                    + '</div>'                                                                       
                + '</div>'; 

                // Add content
                $(this).html(content);
                
            });

        }

    };

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
    Main.default_dropdown_calendar_the_month_year = function ( month, year ) {

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
     * Display current month and year
     *
     * @param integer month contains the month
     * @param integer year contains the year
     * 
     * @since   0.0.8.5  
     */
    Main.default_dropdown_calendar_show_month_year = function ( month, year ) {

        // Add month and year
        $( '.default-dropdown-date-picker .default-dropdown-date-picker-dropdown-menu.show .default-dropdown-date-picker-year-month' ).text( Main.default_dropdown_calendar_the_month_year(month, year) );
        
    }

    /*
     * Create the calendar
     *
     * @param integer month contains the month
     * @param integer day contains the day
     * @param integer year contains the year
     * 
     * @since   0.0.8.5
     * 
     * @return string with html
     */
    Main.default_dropdown_calendar_the_calendar = function ( month, day, year ) {
        
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
        if ( parseInt($('.main .default-dropdown-date-picker').eq(0).attr('data-first-day')) === 1 ) {

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
                n += '</tr>'
                + '<tr>';
            }
            
            if ( fday <= s ) {

                let this_month = (parseInt(month) < 10) ? '0' + parseInt(month) : month;

                let this_date = (show < 10) ? '0' + show : show;

                var add_date = '';

                if ( year + '-' + this_month + '-' + this_date === selected_date ) {

                    add_date = 'default-dropdown-date-picker-calendar-selected-date';

                }

                if ( ( this_date === day ) && ( parseInt(month) === current.getMonth() + 1 ) && ( year === current.getFullYear() ) ) {

                    n += '<td>'
                        + '<a href="#" class="default-current-day ' + add_date + '" data-date="' + year + '-' + this_month + '-' + this_date + '">'
                            + this_date
                        + '</a>'
                    + '</td>';

                } else {

                    if ( ( ( show < day ) && ( parseInt(month) === current.getMonth() + 1 ) && ( year == current.getFullYear() ) ) || ( ( ( parseInt(month) < current.getMonth() + 1 ) && ( year <= current.getFullYear() ) ) || ( year < current.getFullYear() ) ) ) {

                        n += '<td>'
                            + '<a href="#" data-date="' + year + '-' + this_month + '-' + this_date + '" class="' + add_date + '">'
                                + this_date
                            + '</a>'
                        + '</td>';

                    } else {

                        n += '<td>'
                            + '<a href="#" data-date="' + year + '-' + this_month + '-' + this_date + '" class="' + add_date + '">'
                                + this_date
                            + '</a>'
                        + '</td>';

                    }

                }

                show++;

            } else {

                n += '<td>'
                + '</td>';

            }

        }

        n += '</tr>';
        
        return n;
        
    };

    /*
     * Display calendar
     *
     * @param integer month contains the month
     * @param integer day contains the day
     * @param integer year contains the year
     * 
     * @since   0.0.8.5 
     */
    Main.default_dropdown_calendar_show_calendar = function ( month, day, year ) {

        // Display month and year
        Main.default_dropdown_calendar_show_month_year( month, year );
        
        // Display calendar's content
        $( '.default-dropdown-date-picker .default-dropdown-date-picker-dropdown-menu.show .default-dropdown-date-picker-calendar-dates' ).html( Main.default_dropdown_calendar_the_calendar( month, day, year ) );
        
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

        // Display dropdown calendars
        Main.default_dropdown_calendars();

    });

    /*
     * Detect date picker keypress
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.5
     */
    $( document ).on('keypress', '.default-dropdown-date-picker [contenteditable=true]', function(e) {

        // Verify if is not numeric
        if ( isNaN(String.fromCharCode(e.which)) ) {
            e.preventDefault();
        }

        // Verify if maxlength exists
        if ( $(this).attr('maxlength') && $(this).text() ) {

            // Verify if length is greater
            if ( $(this).text().trim().length >= $(this).attr('maxlength') ) {
                e.preventDefault();
            }

        }

    });

    /*
     * Detect date picker keyup
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.5
     */
    $( document ).on('keyup', '.default-dropdown-date-picker [contenteditable=true]', function(e) {

        // Get text
        let text = $(this).text();

        // Verify if text exists
        if ( text ) {

            // Remove spaces
            let clean = text.trim();

            // Empty container
            $(this).empty();
    
            // Insert text
            document.execCommand('insertText', false, clean);
            
            // Add changes
            $(this).focus();

            // Verify if is datepicker
            if ( $(this).closest('.default-dropdown-date-picker').length > 0 ) {

                // Verify if the month and date contains 2 characters
                if ( ($(this).closest('.default-dropdown-date-picker').find('.default-dropdown-date-picker-month').text().length > 1) && ($(this).closest('.default-dropdown-date-picker').find('.default-dropdown-date-picker-date').text().length > 1 ) ) {

                    // Set date
                    let the_date = new Date($(this).closest('.default-dropdown-date-picker').find('.default-dropdown-date-picker-year').text() + '/' + $(this).closest('.default-dropdown-date-picker').find('.default-dropdown-date-picker-month').text() + '/' + $(this).closest('.default-dropdown-date-picker').find('.default-dropdown-date-picker-date').text());

                    // Verify if the date is valid
                    if ( the_date.getTime() === the_date.getTime() ) {

                        // Format the date
                        selected_date = $(this).closest('.default-dropdown-date-picker').find('.default-dropdown-date-picker-year').text() + '-' + $(this).closest('.default-dropdown-date-picker').find('.default-dropdown-date-picker-month').text() + '-' + $(this).closest('.default-dropdown-date-picker').find('.default-dropdown-date-picker-date').text();

                        // Set day
                        $(this).closest('.default-dropdown-date-picker').attr('data-date', $(this).closest('.default-dropdown-date-picker').find('.default-dropdown-date-picker-date').text());

                        // Set month
                        $(this).closest('.default-dropdown-date-picker').attr('data-month', $(this).closest('.default-dropdown-date-picker').find('.default-dropdown-date-picker-month').text());

                        // Set year
                        $(this).closest('.default-dropdown-date-picker').attr('data-year', $(this).closest('.default-dropdown-date-picker').find('.default-dropdown-date-picker-year').text());

                        // Reload calendar's content
                        $(this).closest('.default-dropdown-date-picker').find('.default-dropdown-date-picker-dropdown-menu .default-dropdown-date-picker-calendar-dates').html( Main.default_dropdown_calendar_the_calendar( $(this).closest('.default-dropdown-date-picker').find('.default-dropdown-date-picker-month').text(), $(this).closest('.default-dropdown-date-picker').find('.default-dropdown-date-picker-date').text(), $(this).closest('.default-dropdown-date-picker').find('.default-dropdown-date-picker-year').text() ) );

                        // Add month and year
                        $(this).closest('.default-dropdown-date-picker').find('.default-dropdown-date-picker-dropdown-menu .default-dropdown-date-picker-year-month' ).text( Main.default_dropdown_calendar_the_month_year($(this).closest('.default-dropdown-date-picker').find('.default-dropdown-date-picker-month').text(), $(this).closest('.default-dropdown-date-picker').find('.default-dropdown-date-picker-year').text()) );

                    }

                }
                
            }

        }

    });

    /*
     * Detect date picker paste
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.5
     */
    $( document ).on('paste', '.default-dropdown-date-picker [contenteditable=true]', function(e) {
        e.preventDefault();
    });

    /*
     * Go back button
     *
     * @param object e with global object
     * 
     * @since   0.0.8.5 
     */    
    $(document).on('click', '.default-dropdown-date-picker .default-dropdown-date-picker-dropdown-menu.show .default-dropdown-date-picker-dropdown-previous-btn', function (e) {
        e.preventDefault();

        // Decrease month
        month--;

        // Verify if month is 0
        if ( month < 1 ) {
            
            // Decrease year
            year--;

            // Default month
            month = 12;
            
        }
        
        // Display calendar
        Main.default_dropdown_calendar_show_calendar( month, day, year);
        
    });
    
    /*
     * Go next button
     *
     * @param object e with global object
     * 
     * @since   0.0.8.5 
     */    
    $(document).on('click', '.default-dropdown-date-picker .default-dropdown-date-picker-dropdown-menu.show .default-dropdown-date-picker-dropdown-next-btn', function (e) {
        e.preventDefault();

        // Increase month
        month++;

        // If next month is hight than 12
        if ( month > 12 ) {
            
            // Increase year
            year++;
            
            // Defaulr month
            month = 1;
            
        }
        
        // Display calendar
        Main.default_dropdown_calendar_show_calendar( month, day, year);
        
    });

    /*
     * Select a date
     *
     * @param object e with global object
     * 
     * @since   0.0.8.5 
     */  
    $(document).on('click', '.default-dropdown-date-picker .default-dropdown-date-picker-calendar-dates tr td a', function (e) {
        e.preventDefault();

        // Remove class default-dropdown-date-picker-calendar-selected-date
        $('.default-dropdown-date-picker .default-dropdown-date-picker-calendar-dates tr td a').removeClass('default-dropdown-date-picker-calendar-selected-date');
        
        // Add class default-dropdown-date-picker-calendar-selected-date
        $(this).addClass('default-dropdown-date-picker-calendar-selected-date');

        // Get the selected date
        let the_selected_date = $(this).attr('data-date');

        // Split date
        let split_date = the_selected_date.split( '-' );

        // Format the date
        selected_date = split_date[0] + '-' + split_date[1] + '-' + split_date[2];

        // Set day
        $(this).closest('.default-dropdown-date-picker').attr('data-date', split_date[2]);
        $(this).closest('.default-dropdown-date-picker').find('.default-dropdown-date-picker-date').text(split_date[2]);

        // Set month
        $(this).closest('.default-dropdown-date-picker').attr('data-month', split_date[1]);
        $(this).closest('.default-dropdown-date-picker').find('.default-dropdown-date-picker-month').text(split_date[1]);

        // Set year
        $(this).closest('.default-dropdown-date-picker').attr('data-year', split_date[0]);
        $(this).closest('.default-dropdown-date-picker').find('.default-dropdown-date-picker-year').text(split_date[0]);

    });

});