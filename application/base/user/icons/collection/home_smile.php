<?php

if ( !function_exists('md_user_icon_home_smile') ) {
    
    /**
     * The function md_user_icon_home_smile gets the home_smile's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_home_smile($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-home-smile-line' . $class . '"></i>';

    }
    
}

/* End of file home_smile.php */