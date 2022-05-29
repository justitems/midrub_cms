/*
 * Spinner Loading Content JavaScript Default
*/

jQuery(document).ready( function ($) {
    'use strict';

    /*******************************
    METHODS
    ********************************/

    /*
     * Show the loading content button
     * 
     * @param string is contains the button's id
     * 
     * @since   0.0.8.5
     */
    Main.default_spinner_loading_button_show = function(id) {

        // Show the loading animation
        $(id).fadeIn('slow');
        
    };

    /*
     * Hide the loading content button
     * 
     * @param string is contains the button's id
     * 
     * @since   0.0.8.5
     */
    Main.default_spinner_loading_button_hide = function(id) {

        // Hide the loading animation
        $(id).fadeOut('slow');
        
    };

});