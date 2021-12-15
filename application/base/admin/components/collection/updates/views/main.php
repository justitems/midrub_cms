<section class="section updates-page">
    <div class="container-fluid">
        <div class="row theme-row-equal">
            <div class="col-xl-2 col-lg-3 col-md-4 theme-sidebar-menu">
                <?php md_include_component_file(CMS_BASE_ADMIN_COMPONENTS_UPDATES . 'views/menu.php'); ?>
            </div>
            <div class="col-xl-10 col-lg-9 col-md-8 pt-3 updates-view">
                <?php if ( $updates ) { ?>
                    <?php md_get_admin_fields(array(
                        'header' => array(
                            'title' => md_the_admin_icon(array('icon' => 'update'))
                            . $this->lang->line('updates_available_updates')
                        ),
                        'fields' => array(
                            array(
                                'field_slug' => 'midrub',
                                'field_type' => 'update',
                                'field_words' => array(
                                    'field_title' => $updates['name'] . ' ' . $updates['version'],
                                    'field_description' => $updates['body']
                                ),
                                'field_params' => array(
                                    'update_form' => TRUE
                                )

                            ) 

                        )

                    )); ?>
                <?php } else { ?>
                    <div class="theme-box-1">
                        <p class="updates-no-updates-were-found">
                            <?php echo $this->lang->line('updates_no_updates_available'); ?>
                        </p>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>

<?php md_include_component_file(CMS_BASE_ADMIN_COMPONENTS_UPDATES . 'views/footer.php'); ?>