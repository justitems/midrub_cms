
<!doctype html>
<html lang="en" class="h-100">
    <head>
        <meta charset="utf-8">
        <title><?php echo !empty($page_title)?$page_title:''; ?></title>
        <link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link href="//fonts.googleapis.com/css2?family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600&display=swap" rel="stylesheet">
        <style>
            .jumbotron {
                margin-bottom: 15px;
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
            
            .form-group {
                margin-bottom: 15px;
                padding: 15px;
                border: 0;
                border-top: 0;
                border-radius: 4px;
                background-color: #FFFFFF !important;
                -webkit-box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.08), 0 1px 2px 0 rgba(0, 0, 0, 0.03);
                box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.08), 0 1px 2px 0 rgba(0, 0, 0, 0.03);
            }

            .form-group .theme-text-input-1 {
                padding: 0 .75rem !important;
                width: 100%;
                height: 40px !important;
                border: 1px solid #dee2ed !important;
                border-radius: 2px;
                font-size: 14px !important;
            }

            .form-group .theme-text-input-1:focus,
            .form-group .theme-text-input-1:active,
            .form-group .theme-text-input-1:-webkit-autofill,
            .form-group .theme-text-input-1:-webkit-autofill:hover, 
            .form-group .theme-text-input-1:-webkit-autofill:focus, 
            .form-group .theme-text-input-1:-webkit-autofill:active {
                -webkit-box-shadow: 0 0 0 30px #FFFFFF inset !important;
            }

            .form-group .theme-text-input-1:focus,
            .form-group .theme-text-input-1:active {
                border: 1px solid #dee2ed !important;
                outline: 0 !important;
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
                <?php echo form_open(empty($callback_url)?$callback_url:'', array('data-csrf' => $this->security->get_csrf_token_name())) ?>
                    <div class="jumbotron">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="mb-0">
                                    <?php echo !empty($page_title)?$page_title:''; ?>
                                </h4>
                            </div>    
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                        <?php

                        // Verify if fields exists
                        if ( !empty($fields) ) {

                            // List the fields
                            foreach ( $fields as $field ) {

                                // Verify if the required fields exists
                                if ( empty($field['slug']) || empty($field['name']) || empty($field['type']) || empty($field['placeholder']) ) {
                                    continue;
                                }

                                ?>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12">
                                            <input type="text" name="<?php echo $field['slug']; ?>" class="theme-text-input-1" placeholder="<?php echo $field['placeholder']; ?>" />
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                        </div>
                    </div>
                    <div class="jumbotron-footer">
                        <div class="row">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-info btn-sm">
                                    <svg class="bi bi-box-arrow-in-up-right" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M14.5 3A1.5 1.5 0 0013 1.5H3A1.5 1.5 0 001.5 3v5a.5.5 0 001 0V3a.5.5 0 01.5-.5h10a.5.5 0 01.5.5v10a.5.5 0 01-.5.5H9a.5.5 0 000 1h4a1.5 1.5 0 001.5-1.5V3z" clip-rule="evenodd"/>
                                        <path fill-rule="evenodd" d="M4.5 6a.5.5 0 01.5-.5h5a.5.5 0 01.5.5v5a.5.5 0 01-1 0V6.5H5a.5.5 0 01-.5-.5z" clip-rule="evenodd"/>
                                        <path fill-rule="evenodd" d="M10.354 5.646a.5.5 0 010 .708l-8 8a.5.5 0 01-.708-.708l8-8a.5.5 0 01.708 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <?php echo $this->lang->line('user_networks_save'); ?>
                                </button>              
                            </div>                        
                        </div>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </main>
    </body>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</html>