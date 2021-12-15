<?php

if ( !function_exists('md_user_icon_image') ) {
    
    /**
     * The function md_user_icon_image gets the image's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_image($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-image-line' . $class . '"></i>';

    }
    
}

/* End of file image.php */