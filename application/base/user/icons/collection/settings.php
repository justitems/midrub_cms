<?php

if ( !function_exists('md_user_icon_settings') ) {
    
    /**
     * The function md_user_icon_settings gets the settings's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_settings($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-user-settings-line' . $class . '"></i>';

    }
    
}

/* End of file settings.php */