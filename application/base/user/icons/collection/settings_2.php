<?php

if ( !function_exists('md_user_icon_settings_2') ) {
    
    /**
     * The function md_user_icon_settings_2 gets the settings_2's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_settings_2($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-settings-2-line' . $class . '"></i>';

    }
    
}

/* End of file settings_2.php */