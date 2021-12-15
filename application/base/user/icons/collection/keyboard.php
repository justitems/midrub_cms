<?php

if ( !function_exists('md_user_icon_keyboard') ) {
    
    /**
     * The function md_user_icon_keyboard gets the keyboard's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_keyboard($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-keyboard-fill' . $class . '"></i>';

    }
    
}

/* End of file keyboard.php */