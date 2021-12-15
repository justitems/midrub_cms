<?php

if ( !function_exists('md_user_icon_monitor_heart') ) {
    
    /**
     * The function md_user_icon_monitor_heart gets the monitor_heart's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_monitor_heart($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="material-icons-outlined' . $class . '">'
            . 'monitor_heart'
        . '</i>';

    }
    
}

/* End of file monitor_heart.php */