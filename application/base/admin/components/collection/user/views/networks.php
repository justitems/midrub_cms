<div class="row mt-3">
    <div class="col-lg-12">
        <div class="theme-box-1">
            <nav class="navbar navbar-default theme-navbar-1">
                <div class="navbar-header ps-3 pe-3 pt-2 pb-2">
                    <div class="row">
                        <div class="col-12">
                           <a href="<?php echo site_url('admin/user?p=networks&directory=1'); ?>" class="btn-option new-network theme-button-2">
                              <?php echo md_the_admin_icon(array('icon' => 'network_add')); ?>
                              <?php echo $this->lang->line('user_new_network'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </nav>            
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card mt-0 theme-list">
            <div class="card-body">
            <?php

            // Get networks
            $networks = md_the_user_networks();

            // Verify if networks exists
            if ( $networks ) {
               
               // List the available networks
               foreach ( $networks as $network ) {

                  ?>
                  <div class="card theme-box-1" data-network="<?php echo $network['network_slug']; ?>">
                     <div class="card-header">
                        <div class="row">
                           <div class="col-md-10 col-8">
                              <div class="media d-flex justify-content-start">
                                 <span class="mr-3 theme-list-item-icon">
                                    <?php echo md_the_admin_icon(array('icon' => 'network')); ?>
                                 </span>
                                 <div class="media-body">
                                    <h5>
                                       <a href="<?php echo site_url('admin/user?p=networks&network=' . $network['network_slug']); ?>">
                                          <?php echo $network['network_name']; ?>
                                       </a>
                                    </h5>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-1 col-2 text-center">
                                 <span class="label label-default theme-label">
                                    v<?php echo $network['network_version']; ?>
                                 </span>
                           </div>
                           <div class="col-md-1 col-2 text-end">
                              <?php if ( md_the_option('network_' . $network['network_slug'] . '_enabled') ) { ?>
                              <span class="badge bg-primary theme-badge-1">
                                 <?php echo $this->lang->line('user_network_enabled'); ?>
                              </span>
                              <?php } else { ?>
                              <span class="badge bg-light theme-badge-1">   
                                 <?php echo $this->lang->line('user_network_disabled'); ?>
                              </span>
                              <?php } ?>
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
                        <?php echo $this->lang->line('user_no_data_found_to_show'); ?>
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