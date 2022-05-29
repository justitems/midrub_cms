<?php

if ( !function_exists('md_user_icon_phone_find') ) {
    
    /**
     * The function md_user_icon_phone_find gets the phone_find's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_phone_find($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-phone-find-line' . $class . '"></i>';

    }
    
}

/* End of file phone_find.php */