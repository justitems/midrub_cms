<?php

if ( !function_exists('md_admin_icon_my_profile') ) {
    
    /**
     * The function md_admin_icon_my_profile gets the profile's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_my_profile($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:home-person-20-regular"></i>';

    }
    
}

/* End of file my_profile.php */