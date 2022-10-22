<?php

if ( !function_exists('md_user_icon_lock') ) {
    
    /**
     * The function md_user_icon_lock gets the lock's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_lock($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-lock-line' . $class . '"></i>';

    }
    
}

/* End of file lock.php */