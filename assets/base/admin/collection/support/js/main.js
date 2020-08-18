/*
 * Main Faq javascript file
*/

jQuery(document).ready( function ($) {
    'use strict';
    
    // Get home page url
    var url = $('.navbar-brand').attr('href');
    
    /*******************************
    METHODS
    ********************************/
   
    /*
     * Load all faq articles
     * 
     * @param integer page contains the page number
     * 
     * @since   0.0.7.9
     */    
    Main.load_all_faq_articles =  function (page) {
        
        var data = {
            action: 'load_all_faq_articles',
            key: $('.support-page .search-articles').val(),
            page: page
        };
        
        // Set the CSRF field
        data[$('.support-page .csrf-sanitize').attr('name')] = $('.support-page .csrf-sanitize').val();
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/support', 'POST', data, 'load_all_faq_articles');
        
    };

    /*
     * Load all faq categories
     * 
     * @since   0.0.7.9
     */    
    Main.load_all_faq_categories =  function () {
        
        var data = {
            action: 'load_all_faq_categories'
        };
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/support', 'GET', data, 'load_all_faq_categories');
        
    };

    /*
     * Refresh faq categories
     * 
     * @since   0.0.7.9
     */    
    Main.refresh_categories_list =  function () {
        
        var data = {
            action: 'refresh_categories_list'
        };
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/support', 'GET', data, 'refresh_categories_list');
        
    };

    /*
     * Load all parent faq categories
     * 
     * @since   0.0.7.9
     */    
    Main.load_all_parent_faq_categories =  function () {
        
        var data = {
            action: 'load_all_parent_faq_categories'
        };
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/support', 'GET', data, 'load_all_parent_faq_categories');
        
    };

    /*
     * Display articles pagination
     */
    Main.show_articles_pagination = function( id, total ) {
        
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

    /*******************************
    ACTIONS
    ********************************/

    /*
     * Detect open categories popup
     * 
     * @since   0.0.7.9
     */    
    $(document).on('show.bs.modal', '#categories-popup-manager', function () {

        // Load all faq categories
        Main.load_all_faq_categories();

    });

    /*
     * Detect closed categories popup
     * 
     * @since   0.0.7.9
     */    
    $(document).on('hide.bs.modal', '#categories-popup-manager', function () {

        // Refresh faq categories
        Main.refresh_categories_list();

    });

    /*
     * Detect categories parents popup
     * 
     * @since   0.0.7.9
     */    
    $(document).on('show.bs.collapse', '#add-new-category', function () {

        // Load all parent faq categories
        Main.load_all_parent_faq_categories();

    });

    /*
     * Search articles
     * 
     * @since   0.0.7.9
     */
    $(document).on('keyup', '.support-page .search-articles', function () {
        
        // Load all faq articles
        Main.load_all_faq_articles(1);
        
    });
   
    /*
     * Detect category deletion
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.9
     */
    $(document).on('click', '#categories-popup-manager .delete-category-single', function (e) {
        e.preventDefault();
        
        var data = {
            action: 'delete_category',
            category_id: $(this).attr('data-id')
        };
        
        data[$('#categories-popup-manager .create-category').attr('data-csrf')] = $('input[name="' + $('#categories-popup-manager .create-category').attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/support', 'POST', data, 'delete_category');
        
    });
    
    /*
     * Detect all faq articles selection
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.9
     */ 
    $( document ).on( 'click', '.support-page #support-articles-select-all', function (e) {
        
        setTimeout(function(){
            
            if ( $( '.support-page #support-articles-select-all' ).is(':checked') ) {

                $( '.support-page .list-contents input[type="checkbox"]' ).prop('checked', true);

            } else {

                $( '.support-page .list-contents input[type="checkbox"]' ).prop('checked', false);

            }
        
        },500);
        
    });   
   
    /*
     * Delete faq article
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.9
     */ 
    $( document ).on( 'click', '.support-page .delete-faq-articles', function (e) {
        e.preventDefault();
        
        // Prepare data
        var data = {
            action: 'delete_faq_articles'
        };
        
        // Get all faq articles
        var faq_articles = $('.support-page .list-contents input[type="checkbox"]');
        
        var selected = [];
        
        // List all faq articles
        for ( var d = 0; d < faq_articles.length; d++ ) {

            if ( faq_articles[d].checked ) {
                selected.push($(faq_articles[d]).attr('data-id'));
            }
            
        }

        // Set selected articles
        data['articles'] = selected;
        
        // Set the CSRF field
        data[$('.support-page .csrf-sanitize').attr('name')] = $('.support-page .csrf-sanitize').val();

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/support', 'POST', data, 'delete_faq_articles');
        
    });
    
    /*
     * Delete faq article
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.9
     */ 
    $( document ).on( 'click', '.support-page .delete-faq-article', function (e) {
        e.preventDefault();
        
        // Prepare data
        var data = {
            action: 'delete_faq_articles'
        };
        
        // Get article's ID
        var article_id = $(this).closest('.article-single').attr('data-id');

        var selected = [];

        selected.push(article_id);

        // Set selected articles
        data['articles'] = selected;
        
        // Set the CSRF field
        data[$('.support-page .csrf-sanitize').attr('name')] = $('.support-page .csrf-sanitize').val();

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/support', 'POST', data, 'delete_faq_articles');
        
    });
    
    /*
     * Displays pagination by page click
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.9
     */    
    $( document ).on( 'click', 'body .pagination li a', function (e) {
        e.preventDefault();
        
        // Get the page number
        var page = $(this).attr('data-page');
        
        // Load all faq articles
        Main.load_all_faq_articles(page);
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });

    /*
     * Select parent
     * 
     * @since   0.0.7.9
     */
    $(document).on('click', '#categories-popup-manager .category-parents-list-ul li a', function (e) {
        e.preventDefault();

        // Get parent id
        var category_id = $(this).attr('data-id');

        // Get parent text
        var category_text = $(this).text();

        // Set parent id
        $(this).closest('.form-group').find('.btn-secondary').attr('data-id', category_id);

        // Set parent text
        $(this).closest('.form-group').find('.btn-secondary').text(category_text);

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

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
            // Reset Form
            $('#categories-popup-manager .create-category')[0].reset();
            
            // Remove parent attr
            $('#categories-popup-manager .category-select-parent').removeAttr('data-id');

            // Set parent text
            $('#categories-popup-manager .category-select-parent').text(data.select_category);

            // Load all categories
            Main.load_all_faq_categories();

            // Load all parent categories
            Main.load_all_parent_faq_categories();
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
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
        
        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
            // Load all categories
            Main.load_all_faq_categories();

            // Load all parent categories
            Main.load_all_parent_faq_categories();
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
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
        
        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
            // Add article's ID
            $('.create-new-faq-article').attr('data-id', data.article_id);
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
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

        // Uncheck all selection articles
        $( '.support-page #support-articles-select-all' ).prop('checked', false)

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Generate pagination
            Main.pagination.page = data.page;
            Main.show_articles_pagination('.support-page', data.total);

            // All articles
            var all_articles = '';
            
            // List all articles
            for ( var c = 0; c < data.articles.length; c++ ) {

                if ( data.articles[c].status < 1 ) {
                    
                    var status = '<span class="label label-primary">'
                                    + data.words.draft
                                + '</span>';
                    
                } else {
                    
                    var status = '<span class="label label-primary">'
                                    + data.words.published
                                + '</span>';                    
                    
                }

                // Set content
                all_articles += '<li class="article-single" data-id="' + data.articles[c].article_id + '">'
                    + '<div class="row">'
                        + '<div class="col-lg-10 col-md-8 col-xs-8">'
                            + '<div class="checkbox-option-select">'
                                + '<input id="frontent-article-single-' + data.articles[c].article_id + '" name="frontent-article-single-' + data.articles[c].article_id + '" data-id="' + data.articles[c].article_id + '" type="checkbox">'
                                + '<label for="frontent-article-single-' + data.articles[c].article_id + '"></label>'
                            + '</div>'
                            + '<a href="' + url + 'admin/support?p=faq&article=' + data.articles[c].article_id + '">'
                                + data.articles[c].title
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
                                        + '<a href="#" class="delete-faq-article">'
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
            $('.support-page .list-contents').html(all_articles);

            // Display start listing
            $('.support-page .pagination-from').text(page);  
            
            // Display end listing
            $('.support-page .pagination-to').text(to);  

            // Display total items
            $('.support-page .pagination-total').text(data.total);

            // Show Pagination
            $('.support-page .pagination-area').show();  
            
        } else {

            // Hide Pagination
            $('.support-page .pagination-area').hide();  
            
            // Set no data found message
            var no_data = '<li>'
                                + data.message
                            + '</li>';

            // Display contents
            $('.support-page .list-contents').html(no_data);   
            
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

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Display categories
            $('#categories-popup-manager .modal-body').html(data.categories);
            
        } else {
  
            // Set no data found message
            var no_data = '<p>'
                                + data.message
                            + '</p>';

            // Display no categories message
            $('#categories-popup-manager .modal-body').html(no_data);   
            
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

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Get all categories
            var categories = $('.categories-list .panel-body input[type="checkbox"]');

            // Categories array
            var cats = [];

            // List all categories
            for (var d = 0; d < categories.length; d++) {

                if (categories[d].checked) {
                    cats.push($(categories[d]).attr('data-id'));
                }

            }

            // Display the categories
            $('.categories-list .panel-body').html(data.categories);

            // Verify if categories were checked
            if ( cats.length > 0 ) {

                // List all selected categories
                for (var d = 0; d < cats.length; d++) {

                    // Verify if category still exists
                    if ( $('.categories-list .panel-body input[data-id="' + cats[d] + '"]').length > 0 ) {

                        // Check the category
                        $('.categories-list .panel-body input[data-id="' + cats[d] + '"]').prop('checked', true);

                    }

                }

            }
            
        } else {
  
            // Set no data found message
            var no_data = '<p>'
                                + data.message
                            + '</p>';

            // Display no categories message
            $('.categories-list .panel-body').html(no_data);   
            
        }

    };

    /*
     * Display all parents faq categories
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.9
     */
    Main.methods.load_all_parent_faq_categories = function ( status, data ) {

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
            $('#categories-popup-manager .category-parents-list-ul').html(categories);  
            
        } else {
  
            // Set no data found message
            var no_data = '<li>'
                                + data.message
                            + '</li>';

            // Display no categories message
            $('#categories-popup-manager .category-parents-list-ul').html(no_data);   
            
        }

    };
    
    /*
     * Display faq article deletion response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.9
     */
    Main.methods.delete_faq_articles = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
            // Uncheck all
            $( '.support-page input[type="checkbox"]' ).prop('checked', false);
            
            // Load all faq articles
            Main.load_all_faq_articles(1);
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
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
    $('#categories-popup-manager .create-category').submit(function (e) {
        e.preventDefault();

        // Prepare data to send
        var data = {
            action: 'create_category'
        };

        if ( $(this).find('.category-select-parent').attr('data-id') ) {
            data['parent'] = $(this).find('.category-select-parent').attr('data-id');
        }
        
        // Get all categories
        var categories = $('#categories-popup-manager .tab-all-categories .tab-pane');
        
        // List all categories
        for ( var d = 0; d < categories.length; d++ ) {
            data[$(categories[d]).attr('data-lang')] = $(categories[d]).find('.category-name').val();
        }
        
        data[$(this).attr('data-csrf')] = $('input[name="' + $(this).attr('data-csrf') + '"]').val();

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/support', 'POST', data, 'create_category');
        
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
        var categories = $('.categories-list .panel-body input[type="checkbox"]');
        
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
        
        // List all categories
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

        data[$(this).attr('data-csrf')] = $('input[name="' + $(this).attr('data-csrf') + '"]').val();

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/support', 'POST', data, 'create_new_faq_article');
        
    });
    
    /*******************************
    DEPENDENCIES
    ********************************/

    // Verify if is the page with articles
    if ( $('.support-page .search-articles').length > 0 ) {

        // Load all faq articles
        Main.load_all_faq_articles(1);

    } else if ( ( $('.support-page .single-faq-article').length > 0 ) || ( $('.support-page .new-faq-article').length > 0 ) ) {

        var langs = $(document).find('.tab-content .tab-pane');

        for (var e = 0; e < langs.length; e++) {

            $('.' + $(langs[e]).find('.summernote-body').attr('data-dir')).summernote('code', $(langs[e]).find('.article-body').val());

        }

    }

    // Hide loading animation
    $('.page-loading').fadeOut('slow');
 
});