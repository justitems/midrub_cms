<section class="section settings-page">
    <div class="container-fluid">
        <div class="row theme-row-equal">
            <div class="col-xl-2 col-lg-3 col-md-4 theme-sidebar-menu">
                <?php md_include_component_file( CMS_BASE_ADMIN_COMPONENTS_SETTINGS . 'views/menu.php'); ?>
            </div>
            <div class="col-xl-10 col-lg-9 col-md-8 pt-3 settings-view">
                <?php 
                
                // Fields container
                $fields = array();

                // Get the permissions
                $the_permissions = the_settings_list_permissions();

                // Verify if permissions exists
                if ( $the_permissions ) {

                    // List the permissions
                    foreach ( $the_permissions as $the_permission ) {

                        // Set status
                        $fields[] = array(
                            'field_slug' => $the_permission['permission_slug'],
                            'field_type' => 'dropdown',
                            'field_words' => array(
                                'field_title' => $the_permission['permission_name'],
                                'field_description' => $the_permission['permission_description']
                            ),
                            'field_params' => array(
                                'button_text' => $this->lang->line('settings_public'),
                                'button_value' => md_the_option($the_permission['permission_slug'])?md_the_user_option($this->user_id, $the_permission['permission_slug']):2,
                                'field_items' => array (
                                    array(
                                        'id' => 0,
                                        'name' => $this->lang->line('settings_private')  
                                    ),
                                    array(
                                        'id' => 1,
                                        'name' => $this->lang->line('settings_by_request')    
                                    ),
                                    array(
                                        'id' => 2,
                                        'name' => $this->lang->line('settings_public')   
                                    ) 
                                    
                                )
            
                            )
            
                        );

                    }

                    // Display the permissions
                    md_get_admin_fields(array(
                        'header' => array(
                            'title' => md_the_admin_icon(array('icon' => 'settings'))
                            . $this->lang->line('settings_permissions')
                        ),
                        'fields' => $fields

                    )); 

                } else {

                    ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card mt-0 theme-list">
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <p class="theme-box-1 theme-list-no-results-found">
                                                <?php echo $this->lang->line('settings_no_permissions_found'); ?>
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
            </div>
        </div>
    </div>
</section>