/*
 * Dropdown Time Picker JavaScript Default
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

        // Verify if time pickers exists
        if ( $('.main .default-dropdown-time-picker').length > 0 ) {

            // Identify all time pickers
            $( '.main .default-dropdown-time-picker' ).each(function() {

                // Set hour
                var hour = $(this).attr('data-hour');

                // Set minute
                let minute = $(this).attr('data-minute');

                // Unique id
                let unique_id = Math.floor(Math.random() * 100);

                // Meridiem
                var meridiem ='';

                // Meridiems
                var meridiems = '';
                
                // Verify if is 12 hours format
                if ( parseInt($(this).attr('data-time-format')) === 12 ) {

                    // Set meridiem
                    meridiem = (hour < 12)?'<span class="default-dropdown-time-picker-meridiem" contenteditable="true" placeholder="AM" maxlength="2">' + 'AM' + '</span>':'<span class="default-dropdown-time-picker-meridiem" contenteditable="true" placeholder="PM" maxlength="2">' + 'PM' + '</span>';

                    // Adjust the hour
                    hour = (hour > 11)?((hour - 12) < 10)?'0' + (hour - 12):(hour - 12):hour;

                    // Set meridiems
                    meridiems = '<div class="col-4">'
                        + '<ul class="default-dropdown-time-picker-dropdown-meridiem">'
                            + '<li>'
                                + '<a href="#" data-meridiem="0">'
                                    + 'AM'
                                + '</a>'
                            + '</li>'
                            + '<li>'
                                + '<a href="#" data-meridiem="1">'
                                    + 'PM'
                                + '</a>'
                            + '</li>'
                        + '</ul>'
                    + '</div>';

                    // Set hours
                    var hours = '<li>'
                        + '<a href="#" data-hour="00">'
                            + '00'
                        + '</a>'
                    + '</li>'
                    + '<li>'
                        + '<a href="#" data-hour="01">'
                            + '01'
                        + '</a>'
                    + '</li>'
                    + '<li>'
                        + '<a href="#" data-hour="02">'
                            + '02'
                        + '</a>'
                    + '</li>'
                    + '<li>'
                        + '<a href="#" data-hour="03">'
                            + '03'
                        + '</a>'
                    + '</li>'
                    + '<li>'
                        + '<a href="#" data-hour="04">'
                            + '04'
                        + '</a>'
                    + '</li>'
                    + '<li>'
                        + '<a href="#" data-hour="05">'
                            + '05'
                        + '</a>'
                    + '</li>'
                    + '<li>'
                        + '<a href="#" data-hour="06">'
                            + '06'
                        + '</a>'
                    + '</li>'
                    + '<li>'
                        + '<a href="#" data-hour="07">'
                            + '07'
                        + '</a>'
                    + '</li>'
                    + '<li>'
                        + '<a href="#" data-hour="08">'
                            + '08'
                        + '</a>'
                    + '</li>'
                    + '<li>'
                        + '<a href="#" data-hour="09">'
                            + '09'
                        + '</a>'
                    + '</li>'
                    + '<li>'
                        + '<a href="#" data-hour="10">'
                            + '10'
                        + '</a>'
                    + '</li>'
                    + '<li>'
                        + '<a href="#" data-hour="11">'
                            + '11'
                        + '</a>'
                    + '</li>';

                } else {

                    // Set hours
                    var hours = '<li>'
                        + '<a href="#" data-hour="00">'
                            + '00'
                        + '</a>'
                    + '</li>'
                    + '<li>'
                        + '<a href="#" data-hour="01">'
                            + '01'
                        + '</a>'
                    + '</li>'
                    + '<li>'
                        + '<a href="#" data-hour="02">'
                            + '02'
                        + '</a>'
                    + '</li>'
                    + '<li>'
                        + '<a href="#" data-hour="03">'
                            + '03'
                        + '</a>'
                    + '</li>'
                    + '<li>'
                        + '<a href="#" data-hour="04">'
                            + '04'
                        + '</a>'
                    + '</li>'
                    + '<li>'
                        + '<a href="#" data-hour="05">'
                            + '05'
                        + '</a>'
                    + '</li>'
                    + '<li>'
                        + '<a href="#" data-hour="06">'
                            + '06'
                        + '</a>'
                    + '</li>'
                    + '<li>'
                        + '<a href="#" data-hour="07">'
                            + '07'
                        + '</a>'
                    + '</li>'
                    + '<li>'
                        + '<a href="#" data-hour="08">'
                            + '08'
                        + '</a>'
                    + '</li>'
                    + '<li>'
                        + '<a href="#" data-hour="09">'
                            + '09'
                        + '</a>'
                    + '</li>'
                    + '<li>'
                        + '<a href="#" data-hour="10">'
                            + '10'
                        + '</a>'
                    + '</li>'
                    + '<li>'
                        + '<a href="#" data-hour="11">'
                            + '11'
                        + '</a>'
                    + '</li>'            
                    + '<li>'
                        + '<a href="#" data-hour="12">'
                            + '12'
                        + '</a>'
                    + '</li>'
                    + '<li>'
                        + '<a href="#" data-hour="13">'
                            + '13'
                        + '</a>'
                    + '</li>'
                    + '<li>'
                        + '<a href="#" data-hour="14">'
                            + '14'
                        + '</a>'
                    + '</li>'
                    + '<li>'
                        + '<a href="#" data-hour="15">'
                            + '15'
                        + '</a>'
                    + '</li>'
                    + '<li>'
                        + '<a href="#" data-hour="16">'
                            + '16'
                        + '</a>'
                    + '</li>'
                    + '<li>'
                        + '<a href="#" data-hour="17">'
                            + '17'
                        + '</a>'
                    + '</li>'
                    + '<li>'
                        + '<a href="#" data-hour="18">'
                            + '18'
                        + '</a>'
                    + '</li>'
                    + '<li>'
                        + '<a href="#" data-hour="19">'
                            + '19'
                        + '</a>'
                    + '</li>'
                    + '<li>'
                        + '<a href="#" data-hour="20">'
                            + '20'
                        + '</a>'
                    + '</li>'
                    + '<li>'
                        + '<a href="#" data-hour="21">'
                            + '21'
                        + '</a>'
                    + '</li>'
                    + '<li>'
                        + '<a href="#" data-hour="22">'
                            + '22'
                        + '</a>'
                    + '</li>'
                    + '<li>'
                        + '<a href="#" data-hour="23">'
                            + '23'
                        + '</a>'
                    + '</li>';
                    
                }

                // With meridiem class
                let with_meridiem = (parseInt($(this).attr('data-time-format')) === 12 )?' default-dropdown-time-with-meridiem':'';

                // Prepare content
                let content = '<div class="row">'
                    + '<div class="col-9">'
                        + '<div class="default-dropdown-time-picker-container">'
                            + '<span class="default-dropdown-time-picker-hour" contenteditable="true" placeholder="00" maxlength="2">'
                                + hour
                            + '</span>'
                            + '<span class="default-dropdown-time-picker-separator">'
                                + ':'
                            + '</span>'
                            + '<span class="default-dropdown-time-picker-minute" contenteditable="true" placeholder="00" maxlength="2">'
                                + minute
                            + '</span>'
                            + '<span class="default-dropdown-time-picker-separator">'
                            + ' '
                            + '</span>'
                            + meridiem
                        + '</div>'
                    + '</div>'                                                                        
                    + '<div class="col-3 p-0 text-center">'
                        + '<div id="default-dropdown-time-picker-dropdown-' + unique_id + '" class="dropdown dropdown-options m-0 theme-dropdown-5 theme-dropdown-icon-1">'
                            + '<button class="btn btn-link" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" data-type="0">'
                                + words.icon_arrow_down
                            + '</button>'
                            + '<div class="dropdown-menu default-dropdown-time-picker-dropdown-menu' + with_meridiem + ' dropdown-menu-right">'
                                + '<div class="row">'
                                    + '<div class="col-4">'
                                        + '<ul class="default-dropdown-time-picker-dropdown-hour">'
                                            + hours
                                        + '</ul>'
                                    + '</div>'
                                    + '<div class="col-4">'
                                        + '<ul class="default-dropdown-time-picker-dropdown-minute">'
                                            + '<li>'
                                                + '<a href="#" data-minute="00">'
                                                    + '00'
                                                + '</a>'
                                            + '</li>'
                                            + '<li>'
                                                + '<a href="#" data-minute="05">'
                                                    + '05'
                                                + '</a>'
                                            + '</li>'
                                            + '<li>'
                                                + '<a href="#" data-minute="10">'
                                                    + '10'
                                                + '</a>'
                                            + '</li>'
                                            + '<li>'
                                                + '<a href="#" data-minute="15">'
                                                    + '15'
                                                + '</a>'
                                            + '</li>'
                                            + '<li>'
                                                + '<a href="#" data-minute="20">'
                                                    + '20'
                                                + '</a>'
                                            + '</li>'
                                            + '<li>'
                                                + '<a href="#" data-minute="25">'
                                                    + '25'
                                                + '</a>'
                                            + '</li>'
                                            + '<li>'
                                                + '<a href="#" data-minute="30">'
                                                    + '30'
                                                + '</a>'
                                            + '</li>'
                                            + '<li>'
                                                + '<a href="#" data-minute="35">'
                                                    + '35'
                                                + '</a>'
                                            + '</li>'
                                            + '<li>'
                                                + '<a href="#" data-minute="40">'
                                                    + '40'
                                                + '</a>'
                                            + '</li>'
                                            + '<li>'
                                                + '<a href="#" data-minute="45">'
                                                    + '45'
                                                + '</a>'
                                            + '</li>'
                                            + '<li>'
                                                + '<a href="#" data-minute="50">'
                                                    + '50'
                                                + '</a>'
                                            + '</li>'            
                                            + '<li>'
                                                + '<a href="#" data-minute="55">'
                                                    + '55'
                                                + '</a>'
                                            + '</li>'
                                        + '</ul>'
                                    + '</div>'
                                    + meridiems
                                + '</div>'
                            + '</div>'
                        + '</div>'
                    + '</div>'                                                                            
                + '</div>'; 

                // Add content
                $(this).html(content);
                
            });

        }

    });

    /*
     * Detect time picker keyup
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.5
     */
    $( document ).on('keyup', '.default-dropdown-time-picker [contenteditable=true]', function(e) {

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

            // Verify if is timepicker
            if ( $(this).closest('.default-dropdown-time-picker').length > 0 ) {

                // Verify if the hour and minute contains 2 characters
                if ( ($(this).closest('.default-dropdown-time-picker').find('.default-dropdown-time-picker-hour').text().length > 1) && ($(this).closest('.default-dropdown-time-picker').find('.default-dropdown-time-picker-minute').text().length > 1 ) ) {

                    // Verify if is meridiem
                    if ( $(this).hasClass('default-dropdown-time-picker-meridiem') ) {

                        // Verify if the meridiem is correct
                        if ( (clean === 'AM') || (clean === 'PM') ) {

                            // Set hour
                            let hour = (clean === 'AM')?(parseInt($(this).closest('.default-dropdown-time-picker').attr('data-hour')) > 11)?(parseInt($(this).closest('.default-dropdown-time-picker').attr('data-hour')) - 12):$(this).closest('.default-dropdown-time-picker').attr('data-hour'):(parseInt($(this).closest('.default-dropdown-time-picker').attr('data-hour')) < 12)?(parseInt($(this).closest('.default-dropdown-time-picker').attr('data-hour')) + 12):$(this).closest('.default-dropdown-time-picker').attr('data-hour');

                            // Set hour
                            $(this).closest('.default-dropdown-time-picker').attr('data-hour', hour);
                            
                            // Set meridiem
                            let meridiem = (clean === 'AM')?0:1;

                            // Remove the selected meridiem
                            $(this).closest('.default-dropdown-time-picker').find('.default-dropdown-time-picker-dropdown-meridiem > li > a').removeClass('default-dropdown-time-picker-dropdown-selected');

                            // Add the selected meridiem
                            $(this).closest('.default-dropdown-time-picker').find('.default-dropdown-time-picker-dropdown-meridiem > li > a[data-meridiem="' + meridiem + '"]').addClass('default-dropdown-time-picker-dropdown-selected');

                        }

                    } else {

                        // Set hour
                        let hour = ($(this).closest('.default-dropdown-time-picker').find('.default-dropdown-time-picker-hour').text().trim() === '24')?'00':$(this).closest('.default-dropdown-time-picker').find('.default-dropdown-time-picker-hour').text().trim();

                        // Set minute
                        let minute = $(this).closest('.default-dropdown-time-picker').find('.default-dropdown-time-picker-minute').text().trim();

                        // Get today date
                        let today = new Date();

                        // Set date
                        let the_date = new Date(today.getFullYear() + '/' + String(today.getMonth() + 1).padStart(2, '0') + '/' + String(today.getDate()).padStart(2, '0') + ' ' + hour + ':' + minute + ':' + '00');

                        // Verify if the date is correct
                        if ( the_date.getTime() === the_date.getTime() ) {

                            // Set hour
                            $(this).closest('.default-dropdown-time-picker').attr('data-hour', hour);

                            // Set minute
                            $(this).closest('.default-dropdown-time-picker').attr('data-minute', minute);

                            // Remove the selected hour
                            $(this).closest('.default-dropdown-time-picker').find('.default-dropdown-time-picker-dropdown-hour > li > a').removeClass('default-dropdown-time-picker-dropdown-selected');

                            // Remove the selected minute
                            $(this).closest('.default-dropdown-time-picker').find('.default-dropdown-time-picker-dropdown-minute > li > a').removeClass('default-dropdown-time-picker-dropdown-selected');

                            // Add the selected hour
                            $(this).closest('.default-dropdown-time-picker').find('.default-dropdown-time-picker-dropdown-hour > li > a[data-hour="' + hour + '"]').addClass('default-dropdown-time-picker-dropdown-selected');

                            // Add the selected minute
                            $(this).closest('.default-dropdown-time-picker').find('.default-dropdown-time-picker-dropdown-minute > li > a[data-minute="' + minute + '"]').addClass('default-dropdown-time-picker-dropdown-selected');

                        }

                    }

                }
                
            }

        }

    });

    /*
     * Detect time picker paste
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.5
     */
    $( document ).on('paste', '.default-dropdown-time-picker [contenteditable=true]', function(e) {
        e.preventDefault();
    });

    /*
     * Detect time picker keypress
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.5
     */
    $( document ).on('keypress', '.default-dropdown-time-picker [contenteditable=true]', function(e) {

        // Verify if is not numeric
        if ( isNaN(String.fromCharCode(e.which)) && !$(this).hasClass('default-dropdown-time-picker-meridiem') ) {
            e.preventDefault();
        }

        // Verify if is meridiem
        if ( $(this).hasClass('default-dropdown-time-picker-meridiem') ) {

            // Verify if the value is allowed
            if ( (String.fromCharCode(e.which) !== 'A') && (String.fromCharCode(e.which) !== 'P') && (String.fromCharCode(e.which) !== 'M') && (String.fromCharCode(e.which) !== 'AM') && (String.fromCharCode(e.which) !== 'PM') ) {
                e.preventDefault();
            }

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
     * Detect dropdown click
     *
     * @param object e with global object
     * 
     * @since   0.0.8.5 
     */    
    $(document).on('click', '.default-dropdown-time-picker .btn-link', function (e) {
        e.preventDefault();

        // Reset the click
        $(this).off('click'); 

        // Set hour
        var hour = $(this).closest('.default-dropdown-time-picker').attr('data-hour');

        // Set minute
        var minute = $(this).closest('.default-dropdown-time-picker').attr('data-minute');

        // Verify if is 12 hours format
        if ( parseInt($(this).closest('.default-dropdown-time-picker').attr('data-time-format')) === 12 ) {

            // Set meridiem
            let meridiem = (hour > 11)?1:0;

            // Set active class
            $(this).closest('.default-dropdown-time-picker').find('.default-dropdown-time-picker-dropdown-meridiem > li > a[data-meridiem="' + meridiem + '"]').addClass('default-dropdown-time-picker-dropdown-selected');    

            // Adjust the hour
            hour = (hour > 11)?((hour - 12) < 10)?'0' + (hour - 12):(hour - 12):hour;

        }
        
        // Set active class
        $(this).closest('.default-dropdown-time-picker').find('.default-dropdown-time-picker-dropdown-hour > li > a[data-hour="' + hour + '"]').addClass('default-dropdown-time-picker-dropdown-selected');
        $(this).closest('.default-dropdown-time-picker').find('.default-dropdown-time-picker-dropdown-minute > li > a[data-minute="' + minute + '"]').addClass('default-dropdown-time-picker-dropdown-selected');

        // Scroll hour
        $(this).closest('.default-dropdown-time-picker').find('.default-dropdown-time-picker-dropdown-hour').animate({
            scrollTop: (parseInt(hour) > 0)?(parseInt(hour) * 33):0
        }, 500);

        // Scroll minute
        $(this).closest('.default-dropdown-time-picker').find('.default-dropdown-time-picker-dropdown-minute').animate({
            scrollTop: (parseInt(minute) > 0)?((parseInt(minute)/5) * 33):0
        }, 500);
        
    });

    /*
     * Select a hour
     *
     * @param object e with global object
     * 
     * @since   0.0.8.5 
     */  
    $(document).on('click', '.default-dropdown-time-picker .default-dropdown-time-picker-dropdown-hour li a, .default-dropdown-time-picker .default-dropdown-time-picker-dropdown-minute li a, .default-dropdown-time-picker .default-dropdown-time-picker-dropdown-meridiem li a', function (e) {
        e.preventDefault();

        // Remove class default-dropdown-time-picker-dropdown-selected
        $(this).closest('ul').find('li a').removeClass('default-dropdown-time-picker-dropdown-selected');
        
        // Add class default-dropdown-time-picker-dropdown-selected
        $(this).addClass('default-dropdown-time-picker-dropdown-selected');

        // Set hour
        var hour = $(this).closest('.default-dropdown-time-picker').find('.default-dropdown-time-picker-dropdown-hour .default-dropdown-time-picker-dropdown-selected').attr('data-hour');

        // Set minute
        var minute = $(this).closest('.default-dropdown-time-picker').find('.default-dropdown-time-picker-dropdown-minute .default-dropdown-time-picker-dropdown-selected').attr('data-minute');

        // Set hour
        $(this).closest('.default-dropdown-time-picker').find('.default-dropdown-time-picker-hour').text(hour);

        // Verify if is 12 hours format
        if ( parseInt($(this).closest('.default-dropdown-time-picker').attr('data-time-format')) === 12 ) {

            // Get meridiem
            let meridiem = $(this).closest('.default-dropdown-time-picker').find('.default-dropdown-time-picker-dropdown-meridiem .default-dropdown-time-picker-dropdown-selected');

            // Set meridiem
            $(this).closest('.default-dropdown-time-picker').find('.default-dropdown-time-picker-meridiem').text($(meridiem).text());

            // Adjust the hour
            hour = (parseInt($(meridiem).attr('data-meridiem')) > 0)?(parseInt(hour) + 12):hour;

        }

        // Set hour
        $(this).closest('.default-dropdown-time-picker').attr('data-hour', hour);

        // Set minute
        $(this).closest('.default-dropdown-time-picker').attr('data-minute', minute);
        $(this).closest('.default-dropdown-time-picker').find('.default-dropdown-time-picker-minute').text(minute);

    });
    
});