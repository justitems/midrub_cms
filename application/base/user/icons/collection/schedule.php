<?php

if ( !function_exists('md_user_icon_schedule') ) {
    
    /**
     * The function md_user_icon_schedule gets the schedule's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_schedule($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="material-icons-outlined' . $class . '">'
            . 'schedule_send'
        . '</i>';

    }
    
}

/* End of file schedule.php */