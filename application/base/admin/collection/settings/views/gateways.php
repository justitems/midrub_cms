<section>
    <div class="container-fluid settings">
        <div class="row">
            <div class="col-lg-2 col-lg-offset-1">
                <div class="row">
                    <div class="col-lg-12">  
                        <?php md_include_component_file( MIDRUB_BASE_ADMIN_SETTINGS . 'views/menu.php' ); ?>
                    </div>
                </div>                        
            </div>
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-12 settings-area">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fas fa-money-check-alt"></i>
                                <?php echo $this->lang->line('gateways'); ?>
                            </div>
                            <div class="panel-body">
                                <ul class="settings-list-options gateways">
                                    <?php

                                    // Verify if payments gateways exists
                                    if ( md_the_gateways() ) {

                                        // List all payments gateways
                                        foreach ( md_the_gateways() as $payment ) {
                                            
                                            // Get gateway slug
                                            $gateway_slug = array_keys($payment);

                                            // Verify if the gateway is enabled
                                            if ( get_option($gateway_slug[0]) ) {

                                                // Set the enable status
                                                $status = $this->lang->line('enabled');

                                            } else {

                                                // Set the disabled status
                                                $status = $this->lang->line('disabled');

                                            }

                                            // Display the list
                                            echo '<li class="row">'
                                                    . '<div class="col-md-10 col-sm-8 col-xs-6 clean">'
                                                        . '<h3>' . $payment[$gateway_slug[0]]['gateway_name'] . '</h3>'
                                                        . '<span style="background-color: ' . $payment[$gateway_slug[0]]['gateway_color'] . '">' . $status . '</span>'
                                                    . '</div>'
                                                    . '<div class="col-md-2 col-sm-4 col-xs-6 clean text-right">'
                                                        . '<a href="' . site_url('admin/settings?p=gateways&gateway=' . $gateway_slug[0]) . '" class="btn btn-default"><i class="fa fa-cogs" aria-hidden="true"></i> ' . $this->lang->line('api_manage') . '</a>'
                                                    . '</div>'
                                                . '</li>';

                                        }
                                        
                                    } else {

                                        // No gateways found
                                        echo '<li>'
                                                . '<div class="setrow">'
                                                    . $this->lang->line('no_payment_gateways_found')
                                                . '</div>'
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
    </div>
</section>

<?php md_include_component_file( MIDRUB_BASE_ADMIN_SETTINGS . 'views/footer.php' ); ?>