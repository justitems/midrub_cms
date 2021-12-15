<div class="row">
   <div class="col-xl-2 col-lg-3 col-md-3">
      <div class="theme-panel">
         <div class="theme-panel-body">
            <ul class="nav nav-tabs flex-column user-plan-main-menu theme-panel-menu-list" id="user-plan-main-menu" role="tablist">
                  <?php

                  // Get plans options
                  $plans_options = md_the_plans_options();

                  // Verify if plans options exists
                  if ($plans_options) {

                     // List options
                     for ( $p = 0; $p < count($plans_options); $p++) {
                        
                        // Only general and networks are allowed
                        if ( ($plans_options[$p]['slug'] !== 'general') && ($plans_options[$p]['slug'] !== 'advanced') && $plans_options[$p]['slug'] !== 'networks' ) {
                           continue;
                        }

                        $active = '';

                        // Verify if is the first
                        if ( $plans_options[$p]['slug'] === 'general' ) {
                           $active = ' active';
                        }

                        echo '<li>'
                                 . '<a href="#nav-' . $plans_options[$p]['slug'] . '" role="tab" class="d-flex justify-content-start' . $active . '" id="' . $plans_options[$p]['slug'] . '-tab" aria-controls="nav-' . $plans_options[$p]['slug'] . '" aria-selected="false" data-bs-toggle="tab">'
                                    . $plans_options[$p]['icon']
                                    . '<span>'
                                       . $plans_options[$p]['name']
                                    . '</span>'
                                 . '</a>'
                              . '</li>';

                     }

                     // Verify if there are more than 2 options
                     if ( count($plans_options) > 2 ) {

                        // List options
                        for ( $p = 0; $p < count($plans_options); $p++) {

                           // Only general and networks are allowed
                           if ( ($plans_options[$p]['slug'] === 'general') && ($plans_options[$p]['slug'] === 'advanced') && ($plans_options[$p]['slug'] === 'networks') ) {
                              continue;
                           }

                           // Verify if the app is enabled
                           if ( !md_the_option('app_' . $plans_options[$p]['slug'] . '_enabled') ) {
                              continue;
                           }

                           echo '<li>'
                                    . '<a href="#nav-' . $plans_options[$p]['slug'] . '" role="tab" class="d-flex justify-content-start" id="' . $plans_options[$p]['slug'] . '-tab" aria-controls="nav-' . $plans_options[$p]['slug'] . '" aria-selected="false" data-bs-toggle="tab">'
                                       . $plans_options[$p]['icon']
                                       . '<span>'
                                          . $plans_options[$p]['name']
                                       . '</span>'
                                    . '</a>'
                                 . '</li>';

                        }

                     }

                  }
                  ?>
            </ul>
         </div>
      </div>
   </div>
   <div class="col-xl-10 col-lg-9 col-md-9">
      <?php echo form_open('', array('class' => 'update-plan', 'data-csrf' => $this->security->get_csrf_token_name(), 'data-plan-id' => $this->input->get('plan_id', true))) ?>
      <div class="row">
         <div class="col-lg-12">
            <div class="tab-content" id="user-tab-plans">
               <?php

               // Get plans options
               $plans_options = md_the_plans_options();

               // Verify if plans options exists
               if ( $plans_options ) {

                  // Set tabs
                  $tabs = '';

                  // Lista all options
                  foreach ( $plans_options as $options ) {

                     $active = '';

                     if ( $options['slug'] === 'general' ) {
                        $active = ' show active';
                     }

                     // Open tab
                     echo '<div class="tab-pane fade' . $active . '" id="nav-' . $options['slug'] . '" role="tabpanel" aria-labelledby="nav-' . $options['slug'] . '-tab">';

                     // Verify if fields exists
                     if ( $options['fields'] ) {

                        md_get_admin_fields(array(
                           'fields' => $options['fields']
                        ));

                     }

                     // Close tab
                     echo '</div>';

                  }

               }
               ?>
            </div>
         </div>
      </div>
      <?php echo form_close() ?>
   </div>
</div>