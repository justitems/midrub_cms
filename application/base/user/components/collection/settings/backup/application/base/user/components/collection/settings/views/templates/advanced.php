<div class="settings-list theme-box">
    <div class="tab-content">
        <div class="tab-pane container fade active show" id="advanced-settings">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <svg class="bi bi-gear" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M8.837 1.626c-.246-.835-1.428-.835-1.674 0l-.094.319A1.873 1.873 0 0 1 4.377 3.06l-.292-.16c-.764-.415-1.6.42-1.184 1.185l.159.292a1.873 1.873 0 0 1-1.115 2.692l-.319.094c-.835.246-.835 1.428 0 1.674l.319.094a1.873 1.873 0 0 1 1.115 2.693l-.16.291c-.415.764.42 1.6 1.185 1.184l.292-.159a1.873 1.873 0 0 1 2.692 1.116l.094.318c.246.835 1.428.835 1.674 0l.094-.319a1.873 1.873 0 0 1 2.693-1.115l.291.16c.764.415 1.6-.42 1.184-1.185l-.159-.291a1.873 1.873 0 0 1 1.116-2.693l.318-.094c.835-.246.835-1.428 0-1.674l-.319-.094a1.873 1.873 0 0 1-1.115-2.692l.16-.292c.415-.764-.42-1.6-1.185-1.184l-.291.159A1.873 1.873 0 0 1 8.93 1.945l-.094-.319zm-2.633-.283c.527-1.79 3.065-1.79 3.592 0l.094.319a.873.873 0 0 0 1.255.52l.292-.16c1.64-.892 3.434.901 2.54 2.541l-.159.292a.873.873 0 0 0 .52 1.255l.319.094c1.79.527 1.79 3.065 0 3.592l-.319.094a.873.873 0 0 0-.52 1.255l.16.292c.893 1.64-.902 3.434-2.541 2.54l-.292-.159a.873.873 0 0 0-1.255.52l-.094.319c-.527 1.79-3.065 1.79-3.592 0l-.094-.319a.873.873 0 0 0-1.255-.52l-.292.16c-1.64.893-3.433-.902-2.54-2.541l.159-.292a.873.873 0 0 0-.52-1.255l-.319-.094c-1.79-.527-1.79-3.065 0-3.592l.319-.094a.873.873 0 0 0 .52-1.255l-.16-.292c-.892-1.64.902-3.433 2.541-2.54l.292.159a.873.873 0 0 0 1.255-.52l.094-.319z"/>
                        <path fill-rule="evenodd" d="M8 5.754a2.246 2.246 0 1 0 0 4.492 2.246 2.246 0 0 0 0-4.492zM4.754 8a3.246 3.246 0 1 1 6.492 0 3.246 3.246 0 0 1-6.492 0z"/>
                    </svg>
                    <?php echo $this->lang->line('advanced_settings'); ?>
                </div>
                <div class="panel-body">
                    <ul class="settings-list-options">
                        <?php

                            // Display the first name option
                            get_option_template(array(
                                'type' => 'text_input',
                                'slug' => 'first_name',
                                'name' => $this->lang->line('first_name'),
                                'description' => $this->lang->line('first_name_description'),
                                'edit' => true
                            ));

                            // Display the last name option
                            get_option_template(array(
                                'type' => 'text_input',
                                'slug' => 'last_name',
                                'name' => $this->lang->line('last_name'),
                                'description' => $this->lang->line('last_name_description'),
                                'edit' => true
                            ));

                            // Verify if the username is enabled
                            if ( get_option('auth_enable_username_input') ) {

                                // Set the username option
                                get_option_template(array(
                                    'type' => 'text_input',
                                    'slug' => 'username',
                                    'name' => $this->lang->line('username'),
                                    'description' => $this->lang->line('username_description'),
                                    'edit' => false
                                ));

                            }

                            // Display the email option
                            get_option_template(array(
                                'type' => 'text_input',
                                'slug' => 'email',
                                'name' => $this->lang->line('email'),
                                'description' => $this->lang->line('email_description'),
                                'edit' => true
                            ));

                            // Display the password option
                            get_option_template(array(
                                'type' => 'modal_link',
                                'slug' => 'change-password',
                                'name' => $this->lang->line('password'),
                                'description' => $this->lang->line('password_description'),
                                'modal_link' => $this->lang->line('change_password'),
                                'edit' => false
                            )); 
                            
                            // Display the country option
                            get_option_template(array(
                                'type' => 'text_input',
                                'slug' => 'country',
                                'name' => $this->lang->line('country'),
                                'description' => $this->lang->line('country_description'),
                                'edit' => true
                            )); 
                            
                            // Display the city option
                            get_option_template(array(
                                'type' => 'text_input',
                                'slug' => 'city',
                                'name' => $this->lang->line('city'),
                                'description' => $this->lang->line('city_description'),
                                'edit' => true
                            ));
                            
                            // Display the address option
                            get_option_template(array(
                                'type' => 'text_input',
                                'slug' => 'address',
                                'name' => $this->lang->line('address'),
                                'description' => $this->lang->line('address_description'),
                                'edit' => true
                            ));  
                            
                            // Verify if multilanguage is enabled
                            if ( get_option('enable_multilanguage') ) {

                                // Display the laguages option
                                get_option_template(array(
                                    'type' => 'select_input',
                                    'slug' => 'user_language',
                                    'name' => $this->lang->line('language'),
                                    'description' => $this->lang->line('select_language_description'),
                                    'options' => settings_language_list()
                                ));

                            }

                            // Set the delete account option
                            get_option_template(array(
                                'type' => 'modal_link',
                                'slug' => 'delete-account',
                                'name' => $this->lang->line('delete_account'),
                                'description' => $this->lang->line('delete_account_description'),
                                'modal_link' => $this->lang->line('delete_my_account'),
                                'edit' => false
                            ));

                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>