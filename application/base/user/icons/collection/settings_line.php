<?php

if ( !function_exists('md_user_icon_settings_line') ) {
    
    /**
     * The function md_user_icon_settings_line gets the settings line's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_settings_line($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-list-settings-line' . $class . '"></i>';

    }
    
}

/* End of file settings_line.php */