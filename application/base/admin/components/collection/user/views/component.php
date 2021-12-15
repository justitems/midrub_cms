<?php

// Get component's data
$component = md_the_user_component($this->input->get('component', true));

// Verify if $component exists
if ( $component ) {

   // Set the component's icon
   $component_icon = !empty($component['component_icon'])?$component['component_icon']:'';

   // Fields container
   $fields = array();

   // Get the component's fields
   $component_fields = md_the_user_component_options();

   // Verify if the component has fields
   if ( $component_fields ) {

      // Set fields
      $fields = $component_fields;

   }

   ?>
   <div class="row mt-3">
      <div class="col-lg-12 settings-area">
         <?php md_get_admin_fields(array(
               'header' => array(
                  'title' => $component_icon
                  . $component['component_name']
               ),
               'fields' => $fields

         )); ?>      
      </div>
   </div>
<?php
} else {
   ?>
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
<?php
}
?>