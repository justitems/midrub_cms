<?php

if ( !function_exists('md_admin_icon_plugins') ) {
    
    /**
     * The function md_admin_icon_plugins gets the plugins icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_plugins($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:apps-24-regular"></i>';

    }
    
}

/* End of file plugins.php */