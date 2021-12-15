<?php

if ( !function_exists('md_user_icon_image_material') ) {
    
    /**
     * The function md_user_icon_image_material gets the image_material's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_image_material($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="material-icons-outlined' . $class . '">'
            . 'image'
        . '</i>';

    }
    
}

/* End of file image_material.php */