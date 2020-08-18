jQuery(document).ready(function () {
    // This file contains send and update message's templates
    'use strict';
    
    var url = jQuery('.navbar-brand').attr('href');
    
    if ( jQuery('.terms-policies').length > 0 ) {
        
        // Use the summernote in the Terms sections page
        jQuery('.terms-policies .summernote').summernote();
        
        // Add value if exists
        jQuery('#terms-and-conditions .summernote').summernote('code', jQuery('#terms-and-conditions .msg-body').val());
        jQuery('#privacy-policy .summernote').summernote('code', jQuery('#privacy-policy .msg-body').val());
        jQuery('#cookies .summernote').summernote('code', jQuery('#cookies .msg-body').val());
        
    } else {
        
        // Use the summernote in the Notifications page
        jQuery('#summernote').summernote();
        
    }
    
    jQuery('.note-editable').on('blur', function () {
        
        if ( jQuery('.terms-policies').length > 0 ) {
            
            jQuery(this).closest('form').find('.msg-body').val(jQuery(this).closest('form').find('.summernote').summernote('code'));
            
        } else {
            
            jQuery('.msg-body').val(jQuery('#summernote').summernote('code'));
            
        }
        
    });
    
    jQuery('.send-mess').submit(function (e) {
        // Send notifications by email
        e.preventDefault();
        
        var msg_body = btoa(encodeURIComponent(jQuery('.msg-body').val()));
        var msg_title = btoa(encodeURIComponent(jQuery('.msg-title').val()));
        msg_body = msg_body.replace('/', '-');
        msg_body = msg_body.replace(/=/g, '');
        msg_title = msg_title.replace('/', '-');
        msg_title = msg_title.replace(/=/g, '');		
        var template = jQuery('.template').val();
        var name = jQuery('input[name="csrf_test_name"]').val();
        
        // Load gif loading icon
        jQuery('img.display-none').fadeIn('slow');
        
        // Create an object with form data
        var data = {'title': msg_title, 'body': msg_body, 'template': template, 'csrf_test_name': name};
        
        // Submit data via ajax
        jQuery.ajax({
            url: url + 'admin/notification/',
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
                    jQuery('#summernote').summernote('code', '');
                    jQuery('.msg-body').val('');
                    jQuery('.msg-title').val('');
                    jQuery('.template').val('');
                });
                
                // Refresh sent notifications list
                load_all_sent_notifications();
                
            },
            complete: function () {
                
                jQuery('img.display-none').fadeOut('slow');
                
            },
            error: function (data, jqXHR, textStatus) {
                
                console.log('Request failed: ' + textStatus);
                
            }
            
        });
        
    });
    
    jQuery('.terms-policies .save-terms').submit(function (e) {
        // Save terms content
        e.preventDefault();
        
        var $this = jQuery(this);
        var msg_body = jQuery(this).find('.msg-body').val();
        var msg_title = jQuery(this).find('.msg-title').val();
        var term_key = jQuery(this).find('.term-key').val();
        var name = jQuery(this).find('input[name="csrf_test_name"]').val();
        
        // Load gif loading icon
        jQuery('img.display-none').fadeIn('slow');
        
        // Create an object with form data
        var data = {'title': msg_title, 'body': msg_body, 'term_key': term_key, 'csrf_test_name': name};

        // Submit data via ajax
        jQuery.ajax({
            url: url + 'admin/terms-and-policies',
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function (data) {

                // Verify if the success response exists
                if ( data.success ) {

                    // Display alert
                    Main.popup_fon('subi', data.message, 1500, 2000);

                } else {

                    // Display alert
                    Main.popup_fon('sube', data.message, 1500, 2000);

                }
                
            },
            complete: function () {
                
                $this.data('requestRunning', false);
                jQuery('img.display-none').fadeOut('slow');
                
            },
            error: function (data, jqXHR, textStatus) {
                
                console.log('Request failed: ' + textStatus);
                
            }
            
        });
        
    });
    
    jQuery('.save-new-guide').submit(function (e) {
        // Save guides
        e.preventDefault();
        
        var msg_body = jQuery('.msg-body').val();
        var msg_title = jQuery('.msg-title').val();
        var msg_short = jQuery('.msg-short').val();
        var guide = jQuery('.guide').val();
        var name = jQuery('input[name="csrf_test_name"]').val();
        
        // Load gif loading icon
        jQuery('img.display-none').fadeIn('slow');
        
        // Create an object with form data
        var data = {
            title: msg_title,
            short: msg_short,
            body: msg_body,
            guide: guide,
            csrf_test_name: name
        };

        // Submit data via ajax
        jQuery.ajax({
            url: url + 'admin/guides',
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
                    jQuery('.preview').empty();
                    jQuery('#summernote').summernote('code', '');
                    jQuery('.msg-body').val('');
                    jQuery('.msg-title').val('');
                    jQuery('.msg-short').val('');
                    jQuery('.guide').val('');
                });
                
                load_all_guides();
                
            },
            complete: function () {
                
                jQuery('img.display-none').fadeOut('slow');
                
            },
            error: function (data, jqXHR, textStatus) {
                
                console.log('Request failed: ' + textStatus);
                
            }
            
        });
        
    });    
    
    jQuery(document).on('click', '#templates .list-group-item, #sent .list-group-item', function () {
        
        if (jQuery(this).attr('data-id') ) {
            
            var id = jQuery(this).attr('data-id');
            
            // Add active class
            jQuery('.list-group-item').removeClass('active');
            jQuery(this).addClass('active');
            
            // Submit data via ajax
            jQuery.ajax({
                url: url + 'admin/get-notification/' + id,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    
                    if ( data[0].notification_title ) {
                        
                        jQuery('.msg-title').val(data[0].notification_title);
                        
                    }                    
                    
                    if ( data[0].notification_body ) {
                        
                        jQuery('#summernote').summernote('code', data[0].notification_body);
                        jQuery('.msg-body').val(data[0].notification_body);
                        
                    } else {
                        
                        jQuery('#summernote').summernote('code', '');
                        jQuery('.msg-body').val('');                        
                        
                    }
                    
                    if (data[0].template_name) {
                        
                        jQuery('.template').val(data[0].template_name);
                        jQuery('.buttons>.btn-danger').hide();
                        jQuery('.buttons>.send-msg').hide();
                        jQuery('.buttons>.update-msg').show();
                        
                    } else {
                        
                        jQuery('.template').val('');
                        jQuery('.buttons>.btn-danger').show();
                        jQuery('.buttons>.btn-danger').attr('data-id', id);
                        jQuery('.buttons>.send-msg').show();
                        jQuery('.buttons>.update-msg').hide();
                        
                    }
                    
                },
                error: function (data, jqXHR, textStatus) {
                    
                    console.log('Request failed: ' + textStatus);
                    
                }
                
            });
            
        }
        
    });
    
    jQuery(document).on('click', '#guides .list-group-item', function () {
        
        if (jQuery(this).attr('data-id') ) {
            
            var id = jQuery(this).attr('data-id');
            
            // Add active class
            jQuery('.list-group-item').removeClass('active');
            jQuery(this).addClass('active');
            
            // Submit data via ajax
            jQuery.ajax({
                url: url + 'admin/get-guide/' + id,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    
                    if ( data[0].title ) {
                        
                        jQuery('.msg-title').val( data[0].title );
                        
                    }                    

                    if ( data[0].body ) {
                        
                        jQuery('#summernote').summernote('code', data[0].body);
                        jQuery('.msg-body').val( data[0].body );
                        
                    } else {
                        
                        jQuery('#summernote').summernote('');
                        jQuery('.msg-body').val('');                        
                        
                    }
                    
                    
                    if ( data[0].short ) {
                        
                        jQuery('.msg-short').val( data[0].short );   
                        
                    } else {
                        
                        jQuery('.msg-short').val('');                        
                        
                    } 
                    
                    if ( data[0].cover ) {
                        
                        jQuery('.preview').html( '<img src="' + data[0].cover + '" class="thumbnail">' );
                        
                    } else {
                        
                        jQuery('.preview').empty();
                        
                    }                 

                    jQuery('.guide').val(data[0].guide_id);
                    jQuery('.buttons>.btn-danger').attr('data-id', id);
                    jQuery('.buttons>.btn-danger').show();
                    
                },
                error: function (data, jqXHR, textStatus) {
                    
                    console.log('Request failed: ' + textStatus);
                    
                }
                
            });
            
        }
        
    });         
    
    jQuery(document).on('click', '.delete-notification', function () {
        
        if ( jQuery(this).attr('data-id') ) {
            
            var id = jQuery(this).attr('data-id');
            
            jQuery.ajax({
                url: url + 'admin/del-notification/' + id,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    
                    if (data.indexOf('msuccess') >= 0) {
                        document.getElementsByClassName('send-mess')[0].reset();
                        jQuery('#summernote').summernote('code', ' ')
                    }
                    
                    jQuery('.alert-msg').show();
                    jQuery('.buttons>.btn-danger').hide();
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
            
            // Refresh sent notifications list
            load_all_sent_notifications();
            
        }
        
    });
    
    jQuery(document).on('click', '.delete-guide', function () {
        
        if ( jQuery(this).attr('data-id') ) {
            
            var id = jQuery(this).attr('data-id');
            
            jQuery.ajax({
                url: url + 'admin/del-guide/' + id,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    
                    if (data.indexOf('msuccess') >= 0) {
                        document.getElementsByClassName('save-new-guide')[0].reset();
                        jQuery('#summernote').summernote('code', ' ');
                        jQuery('.preview').empty();
                    }
                    
                    jQuery('.alert-msg').show();
                    jQuery('.buttons>.btn-danger').hide();
                    jQuery('.alert-msg').html(data);
                    jQuery('.merror').fadeIn(1000).delay(2000).fadeOut(1000, function () {
                        jQuery('.merror').remove();
                        jQuery('.alert-msg').hide();
                    });
                    
                    jQuery('.msuccess').fadeIn(1000).delay(2000).fadeOut(1000, function () {
                        jQuery('.msuccess').remove();
                        jQuery('.alert-msg').hide();
                    });
                
                    load_all_guides();
                    
                },
                error: function (data, jqXHR, textStatus) {
                    
                    console.log('Request failed: ' + textStatus);
                    
                }
                
            });
            
            // Refresh sent notifications list
            load_all_sent_notifications();
            
        }
        
    });    
    
    function load_all_sent_notifications() {
        
        // Get all sent notification
        jQuery.ajax({
            url: url + 'admin/get-notifications/',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                
                if (data) {
                    
                    var notifications = '';
                    
                    for ( var u = 0; u < data.notification.length; u++ ) {
                        
                        notifications += '<li class="list-group-item" data-id="' + data.notification[u].notification_id + '"><i class="fa fa-share" aria-hidden="true"></i> ' + data.notification[u].notification_title + ' <span class="pull-right">' + Main.calculate_time(data.notification[u].sent_time, data.time) + '</span></li>';
                        
                    }
                    
                    jQuery('#sent .list-group').html(notifications);
                    
                } else {
                    
                    jQuery('#sent .list-group').html('<li class="list-group-item">' + translation.ma11 + '</li>');
                    
                }
                
            },
            error: function (data, jqXHR, textStatus) {
                
                console.log('Request failed: ' + textStatus);
                jQuery('#sent .list-group').html('<li class="list-group-item">' + translation.ma11 + '</li>');
                
            }
            
        });
        
    }
    
    function load_all_guides() {
        
        // Get all guides
        jQuery.ajax({
            url: url + 'admin/get-guides',
            type: 'GET',
            dataType: 'json',
            success: function (data) {

                if (data) {
                    
                    var guides = '';
                    
                    for ( var u = 0; u < data.guides.length; u++ ) {
                        
                        guides += '<li class="list-group-item" data-id="' + data.guides[u].guide_id + '">'
                                    + '<i class="fa fa-file" aria-hidden="true"></i> '
                                    + data.guides[u].title
                                    + '<span class="pull-right">'
                                        + Main.calculate_time(data.guides[u].created, data.time)
                                    + '</span>'
                                + '</li>';
                        
                    }
                    
                    jQuery('#guides .list-group').html( guides );
                    
                } else {
                    
                    jQuery('#guides .list-group').html('<li class="list-group-item">' + translation.ma249 + '</li>');
                    
                }
                
            },
            error: function (data, jqXHR, textStatus) {
                
                console.log('Request failed: ' + textStatus);
                jQuery('#guides .list-group').html('<li class="list-group-item">' + translation.ma249 + '</li>');
                
            }
            
        });
        
    }
    
});