<?php

if ( !function_exists('md_admin_icon_header') ) {
    
    /**
     * The function md_admin_icon_header gets the header's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_header($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:padding-top-20-regular"></i>';

    }
    
}

/* End of file header.php */