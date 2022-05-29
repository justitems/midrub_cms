<?php

if ( !function_exists('md_user_icon_insights') ) {
    
    /**
     * The function md_user_icon_insights gets the insights's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_insights($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-line-chart-line' . $class . '"></i>';

    }
    
}

/* End of file insights.php */