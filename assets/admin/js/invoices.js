jQuery(document).ready(function () {
    'use strict';
    
    var url = jQuery( '.navbar-brand' ).attr( 'href' );
    
    var invoices = {
        'page': 1,
        'limit': 10,
    };
    
    jQuery( '.reload-invoice' ).click(function () {
        
        // Get invoice settings
        get_invoice_settings();
        
    });
    
    jQuery( document ).on('change', '.search-by-user, .from-date, .to-date',function () {

        // Get all invoices by page
        get_invoices(1);
        
        // Hide invoice details
        jQuery( '.invoice-details' ).fadeOut('fast');
        
    });
    
    // Set format
    jQuery('.from-date, .to-date').datetimepicker({
        format: 'yyyy-mm-dd hh:ii',
        pickerPosition: 'bottom-left'
    });
    
    jQuery( document ).on( 'click', '.invoices .get-invoice-details', function () {
        
        // Hide invoice details
        jQuery( '.invoice-details' ).fadeOut('fast');
        
        // Get invoice id
        var invoice_id = jQuery(this).attr('data-id');
        
        // submit data via ajax
        jQuery.ajax({
            url: url + 'admin/get-invoice/' + invoice_id,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                
                if ( data ) {
                    
                    jQuery( '.transaction-id' ).text( data.transaction_id );
                    jQuery( '.invoice-created-date' ).text( data.invoice_date );
                    jQuery( '.billing-period-from' ).text( data.from_period );
                    jQuery( '.billing-period-to' ).text( data.to_period );
                    jQuery( '.invoice-hello-text' ).html( data.invoice_title );
                    jQuery( '.invoice-message' ).html( data.invoice_text );
                    jQuery( '.invoice-amount' ).text( data.invoice_amount );
                    jQuery( '.invoice-taxes-value' ).text( data.invoice_taxes );
                    jQuery( '.invoice-total-value' ).text( data.invoice_total );
                    jQuery( '.invoice-plan-name' ).text( data.plan_name );
                    
                    // Display invoice details
                    jQuery( '.invoice-details' ).fadeIn('slow');
                    
                }
                
            },
            error: function (data, jqXHR, textStatus) {
                console.log('Request failed:' + textStatus);
            }
        });
        
    });
    
    jQuery( document ).on( 'click', '.invoices .delete-invoice', function () {
        
        // Get invoice id
        var invoice_id = jQuery(this).attr('data-id');
        
        // submit data via ajax
        jQuery.ajax({
            url: url + 'admin/delete-invoice/' + invoice_id,
            type: 'GET',
            dataType: 'json',
            success: function (data) {

                if ( data ) {
                    
                    // Hide invoice details
                    jQuery( '.invoice-details' ).fadeOut('fast');   
                    
                    // Get all invoices by page
                    get_invoices(1);
                    
                    // Display success alert
                    Main.popup_fon('subi', translation.ma212, 1500, 2000);
                    
                } else {
                    
                    // Display error alert
                    Main.popup_fon('sube', translation.mm103, 1500, 2000);
                    
                }
                
            },
            error: function (data, jqXHR, textStatus) {
                console.log('Request failed:' + textStatus);
                
                // Display error alert
                Main.popup_fon('sube', translation.mm103, 1500, 2000);
            }
        });
        
    }); 
    
    // Send again the invoice
    jQuery( document ).on( 'click', '.invoices .send-invoice-again', function () {
        
        // Get invoice id
        var invoice_id = jQuery(this).attr('data-id');
        
        // submit data via ajax
        jQuery.ajax({
            url: url + 'admin/send-invoice/' + invoice_id,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                
                if ( data ) {
                    
                    // Display success alert
                    Main.popup_fon('subi', translation.ma214, 1500, 2000);
                    
                } else {
                    
                    // Display error alert
                    Main.popup_fon('sube', translation.mm103, 1500, 2000);
                    
                }
                
            },
            error: function (data, jqXHR, textStatus) {
                console.log('Request failed:' + textStatus);
                
                // Display error alert
                Main.popup_fon('sube', translation.mm103, 1500, 2000);
            }
        });
        
    });     
    
    /*
     * Display posts based on clicked pagination's number
     */
    jQuery(document).on('click', '.pagination li a', function (e) {
        e.preventDefault();
        
        invoices.page = jQuery(this).attr('data-page');
        
        get_invoices(jQuery(this).attr('data-page'));
        
    });

    function show_pagination(total) {

        // the code bellow displays pagination
        jQuery('.pagination').empty();

        if ( parseInt(invoices.page) > 1 ) {

            var bac = parseInt(invoices.page) - 1;
            var pages = '<li><a href="#" data-page="' + bac + '">' + translation.mm128 + '</a></li>';

        } else {

            var pages = '<li class="pagehide"><a href="#">' + translation.mm128 + '</a></li>';

        }

        var tot = parseInt(total) / parseInt(invoices.limit);

        tot = Math.ceil(tot) + 1;

        var from = (parseInt(invoices.page) > 2) ? parseInt(invoices.page) - 2 : 1;

        for ( var p = from; p < parseInt(tot); p++ ) {

            if ( p === parseInt(invoices.page) ) {

                pages += '<li class="active"><a data-page="' + p + '">' + p + '</a></li>';

            } else if ( (p < parseInt(invoices.page) + 3) && (p > parseInt(invoices.page) - 3) ) {

                pages += '<li><a href="#" data-page="' + p + '">' + p + '</a></li>';

            } else if ( (p < 6) && (Math.round(tot) > 5) && ((parseInt(invoices.page) == 1) || (parseInt(invoices.page) == 2)) ) {

                pages += '<li><a href="#" data-page="' + p + '">' + p + '</a></li>';

            } else {

                break;

            }

        }

        if ( p === 1 ) {

            pages += '<li class="active"><a data-page="' + p + '">' + p + '</a></li>';

        }

        var next = parseInt(invoices.page);

        next++;

        if ( next < Math.round(tot) ) {

            jQuery('.pagination').html(pages + '<li><a href="#" data-page="' + next + '">' + translation.mm129 + '</a></li>');

        } else {

            jQuery('.pagination').html(pages + '<li class="pagehide"><a href="#">' + translation.mm129 + '</a></li>');

        }

    }
    
    function get_invoices(page) {
        
        // Set the csrf code
        var name = jQuery('input[name="csrf_test_name"]').val();
        
        // Get user
        var user = jQuery('.search-by-user').val();
        
        // Get from date value
        var from_date = jQuery('.from-date').val();     
        
        // Get to date value
        var to_date = jQuery('.to-date').val();         
        
        // Create an object with form data
        var data = {'user': user, 'from_date': from_date, 'to_date': to_date, 'csrf_test_name': name};
        
        // Empty pagination
        jQuery('.pagination').empty();
        
        // submit data via ajax
        jQuery.ajax({
            url: url + 'admin/get-invoices/' + page,
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function (data) {
                
                if ( data ) {
                    
                    show_pagination(data.total);
                    
                    jQuery('#mytable').show();
                    
                    jQuery('.no-invoices-found').hide();
                    
                    var all_invoices = '';
                    
                    for ( var d = 0; d < data.invoices.length; d++ ) {
                        
                        var status = translation.ma211;
                        
                        if ( data.invoices[d].status ) {
                            
                            status = translation.ma210;
                            
                        }
                        
                        all_invoices += '<tr>';
                            all_invoices += '<td>' + status + '</td>';
                            all_invoices += '<td><a href="' + url + 'admin/users#' + data.invoices[d].user_id + '">' + data.invoices[d].username + '</td>';
                            all_invoices += '<td>' + data.invoices[d].invoice_date + '</td>';
                            all_invoices += '<td>' + data.invoices[d].gateway + '</td>';
                            all_invoices += '<td><p data-placement="top" data-toggle="tooltip" title="View"><button class="btn btn-primary btn-xs get-invoice-details" data-title="View" data-toggle="modal" data-target="#edit" data-id="' + data.invoices[d].invoice_id + '"><span class="fa fa-eye"></span></button></p></td>';
                            all_invoices += '<td><p data-placement="top" data-toggle="tooltip" title="Send Again"><button class="btn btn-warning btn-xs send-invoice-again" data-title="Send Again" data-toggle="modal" data-target="#send-again" data-id="' + data.invoices[d].invoice_id + '"><span class="fa fa-share-square"></span></button></p></td>';
                            all_invoices += '<td><p data-placement="top" data-toggle="tooltip" title="Delete"><button class="btn btn-danger btn-xs delete-invoice" data-title="Delete" data-toggle="modal" data-target="#delete" data-id="' + data.invoices[d].invoice_id + '"><span class="glyphicon glyphicon-trash"></span></button></p></td>';
                        all_invoices += '</tr>';
                        
                    }
            
                    jQuery('.all-invoices').html(all_invoices);
                    
                } else {
                    
                    jQuery('#mytable').hide();
                    
                    jQuery('.no-invoices-found').show();
                    
                }
                
            },
            error: function (data, jqXHR, textStatus) {
                console.log(data);
                jQuery('#mytable').hide();
                jQuery('.no-invoices-found').show();
            }
            
        });
        
    }
    
    function get_invoice_settings() {
        
        // submit data via ajax
        jQuery.ajax({
            url: url + 'admin/get-invoice-settings',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                
                // Add logo
                if ( data.invoice_logo ) {
                    
                    jQuery( '.invoice-logo' ).attr('src', data.invoice_logo);
                    
                }
                
                // Add billing period word
                if ( data.billing_period ) {
                    
                    jQuery( '.invoice-billing-period' ).html(data.billing_period);
                    
                }   
                
                // Add the transaction id word
                if ( data.transaction_id ) {
                    
                    jQuery( '.invoice-transaction-id' ).html(data.transaction_id);
                    
                }                
                
                // Add hello text
                if ( data.hello_text ) {
                    
                    jQuery( '.invoice-hello-text' ).html(data.hello_text);
                    
                }   
                
                // Add invoice message
                if ( data.invoice_message ) {
                    
                    jQuery( '.invoice-message' ).html(data.invoice_message);
                    
                }  
                
                // Add invoice date word
                if ( data.date ) {
                    
                    jQuery( '.invoice-date' ).html(data.date);
                    
                }  
                
                // Add invoice date format
                if ( data.invoice_date ) {
                    
                    jQuery( '.invoice-settings .invoice-date-format' ).html(data.invoice_date);
                    
                }   
                
                // Add invoice description word
                if ( data.description ) {
                    
                    jQuery( '.invoice-description' ).html(data.description);
                    
                }    
                
                // Add invoice description text
                if ( data.description_text ) {
                    
                    jQuery( '.invoice-description-text' ).html(data.description_text);
                    
                }
                
                // Add invoice taxes word
                if ( data.taxes ) {
                    
                    jQuery( '.invoice-taxes' ).html(data.taxes);
                    
                }
                
                // Add invoice taxes value
                if ( data.taxes_value ) {
                    
                    jQuery( '.taxes-area' ).show();
                    
                    jQuery( '.invoice-taxes-value' ).html( data.taxes_value + ' %' );
                    
                } else {
                    
                    jQuery( '.taxes-area' ).hide();
                    
                }                
                
                // Add invoice total word
                if ( data.total ) {
                    
                    jQuery( '.invoice-total' ).html(data.total);
                    
                } 
                
                // Add invoice no reply message
                if ( data.no_reply ) {
                    
                    jQuery( '.invoice-no-reply' ).html(data.no_reply);
                    
                }  
                
                // Add invoice amount word
                if ( data.amount ) {
                    
                    jQuery( '.amount' ).html(data.amount);
                    
                }                 
                
            },
            error: function (data, jqXHR, textStatus) {
                console.log('Request failed:' + textStatus);
            }
        });
        
    }
    
    if ( jQuery( '.invoice-settings' ).length > 0 ) {
        
        get_invoice_settings();
        
    } else {
        
        get_invoices(1);
        
        get_invoice_settings();
        
    }
    
});