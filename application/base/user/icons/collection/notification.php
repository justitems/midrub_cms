<?php

if ( !function_exists('md_user_icon_notification') ) {
    
    /**
     * The function md_user_icon_notification gets the notification's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_notification($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-notification-3-line' . $class . '"></i>';

    }
    
}

/* End of file notification.php */