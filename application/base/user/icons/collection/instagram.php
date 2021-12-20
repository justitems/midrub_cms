<?php

if ( !function_exists('md_user_icon_instagram') ) {
    
    /**
     * The function md_user_icon_instagram gets the instagram's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_instagram($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-instagram-line' . $class . '"></i>';

    }
    
}

/* End of file instagram.php */