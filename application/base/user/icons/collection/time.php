<?php

if ( !function_exists('md_user_icon_time') ) {
    
    /**
     * The function md_user_icon_time gets the time's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_time($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-time-line' . $class . '"></i>';

    }
    
}

/* End of file time.php */