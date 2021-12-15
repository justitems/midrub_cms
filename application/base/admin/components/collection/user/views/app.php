<?php

// Get app's data
$app = md_the_user_app($this->input->get('app', true));

// Verify if $app exists
if ( $app ) {

   // Set the app's icon
   $app_icon = !empty($app['app_icon'])?$app['app_icon']:'';

   // Fields container
   $fields = array();

   // Get the app's fields
   $app_fields = md_the_admin_app_options();

   // Verify if the app has fields
   if ( $app_fields ) {

      // Set fields
      $fields = $app_fields;

   }
   
   ?>
   <div class="row mt-3">
      <div class="col-lg-12 settings-area">
         <?php md_get_admin_fields(array(
               'header' => array(
                  'title' => $app_icon
                  . $app['app_name']
               ),
               'fields' => $fields

         )); ?>      
      </div>
   </div>
<?php } else { ?>
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
<?php } ?>