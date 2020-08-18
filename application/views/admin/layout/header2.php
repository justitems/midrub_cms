<!doctype html>
<html lang="en">
    
<head>

    <!-- Title -->
    <title><?php md_get_the_title(); ?></title>

    <!-- Required meta tags -->
    <meta charset="utf-8">

    <!-- Set the initial zoom level when the page is first loaded -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <?php md_get_the_website_favicon(); ?>

    <!-- Start temporary content -->

    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/css/bootstrap.css" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.9.0/css/all.css">

    <!-- Simple Line Icons -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css">

    <!-- Morris -->
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/css/morris.css" media="all">

    <!-- Date Time Picker -->
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/user/styles/css/bootstrap-datetimepicker.css" media="all">
    <?php

    echo custom_header();

    if (isset($component_styles)) {
        ?>
        <!-- Custom Styles -->
        <?php
        echo $component_styles;
    }

    if (file_exists(FCPATH . 'assets/admin/styles/css/custom.css')) {

        echo "\n"
            . "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . base_url() . "assets/admin/styles/css/custom.css?ver=" . MD_VER . "\" media=\"all\"/>"
            . "\n";
    }
    ?>

    <!-- End temporary content -->
    <?php md_get_the_meta_description(); ?>
    <?php md_get_the_meta_keywords(); ?>

    <!-- Styles -->
    <?php md_get_the_css_urls(); ?>

</head>

<body>

    <header>
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= base_url(); ?>">
                <img src="<?php md_get_dashboard_logo(); ?>" alt="<?= $this->config->item('site_name') ?>" width="32">
            </a>
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
                        <span class="label label-success"><?php echo $admin_header['all_tickets'] ?></span>
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