/*
 * Progress Bar Circle JavaScript Default
*/

jQuery(document).ready( function ($) {
    'use strict';

    /*******************************
    METHODS
    ********************************/

    /*
     * Draw the circle
     * 
     * @param object context contains the context
     * @param string color contains the circle's color
     * @param integer width contains the line width
     * @param integer percent contains the circle complete process
     * @param integer radius contains the circle's radius
     * 
     * @since   0.0.8.5
     */
    Main.default_progress_bar_circle = function(context, color, width, percent, radius) {

        // Calculate the percentage
        percent = Math.min(Math.max(0, percent || 1), 1);

        // Begin a path
        context.beginPath();

        // Set size
        context.arc(0, 0, radius, 0, Math.PI * 2 * percent, false);

        // Set color
        context.strokeStyle = color;

        // Set line cap
        context.lineCap = 'round';

        // Set with
        context.lineWidth = width;

        // Draw
        context.stroke();
        
    };

    /*
     * Draw the progress bar
     * 
     * @param string id contains the canvas id
     * 
     * @since   0.0.8.5
     */
    Main.default_progress_draw_bar_circle = function (id) {

        // Verify if the required parameters exists
        if ( ($(id).attr('id') !== null) && ($(id).attr('data-value') !== null) && ($(id).attr('data-max') !== null) ) {

            // Remove existing canvas
            $(id).empty();

            // Get div
            var div = document.getElementById($(id).attr('id'));
            
            // Create canvas
            var canvas = document.createElement('canvas');
            
            // Get context
            var context = canvas.getContext('2d');

            // Set width and height
            canvas.width = canvas.height = 20;
            
            // Append canvas to fiv
            div.appendChild(canvas);
            
            // Set content size
            context.translate(20 / 2, 20 / 2);

            // Rotate
            context.rotate((-1 / 2 + 0 / parseInt($(id).attr('data-max'))) * Math.PI);
            
            // Draw the incomplete circle
            Main.default_progress_bar_circle (context, words.color_grey, 2, 100 / 100, (20 - 2) / 2);

            // Verify if percentage is higher than 0
            if ( parseInt($(id).attr('data-value')) > 0 ) {

                // Verify if percentage is higher than 100
                if ( parseInt($(id).attr('data-value')) > 100 ) {

                    // Draw complete circle
                    Main.default_progress_bar_circle (context, words.color_red, 2, 1, (20 - 2) / 2);

                } else {

                    // Draw complete circle
                    Main.default_progress_bar_circle (context, words.color_blue, 2, $(id).attr('data-value') / 100, (20 - 2) / 2);

                }

            }

        }

    };
  
    /*******************************
    ACTIONS
    ********************************/

    /*
     * Get default content
     * 
     * @since   0.0.8.5
     */
    $(function () {

        // Verify if progress bar exists
        if ( $('.main .default-progress-bar-circle').length > 0 ) {

            // Identify all progress bars
            $( '.main .default-progress-bar-circle' ).each(function() {

                // Verify if the required parameters exists
                if ( ($(this).attr('id') !== null) && ($(this).attr('data-value') !== null) && ($(this).attr('data-max') !== null) ) {

                    // Draw progress bar
                    Main.default_progress_draw_bar_circle('.main #' + $(this).attr('id'));

                }

            });

        }

    });

});