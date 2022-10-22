/*
 * Default Planner JavaScript file
*/

(function( $ ) {

    /*******************************
      SMALL CALENDAR
    ********************************/
 
    /*
     * Show the small calendar
     * 
     * @param object options
     */  
    $.fn.default_planner_show_small_calendar = function(options) {

        // Save this
        let $this = this;

        // Verify if the small calendar has the required parameters
        if ( !$this.attr('data-month') || !$this.attr('data-date') || !$this.attr('data-year') || !$this.attr('data-first-day') ) {
            return
        }

        // Check if the plugin wasn't initiated
        if ( $this.find('.default-planner-small-calendar').length < 1 ) {

            // Detect previous month click
            $this.on('click', '.default-planner-small-calendar-go-back-btn', function (e) {
                e.preventDefault();

                // Display the previous month in the small calendar
                $this.default_planner_show_previous_month_in_small_calendar();

            });

            // Detect next month click
            $this.on('click', '.default-planner-small-calendar-go-next-btn', function (e) {
                e.preventDefault();

                // Display the next month in the small calendar
                $this.default_planner_show_next_month_in_small_calendar();

            });

            // Detect date click
            $this.on('click', '.default-dropdown-date-picker-calendar-dates a', function (e) {
                e.preventDefault();

                // Change the date in the big calendar
                $this.default_planner_change_date_in_big_calendar($(this));

            });

        }
 
        // Small calendar container
        let small_calendar_container = '<table class="default-planner-small-calendar">'
            + '<thead>'
                + '<tr>'
                    + '<th class="default-dropdown-date-picker-year-month">'
                        + '<h4></h4>'
                    + '</th>'
                    + '<th class="text-center">'
                        + '<button type="button" class="btn btn-primary default-planner-small-calendar-go-back-btn">'
                            + words.icon_bi_chevron_left
                        + '</button>'
                    + '</th>'
                    + '<th class="text-center">'
                        + '<button type="button" class="btn btn-primary default-planner-small-calendar-go-next-btn">'
                            + words.icon_bi_chevron_right
                        + '</button>'
                    + '</th>'
                + '</tr>'
            + '</thead>'
            + '<tbody>'
                + '<tr>'
                    + '<td colspan="3">'
                        + '<table>'
                            + '<tbody class="default-dropdown-date-picker-calendar-dates"></tbody>'
                        + '</table>'
                    + '</td>'
                + '</tr>'
            + '</tbody>'
        + '</table>';

        // Add the small calendar container in the planner
        $this.html(small_calendar_container);

        // Generate calendar
        $this.default_planner_show_small_calendar_dates(parseInt($this.attr('data-month')), parseInt($this.attr('data-date')), parseInt($this.attr('data-year')));

        // Set a short pause
        setTimeout(function () {

            // Show month and year
            $this.find('.default-planner-small-calendar h4').html( words.icon_bi_calendar2_check + ' ' + $this.default_planner_the_month_text($this.attr('data-month')) + ' ' + $this.attr('data-year') );

        }, 300);

        // Verify dateClick exists
        if ( typeof options.dateClick === 'function' ) {

            // Register the hook
            this.dateClick = options.dateClick;

        }

    };

    /*
     * Display small calendar dates
     *
     * @param integer month contains the month
     * @param integer day contains the day
     * @param integer year contains the year
     */
    $.fn.default_planner_show_small_calendar_dates = function ( month, day, year ) {
        
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
        if ( parseInt(this.attr('data-first-day')) === 1 ) {

            // Set days of the week
            var n = '<tr>'
                        + '<td>'
                            + words.day_1
                        + '</td>'
                        + '<td>'
                            + words.day_2
                        + '</td>'
                        + '<td>'
                            + words.day_3
                        + '</td>'
                        + '<td>'
                            + words.day_4
                        + '</td>'
                        + '<td>'
                            + words.day_5
                        + '</td>'
                        + '<td>'
                            + words.day_6
                        + '</td>'
                        + '<td>'
                            + words.day_7
                        + '</td>'
                    + '</tr>'
                    + '<tr>';

            // Set day calc
            var day_calc = 2;

        } else {

            // Set days of the week
            var n = '<tr>'
                        + '<td>'
                            + words.day_7
                        + '</td>'
                        + '<td>'
                            + words.day_1
                        + '</td>'
                        + '<td>'
                            + words.day_2
                        + '</td>'
                        + '<td>'
                            + words.day_3
                        + '</td>'
                        + '<td>'
                            + words.day_4
                        + '</td>'
                        + '<td>'
                            + words.day_5
                        + '</td>'
                        + '<td>'
                            + words.day_6
                        + '</td>'
                    + '</tr>'
                    + '<tr>';

            // Set day calc
            var day_calc = 1;

        }

        // Reached month
        var reached = 0;

        // Calculate days
        for ( var s = day_calc; s < 50; s++ ) {

            // Verify if the last day is reached
            if ( show > d.getDate() ) {

                // Reset show
                show = 1;

                // Increase reached
                reached++;

            }

            // Verify if is a week
            if ( (s - day_calc) % 7 === 0 ) {

                // Verify if the last day is reached
                if ( ( show > d.getDate() ) || ( reached > 0 ) ) {
                    break;
                }

                // Set tr
                n += '</tr>'
                + '<tr>';

            }
            
            if ( fday <= s ) {

                let this_month = (parseInt(month) < 10) ? '0' + parseInt(month) : month;

                let this_date = (show < 10) ? '0' + show : show;

                var add_date = '';

                // Verify if the last day is reached
                if ( reached > 0 ) {

                    // Set grey color
                    add_date = ' theme-color-grey';

                }

                // Verify if is the current day
                if ( ( parseInt(this_date) === day ) && ( parseInt(this_month) === current.getMonth() + 1 ) && ( year === current.getFullYear() ) && (reached < 1) ) {

                    // Set current day
                    n += '<td>'
                        + '<a href="#" class="default-planner-small-calendar-current-day ' + add_date + '" data-year="' + year + '" data-month="' + this_month + '" data-date="' + this_date + '">'
                            + this_date
                        + '</a>'
                    + '</td>';

                } else {

                    if ( ( ( show < day ) && ( parseInt(month) === current.getMonth() + 1 ) && ( year == current.getFullYear() ) ) || ( ( ( parseInt(month) < current.getMonth() + 1 ) && ( year <= current.getFullYear() ) ) || ( year < current.getFullYear() ) ) ) {

                        // Set day
                        n += '<td>'
                            + '<a href="#" class="' + add_date + '" data-year="' + year + '" data-month="' + this_month + '" data-date="' + this_date + '">'
                                + this_date
                            + '</a>'
                        + '</td>';

                    } else {

                        // Set day
                        n += '<td>'
                            + '<a href="#" class="' + add_date + '" data-year="' + year + '" data-month="' + this_month + '" data-date="' + this_date + '">'
                                + this_date
                            + '</a>'
                        + '</td>';

                    }

                }

                show++;

            } else {
                
                // Get previous date
                let pd = new Date(year, month, 0);

                // Set first day of the month
                pd.setDate(1);

                // Calculate days
                var pdays =  (pd.getDay() - s);

                // Increase pdays
                pdays++;

                // Set hours
                pd.setHours(((pdays * 24) - ((pdays * 24) * 2))); 

                // Set this date
                let this_date = (pd.getDate() < 10) ? '0' + pd.getDate() : pd.getDate();

                // Set this month
                let this_month = (parseInt(pd.getDate()) < 10) ? '0' + parseInt(pd.getDate()) : pd.getDate();

                // Set date
                n += '<td>'
                    + '<a href="#" class="default-planner-previous-month-day theme-color-grey" data-year="' + pd.getFullYear() + '" data-month="' + this_month + '" data-date="' + this_date + '">'
                        + this_date
                    + '</a>'
                + '</td>';

            }

        }

        n += '</tr>';

        // Calendar's table
        let calendar = '<table>'
            + '<tbody class="default-dropdown-date-picker-calendar-dates">'
                + n
            + '</tbody>'
        + '</table>';

        // Display the calendar
        this.find('.default-planner-small-calendar tbody > tr > td').html(calendar);
        
    };

    /*
     * Display previous month in the small calendar
     */
    $.fn.default_planner_show_previous_month_in_small_calendar = function () {
        
        // Get small calendar
        let small_calendar = this;

        // Set month
        var month = small_calendar.attr('data-month');

        // Set year
        var year = small_calendar.attr('data-year');

        // Increase month
        month--;        

        // If next month is hight than 12
        if ( month < 1 ) {
            
            // Increase year
            year--;
            
            // Default month
            month = 12;
            
        }

        // Set month
        small_calendar.attr('data-month', month);

        // Set year
        small_calendar.attr('data-year', year);

        // Generate calendar
        this.default_planner_show_small_calendar_dates(parseInt(small_calendar.attr('data-month')), parseInt(small_calendar.attr('data-date')), parseInt(small_calendar.attr('data-year')));

        // Show month and year
        this.find('.default-planner-small-calendar h4').html( words.icon_bi_calendar2_check + ' ' + this.default_planner_the_month_text(small_calendar.attr('data-month')) + ' ' + small_calendar.attr('data-year') );

    };

    /*
     * Display next month in the small calendar
     */
    $.fn.default_planner_show_next_month_in_small_calendar = function () {
        
        // Get small calendar
        let small_calendar = this;

        // Set month
        var month = small_calendar.attr('data-month');

        // Set year
        var year = small_calendar.attr('data-year');

        // Increase month
        month++;        

        // If next month is hight than 12
        if ( month > 12 ) {
            
            // Increase year
            year++;
            
            // Default month
            month = 1;
            
        }

        // Set month
        small_calendar.attr('data-month', month);

        // Set year
        small_calendar.attr('data-year', year);

        // Generate calendar
        this.default_planner_show_small_calendar_dates(parseInt(small_calendar.attr('data-month')), parseInt(small_calendar.attr('data-date')), parseInt(small_calendar.attr('data-year')));

        // Show month and year
        this.find('.default-planner-small-calendar h4').html( words.icon_bi_calendar2_check + ' ' + this.default_planner_the_month_text(small_calendar.attr('data-month')) + ' ' + small_calendar.attr('data-year') );
        
    };

    /*******************************
      FILTERS
    ********************************/

    /*
     * Show the filters
     *
     * @param object options
     */  
    $.fn.default_planner_show_filters = function(options) {

        // Save this
        let $this = this;
        
        // Verify if the options has the title and icons parameter
        if ( (typeof options.title === 'undefined') || (typeof options.icons === 'undefined') ) {
            return;
        }

        // Verify if the options has the icons
        if ( (typeof options.icons.title === 'undefined') || (typeof options.icons.manage === 'undefined') ) {
            return;
        }

        // New filter button
        var new_filter = '';

        // Verify if new filter button should be displayed
        if ( typeof options.newFilter === 'number' ) {

            if ( options.newFilter === 1 ) {

                // Set new filter button
                new_filter = '<a href="#" class="default-planner-sidebar-filters-manage-btn">'
                    + options.icons.manage
                + '</a>';

            }

        }

        // Create the categories box
        let categories = '<div class="default-planner-sidebar-filters-header">'
            + '<div class="row">'
                + '<div class="col-8">'
                    + '<h4>'
                        + options.icons.title
                        + options.title
                    + '</h4>'
                + '</div>'
                + '<div class="col-4 text-right">'
                    + new_filter
                + '</div>'
            + '</div>'
        + '</div>'
        + '<div class="default-planner-sidebar-filters-list">'
            + '<ul>'

            + '</ul>'
        + '</div>';

        // Add the events box in the planner
        $this.html(categories);

    };

    /*******************************
      BIG CALENDAR
    ********************************/

    /*
     * Show the big calendar
     *
     * @param object options
     */  
    $.fn.default_planner_show_big_calendar = function(options) {

        // Save this
        let $this = this;

        // Verify if the big calendar has the required parameters
        if ( !$this.attr('data-month') || !$this.attr('data-date') || !$this.attr('data-year') || !$this.attr('data-first-day') || !$this.attr('data-hour-format') ) {
            return
        }

        // Check if the plugin wasn't initiated
        if ( $this.find('.default-planner-calendar-header').length < 1 ) {

            // Detect navigation button click
            $this.on('change', '.default-planner-calendar-navigation-tabs input[type="radio"]', function () {

                // Remove the events
                $this.find('.default-planner-calendar-events-list').empty();

                // Remove the show all
                $this.find('.default-planner-calendar-events-show-all').attr('data-events', 0).find('a').empty();

                // Display the big calendar tab
                $this.default_planner_show_tab_in_big_calendar();

                // Verify if view change exists
                if ( $this.viewChange ) {

                    // Run function
                    $this.viewChange();

                }

            });        

            // Detect previous events button click
            $this.on('click', '.default-planner-calendar-navigation-previous-events-btn', function (e) {
                e.preventDefault();

                // Display the next events in the big calendar
                $this.default_planner_show_previous_events_in_big_calendar();

            });

            // Detect today events button click
            $this.on('click', '.default-planner-calendar-navigation-today-events-btn', function (e) {
                e.preventDefault();

                // Display the today events in the big calendar
                $this.default_planner_show_today_events_in_big_calendar();

            });

            // Detect show all events link click
            $this.on('click', '.default-planner-calendar-tab-events-show-all > a', function (e) {
                e.preventDefault();
                
                // Display all events in the big calendar sidebar
                $this.default_planner_show_all_events_in_big_calendar_sidebar();            

            });

            // Detect hide all events link click
            $this.on('click', '.default-planner-events .default-planner-events-hide-btn', function (e) {
                e.preventDefault();
                
                // Hide the big calendar sidebar
                $this.default_planner_hide_all_events_in_big_calendar_sidebar();            

            });

            // Detect next month click
            $this.on('click', '.default-planner-calendar-navigation-next-events-btn', function (e) {
                e.preventDefault();

                // Display the next events in the big calendar
                $this.default_planner_show_next_events_in_big_calendar();

            });

            // Unique ID
            let unique_id = Math.floor(Math.random() * 100);

            // Prepare the view
            let view = $this.attr('data-view')?$this.attr('data-view'):'day';

            // Tabs
            let tabs = {
                0: (view === 'day')?' checked':'',
                1: (view === 'week')?' checked':'',
                2: (view === 'month')?' checked':''
            };

            // Slides
            let slides = {
                0: (view === 'day')?' active':'',
                1: (view === 'week')?' active':'',
                2: (view === 'month')?' active':''
            };

            // New event button
            var new_event = '';

            // Verify if new event button should be displayed
            if ( typeof options.newEvent === 'number' ) {

                if ( options.newEvent === 1 ) {

                    // Set new event button
                    new_event = '<div class="default-planner-calendar-new-event">'
                        + '<button type="button" class="btn btn-primary default-planner-calendar-new-event-btn">'
                            + words.icon_add
                        + '</button>'
                    + '</div>';

                }

            }
    
            // Big calendar container
            let big_calendar_container = '<div class="default-planner-calendar-header">'
                + '<div class="row">'
                    + '<div class="col-3">'
                        + '<h3></h3>'
                    + '</div>'
                    + '<div class="col-6 text-center">'
                        + '<div class="default-planner-calendar-navigation-tabs">'
                            + '<div class="default-planner-calendar-navigation-tabs-navigation">'
                                + '<input name="tab" type="radio" value="0" class="default-planner-calendar-navigation-tab default-planner-calendar-navigation-tab-1" id="default-planner-calendar-navigation-tab-1-' + unique_id + '"' + tabs[0] + ' />'
                                + '<label for="default-planner-calendar-navigation-tab-1-' + unique_id + '">'
                                    + words.day
                                + '</label>'
                                + '<input name="tab" type="radio" value="1" class="default-planner-calendar-navigation-tab default-planner-calendar-navigation-tab-2" id="default-planner-calendar-navigation-tab-2-' + unique_id + '"' + tabs[1] + ' />'
                                + '<label for="default-planner-calendar-navigation-tab-2-' + unique_id + '">'
                                    + words.week
                                + '</label>'
                                + '<input name="tab" type="radio" value="2" class="default-planner-calendar-navigation-tab default-planner-calendar-navigation-tab-3" id="default-planner-calendar-navigation-tab-3-' + unique_id + '"' + tabs[2] + ' />'
                                + '<label for="default-planner-calendar-navigation-tab-3-' + unique_id + '">'
                                    + words.month
                                + '</label>'                                
                                + '<div class="default-planner-calendar-navigation-tabs-navigation-active"></div>'
                            + '</div>'
                        + '</div>'
                    + '</div>'
                    + '<div class="col-3 text-right">'
                        + '<div class="btn-group default-planner-calendar-navigation" role="group" aria-label="Calendar Navigation">'
                            + '<button type="button" class="btn btn-secondary default-planner-calendar-navigation-previous-events-btn">'
                                + words.icon_bi_chevron_left
                            + '</button>'
                            + '<button type="button" class="btn btn-secondary default-planner-calendar-navigation-today-events-btn">'
                                + '<span>'
                                    + words.today
                                + '</span>'
                            + '</button>'
                            + '<button type="button" class="btn btn-secondary default-planner-calendar-navigation-next-events-btn">'
                                + words.icon_bi_chevron_right
                            + '</button>'
                        + '</div>'
                    + '</div>'
                + '</div>'
            + '</div>'
            + '<div class="default-planner-calendar-body">'
                + '<div class="carousel slide default-planner-calendar-tabs" data-interval="false">'
                    + '<div class="carousel-inner">'
                        + '<div class="carousel-item' + slides[0] + ' default-planner-calendar-tab-day">'
                            + '<div class="default-planner-calendar-tab-day-header d-flex">'
                                + '<div class="default-planner-calendar-tab-day-header-time">'
                                    + words.icon_bi_clock
                                + '</div>'
                                + '<div class="default-planner-calendar-tab-day-header-days">'
                                    + '<div class="row">'
                                        + '<div class="col-6">'
                                            + '<h3></h3>'
                                        + '</div>'
                                        + '<div class="col-6 text-right"></div>'
                                    + '</div>'
                                + '</div>'
                            + '</div>'
                            + '<div class="default-planner-calendar-tab-day-body theme-scrollbar-1"></div>'
                        + '</div>'
                        + '<div class="carousel-item' + slides[1] + ' default-planner-calendar-tab-week">'
                            + '<div class="default-planner-calendar-tab-week-header d-flex">'
                                + '<div class="default-planner-calendar-tab-week-header-time">'
                                    + words.icon_bi_clock
                                + '</div>'
                                + '<div class="default-planner-calendar-tab-week-header-days"></div>'
                            + '</div>'
                            + '<div class="default-planner-calendar-tab-week-body theme-scrollbar-1"></div>'
                        + '</div>'
                        + '<div class="carousel-item' + slides[2] + ' default-planner-calendar-tab-month">'
                            + '<div class="default-planner-calendar-tab-month-header">'
                                + '<div class="default-planner-calendar-tab-month-header-days"></div>'
                            + '</div>'
                            + '<div class="default-planner-calendar-tab-month-body"></div>'
                        + '</div>'
                    + '</div>'
                + '</div>'
                + new_event
            + '</div>';

            // Add the big calendar container in the planner
            $this.html(big_calendar_container);

            // Set a short pause
            setTimeout(function () {

                // Display the big calendar
                $this.default_planner_show_big_calendar_data();

                // Verify setEvents exists
                if ( typeof options.setEvents === 'object' ) {

                    // Add events to the calendar
                    $this.default_planner_set_events_in_big_calendar(options.setEvents);

                } 

            }, 300);

            // Verify viewChange exists
            if ( typeof options.viewChange === 'function' ) {

                // Register the hook
                this.viewChange = options.viewChange;

            }

            // Verify dateChange exists
            if ( typeof options.dateChange === 'function' ) {

                // Register the hook
                this.dateChange = options.dateChange;

            } 

        } else {

            // Set a short pause
            setTimeout(function () {

                // Verify setEvents exists
                if ( typeof options.setEvents === 'object' ) {

                    // Add events to the calendar
                    $this.default_planner_set_events_in_big_calendar(options.setEvents);

                } 

            }, 400);

        }

    };

    /*
     * Display the big calendar data
     */
    $.fn.default_planner_show_big_calendar_data = function () {

        // Show month and year
        this.find('.default-planner-calendar-header h3').html( this.default_planner_the_month_text(this.attr('data-month')) + ' ' + this.attr('data-year') );

        // Get the calendar date
        let the_calendar_date = new Date(this.attr('data-year') + '-' + this.attr('data-month') + '-' + this.attr('data-date'));

        // Display day hours
        this.default_planner_show_day_hours_in_big_calendar(the_calendar_date);

        // Show day of the week and date
        this.find('.default-planner-calendar-tab-day-header-days h3').html( this.default_planner_the_day_text(the_calendar_date.getDay()) + ' ' + parseInt(this.attr('data-date')) );
        
        // Display week days and dates
        this.default_planner_show_week_days_dates_in_big_calendar(the_calendar_date);

        // Display week hours
        this.default_planner_show_week_hours_in_big_calendar(the_calendar_date);

        // Display week days in the month calendar view
        this.default_planner_show_week_days_for_month_in_big_calendar();
    
        // Display dates in the month calendar view
        this.default_planner_show_dates_for_month_in_big_calendar(new Date(this.attr('data-year') + '-' + this.attr('data-month') + '-' + this.attr('data-date')));

    };

    /*
     * Display a tab in the big calendar data
     */
    $.fn.default_planner_show_tab_in_big_calendar = function () {

        // Change the tab
        this.find('.default-planner-calendar-tabs').carousel(parseInt(this.find('.default-planner-calendar-navigation-tab:checked').val()));

        // Change the view
        switch ( parseInt(this.find('.default-planner-calendar-navigation-tab:checked').val()) ) {

            case 0:

                // Set day
                this.attr('data-view', 'day');

                break;

            case 1:

                // Set week
                this.attr('data-view', 'week');

                break;

            case 2:

                // Set month
                this.attr('data-view', 'month');

                break;

        }

    };

    /*
     * Display day hours in the big calendar
     * 
     * @param object the_date contains the date
     */
    $.fn.default_planner_show_day_hours_in_big_calendar = function (the_date) {

        // The hours container
        var hours = '';

        // List the hours
        for ( var h = 0; h < 24; h++ ) {

            // Calculate the hour
            var hour = h;

            // Verify if is the 12 hours format
            if ( this.attr('data-hour-format') === '12' ) {

                // Prepare the hour
                hour = (hour > 12)?parseInt((hour - 12)) + ':00 PM':parseInt(hour) + ':00 AM';

            } else {

                // Prepare the hour
                hour = parseInt(hour) + ':00';
                
            }

            // Add hour html to the container
            hours += '<div class="default-planner-calendar-tab-day-hour">'
                + '<div class="default-planner-calendar-tab-day-hour-time">'
                    + '<span>'
                        + hour
                    + '</span>'
                + '</div>'
                + '<div class="default-planner-calendar-events" data-year="' + the_date.getFullYear() + '" data-month="' + (the_date.getMonth() + 1) + '" data-date="' + the_date.getDate() + '" data-hour="' + h + '">'
                    + '<div class="default-planner-calendar-events-list">'
                    + '</div>'
                    + '<div class="default-planner-calendar-events-show-all" data-events="0" data-events-word="' + words.events + '">'
                        + '<a href="#"></a>'
                    + '</div>' 
                +'</div>'
            + '</div>';

        }

        // Display the hours
        this.find('.default-planner-calendar-tab-day-body').html(hours);

    };

    /*
     * Display week hours in the big calendar
     * 
     * @param object the_date contains the date
     */
    $.fn.default_planner_show_week_hours_in_big_calendar = function (the_date) {

        // Get the day
        let the_day = ( parseInt(this.attr('data-first-day')) === 1 )?new Date(the_date).getDay():(new Date(the_date).getDay() + 1);

        // Calculate the time difference
        let time_difference = the_date.getDate() - the_day + (the_day === 0 ? -6 : 1);

        // First day of the week
        let first_day = new Date(the_date.setDate(time_difference)).getTime();

        // The hours container
        var hours = '';

        // List the hours
        for ( var h = 0; h < 24; h++ ) {

            // Calculate the hour
            var hour = h;

            // Verify if is the 12 hours format
            if ( this.attr('data-hour-format') === '12' ) {

                // Prepare the hour
                hour = (hour > 12)?this.default_planner_the_hour((hour - 12)) + ':00 AM':this.default_planner_the_hour(hour) + ':00 PM';

            } else {

                // Prepare the hour
                hour = this.default_planner_the_hour(hour) + ':00';
                
            }

            // Prepare the hour container
            let hour_container = '<div class="default-planner-calendar-events-list">'
            + '</div>'
            + '<div class="default-planner-calendar-events-show-all" data-events="0" data-events-word="' + words.events + '">'
                + '<a href="#"></a>'
            + '</div>';

            // Verify if the first day of the week is monday
            if ( parseInt(this.attr('data-first-day')) === 1 ) {

                // Add hour html to the container
                hours += '<div class="default-planner-calendar-tab-week-hour">'
                    + '<div class="default-planner-calendar-tab-week-hour-time">'
                        + '<span>'
                            + hour
                        + '</span>'
                    + '</div>'
                    + '<div class="default-planner-calendar-tab-week-days">'
                        + '<div class="default-planner-calendar-events" data-year="' + new Date(first_day).getFullYear() + '" data-month="' + (this.default_planner_the_month(new Date(first_day).getMonth()) + 1) + '" data-date="' + this.default_planner_the_date(new Date(first_day).getDate()) + '" data-hour="' + this.default_planner_the_hour(h) + '">' + hour_container + '</div>'
                        + '<div class="default-planner-calendar-events" data-year="' + new Date(first_day + (1 * 24) * 60 * 60 * 1000).getFullYear() + '" data-month="' + (this.default_planner_the_month(new Date(first_day + (1 * 24) * 60 * 60 * 1000).getMonth()) + 1) + '" data-date="' + this.default_planner_the_date(new Date(first_day + (1 * 24) * 60 * 60 * 1000).getDate()) + '" data-hour="' + this.default_planner_the_hour(h) + '">' + hour_container + '</div>'
                        + '<div class="default-planner-calendar-events" data-year="' + new Date(first_day + (2 * 24) * 60 * 60 * 1000).getFullYear() + '" data-month="' + (this.default_planner_the_month(new Date(first_day + (2 * 24) * 60 * 60 * 1000).getMonth()) + 1) + '" data-date="' + this.default_planner_the_date(new Date(first_day + (2 * 24) * 60 * 60 * 1000).getDate()) + '" data-hour="' + this.default_planner_the_hour(h) + '">' + hour_container + '</div>'
                        + '<div class="default-planner-calendar-events" data-year="' + new Date(first_day + (3 * 24) * 60 * 60 * 1000).getFullYear() + '" data-month="' + (this.default_planner_the_month(new Date(first_day + (3 * 24) * 60 * 60 * 1000).getMonth()) + 1) + '" data-date="' + this.default_planner_the_date(new Date(first_day + (3 * 24) * 60 * 60 * 1000).getDate()) + '" data-hour="' + this.default_planner_the_hour(h) + '">' + hour_container + '</div>'
                        + '<div class="default-planner-calendar-events" data-year="' + new Date(first_day + (4 * 24) * 60 * 60 * 1000).getFullYear() + '" data-month="' + (this.default_planner_the_month(new Date(first_day + (4 * 24) * 60 * 60 * 1000).getMonth()) + 1) + '" data-date="' + this.default_planner_the_date(new Date(first_day + (4 * 24) * 60 * 60 * 1000).getDate()) + '" data-hour="' + this.default_planner_the_hour(h) + '">' + hour_container + '</div>' 
                        + '<div class="default-planner-calendar-events" data-year="' + new Date(first_day + (5 * 24) * 60 * 60 * 1000).getFullYear() + '" data-month="' + (this.default_planner_the_month(new Date(first_day + (5 * 24) * 60 * 60 * 1000).getMonth()) + 1) + '" data-date="' + this.default_planner_the_date(new Date(first_day + (5 * 24) * 60 * 60 * 1000).getDate()) + '" data-hour="' + this.default_planner_the_hour(h) + '">' + hour_container + '</div>'
                        + '<div class="default-planner-calendar-events" data-year="' + new Date(first_day + (6 * 24) * 60 * 60 * 1000).getFullYear() + '" data-month="' + (this.default_planner_the_month(new Date(first_day + (6 * 24) * 60 * 60 * 1000).getMonth()) + 1) + '" data-date="' + this.default_planner_the_date(new Date(first_day + (6 * 24) * 60 * 60 * 1000).getDate()) + '" data-hour="' + this.default_planner_the_hour(h) + '">' + hour_container + '</div>'
                    + '</div>'
                + '</div>'

            } else {

                // Add hour html to the container
                hours += '<div class="default-planner-calendar-tab-week-hour">'
                    + '<div class="default-planner-calendar-tab-week-hour-time">'
                        + '<span>'
                            + hour
                        + '</span>'
                    + '</div>'
                    + '<div class="default-planner-calendar-tab-week-days">'
                        + '<div class="default-planner-calendar-events" data-year="' + new Date(first_day).getFullYear() + '" data-month="' + (this.default_planner_the_month(new Date(first_day).getMonth()) + 1) + '" data-date="' + this.default_planner_the_date(new Date(first_day).getDate()) + '" data-hour="' + this.default_planner_the_hour(h) + '">' + hour_container + '</div>'
                        + '<div class="default-planner-calendar-events" data-year="' + new Date(first_day + (1 * 24) * 60 * 60 * 1000).getFullYear() + '" data-month="' + (this.default_planner_the_month(new Date(first_day + (1 * 24) * 60 * 60 * 1000).getMonth()) + 1) + '" data-date="' + this.default_planner_the_date(new Date(first_day + (1 * 24) * 60 * 60 * 1000).getDate()) + '" data-hour="' + this.default_planner_the_hour(h) + '">' + hour_container + '</div>'
                        + '<div class="default-planner-calendar-events" data-year="' + new Date(first_day + (2 * 24) * 60 * 60 * 1000).getFullYear() + '" data-month="' + (this.default_planner_the_month(new Date(first_day + (2 * 24) * 60 * 60 * 1000).getMonth()) + 1) + '" data-date="' + this.default_planner_the_date(new Date(first_day + (2 * 24) * 60 * 60 * 1000).getDate()) + '" data-hour="' + this.default_planner_the_hour(h) + '">' + hour_container + '</div>'
                        + '<div class="default-planner-calendar-events" data-year="' + new Date(first_day + (3 * 24) * 60 * 60 * 1000).getFullYear() + '" data-month="' + (this.default_planner_the_month(new Date(first_day + (3 * 24) * 60 * 60 * 1000).getMonth()) + 1) + '" data-date="' + this.default_planner_the_date(new Date(first_day + (3 * 24) * 60 * 60 * 1000).getDate()) + '" data-hour="' + this.default_planner_the_hour(h) + '">' + hour_container + '</div>'
                        + '<div class="default-planner-calendar-events" data-year="' + new Date(first_day + (4 * 24) * 60 * 60 * 1000).getFullYear() + '" data-month="' + (this.default_planner_the_month(new Date(first_day + (4 * 24) * 60 * 60 * 1000).getMonth()) + 1) + '" data-date="' + this.default_planner_the_date(new Date(first_day + (4 * 24) * 60 * 60 * 1000).getDate()) + '" data-hour="' + this.default_planner_the_hour(h) + '">' + hour_container + '</div>' 
                        + '<div class="default-planner-calendar-events" data-year="' + new Date(first_day + (5 * 24) * 60 * 60 * 1000).getFullYear() + '" data-month="' + (this.default_planner_the_month(new Date(first_day + (5 * 24) * 60 * 60 * 1000).getMonth()) + 1) + '" data-date="' + this.default_planner_the_date(new Date(first_day + (5 * 24) * 60 * 60 * 1000).getDate()) + '" data-hour="' + this.default_planner_the_hour(h) + '">' + hour_container + '</div>'
                        + '<div class="default-planner-calendar-events" data-year="' + new Date(first_day + (6 * 24) * 60 * 60 * 1000).getFullYear() + '" data-month="' + (this.default_planner_the_month(new Date(first_day + (6 * 24) * 60 * 60 * 1000).getMonth()) + 1) + '" data-date="' + this.default_planner_the_date(new Date(first_day + (6 * 24) * 60 * 60 * 1000).getDate()) + '" data-hour="' + this.default_planner_the_hour(h) + '">' + hour_container + '</div>'
                    + '</div>'
                + '</div>'
                
            }

        }

        // Display the hours
        this.find('.default-planner-calendar-tab-week-body').html(hours);

    };

    /*
     * Display week days and dates in the big calendar
     * 
     * @param object the_date contains the date
     */
    $.fn.default_planner_show_week_days_dates_in_big_calendar = function (the_date) {

        // Get the day
        let the_day = ( parseInt(this.attr('data-first-day')) === 1 )?new Date(the_date).getDay():(new Date(the_date).getDay() + 1);
        
        // Calculate the time difference
        let time_difference = the_date.getDate() - the_day + (the_day === 0 ? -6 : 1);

        // First day of the week
        let first_day = new Date(the_date.setDate(time_difference)).getTime();

        // The days and dates container
        var days_dates = '';        

        // Verify if the first day of the week is monday
        if ( parseInt(this.attr('data-first-day')) === 1 ) {

            // List the days
            for ( var d = 0; d < 7; d++ ) {

                // Add day and date to the container
                days_dates += '<div class="default-planner-calendar-tab-week-header-day">'
                    + '<h4>'
                        + this.default_planner_the_short_day_text(d)
                    + '</h4>'
                    + '<h5>'
                        + new Date(first_day + (d * 24) * 60 * 60 * 1000).getDate()
                    + '</h5>'
                + '</div>';

            }

        } else {

            // List the days
            for ( var d = 0; d < 7; d++ ) {

                // Verify if d is 0
                if ( d < 1 ) {

                    // Add day and date to the container
                    days_dates += '<div class="default-planner-calendar-tab-week-header-day">'
                        + '<h4>'
                            + this.default_planner_the_short_day_text(6)
                        + '</h4>'
                        + '<h5>'
                            + new Date(first_day + (d * 24) * 60 * 60 * 1000).getDate()
                        + '</h5>'
                    + '</div>';
                    
                } else {

                    // Add day and date to the container
                    days_dates += '<div class="default-planner-calendar-tab-week-header-day">'
                        + '<h4>'
                            + this.default_planner_the_short_day_text((d - 1))
                        + '</h4>'
                        + '<h5>'
                            + new Date(first_day + (d * 24) * 60 * 60 * 1000).getDate()
                        + '</h5>'
                    + '</div>';
                    
                }

                // Verify if d is 0
                if ( d > 5 ) {
                    break;
                }

            }
            
        }

        // Display the days and the dates
        this.find('.default-planner-calendar-tab-week-header-days').html(days_dates);

    };

    /*
     * Display week days in the month calendar view
     */
    $.fn.default_planner_show_week_days_for_month_in_big_calendar = function () {
        
        // The days container
        var days = '';

        // List the days
        for ( var d = 1; d < 8; d++ ) {

            // Verify if first day of the week is monday
            if ( parseInt(this.attr('data-first-day')) === 1 ) {

                // Add day to the container
                days += '<div class="default-planner-calendar-tab-month-header-day">'
                    + '<h4>'
                        + this.default_planner_the_day_text(d)
                    + '</h4>'
                + '</div>';

            } else {

                // Prepare new index
                let index = (d < 2)?7:(d - 1);

                // Add day to the container
                days += '<div class="default-planner-calendar-tab-month-header-day">'
                    + '<h4>'
                        + this.default_planner_the_day_text(index)
                    + '</h4>'
                + '</div>';
                
            }

        }

        // Display the days
        this.find('.default-planner-calendar-tab-month-header-days').html(days);

    };

    /*
     * Display dates in the month calendar view
     * 
     * @param object the_date contains the date
     */
    $.fn.default_planner_show_dates_for_month_in_big_calendar = function (the_date) {
        
        // Set day
        let d = new Date(the_date.getFullYear(), (the_date.getMonth() + 1), 0);
        
        // Show option
        var show = 1;

        // The dates container
        var dates = '';

        // Verify if first day of the week is monday
        if ( parseInt(this.attr('data-first-day')) === 1 ) {

            // Set day calc
            var day_calc = 2;

        } else {

            // Set day calc
            var day_calc = 1;

        }

        // Reached month
        var reached = 0;

        // Calculate days
        for ( var s = day_calc; s < 50; s++ ) {

            // Verify if the last day is reached
            if ( show > d.getDate() ) {

                // Reset show
                show = 0;

                // Increase reached
                reached++;

            }

            // Verify if is a week
            if ( (s - day_calc) % 7 === 0 ) {

                // Verify if the last day is reached
                if ( ( show > d.getDate() ) || ( reached > 0 ) ) {
                    break;
                }

                // Verify if is the first date
                if ( dates ) {

                    // Set new row
                    dates += '</div>'
                    + '<div class="default-planner-calendar-eventss">';

                } else {

                    // Set new row
                    dates += '<div class="default-planner-calendar-eventss">';
                    
                }

            }

            // Get previous date
            let pd = new Date(the_date.getFullYear(), (the_date.getMonth() + 1), 0);

            // Set first day of the month
            pd.setDate(0);

            // Calculate days
            var pdays =  (pd.getDay() - s);

            // Increase pdays
            pdays++;

            // Set hours
            pd.setHours(((pdays * 24) - ((pdays * 24) * 2))); 

            // Set this date
            let this_date = this.default_planner_the_date(pd.getDate());

            // Verify if show is not empty
            if ( show > 1 ) {

                // Increase the show
                show++;

            } else if ( this_date === 1 ) {

                // Increase the show
                show++;

            }

            // Custom class
            var custom = '';

            // Very if the days are of the current month
            if ( show < 2 ) {

                // Set disabled class
                custom = ' default-planner-calendar-events-disabled';

            } else {

                // Set active class
                custom = ' default-planner-calendar-events-active';
                
            }
            
            // Add date to the container
            dates += '<div class="default-planner-calendar-events' + custom + '" data-year="' + pd.getFullYear() + '" data-month="' + (this.default_planner_the_month(pd.getMonth()) + 1) + '" data-date="' + this.default_planner_the_date(pd.getDate()) + '">'
                + '<div class="default-planner-calendar-tab-month-top">'
                    + '<a href="#" class="d-flex justify-content-between">'
                        + '<span>'
                            + this.default_planner_the_day_text(((s - day_calc) % 7))
                        + '</span>'                    
                        + '<small>'
                            + this_date
                        + '</small>'
                    + '</a>'
                + '</div>'
                + '<div class="default-planner-calendar-events-list">'
                + '</div>'
                + '<div class="default-planner-calendar-events-show-all" data-events="0" data-events-word="' + words.events + '">'
                    + '<a href="#"></a>'
                + '</div>'                              
            + '</div>';
          
        }

        // Display the dates
        this.find('.default-planner-calendar-tab-month-body').html(dates);

    };

    /*
     * Display the previous events in the big calendar
     */
    $.fn.default_planner_show_previous_events_in_big_calendar = function () {
        
        // Get the calendar date
        let the_calendar_date = new Date(this.attr('data-year') + '-' + this.attr('data-month') + '-' + this.attr('data-date'));

        // Set the date by view
        if ( parseInt(this.find('.default-planner-calendar-navigation-tab:checked').val()) === 0 ) {

            // Get the next time
            let next_time = new Date(the_calendar_date.getTime() - 24 * 60 * 60 * 1000);

            // Calculate the next year
            let next_year = next_time.getFullYear();

            // Calculate the next month
            let next_month = ((next_time.getMonth() + 1) < 10)?'0' + (next_time.getMonth() + 1):(next_time.getMonth() + 1);            

            // Calculate the next date
            let next_date = (next_time.getDate() < 10)?'0' + next_time.getDate():next_time.getDate();

            // Set new year
            this.attr('data-year', next_year);

            // Set new month
            this.attr('data-month', next_month);

            // Set new date
            this.attr('data-date', next_date); 

        } else if ( parseInt(this.find('.default-planner-calendar-navigation-tab:checked').val()) === 1 ) {

            // Get the day
            let the_day = ( parseInt(this.attr('data-first-day')) === 1 )?new Date(the_calendar_date.getTime() - 60 * 60 * 24 * 7 * 1000).getDay():(new Date(the_calendar_date.getTime() - 60 * 60 * 24 * 7 * 1000).getDay() + 1);
            
            // Calculate the time difference
            let time_difference = the_calendar_date.getDate() - the_day + (the_day === 0 ? -6 : 1);

            // First day of the week
            let first_day = new Date(the_calendar_date.setDate(time_difference)).getTime(); 
            
            // Get the next time
            let next_time = new Date(first_day - (7 * 24) * 60 * 60 * 1000);

            // Calculate the next year
            let next_year = next_time.getFullYear();

            // Calculate the next month
            let next_month = ((next_time.getMonth() + 1) < 10)?'0' + (next_time.getMonth() + 1):(next_time.getMonth() + 1);            

            // Calculate the next date
            let next_date = (next_time.getDate() < 10)?'0' + next_time.getDate():next_time.getDate();

            // Set new year
            this.attr('data-year', next_year);

            // Set new month
            this.attr('data-month', next_month);

            // Set new date
            this.attr('data-date', next_date);    

        } else if ( parseInt(this.find('.default-planner-calendar-navigation-tab:checked').val()) === 2 ) {

            // Get the next time
            let next_time = new Date(the_calendar_date.getFullYear(), (the_calendar_date.getMonth() - 1), 1);

            // Calculate the next year
            let next_year = next_time.getFullYear();

            // Calculate the next month
            let next_month = ((next_time.getMonth() + 1) < 10)?'0' + (next_time.getMonth() + 1):(next_time.getMonth() + 1);            

            // Calculate the next date
            let next_date = (next_time.getDate() < 10)?'0' + next_time.getDate():next_time.getDate();

            // Set new year
            this.attr('data-year', next_year);

            // Set new month
            this.attr('data-month', next_month);

            // Set new date
            this.attr('data-date', next_date);            

        }

        // Display the big calendar
        this.default_planner_show_big_calendar_data();

        // Verify if date change exists
        if ( this.dateChange ) {

            // Run function
            this.dateChange();

        }

    };

    /*
     * Display the today events in the big calendar
     */
    $.fn.default_planner_show_today_events_in_big_calendar = function () {

        // Get the next time
        let time = new Date();

        // Calculate the next year
        let year = time.getFullYear();

        // Calculate the next month
        let month = ((time.getMonth() + 1) < 10)?'0' + (time.getMonth() + 1):(time.getMonth() + 1);            

        // Calculate the next date
        let date = (time.getDate() < 10)?'0' + time.getDate():time.getDate();

        // Set new year
        this.attr('data-year', year);

        // Set new month
        this.attr('data-month', month);

        // Set new date
        this.attr('data-date', date);

        // Display the big calendar
        this.default_planner_show_big_calendar_data();

        // Verify if date change exists
        if ( this.dateChange ) {

            // Run function
            this.dateChange(this.attr('data-year'), this.attr('data-month'), this.attr('data-date'));

        }

    };

    /*
     * Display the all events in the big calendar sidebar
     */
    $.fn.default_planner_show_all_events_in_big_calendar_sidebar = function () {

        // Verify if the planner events sidebar is already showed
        if ( !$(this).find('.default-planner-events').hasClass('default-planner-events-show') ) {

            // Show the sidebar
            this.find('.default-planner-events').animate({
                width: 'toggle'
            }, 300).addClass('default-planner-events-show');

        }

    };

    /*
     * Display the next events in the big calendar
     */
    $.fn.default_planner_show_next_events_in_big_calendar = function () {
        
        // Get the calendar date
        let the_calendar_date = new Date(this.attr('data-year') + '-' + this.attr('data-month') + '-' + this.attr('data-date'));

        // Set the date by view
        if ( parseInt(this.find('.default-planner-calendar-navigation-tab:checked').val()) === 0 ) {

            // Get the next time
            let previous_time = new Date(the_calendar_date.getTime() + 24 * 60 * 60 * 1000);

            // Calculate the next year
            let previous_year = previous_time.getFullYear();

            // Calculate the next month
            let previous_month = ((previous_time.getMonth() + 1) < 10)?'0' + (previous_time.getMonth() + 1):(previous_time.getMonth() + 1);            

            // Calculate the next date
            let previous_date = (previous_time.getDate() < 10)?'0' + previous_time.getDate():previous_time.getDate();

            // Set new year
            this.attr('data-year', previous_year);

            // Set new month
            this.attr('data-month', previous_month);

            // Set new date
            this.attr('data-date', previous_date); 

        } else if ( parseInt(this.find('.default-planner-calendar-navigation-tab:checked').val()) === 1 ) {

            // Get the day
            let the_day = ( parseInt(this.attr('data-first-day')) === 1 )?new Date(the_calendar_date).getDay():(new Date(the_calendar_date).getDay() + 1);
            
            // Calculate the time difference
            let time_difference = the_calendar_date.getDate() - the_day + (the_day === 0 ? -6 : 1);

            // First day of the week
            let first_day = new Date(the_calendar_date.setDate(time_difference)).getTime(); 
            
            // Get the next time
            let previous_time = new Date(first_day + (7 * 24) * 60 * 60 * 1000);

            // Calculate the next year
            let previous_year = previous_time.getFullYear();

            // Calculate the next month
            let previous_month = ((previous_time.getMonth() + 1) < 10)?'0' + (previous_time.getMonth() + 1):(previous_time.getMonth() + 1);            

            // Calculate the next date
            let previous_date = (previous_time.getDate() < 10)?'0' + previous_time.getDate():previous_time.getDate();

            // Set new year
            this.attr('data-year', previous_year);

            // Set new month
            this.attr('data-month', previous_month);

            // Set new date
            this.attr('data-date', previous_date);    

        } else if ( parseInt(this.find('.default-planner-calendar-navigation-tab:checked').val()) === 2 ) {

            // Get the next time
            let previous_time = new Date(the_calendar_date.getFullYear(), (the_calendar_date.getMonth() + 1), 1);

            // Calculate the next year
            let previous_year = previous_time.getFullYear();

            // Calculate the next month
            let previous_month = ((previous_time.getMonth() + 1) < 10)?'0' + (previous_time.getMonth() + 1):(previous_time.getMonth() + 1);            

            // Calculate the next date
            let previous_date = (previous_time.getDate() < 10)?'0' + previous_time.getDate():previous_time.getDate();

            // Set new year
            this.attr('data-year', previous_year);

            // Set new month
            this.attr('data-month', previous_month);

            // Set new date
            this.attr('data-date', previous_date);            

        }

        // Display the big calendar
        this.default_planner_show_big_calendar_data();

        // Verify if date change exists
        if ( this.dateChange ) {

            // Run function
            this.dateChange(this.attr('data-year'), this.attr('data-month'), this.attr('data-date'));

        }

    };

    /*
     * Hide the all events in the big calendar sidebar
     */
    $.fn.default_planner_hide_all_events_in_big_calendar_sidebar = function () {

        // Hide the sidebar
        $(this).closest('.default-planner-events').animate({
            width: 'toggle'
        }, 300).removeClass('default-planner-events-show');

    };

    /*
     * Change the date in the big calendar
     * 
     * @param object $this
     */
    $.fn.default_planner_change_date_in_big_calendar = function ($this) {

        // Change the year
        $(this).closest('.default-planner').find('.default-planner-calendar').attr('data-year', $this.attr('data-year'));

        // Change the month
        $(this).closest('.default-planner').find('.default-planner-calendar').attr('data-month', $this.attr('data-month'));

        // Change the date
        $(this).closest('.default-planner').find('.default-planner-calendar').attr('data-date', $this.attr('data-date'));

        // Display the big calendar
        $(this).closest('.default-planner').find('.default-planner-calendar').default_planner_show_big_calendar_data();

        // Verify if date click exists
        if ( this.dateClick ) {

            // Run function
            this.dateClick(this.attr('data-year'), this.attr('data-month'), this.attr('data-date'));

        }

    };

    /*
     * Set events in the big calendar
     * 
     * @param object events with events list
     */
    $.fn.default_planner_set_events_in_big_calendar = function (events) {

        // Verify if events exists
        if ( events.length > 0 ) {

            // Display the events by view
            switch ( this.attr('data-view') ) {

                case 'day':

                    // List the events
                    for ( var e = 0; e < events.length; e++ ) {

                        // Verify if the required parameters exists
                        if ( (typeof events[e].year !== 'undefined') && (typeof events[e].month !== 'undefined') && (typeof events[e].date !== 'undefined') && (typeof events[e].hour !== 'undefined') ) {

                            // Verify if the date already has an event
                            if ( this.find('.default-planner-calendar-events[data-year="' + events[e].year + '"][data-month="' + parseInt(events[e].month) + '"][data-date="' + parseInt(events[e].date) + '"][data-hour="' + parseInt(events[e].hour) + '"] .default-planner-calendar-event').length > 0 ) {

                                // Get the number of not showed events
                                let hidden_events = this.find('.default-planner-calendar-events[data-year="' + events[e].year + '"][data-month="' + parseInt(events[e].month) + '"][data-date="' + parseInt(events[e].date) + '"][data-hour="' + parseInt(events[e].hour) + '"] .default-planner-calendar-events-show-all').attr('data-events');

                                // Set new event number
                                let new_hidden_events = (parseInt(hidden_events) + 1);

                                // Set the number of not showed events
                                this.find('.default-planner-calendar-events[data-year="' + events[e].year + '"][data-month="' + parseInt(events[e].month) + '"][data-date="' + parseInt(events[e].date) + '"][data-hour="' + parseInt(events[e].hour) + '"] .default-planner-calendar-events-show-all').attr('data-events', new_hidden_events);                                

                                // Display the all events link
                                this.find('.default-planner-calendar-events[data-year="' + events[e].year + '"][data-month="' + parseInt(events[e].month) + '"][data-date="' + parseInt(events[e].date) + '"][data-hour="' + parseInt(events[e].hour) + '"] .default-planner-calendar-events-show-all a').html(words.icon_bi_plus + ' ' + new_hidden_events + ' ' + words.events);

                            } else {

                                // Default hour
                                var hour = events[e].hour + ':' + events[e].minute;

                                // Verify if hour format is 12
                                if ( this.attr('data-hour-format') === '12' ) {

                                    // Change hour
                                    hour = (parseInt(events[e].hour) > 11)?(parseInt(events[e].hour) - 12) + ':' + events[e].minute + ' PM':events[e].hour + ':' + events[e].minute + ' AM';

                                }

                                // Default text
                                var text = '';

                                // Verify if the event has text
                                if ( typeof events[e].text !== 'undefined' ) {

                                    // Set text
                                    text = '<span>' + events[e].text + '</span>';

                                }

                                // Default html
                                var html = '<a href="#" class="default-planner-calendar-event">'
                                    + '<small>'
                                        + hour
                                    + '</small>'
                                    + text                               
                                + '</a>';

                                // Verify if custom html exists
                                if ( typeof events[e].html !== 'undefined' ) {

                                    // Set the html
                                    html = events[e].html;

                                }

                                // Set event
                                this.find('.default-planner-calendar-events[data-year="' + events[e].year + '"][data-month="' + parseInt(events[e].month) + '"][data-date="' + parseInt(events[e].date) + '"][data-hour="' + parseInt(events[e].hour) + '"] .default-planner-calendar-events-list').html(html);

                            }

                        }

                    }

                    break;

                case 'week':

                    // List the events
                    for ( var e = 0; e < events.length; e++ ) {

                        // Verify if the required parameters exists
                        if ( (typeof events[e].year !== 'undefined') && (typeof events[e].month !== 'undefined') && (typeof events[e].date !== 'undefined') && (typeof events[e].hour !== 'undefined') ) {

                            // Verify if the date already has an event
                            if ( this.find('.default-planner-calendar-events[data-year="' + events[e].year + '"][data-month="' + parseInt(events[e].month) + '"][data-date="' + parseInt(events[e].date) + '"][data-hour="' + parseInt(events[e].hour) + '"] .default-planner-calendar-event').length > 0 ) {

                                // Get the number of not showed events
                                let hidden_events = this.find('.default-planner-calendar-events[data-year="' + events[e].year + '"][data-month="' + parseInt(events[e].month) + '"][data-date="' + parseInt(events[e].date) + '"][data-hour="' + parseInt(events[e].hour) + '"] .default-planner-calendar-events-show-all').attr('data-events');

                                // Set new event number
                                let new_hidden_events = (parseInt(hidden_events) + 1);

                                // Set the number of not showed events
                                this.find('.default-planner-calendar-events[data-year="' + events[e].year + '"][data-month="' + parseInt(events[e].month) + '"][data-date="' + parseInt(events[e].date) + '"][data-hour="' + parseInt(events[e].hour) + '"] .default-planner-calendar-events-show-all').attr('data-events', new_hidden_events);                                

                                // Display the all events link
                                this.find('.default-planner-calendar-events[data-year="' + events[e].year + '"][data-month="' + parseInt(events[e].month) + '"][data-date="' + parseInt(events[e].date) + '"][data-hour="' + parseInt(events[e].hour) + '"] .default-planner-calendar-events-show-all a').html(words.icon_bi_plus + ' ' + new_hidden_events + ' ' + words.events);

                            } else {

                                // Default hour
                                var hour = events[e].hour + ':' + events[e].minute;

                                // Verify if hour format is 12
                                if ( this.attr('data-hour-format') === '12' ) {

                                    // Change hour
                                    hour = (parseInt(events[e].hour) > 11)?(parseInt(events[e].hour) - 12) + ':' + events[e].minute + ' PM':events[e].hour + ':' + events[e].minute + ' AM';

                                }

                                // Default text
                                var text = '';

                                // Verify if the event has text
                                if ( typeof events[e].text !== 'undefined' ) {

                                    // Set text
                                    text = '<span>' + events[e].text + '</span>';

                                }

                                // Default html
                                var html = '<a href="#" class="default-planner-calendar-event">'
                                    + '<small>'
                                        + hour
                                    + '</small>'
                                    + text                               
                                + '</a>';

                                // Verify if custom html exists
                                if ( typeof events[e].html !== 'undefined' ) {

                                    // Set the html
                                    html = events[e].html;

                                }

                                // Set event
                                this.find('.default-planner-calendar-events[data-year="' + events[e].year + '"][data-month="' + parseInt(events[e].month) + '"][data-date="' + parseInt(events[e].date) + '"][data-hour="' + parseInt(events[e].hour) + '"] .default-planner-calendar-events-list').html(html);

                            }

                        }

                    }

                    break;

                case 'month':
                    
                    // List the events
                    for ( var e = 0; e < events.length; e++ ) {

                        // Verify if the required parameters exists
                        if ( (typeof events[e].year !== 'undefined') && (typeof events[e].month !== 'undefined') && (typeof events[e].date !== 'undefined') && (typeof events[e].hour !== 'undefined') && (typeof events[e].minute !== 'undefined') ) {

                            // Verify if the date already has an event
                            if ( this.find('.default-planner-calendar-events[data-year="' + events[e].year + '"][data-month="' + parseInt(events[e].month) + '"][data-date="' + parseInt(events[e].date) + '"] .default-planner-calendar-event').length > 0 ) {

                                // Get the number of not showed events
                                let hidden_events = this.find('.default-planner-calendar-events[data-year="' + events[e].year + '"][data-month="' + parseInt(events[e].month) + '"][data-date="' + parseInt(events[e].date) + '"] .default-planner-calendar-events-show-all').attr('data-events');

                                // Set new event number
                                let new_hidden_events = (parseInt(hidden_events) + 1);

                                // Set the number of not showed events
                                this.find('.default-planner-calendar-events[data-year="' + events[e].year + '"][data-month="' + parseInt(events[e].month) + '"][data-date="' + parseInt(events[e].date) + '"] .default-planner-calendar-events-show-all').attr('data-events', new_hidden_events);                                

                                // Display the all events link
                                this.find('.default-planner-calendar-events[data-year="' + events[e].year + '"][data-month="' + parseInt(events[e].month) + '"][data-date="' + parseInt(events[e].date) + '"] .default-planner-calendar-events-show-all a').html(words.icon_bi_plus + ' ' + new_hidden_events + ' ' + words.events);

                            } else {

                                // Default hour
                                var hour = events[e].hour + ':' + events[e].minute;

                                // Verify if hour format is 12
                                if ( this.attr('data-hour-format') === '12' ) {

                                    // Change hour
                                    hour = (parseInt(events[e].hour) > 11)?(parseInt(events[e].hour) - 12) + ':' + events[e].minute + ' PM':events[e].hour + ':' + events[e].minute + ' AM';

                                }

                                // Default text
                                var text = '';

                                // Verify if the event has text
                                if ( typeof events[e].text !== 'undefined' ) {

                                    // Set text
                                    text = '<span>' + events[e].text + '</span>';

                                }

                                // Default html
                                var html = '<a href="#" class="default-planner-calendar-event">'
                                    + '<small>'
                                        + hour
                                    + '</small>'
                                    + text                               
                                + '</a>';

                                // Verify if custom html exists
                                if ( typeof events[e].html !== 'undefined' ) {

                                    // Set the html
                                    html = events[e].html;

                                }

                                // Set event
                                this.find('.default-planner-calendar-events[data-year="' + events[e].year + '"][data-month="' + parseInt(events[e].month) + '"][data-date="' + parseInt(events[e].date) + '"] .default-planner-calendar-events-list').html(html);

                            }

                        }

                    }

                    break;

            }

        }

    };

    /*******************************
      GENERAL FUNCTIONS
    ********************************/

    /*
     * Get the month text
     *
     * @param integer month contains the index
     * 
     * @return string
     */  
    $.fn.default_planner_the_month_text = function(month) {
 
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

        return months[parseInt(month)];
        
    };

    /*
     * Get the day text
     *
     * @param integer day contains the index
     * 
     * @return string
     */  
    $.fn.default_planner_the_day_text = function(day) {
 
        // Set days
        var days = [
            words.sunday,
            words.monday,
            words.tuesday,
            words.wednesday,
            words.thursday,
            words.friday,
            words.saturday,
            words.sunday
        ];

        return days[parseInt(day)];
        
    };
 
    /*
     * Get the short day text
     *
     * @param integer day contains the index
     * 
     * @return string
     */  
    $.fn.default_planner_the_short_day_text = function(day) {
 
        // Set days
        var days = [
            words.mon,
            words.tue,
            words.wed,
            words.thu,
            words.fri,
            words.sat,
            words.sun
        ];

        return days[parseInt(day)];
        
    };

    /*
     * Prepare the month
     *
     * @param integer month contains the month
     * 
     * @return string
     */  
    $.fn.default_planner_the_month = function(month) {

        return month;
        
    };

    /*
     * Prepare the date
     *
     * @param integer date contains the date
     * 
     * @return string
     */  
    $.fn.default_planner_the_date = function(date) {

        return date;
        
    };

    /*
     * Prepare the hour
     *
     * @param integer hour contains the hour
     * 
     * @return string
     */  
    $.fn.default_planner_the_hour = function(hour) {

        return hour;
        
    };

}( jQuery ));