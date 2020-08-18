/*
 * Settings javascript file
*/

jQuery(document).ready( function ($) {
    'use strict';
    
    /*
     * Get the website's url
     */
    var url =  $('meta[name=url]').attr('content');
    
    /*******************************
    METHODS
    ********************************/
 
    /*
     * Redirect user to the login or home page
     * 
     * @since   0.0.0.1
     */
    Main.redirect_to_login = function () {
        document.location.href = url;
    };
    
    /*
     * Load invoices
     * 
     * @param integer page contains the page number
     * 
     * @since   0.0.7.5
     */
    Main.load_invoices = function (page) {
        
        if ( $('.settings-page .settings-list-invoices').length < 1 ) {
            return;
        }
        
        var data = {
            action: 'settings_load_invoices',
            page: page
        };
        
        // Make ajax call
        Main.ajax_call(url + 'user/component-ajax/settings', 'GET', data, 'settings_load_invoices');
        
    };
    
    /*******************************
    ACTIONS
    ********************************/
   
    /*
     * Detect select option change
     * 
     * @since   0.0.7.5
     */
    $(document).on('change', '.settings-page .select-option select', function (e) {
        
        $('.settings-page .settings-save-changes').fadeIn('slow');
        
    });    
   
    /*
     * Detect input keyup
     * 
     * @since   0.0.7.5
     */
    $(document).on('keyup', '.settings-page .app-option-input', function (e) {
        
        $('.settings-page .settings-save-changes').fadeIn('slow');
        
    });   
    
    /*
     * Detect checkbox click
     * 
     * @since   0.0.7.5
     */
    $(document).on('click', '.settings-page .app-option-checkbox', function (e) {
        
        $('.settings-page .settings-save-changes').fadeIn('slow');
        
    });
    
    /*
     * Detect click on the save changes button
     * 
     * @since   0.0.7.5
     */
    $(document).on('click', '.settings-page .settings-save-changes', function (e) {
        
        // Get all inputs
        var inputs = $('.settings-page .app-option-input').length;
        
        var all_inputs = [];
        
        for ( var i = 0; i < inputs; i++ ) {
            
            all_inputs[$('.settings-page .app-option-input').eq(i).attr('id')] = $('.settings-page .app-option-input').eq(i).val();
            
        }
        
        // Get all options
        var options = $( '.settings-page .app-option-checkbox' ).length;
        
        var all_options = [];
        
        for ( var o = 0; o < options; o++ ) {
            
            if ( $( '.settings-page .app-option-checkbox' ).eq(o).is(':checked') ) {
                
                all_options[$( '.settings-page .app-option-checkbox' ).eq(o).attr('id')] = 1;
                
            } else {
                
                all_options[$( '.settings-page .app-option-checkbox' ).eq(o).attr('id')] = 0;
                
            }
            
        } 
        
        // Get all select options
        var all_selected_options = $( '.settings-page .select-option select' ).length;
        
        var selected_options = [];
        
        for ( var s = 0; s < all_selected_options; s++ ) {
            
            selected_options[$( '.settings-page .select-option select' ).eq(s).attr('id')] = $( '.settings-page .select-option select' ).eq(s).val();
            
        }         

        var data = {
            action: 'save_user_settings',
            all_inputs: Object.entries(all_inputs),
            all_options: Object.entries(all_options),
            selected_options: Object.entries(selected_options)
        };

        console.log(data);
        
        data[$('.form-settings-save-changes').attr('data-csrf')] = $('input[name="' + $('.form-settings-save-changes').attr('data-csrf') + '"]').val();

        // Make ajax call
        Main.ajax_call(url + 'user/component-ajax/settings', 'POST', data, 'save_user_settings');
        
    });    
    
    /*
     * Delete account
     * 
     * @since   0.0.0.1
     */ 
    $(document).on('click', '.delete-user-account', function (e) {
        
        $.ajax({
            url: url + 'user/delete-account/',
            dataType: 'json',
            type: 'GET',
            success: function (data) {
                
                if ( data.success ) {

                    // Display alert
                    Main.popup_fon('subi', data.message, 1500, 2000);
                    
                    // Redirect to home after 5 seconds
                    setTimeout(Main.redirect_to_login, 5000);

                } else {

                    // Display alert
                    Main.popup_fon('sube', data.message, 1500, 2000);

                }
                
            },
            error: function (data, jqXHR, textStatus) {
                
                console.log('Request failed: ' + textStatus);
                
            }
            
        });
        
    });
    
    /*
     * Displays pagination by page click
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.5
     */    
    $( document ).on( 'click', 'body .pagination li a', function (e) {
        e.preventDefault();
        
        // Get the page number
        var page = $(this).attr('data-page');
        
        // Display results
        switch ( $(this).closest('ul').attr('data-type') ) {
            
            case 'settings-invoices':
                Main.load_invoices(page);
                break;              
            
        }
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });
    
    /*******************************
    RESPONSES
    ********************************/
   
    /*
     * Display invoices by page
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.5
     */
    Main.methods.settings_load_invoices = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display the pagination
            Main.pagination.page = data.page;
            Main.show_pagination('.settings-page #invoices', data.total);

            // Invoices variable
            var invoices = '';

            // List all invoices
            for ( var u = 0; u < data.invoices.length; u++ ) {

                // Add invoice to the list
                invoices += '<li>'
                                + '<div class="row">'
                                    + '<div class="col-xl-9 col-md-9 col-9">'
                                        + '<h3>' + data.invoices[u].invoice_date + '</h3>'
                                    + '</div>'
                                    + '<div class="col-xl-3 col-md-3 col-3 text-right">'
                                        + '<a href="' + url + 'user/settings?p=invoices&invoice=' + data.invoices[u].invoice_id + '" class="btn btn-success theme-background-green">'
                                            + '<i class="fas fa-file-invoice-dollar"></i>'
                                            + data.paid
                                        + '</a>'
                                    + '</div>'
                                + '</div>'
                            + '</li>';

            }

            // Display invoices
            $('.settings-page .settings-list-invoices').html(invoices);
            
        } else {

            // Prepare the no invoices message
            var no_invoices = '<li class="no-invoices-found">'
                                + data.message
                            + '</li>';
            
            // Display the no invoices message
            $('.settings-page .settings-list-invoices').html(no_invoices);
            
        }

    };
    
    /*
     * Save user's settings
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.5
     */
    Main.methods.save_user_settings = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
            // Hide button
            $( '.settings-page .settings-save-changes' ).hide();
            
            // Add disable class
            $( '.settings-page .textarea-option' ).addClass('disabled');
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }

    };
    
    /*
     * Display saving password response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.5
     */
    Main.methods.change_user_password = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
            // Reset the password
            $('.main .form-settings-save-changes')[0].reset();
            
            // Close the modal
            $('#change-password').modal('hide');
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }

    };
    
    /*******************************
    FORMS
    ********************************/
    $('.main #change-password').submit(function (e) {
        e.preventDefault();
        
        // Get current user's password
        var current_password = $(this).find('.current-password').val();
        
        // Get new password
        var new_password = $(this).find('.new-password').val();
        
        // Get repeat password
        var repeat_password = $(this).find('.repeat-password').val();
        
        var data = {
            action: 'change_user_password',
            current_password: current_password,
            new_password: new_password,
            repeat_password: repeat_password
        };
        
        data[$('.form-settings-save-changes').attr('data-csrf')] = $('input[name="' + $('.form-settings-save-changes').attr('data-csrf') + '"]').val();

        // Make ajax call
        Main.ajax_call(url + 'user/component-ajax/settings', 'POST', data, 'change_user_password');
        
    });
    
    // Load all user's invoices
    Main.load_invoices(1);
    
});