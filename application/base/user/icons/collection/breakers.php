<?php

if ( !function_exists('md_user_icon_breakers') ) {
    
    /**
     * The function md_user_icon_breakers gets the breakers's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_breakers($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-line-height' . $class . '"></i>';

    }
    
}

/* End of file breakers.php */