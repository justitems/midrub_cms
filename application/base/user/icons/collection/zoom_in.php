<?php

if ( !function_exists('md_user_icon_zoom_in') ) {
    
    /**
     * The function md_user_icon_zoom_in gets the zoom_in's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_zoom_in($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-zoom-in-line' . $class . '"></i>';

    }
    
}

/* End of file zoom_in.php */