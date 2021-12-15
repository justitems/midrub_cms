
<?php

// Get network
$network = md_the_user_network($this->input->get('network', true));

// Verify if networks exists
if ($network) {

   // Verify if network configuration exists
   if ( !empty($network['network_configuration']) ) {

      // Verify if fields exists
      if ( !empty($network['network_configuration']['fields']) ) {

         ?>
         <div class="row mt-3">
            <div class="col-lg-12">
               <?php md_get_admin_fields(array(
                  'header' => array(
                     'title' => ucwords(str_replace(array('_', '-'), ' ', $this->input->get('network', true)))
                  ),
                  'fields' => $network['network_configuration']['fields']

               )); ?>
            </div>
         </div>
         <?php

      }
      
   }

} else {

   ?>
   <div class="row">
      <div class="col-lg-12">
         <div class="card mt-0 theme-list">
               <div class="card-body">
                  <div class="row">
                     <div class="col-lg-12">
                        <p class="theme-box-1 theme-list-no-results-found">
                           <?php echo $this->lang->line('user_no_data_found_to_show'); ?>
                        </p>         
                     </div>
                  </div>
               </div>
         </div>
      </div>
   </div>
   <?php

}
?>