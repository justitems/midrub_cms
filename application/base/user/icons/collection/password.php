<?php

if ( !function_exists('md_user_icon_password') ) {
    
    /**
     * The function md_user_icon_password gets the password's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_password($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-lock-2-line' . $class . '"></i>';

    }
    
}

/* End of file password.php */