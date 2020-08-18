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
    
});