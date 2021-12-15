<?php

if ( !function_exists('md_user_icon_route') ) {
    
    /**
     * The function md_user_icon_route gets the route's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_route($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-route-line' . $class . '"></i>';

    }
    
}

/* End of file route.php */