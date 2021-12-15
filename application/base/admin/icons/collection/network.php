<?php

if ( !function_exists('md_admin_icon_network') ) {
    
    /**
     * The function md_admin_icon_network gets the network's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_network($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:globe-search-20-regular"></i>';

    }
    
}

/* End of file network.php */