<?php

if ( !function_exists('md_user_icon_user_heart') ) {
    
    /**
     * The function md_user_icon_user_heart gets the user heart's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_user_heart($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-user-heart-line' . $class . '"></i>';

    }
    
}

/* End of file user_heart.php */