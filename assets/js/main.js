/*
 * Main javascript file
*/

/*
 * Create the main object
 */
var Main = new Object({
    methods: {},
    translation: {},
    pagination: {}
});

jQuery(document).ready( function ($) {
    'use strict';

    /*
     * Load the Javascript Object's methods
     * 
     * @param string method for GET or POST
     * @param object data for ajax data pass
     * @param string fun for object's method
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
    Main.ajax_call = function (url, method, data, fun, progress_fun) {

        // Verify if the method was POST
        if ( method === 'POST' ) {

            // Get a new csrf
            $.get($('meta[name=url]').attr('content') + 'auth/ajax/page?action=generate_csrf', function (response) {

                // Parse json
                let json = JSON.parse(response);

                // Verify if csrf exists
                if ( typeof json.csrf !== 'undefined' ) {

                    // Verify if csrf name and hash exists
                    if ( (typeof json.csrf.name !== 'undefined') && (typeof json.csrf.hash !== 'undefined') ) {

                        // Set CSRF
                        data[json.csrf.name] = json.csrf.hash;

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

                            // Get progress
                            xhr: function () {

                                var xhr = $.ajaxSettings.xhr();

                                xhr.upload.onprogress = function (e) {

                                    if (e.lengthComputable) {
                                        
                                        if ( typeof progress_fun !== 'undefined' ) {

                                            Main.methods[progress_fun](e.loaded, e.total);

                                        }

                                    }

                                };

                                return xhr;

                            },
                            
                            success: function (data) {

                                // Verify if request was processed successfully
                                if ( data.success === true ) {
                                    
                                    // Call the response function and return success message
                                    Main.call_object('success', data, fun);
                                
                                } else {
                                
                                    // Call the response function and return error message
                                    Main.call_object('error', data, fun);
                                
                                }

                            },
                            complete: function( ) {

                                // Hide the loading animation
                                $('.page-loading').fadeOut();

                            },
                            error: function (jqXHR) {
                                
                                // Display error
                                console.log(jqXHR.responseText);

                            }
                        });

                    }

                }

            });

        } else {

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

                // Get progress
                xhr: function () {

                    var xhr = $.ajaxSettings.xhr();

                    xhr.upload.onprogress = function (e) {

                        if (e.lengthComputable) {
                            
                            if ( typeof progress_fun !== 'undefined' ) {

                                Main.methods[progress_fun](e.loaded, e.total);

                            }

                        }

                    };

                    return xhr;

                },
                
                success: function (data) {

                    // Verify if request was processed successfully
                    if ( data.success === true ) {
                        
                        // Call the response function and return success message
                        Main.call_object('success', data, fun);
                    
                    } else {
                    
                        // Call the response function and return error message
                        Main.call_object('error', data, fun);
                    
                    }

                },
                complete: function( ) {

                    // Hide the loading animation
                    $('.page-loading').fadeOut();

                },
                error: function (jqXHR) {
                    
                    // Display error
                    console.log(jqXHR.responseText);

                }
            });

        }

    };
    
});