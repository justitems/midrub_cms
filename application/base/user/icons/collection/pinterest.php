<?php

if ( !function_exists('md_user_icon_pinterest') ) {
    
    /**
     * The function md_user_icon_pinterest gets the pinterest icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_pinterest($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-pinterest-line' . $class . '"></i>';

    }
    
}

/* End of file pinterest.php */