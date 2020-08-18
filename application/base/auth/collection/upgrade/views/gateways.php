<div class="container-fluid">
    <main id="main" class="site-main main">
        <section class="gateways-page">
            <div class="container-fluid" data-price="<?php echo $plan_data[0]->plan_price; ?>">
                <div class="row">
                    <div class="col-xl-4 offset-xl-4">
                        <div class="col-xl-12">
                            <div class="panel panel-success mb-4">
                                <div class="panel-heading border-bottom-0">
                                    <h3>
                                        <?php echo $this->lang->line('upgrade_total'); ?>
                                        <span class="pull-right plan-price">
                                            <?php echo $plan_data[0]->plan_price ?>
                                        </span>
                                        <span class="pull-right">
                                            <?php echo $plan_data[0]->currency_sign ?>
                                        </span>
                                        <span class="pull-right discount-price">
                                            <?php echo isset($discount)?'(' . $this->lang->line('upgrade_discount') . ' ' . $discount . '%)':''; ?>
                                        </span>
                                    </h3>
                                </div>
                            </div>
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <h3>
                                        <?php echo $this->lang->line('upgrade_select_payment_method'); ?>
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
                                            'plan_id' => $plan_data[0]->plan_id,
                                            'success_redirect' => site_url('auth/upgrade?p=success'),
                                            'error_redirect' => site_url('auth/upgrade'),
                                            'recurring_payments' => 'on'
                                        );

                                        // Verify if option exists
                                        if ( isset($discount) ) {

                                            // Set discount code
                                            $options['discount_code'] = $discount_code;

                                        }

                                        // Register payment's data
                                        $gateway_url = generate_incomplete_transaction(array(
                                            'pay' => array(
                                                'amount' => $plan_data[0]->plan_price,
                                                'currency' => $plan_data[0]->currency_code,
                                                'sign' => $plan_data[0]->currency_sign
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
                                                        . '<div class="col-lg-2 col-sm-2 col-xs-2 col-2 clean text-center">'
                                                            . $payment[$gateway_slug[0]]['gateway_icon']
                                                        . '</div>'
                                                        . '<div class="col-lg-7 col-sm-7 col-xs-7 col-7 clean">'
                                                            . '<h3>'
                                                                . $payment[$gateway_slug[0]]['gateway_name']
                                                            . '</h3>'
                                                        . '</div>'
                                                        . '<div class="col-lg-3 col-sm-3 col-xs-3 col-3 clean text-center">'
                                                            . '<a href="' . site_url('payments/' . $gateway_slug[0] . '/pay') . '" class="pay-now">'
                                                                . $this->lang->line('upgrade_pay_now')
                                                            . '</a>'
                                                        . '</div>'                                
                                                    . '</div>'
                                                . '</li>';
                                                
                                        }
                                        
                                    } else {

                                        // No gateways found
                                        echo '<li class="no-payments-found">'
                                                . $this->lang->line('upgrade_no_payments')
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
</div>