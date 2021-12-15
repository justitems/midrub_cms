<?php

if ( !function_exists('md_user_icon_trending_up') ) {
    
    /**
     * The function md_user_icon_trending_up gets the trending_up's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_trending_up($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="material-icons-outlined' . $class . '">'
            . 'trending_up'
        . '</i>';

    }
    
}

/* End of file trending_up.php */