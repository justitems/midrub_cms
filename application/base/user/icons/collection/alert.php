<?php

if ( !function_exists('md_user_icon_alert') ) {
    
    /**
     * The function md_user_icon_alert gets the alert's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_alert($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-alert-line' . $class . '"></i>';

    }
    
}

/* End of file alert.php */