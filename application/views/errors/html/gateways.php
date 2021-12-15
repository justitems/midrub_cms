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

        <!-- Set website url -->
        <meta name="url" content="<?php echo site_url(); ?>">

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
                                <img src="https://www.gravatar.com/avatar/<?php echo $this->user_email; ?>" class="img-fluid rounded-circle z-depth-0" width="30">
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
            <section class="gateways-page">
                <div class="container-fluid" data-price="<?php echo $plan_data[0]['plan_price']; ?>">
                    <div class="row">
                        <div class="col-xl-4 offset-xl-4">
                            <div class="col-xl-12">
                                <div class="panel panel-success mb-4">
                                    <div class="panel-heading border-bottom-0">
                                        <h3>
                                            <?php echo $this->lang->line('default_errors_total'); ?>
                                            <span class="float-right subscription-expired-price">
                                                <?php echo $plan_data[0]['plan_price']; ?>
                                            </span>
                                            <span class="float-right">
                                                <?php echo $plan_data[0]['currency_sign']; ?>
                                            </span>
                                            <span class="float-right subscription-expired-discount-price">
                                                <?php echo isset($discount)?'(' . $this->lang->line('default_errors_discount') . ' ' . $discount . '%)':''; ?>
                                            </span>
                                        </h3>
                                    </div>
                                </div>
                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <h3>
                                            <?php echo $this->lang->line('default_errors_select_payment_method'); ?>
                                        </h3>
                                    </div>
                                    <div class="panel-body">
                                        <ul>
                                        <?php

                                        // Verify if payments gateways are available
                                        if ( md_the_gateways() ) {

                                            // Fields
                                            $fields = array();

                                            // Verify if discount exists
                                            if ( isset($discount) ) {

                                                // Set discount value
                                                $fields['discount_value'] = $discount . '%';

                                                // Set discount code
                                                $fields['discount_code'] = $discount_code;

                                            }

                                            // Options
                                            $options = array(
                                                'plan_id' => $plan_data[0]['plan_id'],
                                                'success_redirect' => site_url('error/subscription-expired'),
                                                'error_redirect' => site_url('error/subscription-expired'),
                                                'recurring_payments' => 'on'
                                            );

                                            // Verify if option exists
                                            if ( isset($discount) ) {

                                                // Set discount code
                                                $options['discount_code'] = $discount_code;

                                            }

                                            // Register payment's data
                                            $gateway_url = $this->session->set_flashdata('incomplete_transaction', array(
                                                'pay' => array(
                                                    'amount' => $plan_data[0]['plan_price'],
                                                    'currency' => $plan_data[0]['currency_code'],
                                                    'sign' => $plan_data[0]['currency_sign']
                                                ),
                                                'fields' => $fields,
                                                'options' => $options
                                            ));

                                            // List all enabled payments
                                            foreach ( md_the_gateways() as $payment ) {

                                                // Get gateway's slug
                                                $gateway_slug = array_keys($payment);

                                                // Display the gateway
                                                echo '<li>'
                                                        . '<div class="row">'
                                                            . '<div class="col-lg-2 col-sm-2 col-xs-2 col-2 p-0 text-center">'
                                                                . $payment[$gateway_slug[0]]['gateway_icon']
                                                            . '</div>'
                                                            . '<div class="col-lg-7 col-sm-7 col-xs-7 col-7 p-0">'
                                                                . '<h3>'
                                                                    . $payment[$gateway_slug[0]]['gateway_name']
                                                                . '</h3>'
                                                            . '</div>'
                                                            . '<div class="col-lg-3 col-sm-3 col-xs-3 col-3 p-0 text-center">'
                                                                . '<a href="' . site_url('payments/' . $gateway_slug[0] . '/pay') . '" class="pay-now">'
                                                                    . $this->lang->line('default_errors_pay_now')
                                                                . '</a>'
                                                            . '</div>'                                
                                                        . '</div>'
                                                    . '</li>';
                                                    
                                            }
                                            
                                        } else {

                                            // No gateways found
                                            echo '<li class="no-payments-found">'
                                                    . $this->lang->line('default_errors_no_payments')
                                                . '</li>';

                                        }
                                        ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <!-- jQuery -->
        <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>

        <!-- POPPER JS -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>

        <!-- Bootstrap JS -->
        <script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

        <!-- Main JS -->
        <script src="<?php echo base_url('assets/js/main.js'); ?>?ver=<?php echo MD_VER; ?>5"></script>        

        <!-- Subscription Expired JS -->
        <script src="<?php echo base_url('assets/base/user/default/js/subscription-expired.js'); ?>?ver=<?php echo MD_VER; ?>5"></script>        

    </body>
</html>