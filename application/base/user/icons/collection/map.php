<?php

if ( !function_exists('md_user_icon_map') ) {
    
    /**
     * The function md_user_icon_map gets the map's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_map($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-map-pin-line' . $class . '"></i>';

    }
    
}

/* End of file map.php */