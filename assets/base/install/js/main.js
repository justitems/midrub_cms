/*
 * Main javascript file
*/
jQuery(document).ready( function ($) {
    'use strict';
    
    /*******************************
    METHODS
    ********************************/
  
    /*******************************
    ACTIONS
    ********************************/

    /*
     * Save the information
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.0
     */
    $(document).on('click', '.btn-save-information', function (e) {
        e.preventDefault();

        // Set animation
        let animation = '<div class="page-loading">'
                            + '<div class="animation-area">'
                                + '<div></div>'
                                + '<div></div>'
                            + '</div>'
                        + '</div>';

        // Insert animation
        $(animation).insertAfter('.website-information');

        // Redirect 
        setTimeout(function() {
            
            // Submit the form
            $('.website-information').submit();

        }, 2000);

    });

    /*
     * Save the database's information
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.0
     */
    $(document).on('click', '.btn-save-database', function (e) {
        e.preventDefault();

        // Set animation
        let animation = '<div class="page-loading">'
                            + '<div class="animation-area">'
                                + '<div></div>'
                                + '<div></div>'
                            + '</div>'
                        + '</div>';

        // Insert animation
        $(animation).insertAfter('.database-information');

        // Redirect 
        setTimeout(function() {
            
            // Submit the form
            $('.database-information').submit();

        }, 2000);

    });
   
    /*******************************
    RESPONSES
    ********************************/
    
    /*******************************
    FORMS
    ********************************/

    /*
     * Start Installation
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.1
     */
    $(document).on('submit', '.start-installation', function (e) {
        e.preventDefault();

        // Set animation
        let animation = '<div class="page-loading">'
                            + '<div class="animation-area">'
                                + '<div></div>'
                                + '<div></div>'
                            + '</div>'
                        + '</div>';

        // Insert animation
        $(animation).insertAfter('.start-installation');

        // Set url
        let url = $(this).attr('action');

        // Redirect 
        setTimeout(function() {

            document.location.href = url;

        }, 2000);

    });
    
    /*******************************
    DEPENDENCIES
    ********************************/

    setTimeout(function() {
        
        // Remove the page loading
        $('.page-loading').remove();

        // If finish id exists means Midrub was installed
        if ( $('body #finish').length > 0 ) {

            setTimeout(function() {

                // Refresh
                document.location.href = document.location.href;

            }, 5000);

        }

    }, 600);

});