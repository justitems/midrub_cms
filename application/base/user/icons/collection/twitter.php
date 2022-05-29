<?php

if ( !function_exists('md_user_icon_twitter') ) {
    
    /**
     * The function md_user_icon_twitter gets the twitter's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_twitter($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-twitter-fill' . $class . '"></i>';

    }
    
}

/* End of file twitter.php */