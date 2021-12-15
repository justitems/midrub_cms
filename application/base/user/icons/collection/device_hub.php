<?php

if ( !function_exists('md_user_icon_device_hub') ) {
    
    /**
     * The function md_user_icon_device_hub gets the device_hub's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_device_hub($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="material-icons-outlined' . $class . '">'
            . 'device_hub'
        . '</i>';

    }
    
}

/* End of file device_hub.php */