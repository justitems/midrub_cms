<div class="settings-list theme-box">
    <div class="tab-content">
        <div class="tab-pane container fade active show" id="general-settings">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <svg class="bi bi-gear" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M8.837 1.626c-.246-.835-1.428-.835-1.674 0l-.094.319A1.873 1.873 0 0 1 4.377 3.06l-.292-.16c-.764-.415-1.6.42-1.184 1.185l.159.292a1.873 1.873 0 0 1-1.115 2.692l-.319.094c-.835.246-.835 1.428 0 1.674l.319.094a1.873 1.873 0 0 1 1.115 2.693l-.16.291c-.415.764.42 1.6 1.185 1.184l.292-.159a1.873 1.873 0 0 1 2.692 1.116l.094.318c.246.835 1.428.835 1.674 0l.094-.319a1.873 1.873 0 0 1 2.693-1.115l.291.16c.764.415 1.6-.42 1.184-1.185l-.159-.291a1.873 1.873 0 0 1 1.116-2.693l.318-.094c.835-.246.835-1.428 0-1.674l-.319-.094a1.873 1.873 0 0 1-1.115-2.692l.16-.292c.415-.764-.42-1.6-1.185-1.184l-.291.159A1.873 1.873 0 0 1 8.93 1.945l-.094-.319zm-2.633-.283c.527-1.79 3.065-1.79 3.592 0l.094.319a.873.873 0 0 0 1.255.52l.292-.16c1.64-.892 3.434.901 2.54 2.541l-.159.292a.873.873 0 0 0 .52 1.255l.319.094c1.79.527 1.79 3.065 0 3.592l-.319.094a.873.873 0 0 0-.52 1.255l.16.292c.893 1.64-.902 3.434-2.541 2.54l-.292-.159a.873.873 0 0 0-1.255.52l-.094.319c-.527 1.79-3.065 1.79-3.592 0l-.094-.319a.873.873 0 0 0-1.255-.52l-.292.16c-1.64.893-3.433-.902-2.54-2.541l.159-.292a.873.873 0 0 0-.52-1.255l-.319-.094c-1.79-.527-1.79-3.065 0-3.592l.319-.094a.873.873 0 0 0 .52-1.255l-.16-.292c-.892-1.64.902-3.433 2.541-2.54l.292.159a.873.873 0 0 0 1.255-.52l.094-.319z"/>
                        <path fill-rule="evenodd" d="M8 5.754a2.246 2.246 0 1 0 0 4.492 2.246 2.246 0 0 0 0-4.492zM4.754 8a3.246 3.246 0 1 1 6.492 0 3.246 3.246 0 0 1-6.492 0z"/>
                    </svg>
                    <?php echo $this->lang->line('general_settings'); ?>
                </div>
                <div class="panel-body">
                    <ul class="settings-list-options">
                        <?php

                            // Display the email notifications option
                            get_option_template(array(
                                'type' => 'checkbox_input',
                                'slug' => 'email_notifications',
                                'name' => $this->lang->line('email_notifications'),
                                'description' => $this->lang->line('email_notifications_if_enabled'),
                            ));

                            // Verify if the Faq component is enabled
                            if ( get_option('component_faq_enable') ) {

                                // Display the tickets notifications option
                                get_option_template(array(
                                    'type' => 'checkbox_input',
                                    'slug' => 'notification_tickets',
                                    'name' => $this->lang->line('tickets_email_notification'),
                                    'description' => $this->lang->line('notifications_about_tickets_replies')
                                )); 

                            }
                            
                            // Display the invoices by email option
                            get_option_template(array (
                                'type' => 'checkbox_input',
                                'slug' => 'invoices_by_email',
                                'name' => $this->lang->line('invoices_by_email'),
                                'description' => $this->lang->line('invoices_by_email_description')
                            ));  

                            // Display the 24 hour format option
                            get_option_template(array (
                                'type' => 'checkbox_input',
                                'slug' => '24_hour_format',
                                'name' => $this->lang->line('24_hour_format'),
                                'description' => $this->lang->line('24_hour_format_description')
                            )); 
                            
                            // Display the when week starts option
                            get_option_template(array (
                                'type' => 'checkbox_input',
                                'slug' => 'week_starts_sunday',
                                'name' => $this->lang->line('week_starts_sunday'),
                                'description' => $this->lang->line('week_starts_sunday_description')
                            ));

                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>