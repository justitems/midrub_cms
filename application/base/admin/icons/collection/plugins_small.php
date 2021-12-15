<?php

if ( !function_exists('md_admin_icon_plugins_small') ) {
    
    /**
     * The function md_admin_icon_plugins_small gets the plugins_small icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_plugins_small($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:apps-20-regular"></i>';

    }
    
}

/* End of file plugins_small.php */