<section class="section profile-page">
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-sm-2 offset-sm-2">
                <?php md_get_the_file(CMS_BASE_ADMIN_COMPONENTS_PROFILE . 'views/parts/menu.php'); ?>
            </div>
            <div class="col-sm-6">
            <?php md_get_admin_fields(array(
                'header' => array(
                    'title' => md_the_admin_icon(array('icon' => 'password'))
                    . $this->lang->line('profile_access')
                ),
                'fields' => array(
                    array(
                        'field_slug' => 'profile_password',
                        'field_type' => 'password',
                        'field_words' => array(
                            'field_title' => $this->lang->line('profile_password'),
                            'field_description' => $this->lang->line('profile_password_description')
                        ),
                        'field_params' => array(
                            'placeholder' => $this->lang->line('profile_enter_password'),
                            'value' => '',
                            'disabled' => false
                        )

                    ),
                    array(
                        'field_slug' => 'profile_repeat_password',
                        'field_type' => 'password',
                        'field_words' => array(
                            'field_title' => $this->lang->line('profile_repeat_password'),
                            'field_description' => $this->lang->line('profile_repeat_password_description')
                        ),
                        'field_params' => array(
                            'placeholder' => $this->lang->line('profile_enter_password'),
                            'value' => '',
                            'disabled' => false
                        )

                    ),                        

                )

            )); ?>
            </div>
        </div>
    </div>
</section>

<?php md_get_admin_quick_guide(the_profile_quick_guide()); ?>