<?php

if ( !function_exists('md_admin_icon_link') ) {
    
    /**
     * The function md_admin_icon_link gets the link's icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_link($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:link-28-regular"></i>';

    }
    
}

/* End of file link.php */