<!doctype html>
<html lang="en">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php get_the_site_favicon(); ?>

    <!-- Title -->
    <title><?php md_get_the_title(); ?></title>

    <!-- Set website url -->
    <meta name="url" content="<?php echo site_url(); ?>">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.5.1/css/bootstrap.min.css">

    <!-- CRM CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/base/user/themes/collection/crm/styles/css/main.css?ver=' . MD_VER); ?>" media="all" />

    <!-- Remix Icons -->
    <link href="//cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

    <!-- Google Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp">

    <!-- Styles -->
    <?php get_the_css_urls(); ?>

    <?php get_the_header(); ?>

</head>

<body class="d-flex flex-column h-100 theme-font-1 theme-color-black">

    <div class="wrapper main" data-csrf="<?php echo $this->security->get_csrf_token_name(); ?>" data-csrf-value="<?php echo $this->security->get_csrf_hash(); ?>">
        <nav class="sidebar">
            <?php
            md_get_menu(
                'sidebar_top_menu',
                array(
                    'before_menu' => '<ul class="sidebar-header">',
                    'before_single_item' => '<li[active]><a href="[url]"><i class="[class]"></i><span>[text]</span></a>',
                    'after_single_item' => '</li>',
                    'after_menu' => '</ul>',
                    'before_submenu' => '<ul>',
                    'after_submenu' => '</ul>'                        
                )
            );
            ?> 
            <ul class="sidebar-bottom">
                <?php
                md_get_menu(
                    'sidebar_bottom_menu',
                    array(
                        'before_menu' => '',
                        'before_single_item' => '<li[active]><a href="[url]"><i class="[class]"></i><span>[text]</span></a>',
                        'after_single_item' => '</li>',
                        'after_menu' => '',
                        'before_submenu' => '<ul>',
                        'after_submenu' => '</ul>'                        
                    )
                );
                ?>
                <li>
                    <?php echo get_the_site_logo(); ?>
                </li>
            </ul>
        </nav>

        <?php get_user_view(); ?>

    </div>

    <div class="theme-apps-menu-box">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="input-group">
                    <input type="text" placeholder="<?php echo $this->lang->line('theme_search_for_apps'); ?>" class="form-control crm-search-for-apps-menu" />
                    <?php if ( md_the_team_role_permission('crm_apps') ) { ?>
                    <a href="<?php echo site_url('user/app/crm_apps'); ?>" class="btn btn-light input-group-append">
                        <span class="material-icons-outlined">
                            playlist_add
                        </span>
                    </a>
                    <?php } ?>
                </div>
            </div>
            <div class="panel-body theme-font-1">
                <div class="list-group">
                </div>
            </div>
        </div>
    </div>


    <div class="page-loading">
        <div class="animation-area">
            <div></div>
            <div></div>
        </div>
    </div>

    <div class="theme-notifications-popups">
        <div class="theme-notifications-popup theme-notifications-error-banner">
        </div>
        <div class="theme-notifications-popup theme-notifications-news-banner">
        </div>
        <div class="theme-notifications-popup theme-notifications-fixed-banner">
        </div>
    </div>
    <div class="theme-notifications-promo">
        <div class="theme-notifications-promo-banner">
        </div>
    </div>

    <!-- Theme JS -->
    <script src="//code.jquery.com/jquery-3.5.1.js"></script>
    <script src="//cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="//stackpath.bootstrapcdn.com/bootstrap/4.5.1/js/bootstrap.min.js"></script>
    <?php get_the_footer(); ?>
    <script src="<?php echo base_url('assets/base/user/themes/collection/crm/js/main.js?ver=' . MD_VER); ?>"></script>
    <?php get_the_js_urls(); ?>

    <script language="javascript">
        Main.translation = {
            theme_days: "<?php echo $this->lang->line('theme_days'); ?>",
            theme_ago: "<?php echo $this->lang->line('theme_ago'); ?>",
            theme_just_now: "<?php echo $this->lang->line('theme_just_now'); ?>",
            theme_minutes: "<?php echo $this->lang->line('theme_minutes'); ?>",
            theme_hours: "<?php echo $this->lang->line('theme_hours'); ?>",
            theme_prev: "<?php echo $this->lang->line('theme_prev'); ?>",
            theme_next: "<?php echo $this->lang->line('theme_next'); ?>",
            theme_s: "<?php echo $this->lang->line('theme_s'); ?>",
            theme_m: "<?php echo $this->lang->line('theme_m'); ?>",
            theme_t: "<?php echo $this->lang->line('theme_t'); ?>",
            theme_w: "<?php echo $this->lang->line('theme_w'); ?>",
            theme_tu: "<?php echo $this->lang->line('theme_tu'); ?>",
            theme_f: "<?php echo $this->lang->line('theme_f'); ?>",
            theme_su: "<?php echo $this->lang->line('theme_su'); ?>",
            theme_january: "<?php echo $this->lang->line('theme_january'); ?>",
            theme_february: "<?php echo $this->lang->line('theme_february'); ?>",
            theme_march: "<?php echo $this->lang->line('theme_march'); ?>",
            theme_april: "<?php echo $this->lang->line('theme_april'); ?>",
            theme_may: "<?php echo $this->lang->line('theme_may'); ?>",
            theme_june: "<?php echo $this->lang->line('theme_june'); ?>",
            theme_july: "<?php echo $this->lang->line('theme_july'); ?>",
            theme_august: "<?php echo $this->lang->line('theme_august'); ?>",
            theme_september: "<?php echo $this->lang->line('theme_september'); ?>",
            theme_october: "<?php echo $this->lang->line('theme_october'); ?>",
            theme_november: "<?php echo $this->lang->line('theme_november'); ?>",
            theme_december: "<?php echo $this->lang->line('theme_december'); ?>",
            theme_drag_drop_files_here: "<?php echo $this->lang->line('theme_drag_drop_files_here'); ?>",
            theme_choose_file: "<?php echo $this->lang->line('theme_choose_file'); ?>",
            theme_files_supported: "<?php echo $this->lang->line('theme_files_supported'); ?>",
            icon_bi_x: '<?php echo md_the_user_icon(array('icon' => 'bi_x')); ?>',
        }
    </script>
   
    </body>

</html>