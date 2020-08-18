var codes = {
    'page': 1,
    'limit': 10,
};

function show_pagination(total) {
    
    // the code bellow displays pagination
    jQuery('.pagination').empty();
    
    if ( parseInt(codes.page) > 1 ) {
        
        var bac = parseInt(codes.page) - 1;
        var pages = '<li><a href="#" data-page="' + bac + '">' + translation.mm128 + '</a></li>';
        
    } else {
        
        var pages = '<li class="pagehide"><a href="#">' + translation.mm128 + '</a></li>';
        
    }
    
    var tot = parseInt(total) / parseInt(codes.limit);
    
    tot = Math.ceil(tot) + 1;
    
    var from = (parseInt(codes.page) > 2) ? parseInt(codes.page) - 2 : 1;
    
    for ( var p = from; p < parseInt(tot); p++ ) {
        
        if ( p === parseInt(codes.page) ) {
            
            pages += '<li class="active"><a data-page="' + p + '">' + p + '</a></li>';
            
        } else if ( (p < parseInt(codes.page) + 3) && (p > parseInt(codes.page) - 3) ) {
            
            pages += '<li><a href="#" data-page="' + p + '">' + p + '</a></li>';
            
        } else if ( (p < 6) && (Math.round(tot) > 5) && ((parseInt(codes.page) == 1) || (parseInt(codes.page) == 2)) ) {
            
            pages += '<li><a href="#" data-page="' + p + '">' + p + '</a></li>';
            
        } else {
            
            break;
            
        }
        
    }
    
    if ( p === 1 ) {
        
        pages += '<li class="active"><a data-page="' + p + '">' + p + '</a></li>';
        
    }
    
    var next = parseInt(codes.page);
    
    next++;
    
    if ( next < Math.round(tot) ) {

        jQuery('.pagination').html(pages + '<li><a href="#" data-page="' + next + '">' + translation.mm129 + '</a></li>');
        
    } else {
        
        jQuery('.pagination').html(pages + '<li class="pagehide"><a href="#">' + translation.mm129 + '</a></li>');
        
    }
    
}

function get_coupon_codes(page) {
    
    var url = jQuery('.navbar-brand').attr('href');
    jQuery.ajax({
        url: url + 'admin/coupon-codes/' + page,
        dataType: 'json',
        type: 'GET',
        success: function (data) {

            if ( data ) {

                var all_coupons = '';

                show_pagination(data.total);

                for ( var c = 0; c < data.coupons.length; c++ ) {

                    all_coupons += '<li>' + data.coupons[c].code + '<span> - ' + data.coupons[c].value + ' %</span> <button type="button" class="btn btn-danger pull-right delete-coupon" data-coupon="' + data.coupons[c].coupon_id + '"><i class="fa fa-times"></i></button></li>';

                }

                jQuery( '.coupons-list .coupon-codes' ).html( all_coupons );

            } else {
                
                jQuery( '.coupons-list .coupon-codes' ).html( '<p>No coupon codes found.</p>' );

            }

        },
        error: function (data, jqXHR, textStatus) {
            console.log('Request failed:' + textStatus);
            jQuery( '.coupons-list .coupon-codes' ).html( '<p>No coupon codes found.</p>' );
        }
    });
}

jQuery(document).ready(function () {
    'use strict';
    
    var url = jQuery('.navbar-brand').attr('href');
    
    jQuery(document).on('click', '.pagination li a', function (e) {
        e.preventDefault();
        
        codes.page = jQuery(this).attr('data-page');
        get_coupon_codes(jQuery(this).attr('data-page'));
        
    });
    
    jQuery(document).on('click', '.coupon-codes .delete-coupon', function (e) {
        e.preventDefault();
        
        var coupon = jQuery(this).attr('data-coupon');

        jQuery.ajax({
            url: url + 'admin/delete-code/' + coupon,
            dataType: 'json',
            type: 'GET',
            success: function (data) {
                
                if ( data ) {
                    
                    Main.popup_fon(data[0], data[1], 1500, 2000);
                    
                    if ( data[0] ) {
                        
                        get_coupon_codes(1);
                        
                    }
                    
                }
                
            },
            error: function (data, jqXHR, textStatus) {
                console.log('Request failed:' + textStatus);
            }
        });
        
    });    
    
    get_coupon_codes(1);
    
});