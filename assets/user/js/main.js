/*
 * Main javascript file
*/

/*
 * Create the main object
 */
var Main = new Object({
    translation: {},
    pagination: {},
    methods: {}
});

jQuery(document).ready( function ($) {
    'use strict';
    
    // Get home page url
    var url = $('meta[name=url]').attr('content');
    
    if ( $( '.open-midrub-planner' ).length > 0 ) {
        
        // Set current date
        Main.ctime = new Date();

        // Set current months
        Main.month = Main.ctime.getMonth() + 1;

        // Set current day
        Main.day = Main.ctime.getDate();

        // Set current year
        Main.year = Main.ctime.getFullYear();

        // Set current year
        Main.cyear = Main.year;

        // Set date/hour format
        Main.format = 0;

        // Set selected_date
        Main.selected_date = '';

        // Set selected time
        Main.selected_time = '08:00';
        
    }
    
    /*
     * Detect schedule click
     */
    $(document).on('click', '.open-midrub-planner', function(e) {
        e.preventDefault();

        // Display calendar
        Main.show_calendar( Main.month, Main.day, Main.year, Main.format );
        
        // Set calendar position
        $('.midrub-planner').css({
            'top': ( $(this).offset().top - 330 ) + 'px',
            'left': ( $(this).offset().left - 275 ) + 'px',
        });
        
        // Display calendar
        $('.midrub-planner').fadeIn('fast');
        
    });
    
    /*
     * Select a date
     */  
    $(document).on('click', '.midrub-calendar td a', function (e) {
        e.preventDefault();
        
        // Remove class add-date
        $('.midrub-calendar tr td a').removeClass('add-date');
        
        // Add class add-date
        $(this).addClass('add-date');
        
        // Set new selected date
        Main.selected_date = $(this).attr('data-date');
        
        // Set current date
        var current_date = Main.selected_date;
        
        // Split date
        var split_date = current_date.split( '-' );
        
        // Set correct format
        var format_date = split_date[0] + '-' + ( 10 > split_date[1] ? '0' + split_date[1]: split_date[1] ) + '-' + ( 10 > split_date[2] ? '0' + split_date[2] : split_date[2]  );
        
        // Set date and time
        $( '.datetime' ).val( format_date + ' ' + Main.selected_time );

    });
    
    /*
     * Select time
     */  
    $(document).on('change', '.midrub-calendar-time-hour,.midrub-calendar-time-minutes,.midrub-calendar-time-period', function (e) {
        e.preventDefault();
        
        // Get hour
        var hour = $(this).closest('.row').find('.midrub-calendar-time-hour').val();

        // Get minutes
        var minutes = $(this).closest('.row').find('.midrub-calendar-time-minutes').val();

        // Verify if time period exists
        if ( $('.midrub-calendar-time-period').length > 0 ) {
            
            // Get period
            var period = $(this).closest('.row').find('.midrub-calendar-time-period').val();
            
            if ( period === 'AM' ) {
            
                // Adjust format
                var format_time = hour + ':' + minutes;
            
            } else {
                
                if ( hour > 11 ) {

                    // Adjust format
                    var format_time = '00:' + minutes; 

                } else {

                    // Adjust format
                    var format_time = (12 + parseInt(hour)) + ':' + minutes; 

                }         
                
            }

            // Set selected time
            Main.selected_time = format_time;
            
        } else {
            
            // Adjust format
            var format_time = hour + ':' + minutes;

            // Set selected time
            Main.selected_time = format_time;
            
        }
        
        // Verify if date was selected
        if ( Main.selected_date ) {
            
            // Set current date
            var current_date = Main.selected_date;

            // Split date
            var split_date = current_date.split( '-' );

            // Set correct format
            var format_date = split_date[0] + '-' + ( 10 > split_date[1] ? '0' + split_date[1]: split_date[1] ) + '-' + ( 10 > split_date[2] ? '0' + split_date[2] : split_date[2]  );

            // Set date and time
            $( '.datetime' ).val( format_date + ' ' + Main.selected_time );
            
        }
        
    });
    
    // Enable or disable an option
    $('.container-fluid .setopt').click(function () {
        
        // Make ajax call
        Main.ajax_call( url + 'user/option/' + $(this).attr('id'), 'GET', '', 'enable_or_disable_option_response');
        
    });
    
    /*
     * Go back button
     */    
    $('.go-back').click(function (e) {
        e.preventDefault();

        Main.month--;

        if ( Main.month < 1 ) {
            
            Main.year--;
            Main.month = 12;
            
        }
        
        // Display calendar
        Main.show_calendar( Main.month, Main.day, Main.year, Main.format);
        
    });
    
    /*
     * Go next button
     */
    $('.go-next').click(function (e) {
        e.preventDefault();

        Main.month++;

        if ( Main.month > 12 ) {
            
            Main.year++;
            
            Main.month = 1;
            
        }
        
        // Display calendar
        Main.show_calendar( Main.month, Main.day, Main.year, Main.format);
        
    });
    
    /*
     * Detect any click
     */
    $( 'body' ).click(function(e) {
        
        if ( $('.midrub-planner').length > 0 ) {

            var midrub_planner = $( '.midrub-planner' );

            if ( !midrub_planner.is(e.target) && midrub_planner.has(e.target).length === 0 ) {

                // Hide calendar
                $('.midrub-planner').fadeOut('fast');

            }
        
        }

    });
    
    /*
     * Display calendar months
     */
    function show_year( month, year ) {
        
        // Set months
        var months = [
            ''
            , Main.translation.mu327
            , Main.translation.mu328
            , Main.translation.mu329
            , Main.translation.mu330
            , Main.translation.mu331
            , Main.translation.mu332
            , Main.translation.mu333
            , Main.translation.mu334
            , Main.translation.mu335
            , Main.translation.mu336
            , Main.translation.mu337
            , Main.translation.mu338];

        // Add months
        $( '.year-month' ).text( months[month] + ' ' + year );
        
    }
    
    /*
     * Display calendar
     */
    Main.show_calendar = function ( month, day, year, format ) {

        // Display months
        show_year( month, year );
        
        // Set current date
        var current = new Date();
        
        var d = new Date(year, month, 0);
        
        var e = new Date(d.getFullYear(), d.getMonth(), 1);
        
        var fday = e.getDay();
        
        var show = 1;

        fday++;

        format = 1;

        $( '.midrub-calendar' ).addClass( 'usa' );

        var n = '<tr>'
                    + '<td style="width: 14.28%;">'
                        + Main.translation.mu339
                    + '</td>'
                    + '<td style="width: 14.28%;">'
                        + Main.translation.mu340
                    + '</td>'
                    + '<td style="width: 14.28%;">'
                        + Main.translation.mu341
                    + '</td>'
                    + '<td style="width: 14.28%;">'
                        + Main.translation.mu342
                    + '</td>'
                    + '<td style="width: 14.28%;">'
                        + Main.translation.mu343
                    + '</td>'
                    + '<td style="width: 14.28%;">'
                        + Main.translation.mu344
                    + '</td>'
                    + '<td style="width: 14.28%;">'
                        + Main.translation.mu345
                    + '</td>'
                + '</tr>'
                + '<tr>';

        for ( var s = 1; s < d.getDate() + fday; s++ ) {

            if ( format ) {

                var tu = s - 1;

            } else {

                var tu = s;

            }

            if ( tu % 7 === 0 ) {
                n += '</tr><tr>';

            }
            if ( fday <= s ) {

                var add_date = '';

                if ( year + '-' + month + '-' + show === Main.selected_date ) {

                    add_date = 'add-date';

                }

                if ( ( show === day ) && ( month === current.getMonth() + 1 ) && ( year === current.getFullYear() ) ) {


                    n += '<td><a href="#" class="current-day ' + add_date + '" data-date="' + year + '-' + month + '-' + show + '">' + show + '</a></td>';

                } else {

                    if ( ( ( show < day ) && ( month === current.getMonth() + 1 ) && ( year == current.getFullYear() ) ) || ( ( ( month < current.getMonth() + 1 ) && ( year <= current.getFullYear() ) ) || ( year < current.getFullYear() ) ) ) {

                        n += '<td><a href="#" class="past-days">' + show + '</a></td>';

                    } else {

                        n += '<td><a href="#" data-date="' + year + '-' + month + '-' + show + '" class="' + add_date + '">' + show + '</a></td>';

                    }

                }

                show++;

            } else {

                n += '<td></td>';

            }

        }

        n += '</tr>';
        
        $( '.calendar-dates' ).html( n );
        
    };
    
    /*
     * Calculate time between two dates
     */
    Main.calculate_time = function( from, to ) {
        'use strict';

        // Set calculation time
        var calculate = to - from;

        // Set after variable
        var after = '<i class="far fa-calendar-check"></i> ';

        // Set before variable 
        var before = ' ' + Main.translation.mm104;

        // Define calc variable
        var calc;

        // Verify if time is older than now
        if ( calculate < 0 ) {

            // Set absolute value of a calculated time
            calculate = Math.abs(calculate);

            // Set icon
            after = '<i class="far fa-calendar-plus"></i> ';

            // Empty before
            before = '';

        }

        // Calculate time
        if ( calculate < 60 ) {

            return after + Main.translation.mm105;

        } else if ( calculate < 3600 ) {

            calc = calculate / 60;
            calc = Math.round(calc);
            return after + calc + ' ' + Main.translation.mm106 + before;

        } else if ( calculate < 86400 ) {

            calc = calculate / 3600;
            calc = Math.round(calc);
            return after + calc + ' ' + Main.translation.mm107 + before;

        } else if ( calculate >= 86400 ) {

            calc = calculate / 86400;
            calc = Math.round(calc);
            return after + calc + ' '+ Main.translation.mm103 + before;

        }

    };
    
    /*
     * Display alert
     */
    Main.popup_fon = function( cl, msg, ft, lt ) {

        // Add message
        $('<div class="md-message ' + cl + '"><i class="icon-bell"></i> ' + msg + '</div>').insertAfter('section');

        // Display alert
        setTimeout(function () {

            $( document ).find( '.md-message' ).animate({opacity: '0'}, 500);

        }, ft);

        // Hide alert
        setTimeout(function () {

            $( document ).find( '.md-message' ).remove();

        }, lt);

    };
    
    /*
     * Display pagination
     */
    Main.show_pagination = function( id, total ) {
        
        // Empty pagination
        $( id + ' .pagination' ).empty();
        
        // Verify if page is not 1
        if ( parseInt(Main.pagination.page) > 1 ) {
            
            var bac = parseInt(Main.pagination.page) - 1;
            var pages = '<li class="page-item"><a href="#" class="page-link" data-page="' + bac + '">' + Main.translation.mm128 + '</a></li>';
            
        } else {
            
            var pages = '<li class="pagehide page-item"><a href="#" class="page-link">' + Main.translation.mm128 + '</a></li>';
            
        }
        
        // Count pages
        var tot = parseInt(total) / 10;
        tot = Math.ceil(tot) + 1;
        
        // Calculate start page
        var from = (parseInt(Main.pagination.page) > 2) ? parseInt(Main.pagination.page) - 2 : 1;
        
        // List all pages
        for ( var p = from; p < parseInt(tot); p++ ) {
            
            // Verify if p is equal to current page
            if ( p === parseInt(Main.pagination.page) ) {
                
                // Display current page
                pages += '<li class="active page-item"><a data-page="' + p + '" class="page-link">' + p + '</a></li>';
                
            } else if ( (p < parseInt(Main.pagination.page) + 3) && (p > parseInt(Main.pagination.page) - 3) ) {
                
                // Display page number
                pages += '<li class="page-item"><a href="#" class="page-link" data-page="' + p + '">' + p + '</a></li>';
                
            } else if ( (p < 6) && (Math.round(tot) > 5) && ((parseInt(Main.pagination.page) === 1) || (parseInt(Main.pagination.page) === 2)) ) {
                
                // Display page number
                pages += '<li class="page-item"><a href="#" class="page-link" data-page="' + p + '">' + p + '</a></li>';
                
            } else {
                
                break;
                
            }
            
        }
        
        // Verify if current page is 1
        if (p === 1) {
            
            // Display current page
            pages += '<li class="active page-item"><a data-page="' + p + '" class="page-link">' + p + '</a></li>';
            
        }
        
        // Set the next page
        var next = parseInt( Main.pagination.page );
        next++;
        
        // Verify if next page should be displayed
        if (next < Math.round(tot)) {
            
            $( id + ' .pagination' ).html( pages + '<li class="page-item"><a href="#" class="page-link" data-page="' + next + '">' + Main.translation.mm129 + '</a></li>' );
            
        } else {
            
            $( id + ' .pagination' ).html( pages + '<li class="pagehide page-item"><a href="#" class="page-link">' + Main.translation.mm129 + '</a></li>' );
            
        }
        
    };
    
    /*
     * Load the Javascript Object's methods
     * 
     * @since   0.0.0.1
     */
    Main.call_object = function (status, data, fun) {

        Main.methods[fun](status, data);
        
    };
    
    /*
     * Make ajax requests
     * 
     * @param string method for GET or POST
     * @param object data for ajax data pass
     * @param string fun for object's method
     * 
     * @since   0.0.0.1
     */
    Main.ajax_call = function (url, method, data, fun) {

        // Send ajax request
        $.ajax({
            
            //Set the type of request
            type: method,
            
            // Set url
            url: url,
            
            // Set response format
            dataType: 'json',
            
            // Pass data
            data: data,
            
            success: function (data, textStatus, XMLHttpRequest) {

                // Verify if request was processed successfully
                if ( data.success === true ) {
                    
                    // Call the response function and return success message
                    Main.call_object('success', data, fun);
                
                } else {
                
                    // Call the response function and return error message
                    Main.call_object('error', data, fun);
                
                }

            },
            complete: function( jqXHR, textStatus, errorThrown ) {
                $('.page-loading').fadeOut();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                
                // Display error
                console.log(jqXHR.responseText);

            }
        });

    };
    
    /*
     * Display option status
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.0
     */
    Main.methods.enable_or_disable_option_response = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
        } else {

            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }

    };
    
    // Hide the loading page animation
    setTimeout(function(){
        $('.page-loading').fadeOut('slow');
    }, 600);
    
    // Display datetimepicker
    if ( $('.time-schedule').length > 0 ) {
        
        // Set format
        $('.time-schedule').datetimepicker({
            format: 'yyyy-mm-dd hh:ii',
            pickerPosition: 'bottom-left'
        });
        
    }
    
});