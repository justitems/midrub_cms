<?php

if ( !function_exists('md_user_icon_security') ) {
    
    /**
     * The function md_user_icon_security gets the security's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_security($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-shield-check-line' . $class . '"></i>';

    }
    
}

/* End of file security.php */