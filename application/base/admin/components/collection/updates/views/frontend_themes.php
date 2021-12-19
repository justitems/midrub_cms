<section class="section updates-page">
    <div class="container-fluid">
        <div class="row theme-row-equal">
            <div class="col-xl-2 col-lg-3 col-md-4 theme-sidebar-menu">
                <?php md_include_component_file(CMS_BASE_ADMIN_COMPONENTS_UPDATES . 'views/menu.php'); ?>
            </div>
            <div class="col-xl-10 col-lg-9 col-md-8 pt-3 updates-view">
                <?php if ( $updates ) { ?>

                    <?php

                    // Fields container
                    $fields = array();

                    // List the updates
                    foreach ( $updates as $update ) {

                        // Set field
                        $fields[] = array(
                            'field_slug' => $update['slug'],
                            'field_type' => 'update',
                            'field_words' => array(
                                'field_title' => $update['name'] . ' ' . $update['version'],
                                'field_description' => $update['body']
                            ),
                            'field_params' => array(
                                'update_form' => TRUE,
                                'update_code' => !empty($updates['update_code'])?$updates['update_code']:FALSE,
                                'update_button_code' => !empty($updates['update_code_url'])?$updates['update_code_url']:FALSE
                            )

                        );

                    }

                    ?>

                    <?php md_get_admin_fields(array(
                        'header' => array(
                            'title' => md_the_admin_icon(array('icon' => 'update'))
                            . $this->lang->line('updates_available_updates')
                        ),
                        'fields' => $fields

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