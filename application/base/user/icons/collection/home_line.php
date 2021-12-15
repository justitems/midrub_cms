<?php

if ( !function_exists('md_user_icon_home_line') ) {
    
    /**
     * The function md_user_icon_home_line gets the home_line's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_home_line($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-home-2-line' . $class . '"></i>';

    }
    
}

/* End of file home_line.php */