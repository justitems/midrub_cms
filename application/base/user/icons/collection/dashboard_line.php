<?php

if ( !function_exists('md_user_icon_dashboard_line') ) {
    
    /**
     * The function md_user_icon_dashboard_line gets the ri-dashboard-3-line's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_dashboard_line($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-dashboard-3-line' . $class . '"></i>';

    }
    
}

/* End of file dashboard_line.php */