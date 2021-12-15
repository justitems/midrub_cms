<?php

if ( !function_exists('md_user_icon_booklet_line') ) {
    
    /**
     * The function md_user_icon_booklet_line gets the booklet_line's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_booklet_line($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-booklet-line' . $class . '"></i>';

    }
    
}

/* End of file booklet_line.php */