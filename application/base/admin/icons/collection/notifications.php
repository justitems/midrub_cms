<?php

if ( !function_exists('md_admin_icon_notifications') ) {
    
    /**
     * The function md_admin_icon_notifications gets the notifications's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_notifications($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:channel-alert-24-regular"></i>';

    }
    
}

/* End of file notifications.php */