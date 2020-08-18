/*
 * Main javascript file
*/

jQuery(document).ready( function ($) {
    'use strict';
    
    // Get home page url
    var url = $('.navbar-brand').attr('href');
    
    /*******************************
    METHODS
    ********************************/
   

   
    /*******************************
    ACTIONS
    ********************************/
   
    /*
     * Display settings save options
     * 
     * @since   0.0.7.6
     */ 
    $( document ).on( 'change', '.settings .settings-option-input', function () {
        
        // Display save button
        $('.settings-save-changes').fadeIn('slow');
        
    });    
   
    /*
     * Display settings save options
     * 
     * @since   0.0.7.6
     */ 
    $( document ).on( 'click', '.settings .settings-option-checkbox', function () {
        
        // Display save button
        $('.settings-save-changes').fadeIn('slow');
        
    });   
    
    /*
     * Save settings
     * 
     * @since   0.0.7.6
     */ 
    $( document ).on( 'click', '.settings-save-changes', function () {
        
        // Hide save button
        $('.settings-save-changes').fadeOut('slow');
        
        // Get all options
        var options = $('.settings .settings-option-checkbox').length;
        
        var all_options = [];
        
        for ( var o = 0; o < options; o++ ) {
            
            if ( $('.settings .settings-option-checkbox').eq(o).is(':checked') ) {
                
                all_options[$('.settings .settings-option-checkbox').eq(o).attr('id')] = 1;
                
            } else {
                
                all_options[$('.settings .settings-option-checkbox').eq(o).attr('id')] = 0;
                
            }
            
        }
        
        // Get all inputs
        var inputs = $('.settings .settings-option-input').length;
        
        var all_inputs = [];
        
        for ( var i = 0; i < inputs; i++ ) {
            
            all_inputs[$('.settings .settings-option-input').eq(i).attr('id')] = $('.settings .settings-option-input').eq(i).val();
            
        }
        
        var data = {
            action: 'save_admin_settings',
            all_inputs: Object.entries(all_inputs),
            all_options: Object.entries(all_options)
        };
        
        data[$('.save-settings').attr('data-csrf')] = $('input[name="' + $('.save-settings').attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/settings', 'POST', data, 'save_admin_settings');
        
    });      
   
   
    /*******************************
    RESPONSES
    ********************************/
   
    /*
     * Display settings saving response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.6
     */
    Main.methods.save_admin_settings = function ( status, data ) { 

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
        } else {

            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }
        
    };
   
    /*******************************
    FORMS
    ********************************/
    

    
    /*******************************
    DEPENDENCIES
    ********************************/
   
    // Hide the loading page animation
    setTimeout(function(){
        $('.page-loading').fadeOut('slow');
    }, 600);
    
});