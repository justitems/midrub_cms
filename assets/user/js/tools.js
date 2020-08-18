jQuery(document).ready(function () {
    'use strict';
    var url = $('meta[name=url]').attr('content');
    var posts = {'ipage': 1};
    jQuery('.tools-page .save-bookmark, .bots-page .save-bookmark').click(function(e) {
        e.preventDefault();
        var $this = jQuery(this);
        var slug = $this.attr('href');
        var encode = btoa(slug);
        encode = encode.replace('/', '-');
        var cleanURL = encode.replace(/=/g, '');
        jQuery.ajax({
            url: url + 'user/bookmark/' + cleanURL,
            dataType: 'json',
            type: 'GET',
            success: function (data) {
                if(!$this.hasClass('saved')) {
                    $this.addClass('saved');
                } else {
                    $this.removeClass('saved');
                }
            },
            error: function (data, jqXHR, textStatus) {
                console.log('Request failed: ' + textStatus);
            }
        });
    });
    jQuery(document).on('change', '#file', prepareUpload);
    jQuery(document).on('click', '.media-images-next', function(){
        var page = posts.ipage;
        page++;
        posts.ipage = page;
        get_media(page, 'image');
    });
    jQuery(document).on('click', '.media-images-back', function(){
        var page = posts.ipage;
        page--;
        posts.ipage = page;
        get_media(page, 'image');
    });
    jQuery(document).on('click', '.media-gallery .add-gallery-image', function () {
        var img = jQuery(this).closest('li').attr('data-image');
        jQuery('.imag').fadeIn('slow');
        jQuery('.imag a').text(img);
        jQuery('.imag a').attr('href', img);
        jQuery('.img').val(img);
    });
    jQuery(document).on('submit', '#upim', function (e) {
        e.preventDefault();
        var type = jQuery('#type').val();
        jQuery.ajax({
            url: url + 'user/upimg',
            type: 'POST',
            data: new FormData(jQuery('#upim')[0]),
            processData: false,
            contentType: false,
            beforeSend: function () {
                jQuery('.loading-image').show();
            },
            success: function (data) {
                console.log(data);
                if (data == 0) {
                    popup_fon('sube', translation.mm118 + ' ' + jQuery('section').attr('data-up') + 'MB.', 1500, 2000);
                } else if (data == 1) {
                } else if (data == 3) {
                    popup_fon('sube', translation.mm195, 1500, 2000);
                } else if (data == 4) {
                    popup_fon('sube', translation.mm196, 1500, 2000);
                } else if (data == 5) {
                } else {
                    if (type == 'video') {
                        jQuery('.the-video').val(data);
                        get_media(1, 'video');
                    } else {
                        jQuery('.the-img').val(data);
                        get_media(1, 'image');
                    }
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log('ERRORS: ' + textStatus);
            },
            complete: function () {
                jQuery('.loading-image').hide();
            }
        });
    });
    jQuery(document).on('click', '.media-gallery-images .show-image-preview', function () {
        jQuery('.media-gallery-images ul li.show-preview').fadeOut('slow');
        var index = jQuery('.media-gallery-images ul li').index(jQuery(this).closest('li'));
        index++;
        if(index !== posts.media_img) {
            var img = jQuery(this).closest('li').attr('data-image');
            jQuery('.media-gallery-images ul li').eq(index).html('<img src="' + img + '">');
            jQuery('.media-gallery-images ul li').eq(index).fadeIn('slow');
            posts.media_img = index;
        } else {
            posts.media_img = '';
        }
    });
    jQuery(document).on('click', '.media-gallery-images .delete-gallery-media', function () {
        var id = jQuery(this).closest('li').attr('data-id');
        var type = jQuery(this).closest('.media-gallery').attr('data-type');
        if(type == 'image') {
            var index = jQuery('.media-gallery-images ul li').index(jQuery(this).closest('li'));
        } else {
            var index = jQuery('.media-gallery-videos ul li').index(jQuery(this).closest('li'));
        }
        jQuery.ajax({
            url: url + 'user/delete-media/' + id,
            dataType: 'json',
            type: 'GET',
            success: function (data) {
                if(data) {
                    if(type == 'image') {
                        jQuery('.media-gallery-images ul li').eq(index).remove();
                        jQuery('.media-gallery-images ul li').eq(index).remove();
                    } else {
                        jQuery('.media-gallery-videos ul li').eq(index).remove();
                        jQuery('.media-gallery-videos ul li').eq(index).remove();                        
                    }
                    popup_fon('subi', data, 1500, 2000);
                    get_media(1, 'image');
                    get_media(1, 'video');
                } else {
                    popup_fon('sube', translation.mm3, 1500, 2000);
                }
            },
            error: function (data, jqXHR, textStatus) {
                console.log('Request failed: ' + textStatus);
                popup_fon('sube', translation.mm3, 1500, 2000);
            }
        });
    });   
    function media_pagination(total, type) {
        var limit = 10;
        if(type === 'image') {
            var page = posts.ipage;
            if(total > (page * limit)) {
                jQuery('.media-images-next').removeClass('disabled');
            } else {
                jQuery('.media-images-next').addClass('disabled');
            }
            if(page > 1) {
                jQuery('.media-images-back').removeClass('disabled');
            } else {
                jQuery('.media-images-back').addClass('disabled');
            }
        } else {
            var page = posts.vpage;
            if(total > (page * limit)) {
                jQuery('.media-videos-next').removeClass('disabled');
            } else {
                jQuery('.media-videos-next').addClass('disabled');
            }
            if(page > 1) {
                jQuery('.media-videos-back').removeClass('disabled');
            } else {
                jQuery('.media-videos-back').addClass('disabled');
            }            
        }
    }
    function get_media(page, type) {
        jQuery.ajax({
            url: url + 'user/get-media/' + type + '/' + page,
            dataType: 'json',
            type: 'GET',
            success: function (data) {
                if(type === 'image') {
                    if(data) {
                        jQuery('.media-gallery-images').show();
                        var allmedia = '';
                        media_pagination(data.total, 'image');
                        for (var u = 0; u < data.medias.length; u++) {
                            var body = data.medias[u].body;
                            body = body.replace(url + 'assets/share/', '');
                            allmedia += '<li data-id="' + data.medias[u].media_id + '" data-image="' + data.medias[u].body + '"><i class="fa fa-picture-o pull-left"></i> <span class="pull-left show-image-preview">' + body + '</span><div class="btn-group btn-group-info pull-right"><button class="btn btn-default add-gallery-image" type="button"><i class="fa fa-plus"></i></button><button class="btn btn-default delete-gallery-media" type="button"><i class="fa fa-trash-o"></i></button></div></li><li class="show-preview"></li>';
                        }
                        jQuery('.media-gallery-images').html('<ul>' + allmedia + '</ul>'); 
                        jQuery('.total-gallery-photos').html(data.total + ' photos');
                        if(data.total < 11) {
                            jQuery('.media-gallery-pagination').hide();
                        } else {
                            jQuery('.media-gallery-pagination').show();
                        }
                    } else {
                        jQuery('.media-gallery-pagination').hide();
                        jQuery('.media-gallery-images').hide();
                    }
                } else {
                    if(data) {
                        jQuery('.media-gallery-videos').show();
                        var allmedia = '';
                        media_pagination(data.total, 'video');
                        for (var u = 0; u < data.medias.length; u++) {
                            var body = data.medias[u].body;
                            body = body.replace(url + 'assets/share/', '');
                            allmedia += '<li data-id="' + data.medias[u].media_id + '" data-video="' + data.medias[u].body + '"><i class="fa fa-video-camera pull-left"></i> <span class="pull-left show-video-preview">' + body + '</span><div class="btn-group btn-group-info pull-right"><button class="btn btn-default add-gallery-video" type="button"><i class="fa fa-plus"></i></button><button class="btn btn-default delete-gallery-media" type="button"><i class="fa fa-trash-o"></i></button></div></li><li class="show-preview"></li>';
                        }
                        jQuery('.media-gallery-videos').html('<ul>' + allmedia + '</ul>'); 
                        jQuery('.total-gallery-videos').html(data.total + ' videos');
                        if(data.total < 11) {
                            jQuery('.video-gallery-pagination').hide();
                        } else {
                            jQuery('.video-gallery-pagination').show();
                        }
                    } else {
                        jQuery('.video-gallery-pagination').hide();
                        jQuery('.media-gallery-videos').hide();
                    }                    
                }
            },
            error: function (data, jqXHR, textStatus) {
                console.log('Request failed: ' + textStatus);
                if(type === 'image') {
                    jQuery('.media-gallery-pagination').hide();
                    jQuery('.media-gallery-images').hide();
                } else {
                    jQuery('.video-gallery-pagination').hide();
                    jQuery('.media-gallery-videos').hide();
                }
            }
        });
    }
    function prepareUpload(event) {
        jQuery('#upim').submit();
    }
    if(jQuery('.media-gallery').length > 0) {
        get_media(posts.ipage, 'image');
    }
});