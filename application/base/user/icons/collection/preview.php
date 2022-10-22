<?php

if ( !function_exists('md_user_icon_preview') ) {
    
    /**
     * The function md_user_icon_preview gets the preview's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_preview($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-slideshow-3-line' . $class . '"></i>';

    }
    
}

/* End of file preview.php */