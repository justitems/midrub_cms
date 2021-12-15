<section class="section settings-page">
    <div class="container-fluid">
        <div class="row theme-row-equal">
            <div class="col-xl-2 col-lg-3 col-md-4 theme-sidebar-menu">
                <?php md_include_component_file( CMS_BASE_ADMIN_COMPONENTS_SETTINGS . 'views/menu.php'); ?>
            </div>
            <div class="col-xl-10 col-lg-9 col-md-8 pt-3 settings-view">
                <?php 

                // Display the permissions
                md_get_admin_fields(array(
                    'header' => array(
                        'title' => $gateway['gateway_name']
                    ),
                    'fields' => !empty($gateway['fields'])?$gateway['fields']:array()

                )); 
                
                ?>       
            </div>
        </div>
    </div>
</section>