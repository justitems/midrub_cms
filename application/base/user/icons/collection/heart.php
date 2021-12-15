<?php

if ( !function_exists('md_user_icon_heart') ) {
    
    /**
     * The function md_user_icon_heart gets the heart's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_heart($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-heart-line' . $class . '"></i>';

    }
    
}

/* End of file heart.php */