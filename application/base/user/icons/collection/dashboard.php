<?php

if ( !function_exists('md_user_icon_dashboard') ) {
    
    /**
     * The function md_user_icon_dashboard gets the dashboard's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_dashboard($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-dashboard-line' . $class . '"></i>';

    }
    
}

/* End of file dashboard.php */