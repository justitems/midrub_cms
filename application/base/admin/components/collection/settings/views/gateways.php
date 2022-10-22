<section class="section settings-page">
    <div class="container-fluid">
        <div class="row theme-row-equal">
            <div class="col-xl-2 col-lg-3 col-md-4 theme-sidebar-menu">
                <?php md_include_component_file( CMS_BASE_ADMIN_COMPONENTS_SETTINGS . 'views/menu.php'); ?>
            </div>
            <div class="col-xl-10 col-lg-9 col-md-8 settings-view">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mt-0 theme-list">
                            <div class="card-body">
                            <?php

                            // Get gateways
                            $the_gateways = md_the_gateways();

                            // Verify if the gateways exists
                            if ( $the_gateways ) {
                            
                                // List the gateways
                                foreach ( $the_gateways as $the_gateway ) {

                                        // Get gateway slug
                                        $the_gateway_slug = array_keys($the_gateway);

                                        // Verify if the gateway is enabled
                                        if ( md_the_option('gateway_' . $the_gateway_slug[0] . '_enabled') ) {

                                            // Set the enable status
                                            $status = '<span class="badge bg-primary theme-badge-1">'
                                                . $this->lang->line('settings_enabled')
                                            . '</span>';

                                        } else {

                                            // Set the disabled status
                                            $status = '<span class="badge bg-light theme-badge-1">'
                                                . $this->lang->line('settings_disabled')
                                            . '</span>';

                                        }

                                        ?>
                                        <div class="card theme-box-1" data-app="<?php echo $the_gateway_slug[0]; ?>">
                                            <div class="card-header">
                                                <div class="row">
                                                <div class="col-md-10 col-8">
                                                    <div class="media d-flex justify-content-start">
                                                        <span class="mr-3 theme-list-item-icon">
                                                            <?php echo md_the_admin_icon(array('icon' => 'gateway')); ?>
                                                        </span>
                                                        <div class="media-body">
                                                            <h5>
                                                                <a href="<?php echo site_url('admin/settings?p=gateways&gateway=' . $the_gateway_slug[0]); ?>">
                                                                    <?php echo $the_gateway[$the_gateway_slug[0]]['gateway_name']; ?>
                                                                </a>
                                                            </h5>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-4 text-end">
                                                    <?php echo $status; ?>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php

                                }
                                        
                            } else {

                                ?>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <p class="theme-box-1 theme-list-no-results-found">
                                            <?php echo $this->lang->line('settings_no_gateways_were_found'); ?>
                                        </p>         
                                    </div>
                                </div>
                                <?php

                            }
                            ?>
                            </div>
                        </div>
                    </div>
                </div>     
            </div>
        </div>
    </div>
</section>