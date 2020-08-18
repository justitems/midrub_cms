jQuery(document).ready(function () {
    'use strict';
    // this file contains send and update message's templates
    
    // Get the website url
    var url = jQuery('.navbar-brand').attr('href');
    
    // Track the clicks on social classes
    jQuery('.setopt').click(function () {
        
        enable_or_disable_option(jQuery(this).attr('id'));
        
        if ( jQuery(this).attr('id') === 'facebook_via_permission' ) {
            
            if ( jQuery('#facebook_user_api_key').is(':checked') ) {
                
                jQuery('#facebook_user_api_key').click();
                
            }
            
        } else if ( jQuery(this).attr('id') === 'facebook_user_api_key' ) {
            
            if ( jQuery('#facebook_via_permission').is(':checked') ) {
                
                jQuery('#facebook_via_permission').click();
                
            }
            
        } else if ( jQuery(this).attr('id') === 'facebook_groups_via_permission' ) {
            
            if ( jQuery('#facebook_groups_user_api_key').is(':checked') ) {
                
                jQuery('#facebook_groups_user_api_key').click();
                
            }
            
        } else if ( jQuery(this).attr('id') === 'facebook_groups_user_api_key' ) {
            
            if ( jQuery('#facebook_groups_via_permission').is(':checked') ) {
                
                jQuery('#facebook_groups_via_permission').click();
                
            }
            
        } else if ( jQuery(this).attr('id') === 'facebook_pages_via_permission' ) {
            
            if ( jQuery('#facebook_pages_user_api_key').is(':checked') ) {
                
                jQuery('#facebook_pages_user_api_key').click();
                
            }
            
        } else if ( jQuery(this).attr('id') === 'facebook_pages_user_api_key' ) {
            
            if ( jQuery('#facebook_pages_via_permission').is(':checked') ) {
                
                jQuery('#facebook_pages_via_permission').click();
                
            }
            
        }
        
    });
    
    function enable_or_disable_option(name) {
        
        // submit data via ajax
        jQuery.ajax({
            url: url + 'admin/option/' + name,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                
                if (data !== 1) {
                    jQuery('.alert-msg').show();
                    jQuery('.alert-msg').html(data);
                    jQuery('.merror').fadeIn(1000).delay(2000).fadeOut(1000, function () {
                        
                        jQuery('.merror').remove();
                        jQuery('.alert-msg').hide();
                        
                    });
                    
                }
                
            },
            error: function (data, jqXHR, textStatus) {
                
                console.log('Request failed:' + textStatus);
                
            }
            
        });
        
    }
    
    jQuery('.frontend-logo').click(function (event) {
        
        event.preventDefault();
        jQuery('#media-name').val('frontend-logo');
        jQuery('#file').click();
        
    });
    
    jQuery('.login-logo').click(function (event) {
        
        event.preventDefault();
        jQuery('#media-name').val('login-logo');
        jQuery('#file').click();
        
    });
    
    jQuery('.invoice-logo').click(function (event) {
        
        event.preventDefault();
        jQuery('#media-name').val('invoice-logo');
        jQuery('#file').click();
        
    }); 
    
    jQuery('.settings .main_logo').click(function (event) {
        event.preventDefault();

        jQuery('#media-name').val('main_logo');
        jQuery('#file').click();
        
    });
    
    jQuery('.favicon').click(function (event) {
        
        event.preventDefault();
        jQuery('#media-name').val('favicon');
        jQuery('#file').click();
        
    });
    
    jQuery('.home-bg').click(function (event) {
        
        event.preventDefault();
        jQuery('#media-name').val('home-bg');
        jQuery('#file').click();
        
    });
    
    jQuery('.login-bg').click(function (event) {
        
        event.preventDefault();
        jQuery('#media-name').val('login-bg');
        jQuery('#file').click();
        
    });    
    
    jQuery( '.guide-cover' ).click(function (event) {
        
        event.preventDefault();
        jQuery('#media-name').val('guide-cover');
        jQuery('#file').click();
        
    });  
    
    jQuery( '.about-us-photo' ).click(function (event) {
        
        event.preventDefault();
        jQuery('#media-name').val('about-us-photo');
        jQuery('#file').click();
        
    });    
    
    jQuery('#file').on('change', function (event) {
        
        jQuery('.upmedia').submit();
        
    });
    
    jQuery('.upmedia').submit(function (event) {
        
        event.preventDefault();
        var form_class = jQuery(this).attr('class');
        upload_media('.' + form_class);
        
    });
    
    function upload_media(id) {
        
        jQuery.ajax({
            url: url + 'admin/upmedia',
            type: 'POST',
            data: new FormData(jQuery('.upmedia')[0]),
            processData: false,
            contentType: false,
            success: function (data) {
                
                if ( data === 0 ) {
                    
                    jQuery('#' + jQuery('#media-name').val() + ' .error-upload').html('<p class="merror">' + translation.mm143 + '<p>');
                    
                } else if ( data === 1 ) {
                    
                    jQuery('#' + jQuery('#media-name').val() + ' .error-upload').html( '<p class="merror">' + translation.mm144 + '<p>' );
                    
                } else if (data === 2) {
                    
                    jQuery('#' + jQuery('#media-name').val() + ' .error-upload').html( '<p class="merror">' +translation.mm145 + '<p>' ); 
                    
                } else {
                    
                    jQuery('#' + jQuery('#media-name').val() + ' .preview').html(data);
                    
                }
                
                jQuery('.merror').fadeIn(1000).delay(2000).fadeOut(1000, function () {
                    
                    jQuery('.merror').remove();
                    
                });
                
            },
            error: function (data, jqXHR, textStatus) {
                console.log(data);
            }
        });
        
    }
    
});