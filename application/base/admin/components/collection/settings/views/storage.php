<section class="section settings-page">
    <div class="container-fluid">
        <div class="row theme-row-equal">
            <div class="col-xl-2 col-lg-3 col-md-4 theme-sidebar-menu">
                <?php md_include_component_file( CMS_BASE_ADMIN_COMPONENTS_SETTINGS . 'views/menu.php'); ?>
            </div>
            <div class="col-xl-10 col-lg-9 col-md-8 pt-3 settings-view">
                <?php

                // Default storage's location
                $storage_location = $this->lang->line('settings_select_storage_location');

                // Default storage's location id
                $storage_location_id = 0;                

                // Get the selected storage's location
                $the_storage_location = md_the_option('storage_location');

                // Get the locations
                $the_locations = the_storage_locations();

                // Verify if the locations exists
                if ( $the_locations ) {

                    // List all found locations
                    foreach ( $the_locations as $the_location ) {

                        // Verify if the location is available
                        if ( !$the_location[key($the_location)]['location_enabled']() ) {
                            continue;
                        }

                        // Verify if is the selected location
                        if ( $the_storage_location === key($the_location) ) {

                            // Set new storage's location value
                            $storage_location = $the_location[key($the_location)]['location_name'];

                            // Set new storage's location id
                            $storage_location_id = key($the_location);

                            break;

                        }

                    }

                }
                
                // Display the fields
                md_get_admin_fields(array(
                    'header' => array(
                        'title' => md_the_admin_icon(array('icon' => 'storage'))
                        . $this->lang->line('settings_storage')
                    ),
                    'fields' => array(
                        array(
                            'field_slug' => 'storage_location',
                            'field_type' => 'dynamic_list',
                            'field_words' => array(
                                'field_title' => $this->lang->line('settings_storage_location'),
                                'field_description' => $this->lang->line('settings_storage_location_description')
                            ),
                            'field_params' => array(
                                'button_text' => $storage_location,
                                'button_value' => $storage_location_id,
                                'placeholder' => $this->lang->line('settings_search_for_locations')
                            )
        
                        )                        

                    )

                )); 
                
                ?>              
            </div>
        </div>
    </div>
</section>