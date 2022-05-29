<?php

if ( !function_exists('md_user_icon_phone') ) {
    
    /**
     * The function md_user_icon_phone gets the phone's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_phone($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-phone-line' . $class . '"></i>';

    }
    
}

/* End of file phone.php */