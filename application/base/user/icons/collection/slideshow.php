<?php

if ( !function_exists('md_user_icon_slideshow') ) {
    
    /**
     * The function md_user_icon_slideshow gets the slideshow's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_slideshow($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-slideshow-4-line' . $class . '"></i>';

    }
    
}

/* End of file slideshow.php */