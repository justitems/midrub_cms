<section class="section settings-page">
    <div class="container-fluid">
        <div class="row theme-row-equal">
            <div class="col-xl-2 col-lg-3 col-md-4 theme-sidebar-menu">
                <?php md_include_component_file( CMS_BASE_ADMIN_COMPONENTS_SETTINGS . 'views/menu.php'); ?>
            </div>
            <div class="col-xl-10 col-lg-9 col-md-8 pt-3 settings-view">
                <?php md_get_admin_fields(array(
                    'header' => array(
                        'title' => md_the_admin_icon(array('icon' => 'settings'))
                        . $this->lang->line('settings')
                    ),
                    'fields' => array(
                           
                        array(
                            'field_slug' => 'referrals_enabled',
                            'field_type' => 'checkbox',
                            'field_words' => array(
                                'field_title' => $this->lang->line('settings_enable_referrals'),
                                'field_description' => $this->lang->line('settings_enable_referrals_description')
                            ),
                            'field_params' => array(
                                'checked' => md_the_option('referrals_enabled')?md_the_option('referrals_enabled'):0
                            )

                        ),
                        array(
                            'field_slug' => 'referrals_exact_gains',
                            'field_type' => 'checkbox',
                            'field_words' => array(
                                'field_title' => $this->lang->line('settings_exact_gains'),
                                'field_description' => $this->lang->line('settings_exact_gains_description')
                            ),
                            'field_params' => array(
                                'checked' => md_the_option('referrals_exact_gains')?md_the_option('referrals_exact_gains'):0
                            )

                        )                        

                    )

                )); ?>       
            </div>
        </div>
    </div>
</section>