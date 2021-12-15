<?php

if ( !function_exists('md_user_icon_follow') ) {
    
    /**
     * The function md_user_icon_follow gets the follow's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_follow($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-user-follow-line' . $class . '"></i>';

    }
    
}

/* End of file follow.php */