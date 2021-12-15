<?php

if ( !function_exists('md_user_icon_unfollow') ) {
    
    /**
     * The function md_user_icon_unfollow gets the unfollow's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_unfollow($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-user-unfollow-line' . $class . '"></i>';

    }
    
}

/* End of file unfollow.php */