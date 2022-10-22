<?php

if ( !function_exists('md_admin_icon_images_search') ) {
    
    /**
     * The function md_admin_icon_images_search gets the images_search's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_images_search($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:circle-image-20-regular"></i>';

    }
    
}

/* End of file images_search.php */