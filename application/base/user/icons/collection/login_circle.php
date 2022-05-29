<?php

if ( !function_exists('md_user_icon_login_circle') ) {
    
    /**
     * The function md_user_icon_login_circle gets the login circle icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_user_icon_login_circle($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="ri-login-circle-line' . $class . '"></i>';

    }
    
}

/* End of file login_circle.php */