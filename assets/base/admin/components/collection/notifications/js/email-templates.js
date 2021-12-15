/*
 * Email Templates JavaScript file
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
     * Load email templates by page
     * 
     * @param integer page contains the page number
     * @param integer progress contains the progress option
     * 
     * @since   0.0.8.3
     */    
    Main.email_templates_load_all =  function (page, progress) {

        // Prepare data to send
        var data = {
            action: 'email_templates_load_all',
            key: $('.notifications-page .theme-search-for-emails').val(),
            page: page
            
        };
        
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');

        // Verify if progress exists
        if ( typeof progress !== 'undefined' ) {

            // Make ajax call
            Main.ajax_call(url + 'admin/ajax/notifications', 'POST', data, 'email_templates_display_all', 'ajax_onprogress');

            // Set progress bar
            Main.set_progress_bar();

        } else {

            // Make ajax call
            Main.ajax_call(url + 'admin/ajax/notifications', 'POST', data, 'email_templates_display_all');

        }
        
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

        // Verify if is the page with email templates
        if ( $('.notifications-page .theme-list').length > 0 ) {

            // Load all email's templates by page
            Main.email_templates_load_all(1);

        } else if ( ( $('.notifications-page .notifications-email-template').length > 0 ) || ( $('.notifications-page .notifications-new-email-template').length > 0 ) ) {

            // Get langs
            var langs = $(document).find('.tab-content .tab-pane');

            // List langs
            for (var e = 0; e < langs.length; e++) {

                // Display editor
                $('.' + $(langs[e]).find('.summernote-body').attr('data-dir')).summernote('code', $(langs[e]).find('.article-body').val());

            }

        }

    });

    /*
     * Search for emails
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.5
     */
    $(document).on('keyup', '.notifications-page .theme-search-for-emails', function (e) {
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

                // Load all email's templates by page
                Main.email_templates_load_all(1, 1);

            }, 1000);

        } else {

            // Set opacity
            $this.closest('div').find('a').removeAttr('style');

            // Load all email's templates by page
            Main.email_templates_load_all(1, 1);
            
        }

    });

    /*
     * Detect when a template is selected
     * 
     * @since   0.0.8.3
     */
    $(document).on('change', '.notifications-page .notifications-email-template-select', function () {
        
        // Prepare data to send
        var data = {
            action: 'get_email_template_placeholder',
            template_slug: $(this).val()
        };
        
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/notifications', 'POST', data, 'display_email_template_placeholder');
        
    });

    /*
     * Cancel the search for email templates
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.5
     */ 
    $( document ).on( 'click', '.notifications-page .theme-cancel-search', function (e) {
        e.preventDefault();

        // Empty search input
        $('.notifications-page .theme-search-for-emails').val('');

        // Set opacity
        $(this).closest('div').find('a').removeAttr('style');

        // Load all email's templates by page
        Main.email_templates_load_all(1, 1);   
        
    });

    /*
     * Detects pagination click
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.3
     */    
    $( document ).on( 'click', 'body .theme-pagination li a', function (e) {
        e.preventDefault();
        
        // Get the page number
        var page = $(this).attr('data-page');

        // Display results
        switch ($(this).closest('ul').attr('data-type')) {

            case 'templates':

                // Load all email's templates by page
                Main.email_templates_load_all(page, 1);             

                break;

        }
        
    });

    $(".note-editor .dropdown-toggle").on("click", (e) => {
        if ($(e.currentTarget).attr("aria-expanded")) {
            $(e.currentTarget).dropdown("toggle")
        }
})
   
    /*******************************
    RESPONSES
    ********************************/ 

    /*
     * Display email templates
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.3
     */
    Main.methods.email_templates_display_all = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();

        // Hide pagination
        $('.notifications-page .theme-list > .card-footer').hide(); 

        // Verify if the success response exists
        if ( status === 'success' ) {

            // All templates
            var all_templates = '';
            
            // List all templates
            for ( var t = 0; t < data.templates.length; t++ ) {

                // Set template
                all_templates += '<div class="card theme-box-1 card-email" data-template="' + data.templates[t].template_id + '">'
                    + '<div class="card-header">'
                        + '<div class="row">'
                            + '<div class="col-6">'
                                + '<div class="media d-flex justify-content-start">'
                                    + '<span class="mr-3 theme-list-item-icon">'
                                        + words.icon_mail_template
                                    + '</span>'
                                    + '<div class="media-body">'
                                        + '<h5>'
                                            + '<a href="' + url + 'admin/notifications?p=email_templates&template=' + data.templates[t].template_id + '">'
                                                + data.templates[t].template_title
                                            + '</a>'
                                        + '</h5>'
                                    + '</div>'
                                + '</div>'
                            + '</div>'
                            + '<div class="col-6 text-end">'
                                + '<h6>'
                                    + data.templates[t].template
                                + '</h6>'                                
                            + '</div>'
                        + '</div>'
                    + '</div>'
                + '</div>';

            }

            // Display templates
            $('.notifications-page .theme-list > .card-body').html(all_templates);   
            
            // Set limit
            let limit = ((data.page * 10) < data.total)?(data.page * 10):data.total;

            // Set text
            $('.notifications-page .theme-list > .card-footer h6').html((((data.page - 1) * 10) + 1) + '-' + limit + ' ' + data.words.of + ' ' + data.total + ' ' + data.words.results);

            // Set page
            Main.pagination.page = data.page;

            // Display the pagination
            Main.show_pagination('.notifications-page .theme-list', data.total);

            // Show pagination
            $('.notifications-page .theme-list > .card-footer').show();           
            
        } else {
            
            // Set no data found message
            var no_data = '<p class="theme-box-1 theme-list-no-results-found">'
                                + data.message
                            + '</p>';

            // Display the no data found message
            $('.notifications-page .theme-list > .card-body').html(no_data);   
            
        }

    }

     /*
     * Display template's placeholders
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.3
     */
    Main.methods.display_email_template_placeholder = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Placeholders container
            var placeholders = '';

            // List all placeholders
            for ( var p = 0; p < data.placeholders.length; p++ ) {

                // Set placeholder
                placeholders += '<li>'
                    + '<p>'
                        + '<span class="notifications-emails-template-placeholder">'
                            + data.placeholders[p].code
                        + '</span>'
                        + data.placeholders[p].description
                    + '</p>'
                + '</li>';

            }

            // Display the placeholders
            $('.notifications-page .notifications-emails-template-placeholders').html(placeholders);
            
        } else {
            
            // Set no placeholders found message
            var no_placeholders = '<li class="default-card-box-no-items-found">'
                + data.message
            + '</li>';

            // Display the no placeholders found message
            $('.notifications-page .notifications-emails-template-placeholders').html(no_placeholders);

        }

    };  

    /*
     * Display the template creation response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.3
     */
    Main.methods.create_email_template = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);

            // Get selected template
            var template_slug = $('.notifications-page .notifications-create-email-template .notifications-email-template-select').val();

            // Verify if template's slug exists
            if ( template_slug ) {

                // Remove select's option
                $('.notifications-page .notifications-email-template-select option[value="' + template_slug + '"]').remove()

            }

            // Reset the form
            $('.notifications-page .notifications-create-email-template')[0].reset();

            // Get langs
            var langs = $(document).find('.tab-content .tab-pane');

            // List langs
            for (var e = 0; e < langs.length; e++) {

                // Display editor
                $('.' + $(langs[e]).find('.summernote-body').attr('data-dir')).summernote('reset');

            } 
            
            // Set no placeholders found message
            var no_placeholders = '<li>'
                + '<p>'
                    + data.words.no_placeholders_found
                + '</p>'
            + '</li>';

            // Display the no placeholders found message
            $('.notifications-page .notifications-emails-template-placeholders').html(no_placeholders);            
            
        } else {
            
            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);
            
        }

    };

    /*
     * Display the template update response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.3
     */
    Main.methods.update_email_template = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);         
            
        } else {
            
            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);
            
        }

    };

    /*******************************
    FORMS
    ********************************/

    /*
     * Create an email template
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.3
     */
    $('.notifications-page .notifications-create-email-template').submit(function (e) {
        e.preventDefault();

        // Prepare data to send
        var data = {
            action: 'create_email_template',
            template: $('.notifications-page .notifications-create-email-template .notifications-email-template-select').val()
        };
        
        // Get all editors
        var editors = $('.notifications-page .tab-all-editors > .tab-pane');
        
        // List all editors
        for ( var d = 0; d < editors.length; d++ ) {
            
            // Set editor's data
            data[$(editors[d]).attr('id')] = {
                'title': $(editors[d]).find('.article-title').val(),
                'body': $(editors[d]).find('.summernote-body').summernote('code')
            };
            
        }

		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/notifications', 'POST', data, 'create_email_template');

        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });

    /*
     * Update an email template
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.3
     */
    $('.notifications-page .notifications-update-email-template').submit(function (e) {
        e.preventDefault();

        // Prepare data to send
        var data = {
            action: 'update_email_template',
            template_id: $(this).attr('data-template'),
            template: $('.notifications-page .notifications-update-email-template .notifications-email-template-select').val()
        };
        
        // Get all editors
        var editors = $('.notifications-page .tab-all-editors > .tab-pane');
        
        // List all editors
        for ( var d = 0; d < editors.length; d++ ) {
            
            // Set editor's data
            data[$(editors[d]).attr('id')] = {
                'title': $(editors[d]).find('.article-title').val(),
                'body': $(editors[d]).find('.summernote-body').summernote('code')
            };
            
        }

		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/notifications', 'POST', data, 'update_email_template');

        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });
 
});