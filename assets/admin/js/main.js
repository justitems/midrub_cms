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
    
    // Get the installation url
    var url = $('.navbar-brand').attr('href');
    
    $('.short-menu').click(function () {
        $('nav').toggle('slow');
    });
    
    $(document).on('click', '.settings .spinner .btn:first-of-type', function () {
        
        var id = $(this).attr('data-id');
        $('#'+id).val(parseInt($(this).closest('.spinner').find('input').val(), 10) + 1);
        $('#'+id).keyup();
        
    });
    
    $(document).on('click', '.settings .spinner .btn:last-of-type', function () {
    
        var id = $(this).attr('data-id');
        $('#'+id).val(parseInt($(this).closest('.spinner').find('input').val(), 10) - 1);
        $('#'+id).keyup();
        
    });
    
    $('.optionvalue').keyup(function () {

        var id = $(this).attr('id');

        var value = htmlEntities(encodeURIComponent($(this).val()));

        if ( !value )
            value = 'empty-option';

        value = btoa(value);
        value = value.replace('/', '-');
        value = value.replace(/=/g, '');
        Main.add_value_to_option(id, value);

    });

    $(document).on('change','.optionvalue',function () {

        var id = $(this).attr('id');

        var value = encodeURIComponent($(this).val());

        if (!value) {
            value = 'empty-option';
        }

        value = btoa(value);

        value = value.replace('/', '-');

        value = value.replace(/=/g, '');

        Main.add_value_to_option(id, value);

    });
    
    $(document).on('click', '.users .list-group>li>.question', function () {
        
        $(this).closest('li').find('.answer').toggle('slow');
        
        if ( $(this).closest('li').find('.fa-chevron-down').length > 0 ) {
            
            $(this).closest('li').find('.fa-chevron-down').addClass('fa-chevron-up');
            $(this).closest('li').find('.fa-chevron-up').removeClass('fa-chevron-down');
            
        } else {
            
            $(this).closest('li').find('.fa-chevron-up').addClass('fa-chevron-down');
            $(this).closest('li').find('.fa-chevron-down').removeClass('fa-chevron-up');
            
        }
        
    });
    
    /*
     * Display pagination
     */
    Main.show_pagination = function( id, total ) {
        
        // Empty pagination
        $( id + ' .pagination' ).empty();
        
        // Verify if page is not 1
        if ( parseInt(Main.pagination.page) > 1 ) {
            
            var bac = parseInt(Main.pagination.page) - 1;
            var pages = '<li><a href="#" data-page="' + bac + '">' + translation.mm128 + '</a></li>';
            
        } else {
            
            var pages = '<li class="pagehide"><a href="#">' + translation.mm128 + '</a></li>';
            
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
                pages += '<li class="active"><a data-page="' + p + '">' + p + '</a></li>';
                
            } else if ( (p < parseInt(Main.pagination.page) + 3) && (p > parseInt(Main.pagination.page) - 3) ) {
                
                // Display page number
                pages += '<li><a href="#" data-page="' + p + '">' + p + '</a></li>';
                
            } else if ( (p < 6) && (Math.round(tot) > 5) && ((parseInt(Main.pagination.page) === 1) || (parseInt(Main.pagination.page) === 2)) ) {
                
                // Display page number
                pages += '<li><a href="#" data-page="' + p + '">' + p + '</a></li>';
                
            } else {
                
                break;
                
            }
            
        }
        
        // Verify if current page is 1
        if (p === 1) {
            
            // Display current page
            pages += '<li class="active"><a data-page="' + p + '">' + p + '</a></li>';
            
        }
        
        // Set the next page
        var next = parseInt( Main.pagination.page );
        next++;
        
        // Verify if next page should be displayed
        if (next < Math.round(tot)) {
            
            $( id + ' .pagination' ).html( pages + '<li><a href="#" data-page="' + next + '">' + translation.mm129 + '</a></li>' );
            
        } else {
            
            $( id + ' .pagination' ).html( pages + '<li class="pagehide"><a href="#">' + translation.mm129 + '</a></li>' );
            
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
            
            // Set the timeout for 15 seconds
            timeout: 15000,
            
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
     * Calculate time between two dates
     */
    Main.calculate_time = function( from, to ) {
        'use strict';

        // Set calculation time
        var calculate = to - from;

        // Set after variable
        var after = '<i class="far fa-calendar-check"></i> ';

        // Set before variable 
        var before = ' ' + translation.mm104;

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

            return after + translation.mm105;

        } else if ( calculate < 3600 ) {

            calc = calculate / 60;
            calc = Math.round(calc);
            return after + calc + ' ' + translation.mm106 + before;

        } else if ( calculate < 86400 ) {

            calc = calculate / 3600;
            calc = Math.round(calc);
            return after + calc + ' ' + translation.mm107 + before;

        } else if ( calculate >= 86400 ) {

            calc = calculate / 86400;
            calc = Math.round(calc);
            return after + calc + ' '+ translation.mm103 + before;

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
     * Display alert
     */
    Main.add_value_to_option = function( option, value ) {
    
        // Submit data via ajax
        $.ajax({
            url: url + 'admin/option/' + option + '/' + value,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                if (data !== 1) {
                    $('.alert-msg').show();
                    $('.alert-msg').html(data);
                    $('.merror').fadeIn(1000).delay(2000).fadeOut(1000, function () {
                        $('.merror').remove();
                        $('.alert-msg').hide();
                    });
                }
            },
            error: function (data, jqXHR, textStatus) {
                console.log('Request failed:' + textStatus);
            }
        });

    };
    
});