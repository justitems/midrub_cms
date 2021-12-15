<?php

if ( !function_exists('md_admin_icon_signup') ) {
    
    /**
     * The function md_admin_icon_signup gets the signup's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_signup($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:people-community-add-20-regular"></i>';

    }
    
}

/* End of file signup.php */