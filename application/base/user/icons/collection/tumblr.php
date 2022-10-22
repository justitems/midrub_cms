<?php

if ( !function_exists('md_user_icon_tumblr') ) {
    
    /**
     * The function md_user_icon_tumblr gets the tumblr's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_tumblr($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-tumblr-fill' . $class . '"></i>';

    }
    
}

/* End of file tumblr.php */