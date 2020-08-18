<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $this->config->item('site_name') ?> | <?php echo $this->lang->line('api_get_autorization'); ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="shortcut icon" href="<?php
        $favicon = get_option('favicon');
        if ($favicon): echo $favicon;
        else: echo '/assets/img/favicon.png';
        endif;
        ?>" />
        
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.2.0/css/all.css">
        
        <!-- Simple Line Icons -->
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css">
        
        <!-- Midrub CSS -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/user/styles/css/style.css?ver=<?php echo MD_VER; ?>" media="all"/>
        
        <!-- Midrub Oauth CSS -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/user/styles/css/oauth.css?ver=<?php echo MD_VER; ?>" media="all"/>
        
    </head>
    <body>
        <div class="container-fluid authorize-page">
            <div class="authorize-content">
                <div class="row">
                    <div class="col-12 text-center">
                        <a class="home-page-link" href="<?php echo base_url(); ?>">
                            <img src="<?php
                            $main_logo = get_option('main-logo');
                            if ($main_logo) {
                                echo $main_logo;
                            } else {
                                echo base_url('assets/img/logo.png');
                            }
                            ?>" alt="<?= $this->config->item('site_name') ?>">
                        </a>
                        <hr>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2 text-center">
                        <i class="fas fa-cube"></i>
                    </div>
                    <div class="col-10">
                        <h3>
                            <?php
                                echo $application->application_name;
                            ?>
                        </h3>
                        <p>
                            <?php
                                echo $this->lang->line('api_would_like_permissions');
                            ?>
                        </p>
                    </div>                    
                </div>
                <div class="row">
                    <div class="col-12">
                        <ul>
                            <li>
                            <?php
                                echo $this->lang->line('api_user_profile');
                            ?>                                
                            </li>
                            <?php

                            if ( $all_permissions ) {

                                foreach ( $all_permissions as $permission ) {

                                    echo '<li>'
                                            . $permission
                                        . '</li>';

                                }

                            }
                            ?>
                        </ul>
                    </div>                    
                </div> 
                <div class="row">
                    <div class="col-12">
                        <?php $state = ($this->input->get('state', TRUE))?'&state=' . $this->input->get('state'):''; ?>
                        <a href="<?php if ( preg_match('/\?/i', $application->redirect_url) ): echo $application->redirect_url . '&code=' . $code; else: echo $application->redirect_url . '?code=' . $code . $state; endif; ?>" class="btn btn-success">
                            <?php
                                echo $this->lang->line('api_allow');
                            ?>                             
                        </a>
                        <a href="<?php echo $application->redirect_url; ?>" class="btn btn-default">
                            <?php
                                echo $this->lang->line('api_not_now');
                            ?>
                        </a>
                        <hr>
                    </div>                    
                </div>                 
            </div>
        </div>

        <!-- Optional JavaScript -->
        <script src="<?= base_url(); ?>assets/js/jquery.min.js"></script>
        
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
    </body>
</html>