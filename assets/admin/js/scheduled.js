jQuery(document).ready(function () {
    // this file contains send and update message's templates
    'use strict';
    var url = jQuery('.navbar-brand').attr('href');
    var start;
    jQuery('.only-unpublished').click(function ()
    {
        run_publishing(1);
    });
    jQuery('.all-publish').click(function ()
    {
        run_publishing(0);
    });
    function run_publishing(p)
    {
        // publish scheduled messages.
        var time = 3000; // at each 3 seconds the function will check if a postoponed message's time was expired and the message must be published.
        var limit = 1; // at each call, will be published 1 message. You can change the limit.
        jQuery('.publishing-run').show();
        start = setInterval(function ()
        {
            // submit data via ajax
            jQuery.ajax({
                url: url + 'admin/publish-scheduled/' + limit,
                type: 'GET',
                dataType: 'json',
                success: function (data)
                {
                    if (data < 1 && p === 1)
                    {
                        stopIt();
                    }
                    else if (data > 0)
                    {
                        var un = jQuery('.unpub').text();
                        un = parseInt(un) - parseInt(data);
                        jQuery('.unpub').text(un);
                        jQuery('.label-danger').text(un);
                        var expir = jQuery('.expir').text();
                        un = parseInt(expir) - parseInt(data);
                        if (un >= 0)
                        {
                            jQuery('.expir').text(un);
                        }
                    }
                },
                error: function (data, jqXHR, textStatus)
                {
                    console.log('Request failed: ' + textStatus);
                    stopIt();
                },
            });
        }, time);
    }
    function stopIt()
    {
        // stop publishing checking
        clearInterval(start);
        jQuery('.publishing-run').hide();
    }
});