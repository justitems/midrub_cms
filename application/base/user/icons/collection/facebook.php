<?php

if ( !function_exists('md_user_icon_facebook') ) {
    
    /**
     * The function md_user_icon_facebook gets the facebook's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_facebook($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-facebook-circle-fill' . $class . '"></i>';

    }
    
}

/* End of file facebook.php */