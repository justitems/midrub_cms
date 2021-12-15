<?php

if ( !function_exists('md_user_icon_timer') ) {
    
    /**
     * The function md_user_icon_timer gets the ri-timer-line's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_timer($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-timer-line' . $class . '"></i>';

    }
    
}

/* End of file timer.php */