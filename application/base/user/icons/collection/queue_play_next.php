<?php

if ( !function_exists('md_user_icon_queue_play_next') ) {
    
    /**
     * The function md_user_icon_queue_play_next gets the queue_play_next's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_queue_play_next($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="material-icons-outlined' . $class . '">'
            . 'queue_play_next'
        . '</i>';

    }
    
}

/* End of file queue_play_next.php */