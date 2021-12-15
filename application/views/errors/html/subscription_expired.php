<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $this->lang->line('default_errors_subscription_has_been_expired'); ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=2" />

        <!-- Bootstrap CSS -->
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" />

        <!-- Font Awesome -->
        <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.2.0/css/all.css">

        <!-- Simple Line Icons -->
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css">

        <!-- Subscription Expired CSS -->
        <link href="<?php echo base_url('assets/base/user/default/styles/css/subscription-expired.css'); ?>?ver=<?php echo MD_VER; ?>" rel="stylesheet" />

    </head>

    <body>
        <main role="main">
            <header>
                <div class="container">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="font-logo">
                            <a href="<?php echo site_url(); ?>">
                                <?php if ( md_the_option('frontend_theme_logo') ): echo '<img src="' . md_the_option('frontend_theme_logo') . '" class="logo">'; else: echo $this->config->item('site_name'); endif; ?>
                            </a>
                        </h5>
                        <div class="dropdown">
                            <a href="#" role="button" id="subscription-expired-sign-out-dropdown" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php echo $user_data->first_name?$user_data->first_name . ' ' . $user_data->last_name:$user_data->username; ?>
                                <svg class="bi bi-chevron-down" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 01.708 0L8 10.293l5.646-5.647a.5.5 0 01.708.708l-6 6a.5.5 0 01-.708 0l-6-6a.5.5 0 010-.708z" clip-rule="evenodd"></path>
                                </svg>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="subscription-expired-sign-out-dropdown">
                                <a href="<?php echo site_url('logout') ?>" class="dropdown-item">
                                    <?php echo $this->lang->line('default_errors_sign_out'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <section class="plans-page">
                <div class="container">
                    <?php if ( $upgrade ) { ?>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="subscription-expired-message">
                                    <div class="row">
                                        <div class="col-xl-9">
                                            <i class="icon-info"></i>
                                            <?php echo $upgrade; ?> 
                                        </div>
                                        <div class="col-xl-3 text-right">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="row">
                        <div class="col-12">
                            <h1>
                                <?php echo $this->lang->line('default_errors_choose_the_plan'); ?>
                            </h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h4>
                                <?php echo $this->lang->line('default_errors_renew_choose_another_plan'); ?>
                            </h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="<?php echo empty($plan['hidden'])?'col-md-12':'col-md-9'; ?>">
                            <div class="panel panel-default">
                                <?php if ( !empty($plan['hidden']) ) { ?>
                                <div class="panel-heading">
                                    <?php echo $this->lang->line('default_errors_all_public_plans'); ?>
                                </div>
                                <?php } ?>
                                <div class="panel-body">
                                    <?php if ( !empty($plans[0]['plans']) ) { ?>
                                    <div class="row">
                                        <div class="col-12 text-center">
                                            <?php
                                            
                                                // Set nav start
                                                echo '<ul class="nav plans-groups-nav justify-content-center" id="plans-tab" role="tablist">';

                                                // Set groups
                                                $groups = $plans;

                                                // List groups
                                                foreach ( $groups as $group ) {

                                                    // Nav active
                                                    $nav_active = ( $groups[0]['group_id'] === $group['group_id'] )?' active':'';

                                                    // Set nav's item
                                                    echo '<li class="theme-box-1 nav-item">'
                                                            . '<a class="nav-link' . $nav_active . '" id="tab-' . $group['group_id'] . '-tab" data-toggle="tab" href="#tab-' . $group['group_id'] . '" role="tab" aria-controls="tab-' . $group['group_id'] . '" aria-selected="true">'
                                                                . $group['group_name']
                                                            . '</a>'
                                                        . '</li>';


                                                }

                                                echo '</ul>';
                                            
                                            ?>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <div class="row">
                                    <?php

                                    // Verify if is not a group
                                    if ( empty($plans[0]['plans']) ) {

                                        // List all plans
                                        foreach ($plans as $the_plan) {

                                            // Default title
                                            $title = '';

                                            // Default short description
                                            $short_description = '';

                                            // Default displayed price
                                            $displayed_price = '';  

                                            // Default features
                                            $features = '';

                                            // Verify if the plan has text
                                            if ( !empty($plans_texts[$the_plan['plan_id']]) ) {

                                                // Texts container
                                                $texts = array();

                                                // List the texts
                                                foreach ( $plans_texts[$the_plan['plan_id']] as $the_text ) {

                                                    // Verify if name is title
                                                    if ( $the_text['text_name'] === 'title' ) {

                                                        // Set title
                                                        $texts['title'] = $the_text['text_value'];

                                                    } else if ( $the_text['text_name'] === 'short_description' ) {

                                                        // Set short description
                                                        $texts['short_description'] = $the_text['text_value'];

                                                    } else if ( $the_text['text_name'] === 'displayed_price' ) {

                                                        // Set displayed price
                                                        $texts['displayed_price'] = $the_text['text_value'];

                                                    } else {

                                                        // Verify if features exists
                                                        if ( !isset($texts['features']) ) {

                                                            // Set the features
                                                            $texts['features'] = array();

                                                        }

                                                        // Set the feature
                                                        $texts['features'][] = $the_text['text_value'];

                                                    }

                                                }

                                                // Verify if title exists
                                                if ( isset($texts['title']) ) {

                                                    // Set title
                                                    $title = $texts['title'];

                                                } 

                                                // Verify if short description exists
                                                if ( isset($texts['short_description']) ) {

                                                    // Set short description
                                                    $short_description = $texts['short_description'];

                                                }

                                                // Verify if displayed price exists
                                                if ( isset($texts['displayed_price']) ) {

                                                    // Set displayed price
                                                    $displayed_price = $texts['displayed_price'];

                                                }

                                                // Verify if features exists
                                                if ( isset($texts['features']) ) {
                                                    
                                                    // List features
                                                    foreach ( $texts['features'] as $feature ) {

                                                        // Set feature
                                                        $features .= '<tr>'
                                                            . '<td>'
                                                                . '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-circle" viewBox="0 0 16 16">'
                                                                    . '<path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>'
                                                                    . '<path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>'
                                                                . '</svg>'
                                                                . $feature
                                                            . '</td>'
                                                        . '</tr>';                                                        

                                                    }

                                                }  

                                            }

                                            ?>
                                            <div class="card col">
                                                <div class="card-header">
                                                    <h2>
                                                        <?php echo $title; ?>
                                                    </h2>
                                                    <h3>
                                                    </h3>
                                                    <h5>
                                                        <?php echo $displayed_price; ?>
                                                    </h5>                                         
                                                </div>
                                                <div class="card-body">
                                                    <table class="table">
                                                        <tbody>
                                                            <?php
                                                            
                                                            // Display features
                                                            echo $features;

                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="card-footer">
                                                    <?php if ( $plan['plan_id'] === $the_plan['plan_id'] ) { ?>
                                                    <a href="<?php echo site_url('error/subscription-expired?p=order&plan=' . $the_plan['plan_id']); ?>" class="btn btn-success plans-renew-plan" role="button">
                                                        <?php echo $this->lang->line('default_errors_renew'); ?>
                                                    </a>
                                                    <?php } else { ?>
                                                    <a href="<?php echo site_url('error/subscription-expired?p=order&plan=' . $the_plan['plan_id']); ?>" class="btn btn-success code" role="button">
                                                        <?php echo $this->lang->line('default_errors_order_now'); ?>
                                                    </a>
                                                    <?php } ?>
                                                </div>  
                                            </div>
                                            <?php

                                        }

                                    } else if ( !empty($plans[0]['plans']) ) { 

                                        // Set tabs
                                        echo '<div class="col-12">'
                                                . '<div class="tab-content" id="plans-tabs-parent">';

                                        // Set groups
                                        $groups = $plans;

                                        // List groups
                                        foreach ( $groups as $group ) {

                                            // Tab active
                                            $tab_active = ( $groups[0]['group_id'] === $group['group_id'] )?' show active':'';

                                            // Set Tab Start
                                            echo '<div class="tab-pane fade' . $tab_active . '" id="tab-' . $group['group_id'] . '" role="tabpanel" aria-labelledby="tab-' . $group['group_id'] . '-tab">';

                                            // Set row
                                            echo '<div class="row">';

                                            // Get group's plans
                                            $plans = $group['plans'];

                                            // List all plans
                                            foreach ($plans as $the_plan) {

                                                // Default title
                                                $title = '';

                                                // Default short description
                                                $short_description = '';

                                                // Default displayed price
                                                $displayed_price = '';  

                                                // Default features
                                                $features = '';

                                                // Verify if the plan has text
                                                if ( !empty($plans_texts[$the_plan['plan_id']]) ) {

                                                    // Texts container
                                                    $texts = array();

                                                    // List the texts
                                                    foreach ( $plans_texts[$the_plan['plan_id']] as $the_text ) {

                                                        // Verify if name is title
                                                        if ( $the_text['text_name'] === 'title' ) {

                                                            // Set title
                                                            $texts['title'] = $the_text['text_value'];

                                                        } else if ( $the_text['text_name'] === 'short_description' ) {

                                                            // Set short description
                                                            $texts['short_description'] = $the_text['text_value'];

                                                        } else if ( $the_text['text_name'] === 'displayed_price' ) {

                                                            // Set displayed price
                                                            $texts['displayed_price'] = $the_text['text_value'];

                                                        } else {

                                                            // Verify if features exists
                                                            if ( !isset($texts['features']) ) {

                                                                // Set the features
                                                                $texts['features'] = array();

                                                            }

                                                            // Set the feature
                                                            $texts['features'][] = $the_text['text_value'];

                                                        }

                                                    }

                                                    // Verify if title exists
                                                    if ( isset($texts['title']) ) {

                                                        // Set title
                                                        $title = $texts['title'];

                                                    } 

                                                    // Verify if short description exists
                                                    if ( isset($texts['short_description']) ) {

                                                        // Set short description
                                                        $short_description = $texts['short_description'];

                                                    }

                                                    // Verify if displayed price exists
                                                    if ( isset($texts['displayed_price']) ) {

                                                        // Set displayed price
                                                        $displayed_price = $texts['displayed_price'];

                                                    }

                                                    // Verify if features exists
                                                    if ( isset($texts['features']) ) {
                                                        
                                                        // List features
                                                        foreach ( $texts['features'] as $feature ) {

                                                            // Set feature
                                                            $features .= '<tr>'
                                                                . '<td>'
                                                                    . '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-circle" viewBox="0 0 16 16">'
                                                                        . '<path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>'
                                                                        . '<path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>'
                                                                    . '</svg>'
                                                                    . $feature
                                                                . '</td>'
                                                            . '</tr>';                                                        

                                                        }

                                                    }  

                                                }

                                                ?>
                                                <div class="card col">
                                                    <div class="card-header">
                                                        <h2>
                                                            <?php echo $title; ?>
                                                        </h2>
                                                        <h3>
                                                            
                                                        </h3>
                                                        <h5>
                                                            <?php echo $displayed_price; ?>
                                                        </h5>                                         
                                                    </div>
                                                    <div class="card-body">
                                                        <table class="table">
                                                            <tbody>
                                                                <?php

                                                                // Display features
                                                                echo $features;
                                                                
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="card-footer">
                                                        <?php if ( $plan['plan_id'] === $the_plan['plan_id'] ) { ?>
                                                        <a href="<?php echo site_url('error/subscription-expired?p=order&plan=' . $the_plan['plan_id']); ?>" class="btn btn-success plans-renew-plan" role="button">
                                                            <?php echo $this->lang->line('default_errors_renew'); ?>
                                                        </a>
                                                        <?php } else { ?>
                                                        <a href="<?php echo site_url('error/subscription-expired?p=order&plan=' . $the_plan['plan_id']); ?>" class="btn btn-success code" role="button">
                                                            <?php echo $this->lang->line('default_errors_order_now'); ?>
                                                        </a>
                                                        <?php } ?>
                                                    </div>  
                                                </div>
                                                <?php

                                            }

                                            // End row
                                            echo '</div>';

                                            // Set Tab End
                                            echo '</div>';

                                        }

                                        // Set Tabs End
                                        echo '</div></div>';

                                    }
                                    ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if ( !empty($plan['hidden']) ) { ?>

                        <?php

                        // Default title
                        $title = '';

                        // Default short description
                        $short_description = '';

                        // Verify if the plan has text
                        if ( !empty($plans_texts[$plan['plan_id']]) ) {

                            // Texts container
                            $texts = array();

                            // List the texts
                            foreach ( $plans_texts[$plan['plan_id']] as $the_text ) {

                                // Verify if name is title
                                if ( $the_text['text_name'] === 'title' ) {

                                    // Set title
                                    $texts['title'] = $the_text['text_value'];

                                } else if ( $the_text['text_name'] === 'short_description' ) {

                                    // Set short description
                                    $texts['short_description'] = $the_text['text_value'];

                                }

                            }

                            // Verify if title exists
                            if ( isset($texts['title']) ) {

                                // Set title
                                $title = $texts['title'];

                            }

                        }

                        ?>

                        <div class="col-md-3">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <?php echo $this->lang->line('default_errors_hidden_plan'); ?>
                                </div>
                                <div class="panel-body pl-0">
                                    <div class="card col">
                                        <div class="card-header">
                                            <h2>
                                                <?php echo $title; ?>
                                            </h2>
                                            <h3>
                                                <?php echo $short_description; ?>
                                            </h3>
                                            <h5>
                                                <?php echo $plan['currency_sign']; ?> <?php echo $plan['plan_price']; ?>
                                            </h5>                                         
                                        </div>
                                        <div class="card-footer">
                                            <a href="<?php echo site_url('error/subscription-expired?p=order&plan=' . $plan['plan_id']); ?>" class="btn btn-success plans-renew-plan" role="button">
                                                <?php echo $this->lang->line('default_errors_renew'); ?>
                                            </a>
                                        </div>  
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>                       
                    </div>                        
                </div>
            </section>
        </main>

        <!-- jQuery -->
        <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>

        <!-- Bootstrap CSS -->
        <script src=//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js></script>

        <!-- Bootstrap CSS -->
        <script src=//stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js></script>

    </body>
</html>