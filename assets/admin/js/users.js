/*
 * Users javascript file
 * 
 * @author Scrisoft
*/

jQuery(document).ready(function () {
    'use strict';
    
    // Get main page URL
    var url = jQuery('.navbar-brand').attr('href');
    var users = {'page': 1,'limit': 10,'user_id': 0,'rsearch': ''};
    
    /*
     * Create new user
     * 
     * @since   0.0.0.1
     */
    jQuery('.new-user').submit(function () {
        
        var sendpass = 0;
        
        // Send password by email
        if (jQuery('.sendpass').is(':checked')) {
            sendpass = 1;
        }
        
        // Get the CSRF token
        var name = jQuery('input[name="csrf_test_name"]').val();
        
        // create an object with form data
        var data = {
            first_name: jQuery('.first_name').val(),
            last_name: jQuery('.last_name').val(),
            username: jQuery('.username').val(),
            password: jQuery('.password').val(),
            email: jQuery('.email').val(),
            role: jQuery('.role').val(),
            sendpass: sendpass,
            csrf_test_name: name
        };
        
        // submit data via ajax
        jQuery.ajax({
            url: url + 'admin/create-user',
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function (data) {
                jQuery('.alert-msg').show();
                jQuery('.alert-msg').html(data);
                jQuery('.merror').fadeIn(1000).delay(2000).fadeOut(1000, function () {
                    jQuery('.merror').remove();
                    jQuery('.alert-msg').hide();
                });
                jQuery('.msuccess').fadeIn(1000).delay(2000).fadeOut(1000, function () {
                    jQuery('.msuccess').remove();
                    jQuery('.alert-msg').hide();
                    document.getElementsByClassName('new-user')[0].reset();
                });
            },
            error: function (data, jqXHR, textStatus) {
                console.log('Request failed:' + textStatus);
            }
        });
        return false;
    });
    
    /*
     * Update user's data
     * 
     * @since   0.0.0.1
     */
    jQuery('.update-form').submit(function (e) {
        e.preventDefault();
        
        // Get CRSF token
        var name = jQuery('input[name="csrf_test_name"]').val();
        
        // create an object with form data
        var data = {
            user_id: users.user_id,
            first_name: jQuery('.first_name').val(),
            last_name: jQuery('.last_name').val(),
            password: jQuery('.dpassword').val(),
            email: jQuery('.demail').val(),
            proxy: jQuery('.dproxy').val(),
            status: jQuery('.dstatus').val(),
            role: jQuery('.drole').val(),
            plan: jQuery('.dplan').val(),
            csrf_test_name: name
        };
        
        // submit data via ajax
        jQuery.ajax({
            url: url + 'admin/update-user',
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function (data) {
                jQuery('.alert-msg').show();
                jQuery('.alert-msg').html(data);
                jQuery('.merror').fadeIn(1000).delay(2000).fadeOut(1000, function () {
                    jQuery('.merror').remove();
                    jQuery('.alert-msg').hide();
                });
                jQuery('.msuccess').fadeIn(1000).delay(2000).fadeOut(1000, function () {
                    jQuery('.msuccess').remove();
                    jQuery('.alert-msg').hide();
                });
            },
            error: function (data, jqXHR, textStatus) {
                console.log('Request failed: ' + textStatus);
            }
        });
    });
    
    /*
     * Detect page click on users pagination
     * 
     * @since   0.0.0.1
     */
    jQuery(document).on('click', '.users .fl .pagination li a', function (e) {
        e.preventDefault();
        
        // Get page number
        users.page = jQuery(this).attr('data-page');
        
        // Displat users
        results(jQuery(this).attr('data-page'));
        
    });
    
    /*
     * Detect page click on users content
     * 
     * @since   0.0.0.1
     */
    jQuery(document).on('click', '.users .msg-body .pagination li a', function (e) {
        e.preventDefault();
        
        // Get page number
        users.page = jQuery(this).attr('data-page');
        
        if ( jQuery(this).closest('.tab-pane').attr('id') === 'posts' ) {
            
            // Display posts
            get_user_posts(jQuery(this).attr('data-page'));
            
        } else if ( jQuery(this).closest('.tab-pane').attr('id') === 'rss-feeds' ) {
            
            // Displays user feeds
            get_user_feeds(jQuery(this).attr('data-page'));
            
        } else if ( jQuery(this).closest('.tab-pane').attr('id') === 'emails' ) {
            
            // Displays user email templates
            get_user_emails(jQuery(this).attr('data-page'));
            
        }
        
    });    
    
    /*
     * Detect user edit click
     * 
     * @since   0.0.0.1
     */
    jQuery(document).on('click', '.user-edit', function () {
        
        // Get user's ID
        var $this = jQuery(this);
        users.user_id = $this.attr('data-user');
        
        // Display user's settings
        user_edit();
        
    });
    
    /*
     * Parse user's statistics
     * 
     * @since   0.0.5.3
     */
    jQuery(document).on('click', '.user-statistics', function () {
        
        // Get user's ID
        var $this = jQuery(this);
        users.user_id = $this.attr('data-user');
        
        // Display activity area
        jQuery( '.user-activity' ).hide();
        jQuery( '.user-activity' ).fadeIn('slow');
        
        // This function displays user posts
        get_user_posts(1);
        
        // This function displays user feeds
        get_user_feeds(1);
        
        // This function displays user email templates
        get_user_emails(1);
        
    });
    
    /*
     * Detect user search
     * 
     * @since   0.0.1
     */
    jQuery('.search_user').keyup(function () {
        
        // this function searches users
        var key = jQuery('.search_user').val();
        
        // hide search icon
        jQuery('.fa-binoculars').hide();
        users.rsearch = key;
        
        // change search icon
        jQuery('.search-m').addClass('search-active');
        
        // Verify if admin is in the statistics page 
        if ( jQuery('.widget-box').length > 0 ) {
            
            var url_a = url + 'admin/search-users/1/' + users.rsearch;
            
        } else {
            
            var url_a = url + 'admin/search-users/0/' + users.rsearch;
            
        }
        
        // submit data via ajax
        jQuery.ajax({
            url: url_a,
            type: 'GET',
            dataType: 'json',
            success: function (data) {

                if ( data ) {
                    
                    // Generate the pagination
                    show_pagination(data.total, '.fl');
                    
                    var allusers = '';
                    for (var u = 0; u < data.users.length; u++) {
                        
                        // Get user's role
                        var role = (data.users[u].role == 0) ? 'User' : 'Administrator';
                        
                        // Get the edit button
                        var edit = '<button type="button" data-user="' + data.users[u].user_id + '" class="btn btn-edit pull-right user-edit"><i class="fas fa-pencil-alt"></i></button>';
                        
                        // Verify if admin is in the statistics page 
                        if ( jQuery('.widget-box').length > 0 ) {
                            
                            edit = '<button type="button" data-user="' + data.users[u].user_id + '" class="btn btn-edit pull-right user-statistics"><i class="fas fa-chart-line"></i></button>';
                            
                        }
                        
                        // Create a string with founded users
                        allusers += '<div class="col-lg-12"><img src="http://www.gravatar.com/avatar/' + data.users[u].md5 + '"><h4>' + data.users[u].username + '<small> ' + data.users[u].email + '</small><br><span>' + role + '</span></h4>' + edit + '</div>';
                    
                    }
                    
                    // Display the users
                    jQuery('.user-item').html(allusers);
                    
                } else {
                    
                    // If no users found, display a message
                    jQuery('.user-item').html('<div class="col-lg-12"><p class="nofound">'+translation.ma141+'</p></div>');
                    
                }
            },
            error: function (data, jqXHR, textStatus) {
                
                // Display the issue
                console.log('Request failed: ' + textStatus);
                
                // Empty the pagination links
                jQuery('.pagination').empty();
                
                // Hide the users found in the last search
                jQuery('.user-item').html('<div class="col-lg-12"><p class="nofound">'+translation.ma141+'</p></div>');
                
                // Display a message error
                jQuery('.merror').fadeIn(1000).delay(3000).fadeOut(1000, function () {
                    jQuery('.merror').remove();
                });
                
            }
        });
    });
    
    /*
     * Detect delete account click
     * 
     * @since   0.0.0.1
     */
    jQuery('.delete-account').click(function () {
        
        jQuery('.confirm').fadeIn('slow');
        
    });
    
    /*
     * Detect cancel deletion click
     * 
     * @since   0.0.0.1
     */
    jQuery(document).on('click', '.confirm .no', function (e) {
        e.preventDefault();
        
        // Hide the delete button
        jQuery('.confirm').fadeOut('slow');
        
    });
    
    /*
     * Detect delete confirmation click
     * 
     * @since   0.0.0.1
     */
    jQuery(document).on('click', '.confirm .yes', function (e) {
        e.preventDefault();
        
        // this function deletes users
        // submit data via ajax
        jQuery.ajax({
            url: url + 'admin/delete-user/' + users.user_id,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                
                if ( data.success ) {

                    // Display alert
                    Main.popup_fon('subi', data.message, 1500, 2000);
                    
                    // Reset form
                    resetall();

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
     * Cancel the search
     * 
     * @since   0.0.0.1
     */
    jQuery(document).on('click', '.search-active', function (e) {
        e.preventDefault();
        jQuery('.fa-binoculars').show();
        resetall();
    });
    
    /*
     * Display user's pagination
     * 
     * @since   0.0.0.1
     */
    function show_pagination( total, location ) {
        
        // Empty the pagination
        jQuery(location + ' .pagination').empty();
        
        // Verify if exists previous pages
        if (parseInt(users.page) > 1) {
            var bac = parseInt(users.page) - 1;
            var pages = '<li><a href="#" data-page="' + bac + '">' + translation.mm128 + '</a></li>';
        } else {
            var pages = '<li class="pagehide"><a href="#">' + translation.mm128 + '</a></li>';
        }
        
        // Verify how many pages exists
        var tot = parseInt(total) / parseInt(users.limit);
        tot = Math.ceil(tot) + 1;
        var from = (parseInt(users.page) > 2) ? parseInt(users.page) - 2 : 1;
        for (var p = from; p < parseInt(tot); p++) {
            if (p === parseInt(users.page)) {
                pages += '<li class="active"><a data-page="' + p + '">' + p + '</a></li>';
            } else if ((p < parseInt(users.page) + 3) && (p > parseInt(users.page) - 3)) {
                pages += '<li><a href="#" data-page="' + p + '">' + p + '</a></li>';
            } else if ((p < 6) && (Math.round(tot) > 5) && ((parseInt(users.page) == 1) || (parseInt(users.page) == 2))) {
                pages += '<li><a href="#" data-page="' + p + '">' + p + '</a></li>';
            } else {
                break;
            }
        }
        
        // Verify if exists more pages
        if (p === 1) {
            pages += '<li class="active"><a data-page="' + p + '">' + p + '</a></li>';
        }
        var next = parseInt(users.page);
        next++;
        
        // Display pagination
        if (next < Math.round(tot)) {
            jQuery(location + ' .pagination').html(pages + '<li><a href="#" data-page="' + next + '">' + translation.mm129 + '</a></li>');
        } else {
            jQuery(location + ' .pagination').html(pages + '<li class="pagehide"><a href="#">' + translation.mm129 + '</a></li>');
        }
    }

    /*
     * Display users
     * 
     * @since   0.0.0.1
     */
    function results(page) {
        
        // Verify if admin is in the statistics page 
        if ( jQuery('.widget-box').length > 0 ) {
            
            var url_a = url + 'admin/show-users/' + page + '/1/' + users.rsearch;
            
        } else {
            
            var url_a = url + 'admin/show-users/' + page + '/0/' + users.rsearch
            
        }
        
        // display users by page
        jQuery.ajax({
            url: url_a,
            dataType: 'json',
            type: 'GET',
            beforeSend: function () {
                if (jQuery(document).width() > 700)
                    jQuery( '.fl .pagination' ).closest( '.col-lg-12' ).find( '.pageload' ).show();
            },
            success: function (data) {
                
                if (data) {
                    
                    // Generate the pagination
                    show_pagination(data.total, '.fl');
                    
                    var allusers = '';
                    for (var u = 0; u < data.users.length; u++) {
                        
                        // Get user's role
                        var role = (data.users[u].role == 0) ? 'User' : 'Administrator';
                        
                        // Get the edit button
                        var edit = '<button type="button" data-user="' + data.users[u].user_id + '" class="btn btn-edit pull-right user-edit"><i class="fas fa-pencil-alt"></i></button>';
                        
                        // Verify if admin is in the statistics page 
                        if ( jQuery('.widget-box').length > 0 ) {
                            
                            edit = '<button type="button" data-user="' + data.users[u].user_id + '" class="btn btn-edit pull-right user-statistics"><i class="fas fa-chart-pie"></i></button>';
                            
                        }
                        
                        // Create a string with founded users
                        allusers += '<div class="col-lg-12"><img src="//www.gravatar.com/avatar/' + data.users[u].md5 + '"><h4>' + data.users[u].username + '<small> ' + data.users[u].email + '</small><br><span>' + role + '</span></h4>' + edit + '</div>';
                    }
                    
                    // Display the users
                    jQuery('.user-item').html(allusers);
                    
                }
                
            },
            error: function (data, jqXHR, textStatus) {
                
                // Display the issue
                console.log('Request failed: ' + textStatus);
                
                // Hide the users found in the last search
                jQuery('.user-item').html('<div class="col-lg-12"><p class="nofound">'+translation.ma141+'</p></div>');
                
                // Display a message error
                jQuery('.merror').fadeIn(1000).delay(3000).fadeOut(1000, function () {
                    jQuery('.merror').remove();
                });
                
            },
            complete: function () {
                jQuery( '.fl .pagination' ).closest( '.col-lg-12' ).find( '.pageload' ).fadeOut('slow');
            },
        });
    }
    
    /*
     * Verify if we are on the Users page
     * 
     * @since   0.0.0.1
     */
    if (jQuery('.user-item').length > 0) {
        results(users.page);
        if (window.location.hash) {
            var hash = window.location.hash;
            hash = hash.replace('#', '');
            users.user_id = hash;
            user_edit();
        }
    }
    
    /*
     * Reset the search
     * 
     * @since   0.0.0.1
     */
    function resetall() {
        users.rsearch = '';
        users.page = 1;
        jQuery('.search_user').val('');
        jQuery('.search-m').removeClass('search-active');
        jQuery('.user-details').hide();
        results(1);
    }
    
    /*
     * Gets users feeds
     * 
     * @since   0.0.1
     */
    function get_user_feeds(page) {
        
        jQuery.ajax({
            url: url + 'admin/user-data/2/' + users.user_id + '/' + page,
            dataType: 'json',
            type: 'GET',
            beforeSend: function () {
                if (jQuery(document).width() > 700)
                    jQuery( '#rss-feeds .pagination' ).closest( '.col-lg-12' ).find( '.pageload' ).show();
            },
            success: function (data) {

                // Generate pagination
                show_pagination( data.total, '#rss-feeds' );
                
                if ( data ) {
                    var allfeeds = '';
                    for (var u = 0; u < data.feeds.length; u++) {
                        
                        var title = '<a href="' + data.feeds[u].rss_url + '" target="_blank">' + data.feeds[u].rss_name + '</a>';
                        allfeeds += '<li class="list-group-item"><div class="row toggle"><div class="col-lg-12">' + title + ' </div></div><div class="answer" style="display: none;"></div></li>';
                    }
                    jQuery( '#rss-feeds ul.list-group' ).html(allfeeds);
                }
            },
            error: function (data, jqXHR, textStatus) {
                console.log('Request failed:' + textStatus);
                jQuery('#rss-feeds .pagination').empty();
                jQuery('#rss-feeds ul.list-group').html('<p>' + translation.mm135 + '</p>');
            },
            complete: function () {
                jQuery( '#rss-feeds .pagination' ).closest( '.col-lg-12' ).find( '.pageload' ).fadeOut('slow');
            },
        });
        
    }
    
    /*
     * Gets users emails
     * 
     * @since   0.0.1
     */
    function get_user_emails(page) {
        jQuery.ajax({
            url: url + 'admin/user-data/3/' + users.user_id + '/' + page,
            dataType: 'json',
            type: 'GET',
            beforeSend: function () {
                if (jQuery(document).width() > 700)
                    jQuery( '#emails .pagination' ).closest( '.col-lg-12' ).find( '.pageload' ).show();
            },
            success: function (data) {
                // Generate pagination
                show_pagination( data.total, '#emails' );
                
                if ( data ) {
                    var alltemplates = '';
                    for (var u = 0; u < data.templates.length; u++) {
                        var title = data.templates[u].title;
                        var body = data.templates[u].body;
                        alltemplates += '<li class="list-group-item"><div class="row toggle question"><div class="col-lg-11 col-sm-10 col-xs-10">' + title + '</div><div class="col-lg-1 col-sm-2 col-xs-2"><i class="fa pull-right fa-chevron-down"></i></div></div><div class="answer" style="display: none;"><hr><div class="row"><div class="col-lg-12">' + body + '</div></div></div></li>';
                    }
                    jQuery( '#emails ul.list-group' ).html(alltemplates);
                }
            },
            error: function (data, jqXHR, textStatus) {
                console.log('Request failed:' + textStatus);
                jQuery('#emails .pagination').empty();
                jQuery('#emails ul.list-group').html('<p>' + translation.mm154 + '</p>');
            },
            complete: function () {
                jQuery( '#emails .pagination' ).closest( '.col-lg-12' ).find( '.pageload' ).fadeOut('slow');
            },
        });
        
    }
    
    /*
     * Gets users posts
     * 
     * @since   0.0.1
     */
    function get_user_posts(page) {
        jQuery.ajax({
            url: url + 'admin/user-data/1/' + users.user_id + '/' + page,
            dataType: 'json',
            type: 'GET',
            beforeSend: function () {
                if (jQuery(document).width() > 700)
                    jQuery( '#posts .pagination' ).closest( '.col-lg-12' ).find( '.pageload' ).show();
            },
            success: function (data) {
                
                // Generate pagination
                show_pagination( data.total, '#posts' );
                if ( data ) {
                    var allposts = '';
                    for (var u = 0; u < data.posts.length; u++) {
                        var date = data.posts[u].sent_time;
                        var gettime = Main.calculate_time(date, data.date);
                        var title = '';
                        var url = '';
                        var img = '';
                        var video = '';
                        var history = data.posts[u].history;
                        var histories = '';
                        if ( history ) {
                            
                            for ( var g = 0; g < history.length; g++ ) {
                                
                                var network_name = history[g].network_name;
                                network_name = network_name.replace( '_', ' ' );
                                var status = history[g].status;
                                var stats = '<i class="fa fa-ban"></i>';
                                if ( status === '1' ) {
                                    stats = '<i class="fa fa-check"></i>';
                                }
                                var thebody = '';
                                if ( history[g].network_status ) {
                                    thebody = '<div class="panel-body">' + history[g].network_status + '</div>';
                                }
                                histories += '<div class="panel panel-default"><div class="panel-heading"><strong>' + history[g].user_name + '</strong> <span class="text-muted">(' + network_name + ')</span><span class="pull-right">' + stats + '</span></div>' + thebody + '</div>';
                                
                            }
                        }
                        if ( data.posts[u].title != '' ) {
                            title = '<h4>' + data.posts[u].title + '</h4>';
                        }
                        if ( data.posts[u].url != '' ) {
                            url = '<p class="post-media"><i class="fa fa-link"></i> ' + data.posts[u].url + '</p>';
                        }
                        if ( data.posts[u].img != '' ) {
                            img = '<p class="post-media"><i class="fa fa-picture-o"></i> ' + data.posts[u].img + '</p>';
                        }
                        if ( data.posts[u].video != '' ) {
                            video = '<p class="post-media"><i class="fa fa-video-camera"></i> ' + data.posts[u].video + '</p>';
                        }
                        var body = '<p>' + data.posts[u].body + '</p>';
                        var status = (data.posts[u].status == 1) ? '<span class="label label-success">' + translation.mm130 + '</span>' : (data.posts[u].status == 2) ? (data.posts[u].status == 2 && date > data.date) ? '<span class="label label-warning">scheduled</span>' : '<span class="label label-danger">' + translation.mm112 + '</span>' : '<span class="label label-default">' + translation.mm113 + '</span>';
                        var text = (data.posts[u].body.length > 0) ? data.posts[u].body.substring(0, 100) + '...' : data.posts[u].img.substring(0, 100) + '...';
                        allposts += '<li class="list-group-item"><div class="row toggle question"><div class="col-lg-11 col-sm-10 col-xs-10">' + text + ' ' + status + ' <span class="pull-right">' + gettime + '</span></div><div class="col-lg-1 col-sm-2 col-xs-2"><i class="fa pull-right fa-chevron-down"></i></div></div><div class="answer" style="display: none;"><hr><div class="row"><div class="col-lg-12">' + title + body + url + img + video + histories + '</div></div></div></li>';
                    }
                    jQuery( '#posts ul.list-group' ).html(allposts);
                }
            },
            error: function (data, jqXHR, textStatus) {
                console.log('Request failed:' + textStatus);
                jQuery('#posts .pagination').empty();
                jQuery('#posts ul.list-group').html('<p>' + translation.mm116 + '</p>');
            },
            complete: function () {
                jQuery( '#posts .pagination' ).closest( '.col-lg-12' ).find( '.pageload' ).fadeOut('slow');
            },
        });
        
    }

    /*
     * Edit user data
     * 
     * @since   0.0.0.1
     */
    function user_edit() {
        jQuery('.user-details').hide();
        jQuery('.user-details').fadeIn('slow');
        jQuery('.drole').removeAttr('disabled');
        jQuery('.dstatus').removeAttr('disabled');
        jQuery('.delete-account').show();
        jQuery('.confirm').hide();
        jQuery.ajax({
            url: url + 'admin/user-info/' + users.user_id,
            dataType: 'json',
            type: 'GET',
            beforeSend: function () {
                document.getElementsByClassName('update-form')[0].reset();
            },
            success: function (data) {
                if (data.msg) {
                    jQuery('.first_name').val(data.msg.first_name);
                    jQuery('.last_name').val(data.msg.last_name);
                    jQuery('.dusername').val(data.msg.username);
                    jQuery('.demail').val(data.msg.email);
                    jQuery('.drole').val(data.msg.role);
                    jQuery('.dproxy').val(data.msg.proxy);
                    jQuery('.dstatus').val(data.msg.status);
                    var gettime = Main.calculate_time(data.msg.date, data.msg.current);
                    if (users.user_id === data.user_id) {
                        jQuery('.drole').attr('disabled', 'disabled');
                        jQuery('.dstatus').attr('disabled', 'disabled');
                        jQuery('.delete-account').hide();
                    }
                    if (gettime) {
                        jQuery('.panel-footer').html('<i class="fa fa-user-plus"></i> ' + gettime);
                    }
                    if(data.msg.role == 1)
                    {
                        jQuery('.dplan').closest('div').hide();
                    }
                    else
                    {
                        if(data.msg.plan)
                        {
                                jQuery('.dplan').closest('div').show();
                                jQuery('.dplan').val(data.msg.plan);
                        }	
                    }
                }
            },
            error: function (data, jqXHR, textStatus) {
                console.log('Request failed: ' + textStatus);
                jQuery('.alert-msg').show();
                jQuery('.alert-msg').html('<p class="merror">'+translation.mm3+'</p>');
                jQuery('.merror').fadeIn(1000).delay(2000).fadeOut(1000, function () {
                    jQuery('.merror').remove();
                    jQuery('.alert-msg').hide();
                });
            }
        });
    }
});