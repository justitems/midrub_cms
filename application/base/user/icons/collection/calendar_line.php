<?php

if ( !function_exists('md_user_icon_calendar_line') ) {
    
    /**
     * The function md_user_icon_calendar_line gets the calendar's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_calendar_line($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-calendar-line' . $class . '"></i>';

    }
    
}

/* End of file calendar_line.php */