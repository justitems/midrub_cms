<?php

if ( !function_exists('md_user_icon_scheduled') ) {
    
    /**
     * The function md_user_icon_scheduled gets the alternate email's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_scheduled($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-calendar-check-fill' . $class . '"></i>';

    }
    
}

/* End of file scheduled.php */