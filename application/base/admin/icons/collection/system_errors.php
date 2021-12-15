<?php

if ( !function_exists('md_admin_icon_system_errors') ) {
    
    /**
     * The function md_admin_icon_system_errors gets the system_errors icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon
     */
    function md_admin_icon_system_errors($params) {

        // Set additional class
        $class = !empty($params['class'])?' ' . $params['class']:'';

        // Return icon
        return '<i class="iconify' . $class . '" data-icon="fluent:document-error-20-regular"></i>';

    }
    
}

/* End of file system_errors.php */