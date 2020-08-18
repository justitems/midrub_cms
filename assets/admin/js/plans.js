/*
 * Plans javascript file
*/

jQuery(document).ready( function ($) {
    'use strict';
    
    // Get home page url
    var url = $('.navbar-brand').attr('href');
    
    /*******************************
    METHODS
    ********************************/
   
   
    /*******************************
    RESPONSES
    ********************************/
    
    /*
     * Display new plan creation response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.4
     */
    Main.methods.create_new_plan = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
            setTimeout(function(){
                document.location.href = url + 'admin/plans/' + data.plan_id;
            }, 3000);
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }

    }; 
    
    /*
     * Display the plan deletion response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.4
     */
    Main.methods.delete_plan = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
            setTimeout(function(){
                document.location.href = url + 'admin/plans';
            }, 3000);
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }

    };
    
    /*
     * Display the plan update response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.4
     */
    Main.methods.update_a_plan = function ( status, data ) {
        
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
    ACTIONS
    ********************************/
   
    /*
     * Display deletion options
     * 
     * @since   0.0.7.4
     */
    $(document).on('click', '.plan .delete-plan', function () {

        // Try to delete a plan
        $('.confirm').fadeIn('slow');
        
    });
    
    /*
     * Cancel plan deletion
     * 
     * @since   0.0.7.4
     */
    $(document).on('click', '.plan .confirm .no', function () {

        $('.confirm').fadeOut('slow');
        
    });
    
    /*
     * Delete the plan
     * 
     * @since   0.0.7.4
     */
    $(document).on('click', '.plan .confirm .yes', function (e) {
        e.preventDefault();
        
        // Get the plan's id
        var plan_id = $('.plan').attr('data-plan-id');
        
        var data = {
            action: 'delete_plan',
            plan_id: plan_id
        };
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/plans', 'GET', data, 'delete_plan');
        
    });   
    
    /*******************************
    FORMS
    ********************************/
    
    /*
     * Create a new plan
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.4
     */
    $('.create-plan').submit(function (e) {
        e.preventDefault();
        
        var data = {
            action: 'create_new_plan',
            plan_name: $('.plan_name').val()
        };
        
        data[$('.create-plan').attr('data-csrf')] = $('input[name="' + $('.create-plan').attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/plans', 'POST', data, 'create_new_plan');
        
    });
    
    /*
     * Update the plan
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.4
     */
    $('.update-plan').submit(function (e) {
        e.preventDefault();
        
        // Get all inputs
        var inputs = $('.plan .app-plan-input').length;
        
        var all_inputs = [];
        
        for ( var i = 0; i < inputs; i++ ) {
            
            all_inputs[$('.plan .app-plan-input').eq(i).attr('id')] = $('.plan .app-plan-input').eq(i).val();
            
        }
        
        // Get all options
        var options = $('.plan .app-option-checkbox').length;
        
        var all_options = [];
        
        for ( var o = 0; o < options; o++ ) {
            
            if ( $('.plan .app-option-checkbox').eq(o).is(':checked') ) {
                all_options[$('.plan .app-option-checkbox').eq(o).attr('id')] = 1;
            } else {
                all_options[$('.plan .app-option-checkbox').eq(o).attr('id')] = 0;
            }
            
        }        

        var data = {
            action: 'update_a_plan',
            plan_id: $('.plan').attr('data-plan-id'),
            all_inputs: Object.entries(all_inputs),
            all_options: Object.entries(all_options)
        };
        
        data[$('.update-plan').attr('data-csrf')] = $('input[name="' + $('.update-plan').attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/plans', 'POST', data, 'update_a_plan');
        
    });
 
});