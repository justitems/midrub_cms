<section class="section profile-page">
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-sm-2 offset-sm-2">
                <?php md_get_the_file(CMS_BASE_ADMIN_COMPONENTS_PROFILE . 'views/parts/menu.php'); ?>
            </div>
            <div class="col-sm-6">
                <?php md_get_admin_fields(array(
                    'header' => array(
                        'title' => md_the_admin_icon(array('icon' => 'person_info'))
                        . $this->lang->line('profile_basic')
                    ),
                    'fields' => array(
                        array(
                            'field_slug' => 'profile_first_name',
                            'field_type' => 'text',
                            'field_words' => array(
                                'field_title' => $this->lang->line('profile_first_name'),
                                'field_description' => $this->lang->line('profile_first_name_description')
                            ),
                            'field_params' => array(
                                'placeholder' => $this->lang->line('profile_enter_first_name'),
                                'value' => md_the_user_option($this->user_id, 'first_name'),
                                'disabled' => false
                            )

                        ),
                        array(
                            'field_slug' => 'profile_last_name',
                            'field_type' => 'text',
                            'field_words' => array(
                                'field_title' => $this->lang->line('profile_last_name'),
                                'field_description' => $this->lang->line('profile_last_name_description')
                            ),
                            'field_params' => array(
                                'placeholder' => $this->lang->line('profile_enter_last_name'),
                                'value' => md_the_user_option($this->user_id, 'last_name'),
                                'disabled' => false
                            )

                        ), 
                        array(
                            'field_slug' => 'profile_username',
                            'field_type' => 'text',
                            'field_words' => array(
                                'field_title' => $this->lang->line('profile_username'),
                                'field_description' => $this->lang->line('profile_username_description')
                            ),
                            'field_params' => array(
                                'placeholder' => $this->lang->line('profile_enter_username'),
                                'value' => md_the_user_option($this->user_id, 'username'),
                                'disabled' => true
                            )

                        ), 
                        array(
                            'field_slug' => 'profile_email',
                            'field_type' => 'text',
                            'field_words' => array(
                                'field_title' => $this->lang->line('profile_email'),
                                'field_description' => $this->lang->line('profile_email_description')
                            ),
                            'field_params' => array(
                                'placeholder' => $this->lang->line('profile_enter_email'),
                                'value' => md_the_user_option($this->user_id, 'email'),
                                'disabled' => false
                            )

                        )   

                    )

                )); ?>
                <?php 

                // Get the countries
                $countries = the_profile_countries_list();
                
                // Set the country's name
                $country_name = md_the_user_option($this->user_id, 'country')?$countries[md_the_user_option($this->user_id, 'country')]:$this->lang->line('profile_select_country');

                md_get_admin_fields(array(
                    'header' => array(
                        'title' => md_the_admin_icon(array('icon' => 'person_advanced'))
                        . $this->lang->line('profile_advanced')
                    ),
                    'fields' => array(
                        array(
                            'field_slug' => 'country',
                            'field_type' => 'dynamic_list',
                            'field_words' => array(
                                'field_title' => $this->lang->line('profile_country'),
                                'field_description' => $this->lang->line('profile_country_description')
                            ),
                            'field_params' => array(
                                'button_text' => $country_name,
                                'button_value' => md_the_user_option($this->user_id, 'country')?md_the_user_option($this->user_id, 'country'):0,
                                'placeholder' => $this->lang->line('profile_search_for_countries')
                            )

                        ),
                        array(
                            'field_slug' => 'state',
                            'field_type' => 'text',
                            'field_words' => array(
                                'field_title' => $this->lang->line('profile_state'),
                                'field_description' => $this->lang->line('profile_state_description')
                            ),
                            'field_params' => array(
                                'placeholder' => $this->lang->line('profile_enter_state'),
                                'value' => md_the_user_option($this->user_id, 'state'),
                                'disabled' => false
                            )

                        ), 
                        array(
                            'field_slug' => 'city',
                            'field_type' => 'text',
                            'field_words' => array(
                                'field_title' => $this->lang->line('profile_city'),
                                'field_description' => $this->lang->line('profile_city_description')
                            ),
                            'field_params' => array(
                                'placeholder' => $this->lang->line('profile_enter_city'),
                                'value' => md_the_user_option($this->user_id, 'city'),
                                'disabled' => false
                            )

                        ),
                        array(
                            'field_slug' => 'postal_code',
                            'field_type' => 'text',
                            'field_words' => array(
                                'field_title' => $this->lang->line('profile_postal_code'),
                                'field_description' => $this->lang->line('profile_postal_code_description')
                            ),
                            'field_params' => array(
                                'placeholder' => $this->lang->line('profile_enter_postal_code'),
                                'value' => md_the_user_option($this->user_id, 'postal_code'),
                                'disabled' => false
                            )

                        ),                                                 
                        array(
                            'field_slug' => 'street_number',
                            'field_type' => 'text',
                            'field_words' => array(
                                'field_title' => $this->lang->line('profile_street_and_number'),
                                'field_description' => $this->lang->line('profile_street_and_number_description')
                            ),
                            'field_params' => array(
                                'placeholder' => $this->lang->line('profile_enter_street_and_number'),
                                'value' => md_the_user_option($this->user_id, 'street_number'),
                                'disabled' => false
                            )

                        )

                    )

                )); ?>  
                <?php 

                // Get the user's image
                $user_image = md_the_user_image($this->user_id);
                
                md_get_admin_fields(array(
                    'header' => array(
                        'title' => md_the_admin_icon(array('icon' => 'person_photo'))
                        . $this->lang->line('profile_photo')
                    ),
                    'fields' => array(
                        array(
                            'field_slug' => 'profile_my_photo',
                            'field_type' => 'image',
                            'field_words' => array(
                                'field_title' => $this->lang->line('profile_my_photo'),
                                'field_description' => $this->lang->line('profile_my_photo_description')
                            ),
                            'field_params' => array(
                                'modal' => '#profile-upload-photo-modal',
                                'src' => $user_image?$user_image[0]['body']:''
                            )

                        )

                    )

                )); ?>
            </div>
        </div>
    </div>
</section>

<?php md_get_admin_quick_guide(the_profile_quick_guide()); ?>

<?php md_get_the_file(CMS_BASE_ADMIN_COMPONENTS_PROFILE . 'views/modals/image.php'); ?>