<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $this->config->item('site_name') ?> | <?php echo isset($title)?$title:ucwords(str_replace('_',' ',$this->router->fetch_method())); ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="shortcut icon" href="<?php
        $favicon = get_option("favicon");
        if ($favicon): echo $favicon;
        else: echo base_url() . 'assets/img/favicon.png';
        endif;
        ?>" />
        
        <!-- Bootstrap -->
        <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/css/bootstrap.css"/>
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.2.0/css/all.css">
        
        <!-- Simple Line Icons -->
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css">
        
        <!-- Morris -->
        <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/css/morris.css" media="all">
        
        <!-- Date Time Picker -->
        <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/user/styles/css/bootstrap-datetimepicker.css" media="all">
        <?php
        
        echo custom_header();
        
        if ( isset($component_styles) ) {
            ?>
            <!-- Custom Styles -->
            <?php
            echo $component_styles;
        }

        if (file_exists( FCPATH . 'assets/admin/styles/css/custom.css' ) ) {
            
            echo "\n"
                . "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . base_url() . "assets/admin/styles/css/custom.css?ver=" . MD_VER . "\" media=\"all\"/>"
            ."\n";
        }
        ?>
        
        <?php if ( ($this->router->fetch_method() === 'notifications') ||
                ($this->router->fetch_method() === 'terms_policies') ||
                ($this->router->fetch_method() === 'all_guides') ||
                ($this->router->fetch_method() === 'new_faq_article') ||
                ($this->router->fetch_method() === 'faq_articles') ): ?>
            <link href="<?= base_url(); ?>assets/admin/summernote/dist/summernote.css" rel="stylesheet">
        <?php endif; ?>
            
    </head>
    <body>
        <header>
            <div class="container-fluid"> <a class="navbar-brand" href="<?= base_url(); ?>"><img src="<?php
                    $main_logo = get_option('main_logo');
                    if ($main_logo): echo $main_logo;
                    else: echo base_url() . '/assets/img/logo.png';
                    endif;
                    ?>" alt="<?= $this->config->item('site_name') ?>" width="32"></a>
                <ul class="nav navbar-nav navbar-left">
                    <li>
                        <a href="<?php echo site_url('admin/notifications') ?>" class="btn btn-labeled btn-primary">
                            <span class="btn-label">
                                <i class="icon-notebook"></i>
                            </span>
                            <?php echo $this->lang->line('ma8'); ?>
                        </a>
                    </li>
                    <li>
                        <button type="button" class="btn btn-labeled short-menu"> <i class="fa fa-bars fa-lg"></i> </button>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="<?php echo site_url('admin/support') ?>">
                            <i class="icon-question"></i>
                            <span class="label label-success"><?php echo $this->admin_header['all_tickets'] ?></span>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="<?php echo site_url('admin/update') ?>">
                            <i class="icon-cloud-download"></i>
                            <span class="label label-primary"><?php echo get_update_count(); ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('logout') ?>">
                            <i class="icon-logout"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </header>