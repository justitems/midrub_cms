<?php

if ( !function_exists('md_admin_icon_networks') ) {
    
    /**
     * The function md_admin_icon_networks gets the networks's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_networks($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:book-open-globe-20-regular"></i>';

    }
    
}

/* End of file networks.php */