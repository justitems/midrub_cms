jQuery(document).ready(function() {
    'use strict';
    var url = jQuery('.navbar-brand').attr('href');
    var tickets = {
        'page': 1,
        'limit': 10,
    };
    jQuery(document).on('click', '.pagination li a', function (e) {
        e.preventDefault();
        tickets.page = jQuery(this).attr('data-page');
        get_tickets(jQuery(this).attr('data-page'));
    });
    jQuery(document).on('click', '.tickets .delete-ticket', function (e) {
        e.preventDefault();
        // this function deletes tickets from database
        var id = jQuery(this).attr('data-id');
        jQuery.ajax({
            url: url + 'admin/delete-ticket/' + id,
            dataType: 'json',
            type: 'GET',
            success: function (data) {
                if (data == 1) {
                    Main.popup_fon('subi', translation.mi29, 1500, 2000);
                    if ((jQuery('.delete-ticket').length < 2)) {
                        get_tickets(1);
                        tickets.page = 1;
                    } else {
                        get_tickets(tickets.page);
                    }
                } else {
                    Main.popup_fon('sube', translation.mm3, 1500, 2000);
                }
            },
            error: function (data, jqXHR, textStatus) {
                console.log('Request failed: ' + textStatus);
                Main.popup_fon('sube', translation.mm3, 1500, 2000);
            }
        });
    });
    jQuery(document).on('click', '.tickets .delete-question', function (e) {
        e.preventDefault();
        // this function deletes tickets from database
        var $this = jQuery(this);
        var id = $this.attr('data-id');
        jQuery.ajax({
            url: url + 'admin/delete-question/' + id,
            dataType: 'json',
            type: 'GET',
            success: function (data) {
                if (data == 1) {
                    Main.popup_fon('subi', translation.mi27, 1500, 2000);
                    $this.closest('.single-question').remove();
                    if(jQuery('.single-question').length < 1) {
                        jQuery('.questions').html('<div class="col-lg-12 mess-stat"><ul><li>' + translation.mm200 + '</li></ul></div>');
                    }
                } else {
                    Main.popup_fon('sube', translation.mm3, 1500, 2000);
                }
            },
            error: function (data, jqXHR, textStatus) {
                console.log('Request failed: ' + textStatus);
                Main.popup_fon('sube', translation.mm3, 1500, 2000);
            }
        });
    });
    jQuery(document).on('keyup', '.search_post', function (e) {
        e.preventDefault();
        // this function searches questions from database
        var key = jQuery(this).val();
        var encode = btoa(encodeURIComponent(key));
        encode = encode.replace('/', '-');
        key = encode.replace(/=/g, '');
        jQuery('.fa-binoculars').hide();
        // change search icon
        jQuery('.search-m').addClass('search-active');
        jQuery.ajax({
            url: url + 'user/questions/' + key,
            dataType: 'json',
            type: 'GET',
            success: function (data) {
                if(data) {
                    var questions = '';
                    for(var g = 0; g < data.length; g++) {
                        questions += '<div class="col-lg-12 single-question"><div class="mm-single-result"><h3>' + data[g].question + '</h3><p>' + data[g].response + '</p><p><a href="#" class="delete-question" data-id="' + data[g].question_id + '">' + translation.mi26 + '</a></p></div></div>';
                    }
                    jQuery('.questions').html(questions);
                } else {
                    jQuery('.questions').html('<div class="col-lg-12 mess-stat"><ul><li>' + translation.mm200 + '</li></ul></div>');
                }
            },
            error: function (data, jqXHR, textStatus) {
                console.log('Request failed: ' + textStatus);
                jQuery('.questions').html('<div class="col-lg-12 mess-stat"><ul><li>' + translation.mm200 + '</li></ul></div>');
            },
        });
    });
    jQuery(document).on('click', '.search-active', function (e) {
        e.preventDefault();
        jQuery('.fa-binoculars').show();
        resetall();
    });
    function resetall() {
        jQuery('.search_post').val('');
        jQuery('.search-m').removeClass('search-active');
        jQuery('.questions').html('<div class="col-lg-12 mess-stat"><ul><li>' + translation.mm200 + '</li></ul></div>');
    }
    function no_tickets() {
        jQuery('.pagination').hide();
        return '<ul><li>' + translation.mm201 + '</li></ul>';
    }
    function get_tickets(page) {
        jQuery.ajax({
            url: url + 'admin/get-all-tickets/' + page + '/tickets',
            dataType: 'json',
            type: 'GET',
            success: function (data) {
                if (data) {
                    var alltickets = '';
                    show_pagination(data.total)
                    for (var u = 0; u < data.tickets.length; u++) {
                        var status = (data.tickets[u].status == 1)?'<span class="label label-success">' + translation.mi30 + '</span>':(data.tickets[u].status == 2)?'<span class="label label-primary">' + translation.mi31 + '</span>':'<span class="label label-default">' + translation.mi32 + '</span>';
                        alltickets += '<tr><td width="80%"><h3>' + data.tickets[u].subject + ' </h3>' + status + '</td><td width="10%"><a href="' + url + 'admin/get-ticket/' + data.tickets[u].ticket_id + '" class="btn btn-primary btn-xs"><i class="fa fa-search"></i></a></td><td width="10%"><button class="btn btn-danger btn-xs delete-ticket" data-id="' + data.tickets[u].ticket_id + '">Delete</button></td></tr>';
                    }
                    jQuery('.display-tickets-here').html(alltickets);
                } else {
                    jQuery('.mess-stat').html(no_tickets());
                }
            },
            error: function (data, jqXHR, textStatus) {
                console.log('Request failed:' + textStatus);
                jQuery('.mess-stat').html(no_tickets());
            },
        });
    }
    function show_pagination(total) {
        // the code bellow displays pagination
        jQuery('.pagination').empty();
        if (parseInt(tickets.page) > 1) {
            var bac = parseInt(tickets.page) - 1;
            var pages = '<li><a href="#" data-page="' + bac + '">' + translation.mm128 + '</a></li>';
        } else {
            var pages = '<li class="pagehide"><a href="#">' + translation.mm128 + '</a></li>';
        }
        var tot = parseInt(total) / parseInt(tickets.limit);
        tot = Math.ceil(tot) + 1;
        var from = (parseInt(tickets.page) > 2) ? parseInt(tickets.page) - 2 : 1;
        for (var p = from; p < parseInt(tot); p++) {
            if (p === parseInt(tickets.page)) {
                pages += '<li class="active"><a data-page="' + p + '">' + p + '</a></li>';
            } else if ((p < parseInt(tickets.page) + 3) && (p > parseInt(tickets.page) - 3)) {
                pages += '<li><a href="#" data-page="' + p + '">' + p + '</a></li>';
            } else if ((p < 6) && (Math.round(tot) > 5) && ((parseInt(tickets.page) == 1) || (parseInt(tickets.page) == 2))) {
                pages += '<li><a href="#" data-page="' + p + '">' + p + '</a></li>';
            } else {
                break;
            }
        }
        if (p === 1) {
            pages += '<li class="active"><a data-page="' + p + '">' + p + '</a></li>';
        }
        var next = parseInt(tickets.page);
        next++;
        if (next < Math.round(tot)) {
            jQuery('.pagination').html(pages + '<li><a href="#" data-page="' + next + '">' + translation.mm129 + '</a></li>');
        } else {
            jQuery('.pagination').html(pages + '<li class="pagehide"><a href="#">' + translation.mm129 + '</a></li>');
        }
    }
    get_tickets(tickets.page);
});