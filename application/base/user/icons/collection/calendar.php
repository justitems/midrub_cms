<?php

if ( !function_exists('md_user_icon_calendar') ) {
    
    /**
     * The function md_user_icon_calendar gets the calendar's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_calendar($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-calendar-todo-line' . $class . '"></i>';

    }
    
}

/* End of file calendar.php */