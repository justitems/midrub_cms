<?php

if ( !function_exists('md_user_icon_refresh') ) {
    
    /**
     * The function md_user_icon_refresh gets the refresh's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_refresh($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-refresh-line' . $class . '"></i>';

    }
    
}

/* End of file refresh.php */