
<!doctype html>
<html lang="en" class="h-100">
    <head>
        <meta charset="utf-8">
        <title><?php echo $this->lang->line('networks_connect'); ?> <?php echo ucfirst($connect); ?></title>
        <link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link href="//fonts.googleapis.com/css2?family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600&display=swap" rel="stylesheet">
        <style>
            .jumbotron {
                padding: 15px;
                background-color: transparent;
                -webkit-box-shadow: 0 0 20px rgba(27,22,66,.04), 0 16px 38px rgba(27,22,66,0.03);
                box-shadow: 0 0 20px rgba(27,22,66,.04), 0 16px 38px rgba(27,22,66,0.03);
            }

            .jumbotron h4 {
                margin: 0;
                padding: 0;
                line-height: 30px;
                font-family: 'DM Sans', sans-serif;
                font-weight: 400;
                font-size: 18px;
                color: #272727;
            }

            .jumbotron .col-6 {
                font-size: 13px;
            }

            .jumbotron .progress {
                height: 5px;
                background-color: #f3f8ff;
            }

            .jumbotron .progress .progress-bar {
                background-color: #6658e9 !important;
            }

            .card {
                position: relative;
                margin-bottom: 20px;
                border: 0;
                background-color: #FFFFFF;
                -webkit-box-shadow: 0 2px 3px rgba(18,38,63,.03);
                box-shadow: 0 2px 3px rgba(18,38,63,.03);
            }

            .card h3 {
                margin: 0;
                padding: 0;
                font-family: 'DM Sans', sans-serif;
                font-weight: 400;
                font-size: 16px;                
                color: #3c4858;
            }

            .card p {
                margin: 5px 0 0 0;
                padding: 0;
                font-size: 13px;
                color: #8492a6;
            }

            .checkbox-option {
                width: 100%;
                text-align: right;
            }

            .checkbox-option input[type=checkbox] {
                display: none;
            }

            .checkbox-option input[type=text] {
                margin-top: 2px;
                padding: 0 7px;
                width: 100%;
                height: 35px;
                line-height: 35px;
                border: 1px solid #c1c7cd;
                color: #1b2733;
                
            }

            .checkbox-option label {
                position: relative;
                margin-right:15px;
                margin-top: 20px;                
                width: 50px;
                cursor: pointer;
            }

            .checkbox-option label::before {
                content: '';
                position: absolute;
                margin-top: -5px;
                margin-left: -45px;
                width: 50px;
                height: 10px;
                border-radius: 3px;
                background-color: #f3f8ff;
                transition: all 0.4s ease-in-out;
            }

            .checkbox-option label::after {
                content: '';
                position: absolute;
                top: -4px;
                left: -4px;
                margin-top: -6px;
                width: 20px;
                height: 20px;
                border-radius: 5px;
                background-color: #AFB6C2;
                transition: all 0.3s ease-in-out;
            }

            input[type=checkbox]:checked + label::after {
                left: 40px;
                background-color: #6658e9;
                box-shadow: none;
            } 

            .jumbotron-footer {
                position: static;
                padding: 15px;
                width: 100%;
                background-color: transparent;
                -webkit-box-shadow: 0 0 10px rgba(27,22,66,.04), 0 16px 25px rgba(27,22,66,0.03);
                box-shadow: 0 0 10px rgba(27,22,66,.04), 0 16px 25px rgba(27,22,66,0.03);
            }

            .jumbotron-footer h6 {
                margin: 0;
                padding: 0;
                line-height: 30px;
                font-family: 'DM Sans', sans-serif;
                font-weight: 400;
                font-size: 15px;                
                color: #3c4858;
            }

            .jumbotron-footer h6 .bi {
                margin: -4px 7px 0 0;
            }

            .jumbotron-footer .btn-info {
                padding: 3px 20px 5px;
                color: #fff;
                background-color: #335eea;
                border-color: #335eea;
                box-shadow: none;
            }

            .jumbotron-footer .btn-info:hover,
            .jumbotron-footer .btn-info:active,
            .jumbotron-footer .btn-info:focus {
                background-color: #335eea !important;
                border-color: #335eea !important;
                box-shadow: none !important;
                outline: none !important;
                opacity: 0.7;
            }

            .jumbotron-footer .btn-info .bi {
                margin: -3px 7px 0 0;
            }

            .md-message {
                display: none;
                position: fixed;
                z-index: 9999;
                margin: auto;
                padding: 15px;
                left: 0;
                right: 0;
                bottom: 15px;
                width: 80%;
                min-width: 250px;
                min-height: 20px;
                border-radius: 3px;
                font-size: 17px;
                font-weight: 400;
                font-family: 'Nunito Sans', sans-serif;
                -webkit-animation: mdmess 0.3s;
                animation: mdmess 0.3s;
            }

            .md-message.sube {
                color: #FFFFFF;
                background-color: #ea6759;
                border-color: #ea6759;         
            }

            .md-message.sube .bi {
                float: left;
                margin: 4px 10px 0 0;
            }

            @-webkit-keyframes mdmess {

                0% {
                    opacity: 0.5;
                    -webkit-transform: scale(0.7);
                }
                
                100% {
                    opacity: 1;
                    -webkit-transform: scale(1);
                }

            }

            @keyframes mdmess {

                0% {
                    opacity: 0.5;
                    transform: scale(0.7);
                }
                
                100% {
                    opacity: 1;
                    transform: scale(1);
                }

            }

        </style>
    </head>
    <body class="d-flex flex-column h-100">
        <main role="main" class="flex-shrink-0">
            <div class="container-fluid">
                <?php echo form_open($callback, array('data-csrf' => $this->security->get_csrf_token_name())) ?>
                    <div class="jumbotron">
                        <div class="row">
                            <div class="col-sm-6">
                                <h4 class="mb-0">
                                    <?php echo $title; ?>
                                </h4>
                            </div>
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-6">
                                        <span class="total-selected-items"><?php echo $connected_accounts; ?></span> <?php echo $connect; ?>
                                    </div>
                                    <div class="col-6 text-right">
                                        <span class="total-allowed-items"><?php echo $network_accounts; ?></span> <?php echo $connect; ?>
                                    </div>                                
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="progress">
                                            <div class="progress-bar bg-success" style="width: <?php echo (100 - (($network_accounts - $connected_accounts) / ($network_accounts)) * 100); ?>%;" role="progressbar" aria-valuemin="0" aria-valuenow="<?php echo (100 - (($network_accounts - $connected_accounts) / ($network_accounts)) * 100); ?>" aria-valuemax="100"></div>
                                        </div>
                                    </div>                                
                                </div>                            
                            </div>                        
                        </div>
                    </div>
                    <div class="row">
                        <?php
                        if ( $items ) {

                            foreach ( $items as $item ) {
                                ?>
                                <div class="col-sm-6">
                                    <div class="card widget-flat">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-9">                                
                                                    <div class="float-right">
                                                        <i class="mdi mdi-account-multiple widget-icon"></i>
                                                    </div>
                                                    <h3><?php echo $item['name']; ?></h3>
                                                    <p class="text-muted">
                                                        <?php echo $item['label']; ?>
                                                    </p>
                                                </div>
                                                <div class="col-3">
                                                    <div class="checkbox-option">
                                                        <input id="item-<?php echo $item['net_id']; ?>" name="net_ids[]" type="checkbox" value="<?php echo $item['net_id']; ?>"<?php echo ($item['connected'])?' checked':''; ?>>
                                                        <label for="item-<?php echo $item['net_id']; ?>"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <div class="jumbotron-footer" data-connected-accounts="<?php echo $connected_accounts; ?>" data-total-accounts="<?php echo $network_accounts; ?>">
                        <div class="row">
                            <div class="col-sm-6">
                                <h6 class="mb-0">
                                    <svg class="bi bi-check-box" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M15.354 2.646a.5.5 0 010 .708l-7 7a.5.5 0 01-.708 0l-3-3a.5.5 0 11.708-.708L8 9.293l6.646-6.647a.5.5 0 01.708 0z" clip-rule="evenodd"/>
                                        <path fill-rule="evenodd" d="M1.5 13A1.5 1.5 0 003 14.5h10a1.5 1.5 0 001.5-1.5V8a.5.5 0 00-1 0v5a.5.5 0 01-.5.5H3a.5.5 0 01-.5-.5V3a.5.5 0 01.5-.5h8a.5.5 0 000-1H3A1.5 1.5 0 001.5 3v10z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="selected-items"><?php echo $connected_accounts; ?></span> <?php echo $this->lang->line('networks_selected'); ?> <?php echo ucfirst($connect); ?>
                                </h6>
                            </div>
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-12 text-right">
                                        <button type="submit" class="btn btn-info btn-sm">
                                            <svg class="bi bi-box-arrow-in-up-right" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M14.5 3A1.5 1.5 0 0013 1.5H3A1.5 1.5 0 001.5 3v5a.5.5 0 001 0V3a.5.5 0 01.5-.5h10a.5.5 0 01.5.5v10a.5.5 0 01-.5.5H9a.5.5 0 000 1h4a1.5 1.5 0 001.5-1.5V3z" clip-rule="evenodd"/>
                                                <path fill-rule="evenodd" d="M4.5 6a.5.5 0 01.5-.5h5a.5.5 0 01.5.5v5a.5.5 0 01-1 0V6.5H5a.5.5 0 01-.5-.5z" clip-rule="evenodd"/>
                                                <path fill-rule="evenodd" d="M10.354 5.646a.5.5 0 010 .708l-8 8a.5.5 0 01-.708-.708l8-8a.5.5 0 01.708 0z" clip-rule="evenodd"/>
                                            </svg>
                                            <?php echo $this->lang->line('networks_save'); ?>
                                        </button>
                                    </div>                                
                                </div>                           
                            </div>                        
                        </div>
                    </div>
                    <?php
                    if ( $inputs ) {

                        foreach ( $inputs as $input ) {

                            echo '<input type="hidden" name="' . key($input) . '" value="' . $input[key($input)] . '">';

                        }

                    }
                    ?>
                <?php echo form_close(); ?>
            </div>
        </main>
        <div class="md-message sube">
            <svg class="bi bi-exclamation-circle" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M8 15A7 7 0 108 1a7 7 0 000 14zm0 1A8 8 0 108 0a8 8 0 000 16z" clip-rule="evenodd"/>
                <path d="M7.002 11a1 1 0 112 0 1 1 0 01-2 0zM7.1 4.995a.905.905 0 111.8 0l-.35 3.507a.552.552 0 01-1.1 0L7.1 4.995z"/>
            </svg>
            <?php echo str_replace('[type]', $connect, $this->lang->line('networks_reached_maximum_number_of_accounts')); ?>
        </div>
    </body>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        $('.checkbox-option').click(function(e) {
            
            if ( ($('input:checkbox:checked').length) > parseInt($('.jumbotron-footer').attr('data-total-accounts')) ) {

                // Display alert
                $( '.md-message' ).show();

                // Hide alert
                setTimeout(function () {

                    $( '.md-message' ).hide();

                }, 2000);

                e.preventDefault();
                return;

            }
            
            setTimeout(function() {

                $('.jumbotron-footer .selected-items').text($('input:checkbox:checked').length + parseInt($('.jumbotron-footer').attr('data-connected-accounts')));

                var percentage = (100 - (((parseInt($('.jumbotron-footer').attr('data-total-accounts')) - ($('input:checkbox:checked').length + parseInt($('.jumbotron-footer').attr('data-connected-accounts')))) / (parseInt($('.jumbotron-footer').attr('data-total-accounts')))) * 100));

                $('.progress-bar').css('width', percentage + '%');
                $('.progress-bar').attr('aria-valuenow', percentage);

                $('.total-selected-items').text($('input:checkbox:checked').length + parseInt($('.jumbotron-footer').attr('data-connected-accounts')));

            }, 500);

        });

        if ( parseInt($('.jumbotron-footer').attr('data-total-accounts')) > 0 ) {

            var connected = (parseInt($('.jumbotron-footer').attr('data-connected-accounts')) - $('input:checkbox:checked').length);

            $('.jumbotron-footer').attr('data-connected-accounts', connected);

        }
    </script>
</html>