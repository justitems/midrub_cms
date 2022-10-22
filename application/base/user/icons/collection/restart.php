<?php

if ( !function_exists('md_user_icon_restart') ) {
    
    /**
     * The function md_user_icon_restart gets the restart's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_restart($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-restart-line' . $class . '"></i>';

    }
    
}

/* End of file restart.php */