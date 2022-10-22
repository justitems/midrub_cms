<?php

if ( !function_exists('md_admin_icon_calendar') ) {
    
    /**
     * The function md_admin_icon_calendar gets the calendar's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_calendar($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:calendar-ltr-24-regular"></i>';

    }
    
}

/* End of file calendar.php */