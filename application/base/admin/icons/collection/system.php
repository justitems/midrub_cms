<?php

if ( !function_exists('md_admin_icon_system') ) {
    
    /**
     * The function md_admin_icon_system gets the system icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_system($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:device-meeting-room-20-regular"></i>';

    }
    
}

/* End of file system.php */