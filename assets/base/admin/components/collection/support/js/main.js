/*
 * Main Faq javascript file
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
     * Load all faq articles
     * 
     * @param integer page contains the page number
     * @param integer progress contains the progress option
     * 
     * @since   0.0.7.9
     */    
    Main.load_all_faq_articles =  function (page, progress) {
        
        // Prepare data
        var data = {
            action: 'load_all_faq_articles',
            key: $('.support-page .support-search-for-articles').val(),
            page: page
        };
        
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');
        
        // Verify if progress exists
        if ( typeof progress !== 'undefined' ) {

            // Make ajax call
            Main.ajax_call(url + 'admin/ajax/support', 'POST', data, 'load_all_faq_articles', 'ajax_onprogress');

            // Set progress bar
            Main.set_progress_bar();

        } else {

            // Make ajax call
            Main.ajax_call(url + 'admin/ajax/support', 'POST', data, 'load_all_faq_articles');

        }
        
    };

    /*
     * Get categories parents
     * 
     * @since   0.0.8.5
     */    
    Main.support_get_categories_parents =  function () {
        
        // Prepare data
        var data = {
            action: 'support_get_categories_parents',
            key: $('#support-categories-popup-manager .support-search-for-categories-parents').val()
        };
        
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/support', 'POST', data, 'support_display_categories_parents_response', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
    };

    /*
     * Load all faq categories
     * 
     * @since   0.0.7.9
     */    
    Main.load_all_faq_categories = function () {
        
        // Prepare data
        var data = {
            action: 'load_all_faq_categories'
        };
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/support', 'GET', data, 'load_all_faq_categories', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
    };

    /*
     * Refresh faq categories
     * 
     * @since   0.0.7.9
     */    
    Main.refresh_categories_list = function () {
        
        // Prepare data
        var data = {
            action: 'refresh_categories_list'
        };
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/support', 'GET', data, 'refresh_categories_list', 'ajax_onprogress');

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

        // Verify if is the page with articles
        if ( $('.support-page .support-search-for-articles').length > 0 ) {

            // Load all faq articles
            Main.load_all_faq_articles(1);

        } else if ( ( $('.support-page .single-faq-article').length > 0 ) || ( $('.support-page .new-faq-article').length > 0 ) ) {

            var langs = $(document).find('.tab-content .tab-pane');

            for (var e = 0; e < langs.length; e++) {

                $('.' + $(langs[e]).find('.summernote-body').attr('data-dir')).summernote('code', $(langs[e]).find('.article-body').val());

            }

        }

    });

    /*
     * Detect open categories popup
     * 
     * @since   0.0.7.9
     */    
    $(document).on('show.bs.modal', '#support-categories-popup-manager', function () {

        // Load all faq categories
        Main.load_all_faq_categories();

    });

    /*
     * Detect closed categories popup
     * 
     * @since   0.0.7.9
     */    
    $(document).on('hide.bs.modal', '#support-categories-popup-manager', function () {

        // Refresh faq categories
        Main.refresh_categories_list();

    });

    /*
     * Search articles
     * 
     * @since   0.0.7.9
     */
    $(document).on('keyup', '.support-page .support-search-for-articles', function () {

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

                // Load all faq articles
                Main.load_all_faq_articles(1, 1);

            }, 1000);

        } else {

            // Set opacity
            $this.closest('div').find('a').removeAttr('style');

            // Load all faq articles
            Main.load_all_faq_articles(1, 1);
            
        }
        
    });

    /*
     * Search for categories parents
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.5
     */
    $(document).on('keyup', '#support-categories-popup-manager .support-search-for-categories-parents', function (e) {
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

            Main.schedule_event(function() {

                // Get categories parents
                Main.support_get_categories_parents();

            }, 1000);

        } else {

            // Get categories parents
            Main.support_get_categories_parents();

        }

    });

    /*
     * Load categories parents
     * 
     * @since   0.0.8.5
     */
    $(document).on('click', '#support-categories-popup-manager .support-category-select-parent', function (e) {
        e.preventDefault();

        // Empty search input
        $('#support-categories-popup-manager .support-search-for-categories-parents').val('');

        // Get categories parents
        Main.support_get_categories_parents();

    }); 

    /*
     * Cancel the search for articles
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.5
     */ 
    $( document ).on( 'click', '.support-page .theme-cancel-search', function (e) {
        e.preventDefault();

        // Empty search input
        $('.support-page .support-search-for-articles').val('');

        // Set opacity
        $(this).closest('div').find('a').removeAttr('style');

        // Load all faq articles
        Main.load_all_faq_articles(1, 1);
        
    });

    /*
     * Detect checkbox check
     * 
     * @since   0.0.8.5
     */ 
    $( document ).on( 'click', '.support-page .theme-list > .card-body input[type="checkbox"]', function () {

        // Show the action
        if ( $('.support-page .theme-list > .card-body :checkbox:checked').length > 0 ) {

            // Show actions
            $('.support-page .card-actions').slideDown('slow');

            // Set selected items
            $('.support-page .theme-list .theme-list-selected-items p').html($('.support-page .theme-list > .card-body :checkbox:checked').length + ' ' + words.selected_items);

        } else {

            // Hide actions
            $('.support-page .card-actions').slideUp('slow');
            
        }
        
    });
   
    /*
     * Detect category deletion
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.9
     */
    $(document).on('click', '#support-categories-popup-manager .support-delete-category', function (e) {
        e.preventDefault();
        
        // Prepare data to send
        var data = {
            action: 'delete_category',
            category_id: $(this).attr('data-id')
        };
        
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');   
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/support', 'POST', data, 'delete_category', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
    });   
   
    /*
     * Delete faq article
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.9
     */ 
    $( document ).on( 'click', '.support-page .support-delete-faq-articles', function (e) {
        e.preventDefault();
        
        // Prepare data
        var data = {
            action: 'delete_faq_articles'
        };
        
        // Get all faq articles
        var faq_articles = $('.support-page .theme-list > .card-body input[type="checkbox"]');
        
        var selected = [];
        
        // List all faq articles
        for ( var d = 0; d < faq_articles.length; d++ ) {

            if ( faq_articles[d].checked ) {
                selected.push($(faq_articles[d]).closest('.card-article').attr('data-article'));
            }
            
        }

        // Set selected articles
        data['articles'] = selected;
        
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');   

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/support', 'POST', data, 'support_delete_faq_articles_response', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
    });
    
    /*
     * Delete faq article
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.9
     */ 
    $( document ).on( 'click', '.support-page .support-delete-faq-article', function (e) {
        e.preventDefault();
        
        // Prepare data
        var data = {
            action: 'delete_faq_articles'
        };
        
        // Get article's ID
        var article_id = $(this).closest('.card-article').attr('data-article');

        var selected = [];

        selected.push(article_id);

        // Set selected articles
        data['articles'] = selected;
        
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/support', 'POST', data, 'delete_faq_articles', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
    });
    
    /*
     * Displays pagination by page click
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.9
     */    
    $( document ).on( 'click', 'body .theme-pagination li a', function (e) {
        e.preventDefault();
        
        // Get the page number
        var page = $(this).attr('data-page');
        
        // Load all faq articles
        Main.load_all_faq_articles(page, 1);
        
    });

    /*
     * Select parent
     * 
     * @since   0.0.7.9
     */
    $(document).on('click', '#support-categories-popup-manager .support-category-parents-list-ul li a', function (e) {
        e.preventDefault();

        // Get parent id
        var category_id = $(this).attr('data-id');

        // Get parent text
        var category_text = $(this).text();

        // Set parent id
        $(this).closest('.form-group').find('.support-category-select-parent').attr('data-id', category_id);

        // Set parent text
        $(this).closest('.form-group').find('.support-category-select-parent > span').text(category_text);

    }); 
   
    /*******************************
    RESPONSES
    ********************************/ 
   
    /*
     * Display category creation response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.9
     */
    Main.methods.create_category = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);
            
            // Reset Form
            $('#support-categories-popup-manager .create-category')[0].reset();
            
            // Remove parent attr
            $('#support-categories-popup-manager .support-category-select-parent').removeAttr('data-id');

            // Set parent text
            $('#support-categories-popup-manager .support-category-select-parent > span').text(data.select_category);

            // Load all categories
            Main.load_all_faq_categories();
            
        } else {
            
            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);
            
        }

    };
    
    /*
     * Display category deletion response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.9
     */
    Main.methods.delete_category = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();
        
        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);
            
            // Load all categories
            Main.load_all_faq_categories();

            // Remove parent attr
            $('#support-categories-popup-manager .support-category-select-parent').removeAttr('data-id');

            // Set parent text
            $('#support-categories-popup-manager .support-category-select-parent > span').text(words.select_a_parent);
            
        } else {
            
            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);
            
        }

    };
    
    /*
     * Display article creation response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.9
     */
    Main.methods.create_new_faq_article = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();
        
        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);
            
            // Add article's ID
            $('.create-new-faq-article').attr('data-id', data.article_id);
            
        } else {
            
            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);
            
        }

    };   
    
    /*
     * Display all faq articles
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.9
     */
    Main.methods.load_all_faq_articles = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();

        // Hide pagination
        $('.support-page .theme-list > .card-footer').hide(); 

        // Hide actions
        $('.support-page .card-actions').slideUp('slow');

        // Verify if the success response exists
        if ( status === 'success' ) {

            // All articles
            var all_articles = '';
            
            // List all articles
            for ( var c = 0; c < data.articles.length; c++ ) {

                if ( data.articles[c].status < 1 ) {
                    
                    var status = '<span class="badge bg-light theme-badge-1">'
                                    + data.words.draft
                                + '</span>';
                    
                } else {
                    
                    var status = '<span class="badge bg-primary theme-badge-1">'
                                    + data.words.published
                                + '</span>';                    
                    
                }

                // Set article
                all_articles += '<div class="card theme-box-1 card-article" data-article="' + data.articles[c].article_id + '">'
                    + '<div class="card-header">'
                        + '<div class="row">'
                            + '<div class="col-lg-10 col-md-8 col-xs-8">'
                                + '<div class="media d-flex justify-content-start">'
                                    + '<div class="theme-checkbox-input-1">'
                                        + '<label for="support-single-' + data.articles[c].article_id + '">'
                                            + '<input type="checkbox" id="support-single-' + data.articles[c].article_id + '" data-article="' + data.articles[c].article_id + '">'
                                            + '<span class="theme-checkbox-checkmark"></span>'
                                        + '</label>'
                                    + '</div>'
                                    + '<div class="media-body">'
                                        + '<h5>'
                                            + '<a href="' + url + 'admin/support?p=faq&article=' + data.articles[c].article_id + '">'
                                                + data.articles[c].title
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
                                            + '<a href="#" class="support-delete-faq-article">'
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
            $('.support-page .theme-list > .card-body').html(all_articles);   
            
            // Set limit
            let limit = ((data.page * 10) < data.total)?(data.page * 10):data.total;

            // Set text
            $('.support-page .theme-list > .card-footer h6').html((((data.page - 1) * 10) + 1) + '-' + limit + ' ' + data.words.of + ' ' + data.total + ' ' + data.words.results);

            // Set page
            Main.pagination.page = data.page;

            // Display the pagination
            Main.show_pagination('.support-page .theme-list', data.total);

            // Show pagination
            $('.support-page .theme-list > .card-footer').show();  
            
        } else {

            // Set no data found message
            var no_data = '<p class="theme-box-1 theme-list-no-results-found">'
                                + data.message
                            + '</p>';

            // Display the no data found message
            $('.support-page .theme-list > .card-body').html(no_data);   
            
        }

    };

    /*
     * Display all faq categories
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.9
     */
    Main.methods.load_all_faq_categories = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Display categories
            $('#support-categories-popup-manager .modal-body').html(data.categories);
            
        } else {
  
            // Set no data found message
            let no_data = '<ul>'
                + '<li class="support-no-results-found">'
                    + '<p>'
                        + data.message
                    + '</p>'
                + '</li>'
            + '</ul>';

            // Display no categories message
            $('#support-categories-popup-manager .modal-body').html(no_data);   
            
        }

    };

    /*
     * Display faq categories
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.9
     */
    Main.methods.refresh_categories_list = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Get all categories
            var categories = $('.categories-list .card-body input[type="checkbox"]');

            // Categories array
            var cats = [];

            // List all categories
            for (var d = 0; d < categories.length; d++) {

                if (categories[d].checked) {
                    cats.push($(categories[d]).attr('data-id'));
                }

            }

            // Display the categories
            $('.categories-list .card-body').html(data.categories);

            // Verify if categories were checked
            if ( cats.length > 0 ) {

                // List all selected categories
                for (var d = 0; d < cats.length; d++) {

                    // Verify if category still exists
                    if ( $('.categories-list .card-body input[data-id="' + cats[d] + '"]').length > 0 ) {

                        // Check the category
                        $('.categories-list .card-body input[data-id="' + cats[d] + '"]').prop('checked', true);

                    }

                }

            }
            
        } else {
  
            // Set no data found message
            var no_data = '<p>'
                                + data.message
                            + '</p>';

            // Display no categories message
            $('.categories-list .card-body').html(no_data);   
            
        }

    };

    /*
     * Display all parents faq categories
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.5
     */
    Main.methods.support_display_categories_parents_response = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();

        // Verify if the success response exists
        if ( status === 'success' ) {

            // All Parents Categories
            var categories = '';

            // List available categories
            for ( var c = 0; c < data.categories.length; c++ ) {

                categories += '<li class="list-group-item">'
                                + '<a href="#" data-id="' + data.categories[c].category_id + '">'
                                    + data.categories[c].name
                                + '</a>'
                            + '</li>';

            }

            // Display categories
            $('#support-categories-popup-manager .support-category-parents-list-ul').html(categories);  
            
        } else {
  
            // Set no data found message
            var no_data = '<li class="list-group-item">'
                                + '<p>'
                                    + data.message
                                + '</p>'
                            + '</li>';

            // Display no categories message
            $('#support-categories-popup-manager .support-category-parents-list-ul').html(no_data);   
            
        }

    };
    
    /*
     * Display faq articles deletion response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.9
     */
    Main.methods.support_delete_faq_articles_response = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);
            
            // Load all faq articles
            Main.load_all_faq_articles(1);
            
        } else {
            
            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);
            
        }

    };
    
    /*******************************
    FORMS
    ********************************/
   
    /*
     * Create a new category
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.9
     */
    $('#support-categories-popup-manager .create-category').submit(function (e) {
        e.preventDefault();

        // Prepare data to send
        var data = {
            action: 'create_category'
        };

        if ( $(this).find('.support-category-select-parent').attr('data-id') ) {
            data['parent'] = $(this).find('.support-category-select-parent').attr('data-id');
        }
        
        // Get all categories
        var categories = $('#support-categories-popup-manager .tab-all-categories .tab-pane');
        
        // List all categories
        for ( var d = 0; d < categories.length; d++ ) {
            data[$(categories[d]).attr('data-lang')] = $(categories[d]).find('.category-name').val();
        }
        
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');   

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/support', 'POST', data, 'create_category', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
    });
    
    /*
     * Create a faq article
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.9
     */
    $('.new-faq-article .create-new-faq-article').submit(function (e) {
        e.preventDefault();
        
        // Get all categories
        var categories = $('.categories-list .card-body input[type="checkbox"]');
        
        var cats = [];
        
        // List all categories
        for ( var d = 0; d < categories.length; d++ ) {

            if ( categories[d].checked ) {
                cats.push($(categories[d]).attr('data-id'));
            }
            
        }
        
        var data = {
            action: 'create_new_faq_article',
            cats: cats,
            status: $('.new-faq-article .article-status').val()
        };
        
        // Get all editors
        var editors = $('.new-faq-article .tab-all-editors > .tab-pane');
        
        // List all editors
        for ( var d = 0; d < editors.length; d++ ) {
            
            data[$(editors[d]).attr('id')] = {
                'title': $(editors[d]).find('.article-title').val(),
                'body': $(editors[d]).find('#summernote').summernote('code')
            };
            
        }

        // Verify if article should be updated
        if ( $(this).attr('data-id') ) {
            data['article_id'] = $(this).attr('data-id');
        }

		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');   

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/support', 'POST', data, 'create_new_faq_article', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
    });
 
});