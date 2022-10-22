<?php

if ( !function_exists('md_user_icon_image_fill') ) {
    
    /**
     * The function md_user_icon_image_fill gets the image_fill's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_image_fill($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-image-fill' . $class . '"></i>';

    }
    
}

/* End of file image_fill.php */