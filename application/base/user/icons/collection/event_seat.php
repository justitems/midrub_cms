<?php

if ( !function_exists('md_user_icon_event_seat') ) {
    
    /**
     * The function md_user_icon_event_seat gets the event_seat's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_event_seat($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="material-icons-outlined' . $class . '">'
            . 'event_seat'
        . '</i>';

    }
    
}

/* End of file event_seat.php */