<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <title><?php md_get_the_title(); ?></title>

    <!-- Set website url -->
    <meta name="url" content="<?php echo site_url(); ?>">
    <?php md_get_the_meta_description(); ?>
    <?php md_get_the_meta_keywords(); ?>

    <?php if ( md_the_option('frontend_theme_favicon') ): ?>
    <!-- Favicon-->
    <link rel="shortcut icon" href="<?php echo md_the_option('frontend_theme_favicon'); ?>" />
    <?php endif; ?>    

    <!-- Frontend CRM Styles -->
    <link rel="stylesheet" id="crm-styles-css" href="<?php echo md_the_theme_uri(); ?>styles/css/main.css?ver=0.3" type="text/css" media="all" />

    <!-- Fontisto -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fontisto@v3.0.4/css/fontisto/fontisto.min.css"></i>

    <!-- Line Awesome -->
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

    <?php md_get_the_frontend_header(); ?>

</head>

<body>

    <main role="main" class="main" data-csrf="<?php echo get_instance()->security->get_csrf_token_name(); ?>" data-csrf-value="<?php echo get_instance()->security->get_csrf_hash(); ?>">
        <header>
            <div class="container">
                <nav class="navbar navbar-expand-lg">
                    <a href="<?php echo site_url(); ?>" title="<?php md_get_the_title(); ?>" class="navbar-brand navbar-brand-mobile">
                        <?php if ( md_the_option('frontend_theme_logo') ): echo the_crm_website_logo(); else: echo md_the_site_name(); endif; ?>
                    </a>                    
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#theme-rsponsive-menu-collapse" aria-controls="theme-rsponsive-menu-collapse" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="las la-bars"></i>
                        <i class="las la-times"></i>
                    </button>
                
                    <div class="collapse navbar-collapse justify-content-between" id="theme-rsponsive-menu-collapse">
                        <span></span>
                        <?php

                        // Display main menu
                        md_get_frontend_menu(
                            'main_menu',
                            array(
                                'before_menu' => '<ul class="navbar-nav mr-auto">',
                                'before_single_item' => '<li class="nav-item"><a href="[url]" class="nav-link[active]">[text]',
                                'after_single_item' => '</a></li>',
                                'after_menu' => '</ul>',
                                'before_single_item_with_submenu' => '<li class="nav-item dropdown"><a href="#" class="nav-link dropdown-toggle" id="menu-submenu-dropdown-[unique_id]" role="button" data-bs-toggle="dropdown" aria-expanded="false">[text]<i class="las la-angle-down"></i></a>',
                                'before_submenu' => '<ul class="dropdown-menu" aria-labelledby="menu-submenu-dropdown-[unique_id]">',
                                'after_submenu' => '</ul>',
                                'before_submenu_single_item' => '<li><a href="[url]" class="dropdown-item[active]">[text]',
                                'after_submenu_single_item' => '</a></li>',  
                            )
                        );

                        // Verify if session exists
                        if ( md_the_user_session() ) {

                            // Set sign in url
                            $sign_in = md_the_url_by_page_role('sign_in')?md_the_url_by_page_role('sign_in'):site_url('auth/signin');

                            ?>
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item dropdown">
                                    <a href="#" class="nav-link dropdown-toggle" id="theme-user-menu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <?php echo md_the_user_session()['first_name']?md_the_user_session()['first_name'] . ' ' . md_the_user_session()['last_name']:md_the_user_session()['username']; ?>
                                        <i class="las la-angle-down"></i>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="theme-user-menu">
                                        <li>
                                            <a href="<?php echo $sign_in; ?>" class="dropdown-item">
                                                <?php md_get_the_string('theme_dashboard'); ?>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo site_url('logout'); ?>" class="dropdown-item">
                                                <?php md_get_the_string('theme_sign_out'); ?>
                                            </a>
                                        </li>
                                    </ul>                                    
                                </li>
                            </ul>
                            <?php

                        } else {

                            // Display the access menu
                            md_get_frontend_menu(
                                'access_menu',
                                array(
                                    'before_menu' => '<div class="btn-group">',
                                    'before_single_item' => '<a href="[url]" class="btn btn-primary [class]">[text]',
                                    'after_single_item' => '</a>',
                                    'after_menu' => '</div>'
                                )
                            );

                        }
                        ?>
                    </div>
                </nav>                    
            </div>
        </header>