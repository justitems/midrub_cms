<?php

if ( !function_exists('md_user_icon_facebook_white') ) {
    
    /**
     * The function md_user_icon_facebook_white gets the facebook_white's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_facebook_white($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-facebook-fill' . $class . '"></i>';

    }
    
}

/* End of file facebook_white.php */