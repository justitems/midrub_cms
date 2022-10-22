<section class="section profile-page">
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-sm-2 offset-sm-2">
                <?php md_get_the_file(CMS_BASE_ADMIN_COMPONENTS_PROFILE . 'views/parts/menu.php'); ?>
            </div>
            <div class="col-sm-6">
                <?php 

                // Group the languages
                $languages = array_column(the_profile_languages_list(), 'name', 'id');
                
                // Set the language's name
                $language_name = md_the_user_option($this->user_id, 'user_language')?$languages[md_the_user_option($this->user_id, 'user_language')]:$this->lang->line('profile_select_language');

                md_get_admin_fields(array(
                    'header' => array(
                        'title' => md_the_admin_icon(array('icon' => 'globe'))
                        . $this->lang->line('profile_language')
                    ),
                    'fields' => array(
                        array(
                            'field_slug' => 'user_language',
                            'field_type' => 'dropdown',
                            'field_words' => array(
                                'field_title' => $this->lang->line('profile_language'),
                                'field_description' => $this->lang->line('profile_language_description')
                            ),
                            'field_params' => array(
                                'button_text' => $language_name,
                                'button_value' => md_the_user_option($this->user_id, 'user_language')?md_the_user_option($this->user_id, 'user_language'):0,
                                'field_items' => the_profile_languages_list()

                            )

                        )

                    )

                )); ?>
                <?php

                // Group the time zones
                $time_zones = array_column(the_profile_time_zones_list(), 'name', 'id');

                // Get time zone
                $dtz = new DateTimeZone(date_default_timezone_get());

                // Set button text
                $time_zone_btn = md_the_user_option($this->user_id, 'user_time_zone')?$time_zones[md_the_user_option($this->user_id, 'user_time_zone')]:$time_zones[$dtz->getOffset(new DateTime('now', new DateTimeZone(date_default_timezone_get()))) / 3600];

                // Group the date formats
                $date_formats = array_column(the_profile_date_formats_list(), 'name', 'id');

                md_get_admin_fields(array(
                    'header' => array(
                        'title' => md_the_admin_icon(array('icon' => 'time'))
                        . $this->lang->line('profile_time_formats')
                    ),
                    'fields' => array(
                        array(
                            'field_slug' => 'user_time_zone',
                            'field_type' => 'dropdown',
                            'field_words' => array(
                                'field_title' => $this->lang->line('profile_time_zone'),
                                'field_description' => $this->lang->line('profile_time_zone_description')
                            ),
                            'field_params' => array(
                                'button_text' => $time_zone_btn,
                                'button_value' => md_the_user_option($this->user_id, 'user_time_zone')?md_the_user_option($this->user_id, 'user_time_zone'):0,
                                'field_items' => the_profile_time_zones_list()
                            )

                        ),
                        array(
                            'field_slug' => 'user_date_format',
                            'field_type' => 'dropdown',
                            'field_words' => array(
                                'field_title' => $this->lang->line('profile_date_format'),
                                'field_description' => $this->lang->line('profile_date_format_description')
                            ),
                            'field_params' => array(
                                'button_text' => md_the_user_option($this->user_id, 'user_date_format')?$date_formats[md_the_user_option($this->user_id, 'user_date_format')]:$date_formats['dd/mm/yyyy'],
                                'button_value' => md_the_user_option($this->user_id, 'user_date_format')?md_the_user_option($this->user_id, 'user_date_format'):'dd/mm/yyyy',
                                'field_items' => the_profile_date_formats_list()
                            )

                        ),
                        array(
                            'field_slug' => 'user_time_format',
                            'field_type' => 'dropdown',
                            'field_words' => array(
                                'field_title' => $this->lang->line('profile_time_format'),
                                'field_description' => $this->lang->line('profile_time_format_description')
                            ),
                            'field_params' => array(
                                'button_text' => (md_the_user_option($this->user_id, 'user_time_format') === 'hh:ii')?'HH : II':'HH : II : SS'  ,
                                'button_value' => md_the_user_option($this->user_id, 'user_time_format')?md_the_user_option($this->user_id, 'user_time_format'):0,
                                'field_items' => array (
                                    array(
                                        'id' => 'hh:ii',
                                        'name' => 'HH : II'    
                                    ),
                                    array(
                                        'id' => 'hh:ii:ss',
                                        'name' => 'HH : II : SS'    
                                    )  
                                    
                                )

                            )

                        ),    
                        array(
                            'field_slug' => 'user_hours_format',
                            'field_type' => 'dropdown',
                            'field_words' => array(
                                'field_title' => $this->lang->line('profile_hours_format'),
                                'field_description' => $this->lang->line('profile_hours_format_description')
                            ),
                            'field_params' => array(
                                'button_text' => (md_the_user_option($this->user_id, 'user_hours_format') === '12')?$this->lang->line('profile_12_hour_clock'):$this->lang->line('profile_24_hour_clock'),
                                'button_value' => md_the_user_option($this->user_id, 'user_hours_format')?md_the_user_option($this->user_id, 'user_hours_format'):'24',
                                'field_items' => array (
                                    array(
                                        'id' => '12',
                                        'name' => $this->lang->line('profile_12_hour_clock')    
                                    ),
                                    array(
                                        'id' => '24',
                                        'name' => $this->lang->line('profile_24_hour_clock')
                                    )   
                                    
                                )

                            )

                        ),   
                        array(
                            'field_slug' => 'user_first_day',
                            'field_type' => 'dropdown',
                            'field_words' => array(
                                'field_title' => $this->lang->line('profile_first_day_week'),
                                'field_description' => $this->lang->line('profile_first_day_week_description')
                            ),
                            'field_params' => array(
                                'button_text' => (md_the_user_option($this->user_id, 'user_first_day') === '7')?$this->lang->line('profile_sunday'):$this->lang->line('profile_monday'),
                                'button_value' => md_the_user_option($this->user_id, 'user_first_day')?md_the_user_option($this->user_id, 'user_first_day'):0,
                                'field_items' => array (
                                    array(
                                        'id' => '1',
                                        'name' => $this->lang->line('profile_monday')
                                    ),
                                    array(
                                        'id' => '7',
                                        'name' => $this->lang->line('profile_sunday')    
                                    )  
                                    
                                )

                            )

                        ),                                                                                                                

                    )

                )); ?>                
            </div>
        </div>
    </div>
</section>

<?php md_get_admin_quick_guide(the_profile_quick_guide()); ?>