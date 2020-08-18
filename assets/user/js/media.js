/*
 * Multimedia gallery
*/

(function ( $ ) {
 
    $.fn.midrubGallery = function( options ) {
        
        $.fn.midrubGallery.options = $.extend(
            $.fn.midrubGallery.options,
            options
        );

        $.fn.midrubGallery.loadMedias(1);
        
        return {
            
            deleteMedias: function() {
                
                var medias = Object.values(Main.medias);
                if ( medias.length ) {
                    
                    for ( var d = 0; d < medias.length; d++ ) {

                        $.fn.midrubGallery.deleteMedia(medias[d].id);
                        
                        delete Main.medias[medias[d].id];
                        
                    }
                    
                }
                
                $( '.multimedia-gallery-selected-medias' ).hide();
                $( '.file-uploaded-box-files' ).empty();
                
            }, 
            downloadMedia: function(data) {
                
                var time = Math.floor(Date.now() / 1000);

                var extension = data.link.slice((data.link.lastIndexOf('.') - 1 >>> 0) + 2);

                if ( extension === 'png' || extension === 'jpg' || extension === 'png' || extension === 'gif' ) {
                    var format = 'image/' + extension.replace('jpg', 'jpeg');
                } else {
                    var format = 'video/mp4';
                }

                $.fn.midrubGallery.options.files[time + '-' + data.bytes] = {
                    key: time + '-' + data.bytes,
                    name: data.name,
                    type: format,
                    size: data.bytes,
                    cover: data.cover,
                    link: data.link,
                    lastModified: time
                };

                var s = 0;
                $( '.main .drag-and-drop-files .icon-cloud-upload' ).addClass( 'drag-upload-active' );
                var intval = setInterval(function(){
                    $( '.main .drag-and-drop-files .icon-cloud-upload' ).removeClass( 'drag-upload-active' );
                    setTimeout(function(){
                        $( '.main .drag-and-drop-files .icon-cloud-upload' ).addClass( 'drag-upload-active' );
                    },500); 
                }, 1000);
                var timer = setInterval(function(){

                    var cover = data.cover;

                    if ( typeof cover !== 'undefined') {
                        $.fn.midrubGallery.saveLink($.fn.midrubGallery.options.files[time + '-' + data.bytes]);
                        clearInterval(timer);
                        clearInterval(intval);
                    }

                    if ( s > 15 ) {
                        $.fn.midrubGallery.saveLink($.fn.midrubGallery.options.files[time + '-' + data.bytes]);
                        clearInterval(timer);
                        clearInterval(intval);
                    } else {
                        s++;
                    }

                }, 1000);
                
            }
            
        };
        
    };
    
    $.fn.midrubGallery.options = {
        url: $('meta[name=url]').attr('content'),
        files: {},
        medias: {}
    };
    
    /*******************************
    METHODS
    ********************************/
    $.fn.midrubGallery.uploadFile = function (form, path) {
        
        // Set the media's cover
        form.append('cover', path.cover);
        
        // Set the action
        form.append('action', 'upload_media_in_storage');
        
        // Create inteval variable for animation
        var intval;

        // Upload media
        $.ajax({
            url: $.fn.midrubGallery.options.url + 'user/ajax/media',
            type: 'POST',
            data: form,
            dataType: 'JSON',
            processData: false,
            contentType: false,
            beforeSend: function () {
                $( '.main .drag-and-drop-files .icon-cloud-upload' ).addClass( 'drag-upload-active' );
                intval = setInterval(function(){
                    $( '.main .drag-and-drop-files .icon-cloud-upload' ).removeClass( 'drag-upload-active' );
                    setTimeout(function(){
                        $( '.main .drag-and-drop-files .icon-cloud-upload' ).addClass( 'drag-upload-active' );
                    },500); 
                }, 1000);
            },
            success: function (data) {

                if ( data.success ) {
                    
                    if ( $('.main .storage-all-media-files').length > 0 ) {
                        
                        // Load all media's files
                        Main.loadMedias(1);
                        
                    } else {                    
                    
                        // Set media id
                        path.media_id = data.media_id;

                        // Set the user storage
                        $( '.user-total-storage' ).text( data.user_storage );

                        var li = '<li data-id="' + data.media_id + '">'
                                    + '<div class="row">'
                                        + '<div class="col-xl-11">'
                                            + '<img src="' + path.cover + '">'
                                            + '<p>' + path.name  + '</p>'
                                        + '</div>'
                                        + '<div class="col-xl-1 text-center">'
                                            + '<button class="btn delete-uploaded-media" data-id="' + path.key + '">'
                                                + '<i class="fas fa-times-circle"></i>'
                                            + '</button>'
                                        + '</div>'
                                    + '</div>'
                                + '</li>';

                        $( '.file-uploaded-box-files' ).append(li);

                        $.fn.midrubGallery.loadMedias(1);
                    
                    }
                    
                    Main.popup_fon('subi', data.message, 1500, 2000);
                    
                } else {
                    
                    var li = '<li>'
                                + '<div class="row">'
                                    + '<div class="col-xl-11">'
                                        + '<img src="' + path.cover + '">'
                                        + '<p>'
                                            + path.name
                                            + '<span>'
                                                + data.message
                                            + '</span>'
                                        + '</p>'
                                    + '</div>'
                                    + '<div class="col-xl-1 text-center">'
                                        + '<button class="btn delete-uploaded-media" data-id="' + path.key + '">'
                                            + '<i class="fas fa-times-circle"></i>'
                                        + '</button>'
                                    + '</div>'
                                + '</div>'
                            + '</li>';

                    $( '.file-uploaded-box-files' ).append(li);
                    
                    Main.popup_fon('sube', data.message, 1500, 2000);
                    
                }
                
            },
            error: function (jqXHR, textStatus, errorThrown) {
                
                console.log(jqXHR);
                
            },
            complete: function () {
                
                setTimeout(function(){
                    $( '.main .drag-and-drop-files .icon-cloud-upload' ).removeClass( 'drag-upload-active' );
                }, 2000);
                clearInterval(intval);
                
            }
            
        });

    };
    
    $.fn.midrubGallery.saveLink = function (path) {
        
        // Create inteval variable for animation
        var intval;
        
        // Create object to pass
        var data = {
            action: 'save_media_in_storage',
            link: 'url: ' + path.link,
            cover: 'url: ' + path.cover,
            type: path.type,
            size: path.size,
            name: path.name
        };
        
        // Set CSRF
        data[$('.upim').attr('data-csrf')] = $('input[name="' + $('.upim').attr('data-csrf') + '"]').val();

        // Upload media
        $.ajax({
            url: $.fn.midrubGallery.options.url + 'user/ajax/media',
            type: 'POST',
            data: data,
            dataType: 'JSON',
            beforeSend: function () {
                $( '.main .drag-and-drop-files .icon-cloud-upload' ).addClass( 'drag-upload-active' );
                intval = setInterval(function(){
                    $( '.main .drag-and-drop-files .icon-cloud-upload' ).removeClass( 'drag-upload-active' );
                    setTimeout(function(){
                        $( '.main .drag-and-drop-files .icon-cloud-upload' ).addClass( 'drag-upload-active' );
                    },500); 
                }, 1000);
            },
            success: function (data) {
                
                if ( data.success ) {
                    
                    // Set media id
                    path.media_id = data.media_id;
                    
                    // Set the user storage
                    $( '.user-total-storage' ).text( data.user_storage );
                 
                    var li = '<li data-id="' + data.media_id + '">'
                                + '<div class="row">'
                                    + '<div class="col-xl-11">'
                                        + '<img src="' + path.cover + '">'
                                        + '<p>' + path.name  + '</p>'
                                    + '</div>'
                                    + '<div class="col-xl-1 text-center">'
                                        + '<button class="btn delete-uploaded-media" data-id="' + path.key + '">'
                                            + '<i class="fas fa-times-circle"></i>'
                                        + '</button>'
                                    + '</div>'
                                + '</div>'
                            + '</li>';

                    $( '.file-uploaded-box-files' ).append(li);
                    
                    $.fn.midrubGallery.loadMedias(1);
                    
                } else {
                    
                    var li = '<li>'
                                + '<div class="row">'
                                    + '<div class="col-xl-11">'
                                        + '<img src="' + path.cover + '">'
                                        + '<p>'
                                            + path.name
                                            + '<span>'
                                                + data.message
                                            + '</span>'
                                        + '</p>'
                                    + '</div>'
                                    + '<div class="col-xl-1 text-center">'
                                        + '<button class="btn delete-uploaded-media" data-id="' + path.key + '">'
                                            + '<i class="fas fa-times-circle"></i>'
                                        + '</button>'
                                    + '</div>'
                                + '</div>'
                            + '</li>';

                    $( '.file-uploaded-box-files' ).append(li);
                    
                }
                
            },
            error: function (jqXHR, textStatus, errorThrown) {
                
                console.log(jqXHR);
                
            },
            complete: function () {
                clearInterval(intval);
                $( '.main .drag-and-drop-files .icon-cloud-upload' ).removeClass( 'drag-upload-active' );
            }
            
        });

    };
    
    $.fn.midrubGallery.getPreview = function (file, object) {
        var fileReader = new FileReader();
        if (file.type.match('image')) {
            fileReader.onload = function () {
                var img = document.createElement('img');
                img.src = fileReader.result;

            var image = new Image();

            image.onload = function () {
                var canvas = document.createElement('canvas');
                canvas.width = 250;
                canvas.height = 250;

                canvas.getContext('2d').drawImage(this, 0, 0, 250, 250);

                object.cover = canvas.toDataURL('image/png');
            };
            image.src = img.src;

            };
            fileReader.readAsDataURL(file);
        } else {
            fileReader.onload = function () {
                var blob = new Blob([fileReader.result], {type: file.type});
                var url = URL.createObjectURL(blob);
                var video = document.createElement('video');
                var timeupdate = function () {
                    if (snapImage()) {
                        video.removeEventListener('timeupdate', timeupdate);
                        video.pause();
                    }
                };
                video.addEventListener('loadeddata', function () {
                    if (snapImage()) {
                        video.removeEventListener('timeupdate', timeupdate);
                    }
                });
                var snapImage = function () {
                    var canvas = document.createElement('canvas');
                    canvas.width = 250;
                    canvas.height = 250;
                    canvas.getContext('2d').drawImage(video, 0, 0, 250, 250);
                    var image = canvas.toDataURL();
                    var success = image.length > 10;
                    if (success) {
                        var img = document.createElement('img');
                        img.src = image;
                        URL.revokeObjectURL(url);
                        object.cover = img.src;
                    }
                    return success;
                };
                video.addEventListener('timeupdate', timeupdate);
                video.preload = 'metadata';
                video.src = url;
                video.muted = true;
                video.playsInline = true;
                video.play();
            };
            fileReader.readAsArrayBuffer(file);
        }
    };
    
    $.fn.midrubGallery.deleteMedia = function (media_id) {
        
        // Prepare data to send
        var data = {
            action: 'delete_media',
            media_id: media_id,
            returns: 1
        };
        
        $.ajax({
            url: $.fn.midrubGallery.options.url + 'user/ajax/media',
            dataType: 'json',
            type: 'GET',
            data: data,
            success: function (data) {
                
                if ( data.success ) {
                    
                    Main.popup_fon('subi', data.message, 1500, 2000);
                    $.fn.midrubGallery.loadMedias(1);
                    // Set the user storage
                    $( '.user-total-storage' ).text( data.user_storage );
                    
                } else {
                    
                    Main.popup_fon('sube', data.message, 1500, 2000);
                    
                }
                
            },
            error: function (data, jqXHR, textStatus) {
                Main.popup_fon('sube', data.message, 1500, 2000);
                
            }
            
        });
        
    };    

    $.fn.midrubGallery.saveFile = function (file) {

        $.fn.midrubGallery.options.files[file.lastModified + '-' + file.size] = {
            key: file.lastModified + '-' + file.size,
            name: file.name,
            type: file.type,
            size: file.size,
            lastModified: file.lastModified
        };
        
        var fileType = file.type.split('/');
        var form = new FormData();
        form.append('path', '/');
        form.append('file', file);
        form.append('type', fileType[0]);

        if ( $('.upim #category').length > 0 ) {
            form.append('category', $('.upim #category').val());
        }

        form.append('enctype', 'multipart/form-data');
        form.append($('.upim').attr('data-csrf'), $('input[name="' + $('.upim').attr('data-csrf') + '"]').val());
        $.fn.midrubGallery.getPreview(file, $.fn.midrubGallery.options.files[file.lastModified + '-' + file.size]);
        var s = 0;
        $( '.main .drag-and-drop-files .icon-cloud-upload' ).addClass( 'drag-upload-active' );
        var intval = setInterval(function(){
            $( '.main .drag-and-drop-files .icon-cloud-upload' ).removeClass( 'drag-upload-active' );
            setTimeout(function(){
                $( '.main .drag-and-drop-files .icon-cloud-upload' ).addClass( 'drag-upload-active' );
            },500); 
        }, 1000);
        var timer = setInterval(function(){
            var cover = $.fn.midrubGallery.options.files[file.lastModified + '-' + file.size].cover;
            
            if ( typeof cover !== 'undefined') {
                $.fn.midrubGallery.uploadFile( form, $.fn.midrubGallery.options.files[file.lastModified + '-' + file.size] );
                clearInterval(timer);
                clearInterval(intval);
            }
            
            if ( s > 15 ) {
                $.fn.midrubGallery.options.files[file.lastModified + '-' + file.size].cover = 'data:image/png;base64,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';
                $.fn.midrubGallery.uploadFile( form, $.fn.midrubGallery.options.files[file.lastModified + '-' + file.size] );
                clearInterval(timer);
                clearInterval(intval);
            } else {
                s++;
            }
            
        }, 1000);

    };
    
    $.fn.midrubGallery.loadMedias = function (page) {

        // Prepare data to send
        var data = {
            action: 'get_media',
            page: page
        };

        $.ajax({
            url: $.fn.midrubGallery.options.url + 'user/ajax/media',
            dataType: 'json',
            type: 'GET',
            data: data,
            success: function (data) {
                
                if ( data.success ) {
                    
                    if ( $.fn.midrubGallery.options.medias.page === page && page === 1 ) {
                        $( '.multimedia-gallery ul' ).empty();
                    }
                    
                    var medias = '';
                    
                    for ( var m = 0; m < data.medias.length; m++ ) {
                        
                        medias += '<li>'
                                    + '<a href="#" data-url="' + data.medias[m].body + '" data-id="' + data.medias[m].media_id + '" data-type="' + data.medias[m].type + '">'
                                        + '<img src="' + data.medias[m].cover + '">'
                                        + '<i class="icon-check"></i>'
                                    + '</a>'
                                + '</li>';
                        
                    }
                    
                    $( '.multimedia-gallery ul' ).append(medias);
                    
                    $( 'body .no-medias-found' ).css( 'display', 'none' );
                    
                    $.fn.midrubGallery.options.medias.page = page;
                    
                    if ( ( $.fn.midrubGallery.options.medias.page * 16 ) < data.total ) {
                        $( '.load-more-medias' ).css( 'display', 'flow-root' );
                    } else {
                        $( '.load-more-medias' ).css( 'display', 'none' );
                    }
                    
                } else {
                    $( 'body .multimedia-gallery ul' ).empty();
                    $( 'body .no-medias-found' ).css( 'display', 'block' );
                }
                
            },
            error: function (data, jqXHR, textStatus) {
                $( '.multimedia-gallery ul' ).empty();
                $( 'body .no-medias-found' ).css('display', 'flow-root');
            }
            
        });

    };
    
    /*******************************
    ACTIONS
    ********************************/
    $( document ).on( 'drag dragstart dragend dragover dragenter dragleave drop', '.drag-and-drop-files' , function (e) {
        e.preventDefault();
        e.stopPropagation();
        
        $( this ).addClass( 'drag-active' );

        if ( e.handleObj.origType === 'dragleave' || e.handleObj.origType === 'drop' ) {
            
            $( this ).removeClass( 'drag-active' );
            
            if (typeof e.originalEvent.dataTransfer.files[0] !== 'undefined') {
                $('#file').prop('files', e.originalEvent.dataTransfer.files);
                $('#upim').submit();
            }
            
        }

    });
    
    $( document ).on( 'click', '.drag-and-drop-files a', function (e) {
        e.preventDefault();
        
        $('#file').click();
    });
    
    $( document ).on( 'click', '.delete-uploaded-media', function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        if ( typeof $.fn.midrubGallery.options.files[id].media_id !== 'undefined' ) {
            $.fn.midrubGallery.deleteMedia($.fn.midrubGallery.options.files[id].media_id);
        }
        delete $.fn.midrubGallery.options.files[id];
        $(this).closest('li').remove();
    });    
    
    $( document ).on( 'change', '#file', function (e) {
        $('#upim').submit();
    }); 
    
    $('#upim').submit(function (e) {
        e.preventDefault();
        
        var files = $('#file')[0].files;
        
        if ( typeof files[0] !== 'undefined' ) {
            
            for ( var f = 0; f < files.length; f++ ) {
                
                $.fn.midrubGallery.saveFile(files[f]);
                
            }
            
        }
        
    });
    
    $(document).on('click', '.multimedia-gallery li a', function (e) {
        e.preventDefault();
        
        if ( typeof Main.medias === 'undefined' ) {
            Main.medias = {};
        }
        
        var id = $( this ).attr('data-id');
        
        if ( $( this ).hasClass( 'media-selected' ) ) {
            
            delete Main.medias[id];
            
            $( this ).removeClass( 'media-selected' );
            
        } else {
            
            Main.medias[id] = {
                id: id,
                url: $( this ).attr('data-url'),
                type: $( this ).attr('data-type')
            };
            
            $( this ).addClass( 'media-selected' );          
            
        }
        
        if ( Object.keys(Main.medias).length < 1 ) {
            $( '.multimedia-gallery-selected-medias' ).fadeOut('slow');
        } else {
            $( '.multimedia-gallery-selected-medias p' ).text( Object.keys(Main.medias).length + ' ' + words.selected );
            $( '.multimedia-gallery-selected-medias' ).fadeIn('slow');
        }
        
    });
    
    $(document).on('click', '.load-more-medias', function (e) {
        e.preventDefault();
                    
        $.fn.midrubGallery.loadMedias( ( $.fn.midrubGallery.options.medias.page + 1 ) );
        
    });    
    
    $(document).on('click', '#OpenDropboxFilePicker', function(){
        var options = {
            success: function (files) {
                files.forEach(function (file) {
                    var thumbnail = file.thumbnailLink;
                    var thumb = thumbnail.replace('bounding_box=75', 'bounding_box=256');
                    
                    var time = Math.floor(Date.now() / 1000);
                    
                    var extension = file.link.slice((file.link.lastIndexOf('.') - 1 >>> 0) + 2);
                    
                    if ( extension === 'png' || extension === 'jpg' || extension === 'png' || extension === 'gif' ) {
                        var format = 'image/' + extension.replace('jpg', 'jpeg');
                    } else {
                        var format = 'video/mp4';
                    }
                    
                    $.fn.midrubGallery.options.files[time + '-' + file.bytes] = {
                        key: time + '-' + file.bytes,
                        name: file.name,
                        type: format,
                        size: file.bytes,
                        cover: thumb,
                        link: file.link,
                        lastModified: time
                    };

                    var s = 0;
                    $( '.main .drag-and-drop-files .icon-cloud-upload' ).addClass( 'drag-upload-active' );
                    var intval = setInterval(function(){
                        $( '.main .drag-and-drop-files .icon-cloud-upload' ).removeClass( 'drag-upload-active' );
                        setTimeout(function(){
                            $( '.main .drag-and-drop-files .icon-cloud-upload' ).addClass( 'drag-upload-active' );
                        },500); 
                    }, 1000);
                    var timer = setInterval(function(){
                        
                        var cover = thumb;

                        if ( typeof cover !== 'undefined') {
                            $.fn.midrubGallery.saveLink($.fn.midrubGallery.options.files[time + '-' + file.bytes]);
                            clearInterval(timer);
                            clearInterval(intval);
                        }

                        if ( s > 15 ) {
                            $.fn.midrubGallery.saveLink($.fn.midrubGallery.options.files[time + '-' + file.bytes]);
                            clearInterval(timer);
                            clearInterval(intval);
                        } else {
                            s++;
                        }

                    }, 1000);
        
                });
            },
            cancel: function () {
            },
            linkType: 'direct',
            multiselect: true,
            extensions: ['.png', '.gif', '.jpg', '.jpeg', '.mp4'],
        };    
        Dropbox.choose(options);
    });
    
    $(document).on('click', '.pixabay-drive-picker', function() {
        
        var url = $.fn.midrubGallery.options.url + 'user/app/posts?q=pixabay';
        var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : window.screenX;
        var dualScreenTop = window.screenTop != undefined ? window.screenTop : window.screenY;

        var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

        var left = ((width / 2) - ((width/2) / 2)) + dualScreenLeft;
        var top = ((height / 2) - ((height/2) / 2)) + dualScreenTop;
        var pixabayWindow = window.open(url, 'Pixabay', 'scrollbars=yes, width=' + (width/2) + ', height=' + (height/2) + ', top=' + top + ', left=' + left);

        if (window.focus) {
            pixabayWindow.focus();
        }
        
    });    
 
}( jQuery ));

var midrubGallery = jQuery( '.multimedia-gallery' ).midrubGallery();

function pixabay_save_photo(data) {
    midrubGallery.downloadMedia(data);
}