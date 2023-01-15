<?php

if ( !function_exists('md_user_icon_zoom_out') ) {
    
    /**
     * The function md_user_icon_zoom_out gets the zoom_out's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_zoom_out($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-zoom-out-line' . $class . '"></i>';

    }
    
}

/* End of file zoom_out.php */