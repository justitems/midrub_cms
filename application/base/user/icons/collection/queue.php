<?php

if ( !function_exists('md_user_icon_queue') ) {
    
    /**
     * The function md_user_icon_queue gets the queue's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_queue($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-admin-line' . $class . '"></i>';

    }
    
}

/* End of file queue.php */