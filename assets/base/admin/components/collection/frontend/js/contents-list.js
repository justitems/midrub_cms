/*
 * Contents list javascript file
*/

jQuery(document).ready( function ($) {
    'use strict';
    
    /*
     * Get the website's url
     */
    var url = $('meta[name=url]').attr('content');
    
    /*******************************
    METHODS
    ********************************/
   
    /*
     * Load contents by category
     * 
     * @param integer page contains the page number
     * @param integer progress contains the progress option
     * 
     * @since   0.0.7.8
     */    
    Main.frontend_get_contents_by_category =  function (page, progress) {

        // Prepare params
        var data = {
            action: 'frontend_get_contents_by_category',
            contents_category: $('.frontend-page').attr('data-order'),
            key: $('.frontend-page .theme-search-for-contents').val(),
            page: page
        };
        
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');

        // Verify if progress exists
        if ( typeof progress !== 'undefined' ) {

            // Make ajax call
            Main.ajax_call(url + 'admin/ajax/frontend', 'POST', data, 'frontend_display_contents_by_category_response', 'ajax_onprogress');

            // Set progress bar
            Main.set_progress_bar();

        } else {

            // Make ajax call
            Main.ajax_call(url + 'admin/ajax/frontend', 'POST', data, 'frontend_display_contents_by_category_response');

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

		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/frontend', 'POST', data, 'load_theme_templates', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();        
        
    };

    /*******************************
    ACTIONS
    ********************************/

    /*
    * Load default content
    *
    * @since   0.0.8.5
    */
    $(function () {

        // Load all contents by category
        Main.frontend_get_contents_by_category(1);

    });

    /*
     * Detect modal open
     * 
     * @since   0.0.7.8
     */   
    $( '#theme-templates-selector' ).on('shown.bs.modal', function () {
        
        // Empty theme's templates list
        $('#theme-templates-selector #contents-option-field-theme-template').empty();

        // Load theme's templates
        Main.load_theme_templates();
        
    });

    /*
     * Search for contents
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.5
     */
    $(document).on('keyup', '.frontend-page .theme-search-for-contents', function (e) {
        e.preventDefault();

        // Set this
        let $this = $(this);

        // Verify if input has a value
        if ( $(this).val() !== '' ) {

            // Verify if an event was already scheduled
            if ( typeof Main.queue !== 'undefined' ) {

                // Clear previous timout
                clearTimeout(Main.queue);

            }
            
            // Verify if loader icon has style
            if ( !$this.closest('div').find('.theme-list-loader-icon').attr('style') ) {

                // Set opacity
                $this.closest('div').find('.theme-list-loader-icon').fadeTo( 'slow', 1.0);

            }

            Main.schedule_event(function() {

                // Set opacity
                $this.closest('div').find('.theme-list-loader-icon').removeAttr('style');         

                // Set opacity
                $this.closest('div').find('a').fadeTo( 'slow', 1.0);

                // Load all contents by category
                Main.frontend_get_contents_by_category(1, 1);

            }, 1000);

        } else {

            // Set opacity
            $this.closest('div').find('a').removeAttr('style');

            // Load all contents by category
            Main.frontend_get_contents_by_category(1, 1);
            
        }

    });

    /*
     * Cancel the search for contents
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.5
     */ 
    $( document ).on( 'click', '.frontend-page .theme-cancel-search', function (e) {
        e.preventDefault();

        // Empty search input
        $('.frontend-page .theme-search-for-contents').val('');

        // Set opacity
        $(this).closest('div').find('a').removeAttr('style');

        // Load all contents by category
        Main.frontend_get_contents_by_category(1, 1);
        
    });

   
    /*
     * Delete content by id
     * 
     * @since   0.0.7.8
     */
    $(document).on('click', '.frontend-page .theme-list .frontend-delete-content', function (e) {
        e.preventDefault();
        
        // Get content's id
        var content = $(this).closest('.card-content').attr('data-content');

        // Prepare data
        var data = {
            action: 'frontend_delete_content',
            content: content
        };
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/frontend', 'GET', data, 'frontend_delete_content_response', 'ajax_onprogress');

        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });

    /*
     * Detect pagination click
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.5
     */
    $(document).on('click', 'body .theme-pagination li a', function (e) {
        e.preventDefault();

        // Verify which pagination it is based on data's type 
        var page = $(this).attr('data-page');

        // Display results
        switch ($(this).closest('ul').attr('data-type')) {

            case 'contents':

                // Load clients by page
                Main.frontend_get_contents_by_category(page, 1);

                break;

        }

    });

    /*
     * Detect checkbox check
     * 
     * @since   0.0.8.5
     */ 
    $( document ).on( 'click', '.frontend-page .theme-list > .card-body input[type="checkbox"]', function () {

        // Show the action
        if ( $('.frontend-page .theme-list > .card-body :checkbox:checked').length > 0 ) {

            // Show actions
            $('.frontend-page .card-actions').slideDown('slow');

            // Set selected items
            $('.frontend-page .theme-list .theme-list-selected-items p').html($('.frontend-page .theme-list > .card-body :checkbox:checked').length + ' ' + words.selected_items);

        } else {

            // Hide actions
            $('.frontend-page .card-actions').slideUp('slow');
            
        }
        
    });

    /*
     * Delete contents
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.8
     */ 
    $( document ).on( 'click', '.frontend-page .frontend-delete-contents', function (e) {
        e.preventDefault();
    
        // Define the contents ids variable
        var contents_ids = [];
        
        // Get selected contents ids
        $('.frontend-page .theme-list > .card-body input[type="checkbox"]:checkbox:checked').each(function () {
            contents_ids.push($(this).closest('.card-content').attr('data-content'));
        });

        // Create an object with form data
        var data = {
            action: 'frontend_delete_contents',
            contents_ids: contents_ids
        };
        
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/frontend', 'POST', data, 'frontend_delete_content_response', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
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
    Main.methods.frontend_display_contents_by_category_response = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();

        // Hide pagination
        $('.frontend-page .theme-list > .card-footer').hide(); 

        // Hide actions
        $('.frontend-page .card-actions').slideUp('slow');

        // Verify if the success response exists
        if ( status === 'success' ) {

            // All contents
            var all_contents = '';
            
            // List all contents
            for ( var c = 0; c < data.contents.length; c++ ) {

                // Default status
                var status = '<span class="badge bg-light theme-badge-1">'
                                + data.words.draft
                            + '</span>';

                // Verify if content is published
                if ( data.contents[c].status > 0 ) {

                status = '<span class="badge bg-primary theme-badge-1">'
                                + data.words.published
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
                all_contents += '<div class="card theme-box-1 card-content" data-content="' + data.contents[c].content_id + '">'
                    + '<div class="card-header">'
                        + '<div class="row">'
                            + '<div class="col-lg-10 col-md-8 col-xs-8">'
                                + '<div class="media d-flex justify-content-start">'
                                    + '<div class="theme-checkbox-input-1">'
                                        + '<label for="frontend-contents-single-' + data.contents[c].content_id + '">'
                                            + '<input type="checkbox" id="frontend-contents-single-' + data.contents[c].content_id + '" data-content="' + data.contents[c].content_id + '">'
                                            + '<span class="theme-checkbox-checkmark"></span>'
                                        + '</label>'
                                    + '</div>'
                                    + '<div class="media-body">'
                                        + '<h5>'
                                            + '<a href="' + url + 'admin/frontend?p=editor&category=' + data.contents[c].contents_category + '&content_id=' + data.contents[c].content_id + url_params + '">'
                                                + data.contents[c].content_title
                                            + '</a>'
                                        + '</h5>'
                                    + '</div>'
                                + '</div>'
                            + '</div>'
                            + '<div class="col-lg-1 col-md-2 col-xs-2">'
                                + status
                            + '</div>'
                            + '<div class="col-lg-1 col-md-2 col-xs-2 text-end">'
                                + '<div class="btn-group theme-dropdown-2">'
                                    + '<button type="button" class="btn dropdown-toggle text-end" aria-haspopup="true" aria-expanded="false" data-bs-toggle="dropdown">'
                                        + words.icon_more
                                    + '</button>'
                                    + '<ul class="dropdown-menu">'
                                        + '<li>'
                                            + '<a href="#" class="frontend-delete-content">'
                                                + words.icon_delete
                                                + data.words.delete
                                            + '</a>'
                                        + '</li>'
                                    + '</ul>'
                                + '</div>'
                            + '</div>'
                        + '</div>'
                    + '</div>'
                + '</div>';

            }

            // Display templates
            $('.frontend-page .theme-list > .card-body').html(all_contents);   
            
            // Set limit
            let limit = ((data.page * 10) < data.total)?(data.page * 10):data.total;

            // Set text
            $('.frontend-page .theme-list > .card-footer h6').html((((data.page - 1) * 10) + 1) + '-' + limit + ' ' + data.words.of + ' ' + data.total + ' ' + data.words.results);

            // Set page
            Main.pagination.page = data.page;

            // Display the pagination
            Main.show_pagination('.frontend-page .theme-list', data.total);

            // Show pagination
            $('.frontend-page .theme-list > .card-footer').show();   
            
        } else {

            // Set no data found message
            var no_data = '<p class="theme-box-1 theme-list-no-results-found">'
                                + data.message
                            + '</p>';

            // Display the no data found message
            $('.frontend-page .theme-list > .card-body').html(no_data);  
            
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
    Main.methods.frontend_delete_content_response = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);
            
            // Load all contents by category
            Main.frontend_get_contents_by_category(1);
            
        } else {
            
            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);
            
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

        // Remove progress bar
        Main.remove_progress_bar();

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
 
});