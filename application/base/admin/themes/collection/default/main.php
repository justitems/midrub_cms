<!DOCTYPE html>
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
        <link href="//cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />

        <!-- Default Theme Styles -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/base/admin/themes/collection/default/styles/css/main.css?ver=' . MD_VER); ?>" media="all">    

        <!-- Styles -->
        <?php md_get_the_css_urls(); ?>

    </head>
    <body class="d-flex flex-column h-100">
        <div class="wrapper main" data-csrf="<?php echo $this->security->get_csrf_token_name(); ?>" data-csrf-value="<?php echo $this->security->get_csrf_hash(); ?>">
            <nav class="sidebar">
                <ul class="sidebar-header">
                    <?php

                    // Get the admin's menu
                    $admin_menu = md_the_admin_menu();

                    // Verify if admin menu exists
                    if ( $admin_menu ) {

                        // List the menu's items
                        foreach ( $admin_menu as $item ) {

                            // Verify if item's parent exists
                            if ( !empty($item['item_parent']) ) {
                                continue;
                            }

                            // Set active class
                            $active = (current_url() === $item['item_url'])?' class="active"':'';

                            // Submenu
                            $submenu = '';

                            // Get the menu item's childrens
                            $admin_sub_menu = md_the_admin_menu(array('item_parent' => $item['item_slug']));

                            // Verify if submenu exists
                            if ( $admin_sub_menu ) {

                                // Set list
                                $submenu .= '<ul>';

                                // List the submenu's items
                                foreach ( $admin_sub_menu as $item ) {

                                    // Set active class
                                    $active = (current_url() === $item['item_url'])?' class="active"':'';

                                    // Append item
                                    $submenu .= '<li' . $active . '>'
                                        . '<a href="' . $item['item_url'] . '">'
                                            . $item['item_icon']
                                            . '<span>'
                                                . $item['item_name']
                                            . '</span>'
                                        . '</a>'
                                    . '</li>';

                                }

                                // End list
                                $submenu .= '</ul>';

                            }

                            // Display item
                            echo '<li' . $active . '>'
                                . '<a href="' . $item['item_url'] . '">'
                                    . $item['item_icon']
                                    . '<span>'
                                        . $item['item_name']
                                    . '</span>'
                                . '</a>'
                                . $submenu
                            . '</li>';

                        }

                    }
                    
                    ?>                                                                           
                </ul>
                <ul class="sidebar-bottom">
                    <li>
                        <a href="#" class="theme-profile-image">
                            <?php 
                            
                            // Get the user's image
                            $user_image = md_the_user_image($this->user_id);
                            
                            // Display the image
                            echo $user_image?'<img src="' . $user_image[0]['body'] . '" alt="Midrub" width="32">':'<img src="' . base_url('assets/img/avatar-placeholder.png') . '" alt="Midrub" width="32">';
                            ?>
                            
                        </a>
                        <ul>
                            <?php
                            
                            // Get the menu item's childrens
                            $admin_sub_menu = md_the_admin_menu(array('item_parent' => 'account'));

                            // Verify if submenu exists
                            if ( $admin_sub_menu ) {

                                // List the submenu's items
                                foreach ( $admin_sub_menu as $item ) {

                                    // Set active class
                                    $active = (current_url() === $item['item_url'])?' class="active"':'';

                                    // Display item
                                    echo '<li' . $active . '>'
                                        . '<a href="' . $item['item_url'] . '">'
                                            . $item['item_icon']
                                            . '<span>'
                                                . $item['item_name']
                                            . '</span>'
                                        . '</a>'
                                    . '</li>';

                                }

                                // Display the separator
                                echo '<li class="default-sidebar-menu-items-separator"></li>';

                            }
                            ?>                          
                            <li>
                                <a href="<?php echo site_url('logout'); ?>">
                                    <?php echo md_the_admin_icon(array('icon' => 'sign_out')); ?>
                                    <span>
                                        <?php echo $this->lang->line('theme_sign_out'); ?>
                                    </span>
                                </a>
                            </li>                                                                                                           
                        </ul>                        
                    </li>
                </ul>
            </nav>
            <?php md_get_admin_view(); ?>
        </div>
        <div class="theme-page-loading">
            <div class="theme-animation-area">
                <div></div>
                <div></div>
            </div>
        </div>
        <div class="theme-save-changes">
            <div class="row">
                <div class="col-md-6">
                    <p>
                        <?php echo md_the_admin_icon(array('icon' => 'warning')); ?>
                        <?php echo $this->lang->line('theme_you_have_unsaved_changes'); ?>
                    </p>
                </div>
                <div class="col-md-6">
                    <div class="btn-group" role="group" aria-label="Unsaved changes">
                        <button type="button" class="btn btn-primary theme-changes-btn theme-cancel-changes-btn">
                                <?php echo md_the_admin_icon(array('icon' => 'cancel')); ?>
                                <?php echo $this->lang->line('theme_cancel'); ?>
                        </button>
                        <button type="button" class="btn btn-primary theme-changes-btn theme-save-changes-btn">
                                <?php echo md_the_admin_icon(array('icon' => 'save')); ?>
                                <?php echo $this->lang->line('theme_save'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>
        <script src="//code.iconify.design/2/2.0.3/iconify.min.js"></script>
        <script src="<?php echo base_url('assets/js/main.js?ver=') . MD_VER ?>"></script>
        <script src="<?php echo base_url('assets/base/admin/themes/collection/default/js/main.js?ver=') . MD_VER ?>"></script>
        <?php md_get_the_js_urls(); ?>
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
                theme_icon_plus: '<?php echo md_the_admin_icon(array('icon' => 'plus')); ?>',
                theme_icon_arrow_right: '<?php echo md_the_admin_icon(array('icon' => 'arrow_right')); ?>',
                theme_icon_arrow_ltr: '<?php echo md_the_admin_icon(array('icon' => 'arrow_ltr')); ?>',
                theme_icon_arrow_rtl: '<?php echo md_the_admin_icon(array('icon' => 'arrow_rtl')); ?>'
            }
        </script>
    </body>
</html>