<?php

if ( !function_exists('md_user_icon_photo_resize') ) {
    
    /**
     * The function md_user_icon_photo_resize gets the photo_resize's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_photo_resize($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-screenshot-2-line' . $class . '"></i>';

    }
    
}

/* End of file photo_resize.php */