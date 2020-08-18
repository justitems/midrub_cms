/*
 * Contents list javascript file
*/

jQuery(document).ready( function ($) {
    'use strict';
    
    // Get home page url
    var url = $('.navbar-brand').attr('href');
    
    /*******************************
    METHODS
    ********************************/
   
    /*
     * Load contents by category
     * 
     * @param integer page contains the page number
     * 
     * @since   0.0.7.8
     */    
    Main.frontend_load_contents_by_category =  function (page) {

        var data = {
            action: 'load_contents_by_category',
            page: page,
            contents_category: $('.frontend-page').attr('data-order'),
            key: $('.frontend-page .search-contents').val()
        };
        
        // Set the CSRF field
        data[$('.frontend-page .csrf-sanitize').attr('name')] = $('.frontend-page .csrf-sanitize').val();
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/frontend', 'POST', data, 'load_contents_by_category');
        
    };

    /*
     * Display contents pagination
     */
    Main.show_contents_pagination = function( id, total ) {
        
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
        var tot = parseInt(total) / 20;
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
     * Load theme's templates
     * 
     * @since   0.0.7.8
     */    
    Main.load_theme_templates =  function () {

        // Prepare data
        var data = {
            action: 'load_theme_templates',
            contents_category: $('.frontend-page').attr('data-order')
        };

        // Set the CSRF field
        data[$('.frontend-page .csrf-sanitize').attr('name')] = $('.frontend-page .csrf-sanitize').val();
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/frontend', 'POST', data, 'load_theme_templates');
        
    };

    /*******************************
    ACTIONS
    ********************************/

    /*
     * Detect modal open
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.8
     */   
    $( '#theme-templates-selector' ).on('shown.bs.modal', function (e) {
        
        // Empty theme's templates list
        $('#theme-templates-selector #contents-option-field-theme-template').empty();

        // Load theme's templates
        Main.load_theme_templates();
        
    });

    /*
     * Search contents by category
     * 
     * @since   0.0.7.8
     */
    $(document).on('keyup', '.frontend-page .search-contents', function () {
        
        // Load all contents by category
        Main.frontend_load_contents_by_category(1);
        
    });
   
    /*
     * Delete content by id
     * 
     * @since   0.0.7.8
     */
    $(document).on('click', '.frontend-page .list-contents .delete-content', function (e) {
        e.preventDefault();
        
        // Get content's id
        var content_id = $(this).closest('.contents-single').attr('data-id');

        var data = {
            action: 'delete_content',
            content_id: content_id
        };
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/frontend', 'GET', data, 'delete_content_response');

        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });

    /*
     * Displays pagination by page click
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.8
     */    
    $( document ).on( 'click', 'body .pagination li a', function (e) {
        e.preventDefault();
        
        // Get the page number
        var page = $(this).attr('data-page');

        // Load all contents by category
        Main.frontend_load_contents_by_category(page);
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });

    /*
     * Detect all contents selection
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.8
     */ 
    $( document ).on( 'click', '.frontend-page #frontent-contents-select-all', function (e) {
        
        setTimeout(function(){
            
            if ( $( '.frontend-page #frontent-contents-select-all' ).is(':checked') ) {

                $( '.frontend-page .list-contents li input[type="checkbox"]' ).prop('checked', true);

            } else {

                $( '.frontend-page .list-contents li input[type="checkbox"]' ).prop('checked', false);

            }
        
        },500);
        
    });

    /*
     * Delete contents
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.8
     */ 
    $( document ).on( 'click', '.frontend-page .delete-contents', function (e) {
        e.preventDefault();
    
        // Define the contents ids variable
        var contents_ids = [];
        
        // Get selected contents ids
        $('.frontend-page .list-contents li input[type="checkbox"]:checkbox:checked').each(function () {
            contents_ids.push($(this).attr('data-id'));
        });

        // Create an object with form data
        var data = {
            action: 'delete_contents',
            contents_ids: contents_ids
        };
        
        // Set the CSRF field
        data[$('.frontend-page .csrf-sanitize').attr('name')] = $('.frontend-page .csrf-sanitize').val();
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/frontend', 'POST', data, 'delete_content_response');

        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });
   
    /*******************************
    RESPONSES
    ********************************/ 
   
    /*
     * Display contents
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.8
     */
    Main.methods.load_contents_by_category = function ( status, data ) {

        // Uncheck all selection contents
        $( '.frontend-page #frontent-contents-select-all' ).prop('checked', false)

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Generate pagination
            Main.pagination.page = data.page;
            Main.show_contents_pagination('.frontend-page', data.total);

            // All contents
            var all_contents = '';
            
            // List all contents
            for ( var c = 0; c < data.contents.length; c++ ) {

                // Default status
                var status = '<span class="label label-default">'
                                + data.words.draft
                            + '</span>';

                // Verify if content is published
                if ( data.contents[c].status > 0 ) {

                status = '<span class="label label-primary">'
                                + data.words.publish
                            + '</span>';         

                }

                // Additional parameters
                var url_params = '';

                // Verify content has a component
                if ( data.contents[c].contents_component ) {
                    url_params = '&component=' + data.contents[c].contents_component;
                } else if ( data.contents[c].contents_template ) {
                    url_params = '&template=' + data.contents[c].contents_template;
                }

                // Set content
                all_contents += '<li class="contents-single" data-id="' + data.contents[c].content_id + '">'
                    + '<div class="row">'
                        + '<div class="col-lg-10 col-md-8 col-xs-8">'
                            + '<div class="checkbox-option-select">'
                                + '<input id="frontent-contents-single-' + data.contents[c].content_id + '" name="frontent-contents-single-' + data.contents[c].content_id + '" data-id="' + data.contents[c].content_id + '" type="checkbox">'
                                + '<label for="frontent-contents-single-' + data.contents[c].content_id + '"></label>'
                            + '</div>'
                            + '<a href="' + url + 'admin/frontend?p=editor&category=' + data.contents[c].contents_category + '&content_id=' + data.contents[c].content_id + url_params + '">'
                                + data.contents[c].meta_value
                            + '</a>'
                        + '</div>'
                        + '<div class="col-lg-1 col-md-2 col-xs-2">'
                            + status
                        + '</div>'
                        + '<div class="col-lg-1 col-md-2 col-xs-2 text-right">'
                            + '<div class="btn-group">'
                                + '<button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                                    + '<i class="icon-options-vertical"></i>'
                                + '</button>'
                                + '<ul class="dropdown-menu">'
                                    + '<li>'
                                        + '<a href="#" class="delete-content">'
                                            + '<i class="icon-trash"></i>'
                                            + data.words.delete
                                        + '</a>'
                                    + '</li>'
                                + '</ul>'
                            + '</div>'
                        + '</div>'
                    + '</div>'
                + '</li>';

            }

            // Get the page
            var page = ( (data.page - 1) < 1)?1:((data.page - 1) * 20);

            // Get results to
            var to = ((parseInt(page) * 20) < data.total)?(parseInt(data.page) * 20):data.total;

            // Display contents
            $('.frontend-page .list-contents').html(all_contents);

            // Display start listing
            $('.frontend-page .pagination-from').text(page);  
            
            // Display end listing
            $('.frontend-page .pagination-to').text(to);  

            // Display total items
            $('.frontend-page .pagination-total').text(data.total);

            // Show Pagination
            $('.frontend-page .pagination-area').show();  
            
        } else {

            // Hide Pagination
            $('.frontend-page .pagination-area').hide();  
            
            // Set no data found message
            var no_data = '<li>'
                                + data.message
                            + '</li>';

            // Display contents
            $('.frontend-page .list-contents').html(no_data);   
            
        }

    };
 
    /*
     * Display content deletion response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.8
     */
    Main.methods.delete_content_response = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
            // Load all contents by category
            Main.frontend_load_contents_by_category(1);
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }

    };

    /*
     * Display theme's templates
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.8
     */
    Main.methods.load_theme_templates = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Templates list
            var templates = '';

            // List al templates
            for ( var d = 0; d < data.templates.length; d++ ) {

                // Add template
                templates += '<option value="' + data.templates[d].slug + '">'
                                + data.templates[d].name
                            + '</option>';

            }

            // Display templates
            $('#theme-templates-selector #contents-option-field-theme-template').html(templates);
            
        }

    };
    
    /*******************************
    FORMS
    ********************************/
   
    /*
     * Create a new content
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.8
     */
    $('body .create-content').submit(function (e) {
        e.preventDefault();

        // Get action
        var action = $(this).attr('action');

        // Verify if is a page for auth components or for a theme
        if ( $(this).find('#contents-option-field-theme-template').length > 0 ) {

            // Get template
            var template = $(this).find('#contents-option-field-theme-template').val();

            // Redirect to editor
            document.location.href = action + '&template=' + template;            

        } else {

            // Get component 
            var component = $(this).find('#contents-option-field-auth_components').val();

            // Redirect to editor
            document.location.href = action + '&component=' + component;

        }

    });
    
    /*******************************
    DEPENDENCIES
    ********************************/

    // Load all contents by category
    Main.frontend_load_contents_by_category(1);
 
});