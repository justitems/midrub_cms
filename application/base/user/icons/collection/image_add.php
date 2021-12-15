<?php

if ( !function_exists('md_user_icon_image_add') ) {
    
    /**
     * The function md_user_icon_image_add gets the image_add's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_image_add($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-image-add-line' . $class . '"></i>';

    }
    
}

/* End of file image_add.php */