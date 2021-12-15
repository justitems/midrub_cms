<?php

if ( !function_exists('md_admin_icon_password') ) {
    
    /**
     * The function md_admin_icon_password gets the password's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_password($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:password-24-regular"></i>';

    }
    
}

/* End of file password.php */