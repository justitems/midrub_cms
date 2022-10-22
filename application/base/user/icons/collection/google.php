<?php

if ( !function_exists('md_user_icon_google') ) {
    
    /**
     * The function md_user_icon_google gets the google's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_google($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-google-fill' . $class . '"></i>';

    }
    
}

/* End of file google.php */