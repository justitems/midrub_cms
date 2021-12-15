<?php

if ( !function_exists('md_user_icon_query_stats') ) {
    
    /**
     * The function md_user_icon_query_stats gets the query_stats's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_query_stats($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="material-icons-outlined' . $class . '">'
            . 'query_stats'
        . '</i>';

    }
    
}

/* End of file query_stats.php */