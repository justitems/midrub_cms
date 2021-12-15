jQuery(document).ready(function () {
    'use strict';
    // this file contains send and update message's templates
    
    /*
     * Get the website's url
     */
    var url = $('meta[name=url]').attr('content'); 
    
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
    
    jQuery('#file').on('change', function (event) {
        
        jQuery('.upmedia').submit();
        
    });
    
    jQuery('.upmedia').submit(function (event) {
        
        event.preventDefault();

        upload_media();
        
    });
    
    function upload_media() {

        // Set file
        var file = $('#file')[0].files[0];

        // Start form
        var form = new FormData();

        // Set path
        form.append('path', '/');

        // Set file
        form.append('file', file);

        // Set file's name
        form.append('file_name', jQuery('#media-name').val());        

        // Get file's type
        var fileType = file.type.split('/');

        // Set file's type
        form.append('type', fileType[0]);

        // Set enctype
        form.append('enctype', 'multipart/form-data');

        // Set CSRF
        form.append($('.upmedia').attr('data-csrf'), $('input[name="' + $('.upmedia').attr('data-csrf') + '"]').val());

        // Set the action
        form.append('action', 'upload_media_in_storage');
        
        jQuery.ajax({
            url: url + 'admin/ajax/settings',
            type: 'POST',
            data: form,
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