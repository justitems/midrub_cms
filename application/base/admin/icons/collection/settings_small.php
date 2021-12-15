<?php

if ( !function_exists('md_admin_icon_settings_small') ) {
    
    /**
     * The function md_admin_icon_settings_small gets the settings_small icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_settings_small($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:calendar-settings-20-regular"></i>';

    }
    
}

/* End of file settings_small.php */